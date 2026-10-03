-- =====================================================================
-- TobaCare — Database Schema (PostgreSQL 13+)
-- Berdasarkan PRD TobaCare, bagian 13 (Data Model)
-- Catatan: kolom/tabel bertanda [TBD] mengikuti keputusan yang belum final di PRD
-- =====================================================================

CREATE EXTENSION IF NOT EXISTS "pgcrypto";   -- gen_random_uuid()
-- CREATE EXTENSION IF NOT EXISTS postgis;   -- opsional [TBD]: indeks geospasial

-- ---------------------------------------------------------------------
-- ENUM TYPES
-- ---------------------------------------------------------------------
CREATE TYPE report_status AS ENUM (
  'submitted', 'ai_analysis', 'pending_verification', 'verified',
  'assigned', 'in_progress', 'resolved', 'closed', 'rejected'
);

CREATE TYPE priority_level AS ENUM ('low', 'medium', 'high', 'critical');

CREATE TYPE analysis_status AS ENUM ('pending', 'success', 'partial', 'failed');

CREATE TYPE classification_source AS ENUM ('vision', 'text', 'fusion');

CREATE TYPE duplicate_decision AS ENUM ('pending', 'merged', 'kept_separate', 'ignored');

CREATE TYPE priority_source AS ENUM ('ai', 'admin');

CREATE TYPE notification_type AS ENUM (
  'report_submitted', 'report_verified', 'report_assigned',
  'status_changed', 'report_resolved', 'info_requested'
);

-- ---------------------------------------------------------------------
-- UTIL: auto-update updated_at
-- ---------------------------------------------------------------------
CREATE OR REPLACE FUNCTION set_updated_at() RETURNS trigger AS $$
BEGIN
  NEW.updated_at = now();
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- ---------------------------------------------------------------------
-- ROLE, AGENCY, USER
-- ---------------------------------------------------------------------
CREATE TABLE roles (
  id          SMALLSERIAL PRIMARY KEY,
  name        VARCHAR(30) NOT NULL UNIQUE      -- user | operator | admin
);

-- [TBD] Penugasan ke instansi atau operator individu. Tabel ini opsional.
CREATE TABLE agencies (
  id          UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  name        VARCHAR(150) NOT NULL UNIQUE,
  contact     VARCHAR(150),
  is_active   BOOLEAN NOT NULL DEFAULT TRUE,
  created_at  TIMESTAMPTZ NOT NULL DEFAULT now()
);

CREATE TABLE users (
  id             UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  role_id        SMALLINT NOT NULL REFERENCES roles(id),
  agency_id      UUID REFERENCES agencies(id) ON DELETE SET NULL,  -- untuk operator
  name           VARCHAR(100) NOT NULL,
  email          VARCHAR(255) NOT NULL,
  password_hash  VARCHAR(255) NOT NULL,
  is_active      BOOLEAN NOT NULL DEFAULT TRUE,
  last_login_at  TIMESTAMPTZ,
  created_at     TIMESTAMPTZ NOT NULL DEFAULT now(),
  updated_at     TIMESTAMPTZ NOT NULL DEFAULT now()
);
CREATE UNIQUE INDEX uq_users_email ON users (lower(email));
CREATE INDEX idx_users_role ON users (role_id);
CREATE TRIGGER trg_users_updated BEFORE UPDATE ON users
  FOR EACH ROW EXECUTE FUNCTION set_updated_at();

-- ---------------------------------------------------------------------
-- CATEGORY (extensible, mendukung subkategori)
-- ---------------------------------------------------------------------
CREATE TABLE categories (
  id                 SERIAL PRIMARY KEY,
  parent_id          INT REFERENCES categories(id) ON DELETE SET NULL,
  code               VARCHAR(50) NOT NULL UNIQUE,   -- dipakai untuk memetakan label model AI
  name               VARCHAR(100) NOT NULL,
  default_agency_id  UUID REFERENCES agencies(id) ON DELETE SET NULL,
  sort_order         INT NOT NULL DEFAULT 0,
  is_active          BOOLEAN NOT NULL DEFAULT TRUE,
  created_at         TIMESTAMPTZ NOT NULL DEFAULT now()
);
CREATE INDEX idx_categories_parent ON categories (parent_id);

-- ---------------------------------------------------------------------
-- REPORT
-- ---------------------------------------------------------------------
CREATE TABLE reports (
  id               UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  user_id          UUID NOT NULL REFERENCES users(id),
  category_id      INT REFERENCES categories(id),        -- kategori final
  title            VARCHAR(100) NOT NULL CHECK (char_length(title) >= 5),
  description      TEXT NOT NULL CHECK (char_length(description) BETWEEN 20 AND 1000),
  additional_info  VARCHAR(500),
  event_time       TIMESTAMPTZ NOT NULL DEFAULT now(),
  status           report_status NOT NULL DEFAULT 'submitted',
  priority_final   priority_level,
  priority_source  priority_source,
  needs_manual_review BOOLEAN NOT NULL DEFAULT FALSE,
  is_public        BOOLEAN NOT NULL DEFAULT TRUE,        -- [TBD] laporan privat
  merged_into_id   UUID REFERENCES reports(id) ON DELETE SET NULL,
  rejection_reason TEXT,
  verified_at      TIMESTAMPTZ,
  resolved_at      TIMESTAMPTZ,
  closed_at        TIMESTAMPTZ,
  created_at       TIMESTAMPTZ NOT NULL DEFAULT now(),
  updated_at       TIMESTAMPTZ NOT NULL DEFAULT now(),
  CHECK (event_time <= now() + interval '5 minutes'),
  CHECK (merged_into_id IS NULL OR merged_into_id <> id),
  CHECK (status <> 'rejected' OR rejection_reason IS NOT NULL)
);
CREATE INDEX idx_reports_user      ON reports (user_id);
CREATE INDEX idx_reports_status    ON reports (status);
CREATE INDEX idx_reports_category  ON reports (category_id);
CREATE INDEX idx_reports_priority  ON reports (priority_final);
CREATE INDEX idx_reports_created   ON reports (created_at DESC);
CREATE INDEX idx_reports_review    ON reports (needs_manual_review) WHERE needs_manual_review;
CREATE INDEX idx_reports_merged    ON reports (merged_into_id);
CREATE TRIGGER trg_reports_updated BEFORE UPDATE ON reports
  FOR EACH ROW EXECUTE FUNCTION set_updated_at();

-- LOCATION (1 laporan : 1 lokasi)
CREATE TABLE locations (
  id            UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  report_id     UUID NOT NULL UNIQUE REFERENCES reports(id) ON DELETE CASCADE,
  latitude      NUMERIC(9,6) NOT NULL CHECK (latitude  BETWEEN -90  AND 90),
  longitude     NUMERIC(9,6) NOT NULL CHECK (longitude BETWEEN -180 AND 180),
  address_text  VARCHAR(255),
  region        VARCHAR(100),                       -- kelurahan/kecamatan [TBD]
  nearby_poi    VARCHAR(100)                        -- mis. sekolah (sinyal prioritas)
);
CREATE INDEX idx_locations_coords ON locations (latitude, longitude);
CREATE INDEX idx_locations_region ON locations (region);
-- Jika PostGIS dipakai: ALTER TABLE locations ADD COLUMN geom geography(Point,4326);
--                       CREATE INDEX idx_locations_geom ON locations USING GIST (geom);

-- REPORT IMAGE
CREATE TABLE report_images (
  id             UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  report_id      UUID REFERENCES reports(id) ON DELETE CASCADE,  -- NULL = upload pra-submit
  uploaded_by    UUID NOT NULL REFERENCES users(id),
  storage_key    VARCHAR(255) NOT NULL UNIQUE,
  mime_type      VARCHAR(50) NOT NULL CHECK (mime_type IN ('image/jpeg','image/png','image/webp')),
  size_bytes     INT NOT NULL CHECK (size_bytes > 0),
  width          INT,
  height         INT,
  file_hash      CHAR(64),                          -- SHA-256, untuk deteksi foto sama
  quality_flags  JSONB NOT NULL DEFAULT '{}',       -- {"blur":false,"too_dark":false}
  sort_order     SMALLINT NOT NULL DEFAULT 0,
  created_at     TIMESTAMPTZ NOT NULL DEFAULT now()
);
CREATE INDEX idx_images_report ON report_images (report_id);
CREATE INDEX idx_images_hash   ON report_images (file_hash);

-- ---------------------------------------------------------------------
-- AI TABLES
-- ---------------------------------------------------------------------
CREATE TABLE ai_analyses (
  id                  UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  report_id           UUID NOT NULL REFERENCES reports(id) ON DELETE CASCADE,
  status              analysis_status NOT NULL DEFAULT 'pending',
  model_versions      JSONB NOT NULL DEFAULT '{}',   -- {"vision":"cv-v0.1","text":"..."}
  fused_confidence    NUMERIC(5,4) CHECK (fused_confidence BETWEEN 0 AND 1),
  modality_conflict   BOOLEAN NOT NULL DEFAULT FALSE,
  needs_manual_review BOOLEAN NOT NULL DEFAULT FALSE,
  keywords            TEXT[],
  urgency_indication  priority_level,
  suggested_agency_id UUID REFERENCES agencies(id) ON DELETE SET NULL,
  processing_ms       INT,
  error_message       TEXT,
  started_at          TIMESTAMPTZ NOT NULL DEFAULT now(),
  finished_at         TIMESTAMPTZ
);
CREATE INDEX idx_analyses_report ON ai_analyses (report_id, started_at DESC);
CREATE INDEX idx_analyses_review ON ai_analyses (needs_manual_review) WHERE needs_manual_review;

CREATE TABLE ai_classifications (
  id                      UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  analysis_id             UUID NOT NULL REFERENCES ai_analyses(id) ON DELETE CASCADE,
  image_id                UUID REFERENCES report_images(id) ON DELETE SET NULL,  -- untuk source=vision
  source                  classification_source NOT NULL,
  rank                    SMALLINT NOT NULL DEFAULT 1,       -- top-k
  label                   VARCHAR(50) NOT NULL,              -- = categories.code
  subtype                 VARCHAR(50),
  confidence              NUMERIC(5,4) NOT NULL CHECK (confidence BETWEEN 0 AND 1),
  raw_output              JSONB,
  -- koreksi manusia (human-in-the-loop)
  admin_corrected_label   VARCHAR(50),
  corrected_by            UUID REFERENCES users(id),
  corrected_at            TIMESTAMPTZ,
  correction_reason       TEXT,
  verified                BOOLEAN NOT NULL DEFAULT FALSE,    -- label terverifikasi untuk dataset
  created_at              TIMESTAMPTZ NOT NULL DEFAULT now(),
  CHECK (admin_corrected_label IS NULL OR corrected_by IS NOT NULL)
);
CREATE INDEX idx_class_analysis ON ai_classifications (analysis_id);
CREATE INDEX idx_class_verified ON ai_classifications (verified) WHERE verified;

CREATE TABLE duplicate_candidates (
  id                   UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  report_id            UUID NOT NULL REFERENCES reports(id) ON DELETE CASCADE,
  candidate_report_id  UUID NOT NULL REFERENCES reports(id) ON DELETE CASCADE,
  similarity_score     NUMERIC(5,4) NOT NULL CHECK (similarity_score BETWEEN 0 AND 1),
  signals              JSONB NOT NULL DEFAULT '{}',  -- {"text":0.9,"geo_m":35,"category":1,"time_h":20,"visual":null}
  decision             duplicate_decision NOT NULL DEFAULT 'pending',
  decided_by           UUID REFERENCES users(id),
  decided_at           TIMESTAMPTZ,
  created_at           TIMESTAMPTZ NOT NULL DEFAULT now(),
  CHECK (report_id <> candidate_report_id),
  UNIQUE (report_id, candidate_report_id)
);
CREATE INDEX idx_dup_pending ON duplicate_candidates (decision) WHERE decision = 'pending';
CREATE INDEX idx_dup_candidate ON duplicate_candidates (candidate_report_id);

CREATE TABLE priority_recommendations (
  id                 UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  report_id          UUID NOT NULL REFERENCES reports(id) ON DELETE CASCADE,
  recommended_level  priority_level NOT NULL,
  score              NUMERIC(5,4) NOT NULL CHECK (score BETWEEN 0 AND 1),
  reasoning          JSONB NOT NULL DEFAULT '[]',    -- daftar faktor + kontribusi
  admin_final_level  priority_level,
  decided_by         UUID REFERENCES users(id),
  decided_at         TIMESTAMPTZ,
  is_current         BOOLEAN NOT NULL DEFAULT TRUE,
  created_at         TIMESTAMPTZ NOT NULL DEFAULT now()
);
CREATE INDEX idx_prio_report ON priority_recommendations (report_id);
CREATE UNIQUE INDEX uq_prio_current ON priority_recommendations (report_id) WHERE is_current;

-- ---------------------------------------------------------------------
-- WORKFLOW
-- ---------------------------------------------------------------------
CREATE TABLE report_status_history (
  id           UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  report_id    UUID NOT NULL REFERENCES reports(id) ON DELETE CASCADE,
  from_status  report_status,                      -- NULL untuk entri pertama
  to_status    report_status NOT NULL,
  changed_by   UUID REFERENCES users(id),          -- NULL = sistem
  note         TEXT,
  created_at   TIMESTAMPTZ NOT NULL DEFAULT now()
);
CREATE INDEX idx_history_report ON report_status_history (report_id, created_at);

CREATE TABLE assignments (
  id           UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  report_id    UUID NOT NULL REFERENCES reports(id) ON DELETE CASCADE,
  assigned_by  UUID NOT NULL REFERENCES users(id),
  operator_id  UUID REFERENCES users(id),
  agency_id    UUID REFERENCES agencies(id),
  due_date     DATE,
  note         TEXT,
  accepted_at  TIMESTAMPTZ,
  is_active    BOOLEAN NOT NULL DEFAULT TRUE,
  created_at   TIMESTAMPTZ NOT NULL DEFAULT now(),
  CHECK (operator_id IS NOT NULL OR agency_id IS NOT NULL)
);
CREATE INDEX idx_assign_report   ON assignments (report_id);
CREATE INDEX idx_assign_operator ON assignments (operator_id) WHERE is_active;
CREATE UNIQUE INDEX uq_assign_active ON assignments (report_id) WHERE is_active;

CREATE TABLE resolution_evidences (
  id             UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  report_id      UUID NOT NULL REFERENCES reports(id) ON DELETE CASCADE,
  assignment_id  UUID REFERENCES assignments(id) ON DELETE SET NULL,
  uploaded_by    UUID NOT NULL REFERENCES users(id),
  storage_key    VARCHAR(255) NOT NULL UNIQUE,
  mime_type      VARCHAR(50) NOT NULL CHECK (mime_type IN ('image/jpeg','image/png','image/webp')),
  size_bytes     INT NOT NULL CHECK (size_bytes > 0),
  note           TEXT,
  created_at     TIMESTAMPTZ NOT NULL DEFAULT now()
);
CREATE INDEX idx_evidence_report ON resolution_evidences (report_id);

-- Feedback pelapor setelah Resolved [Enhancement]
CREATE TABLE report_feedback (
  id          UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  report_id   UUID NOT NULL UNIQUE REFERENCES reports(id) ON DELETE CASCADE,
  user_id     UUID NOT NULL REFERENCES users(id),
  rating      SMALLINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
  comment     VARCHAR(500),
  not_resolved_flag BOOLEAN NOT NULL DEFAULT FALSE,
  created_at  TIMESTAMPTZ NOT NULL DEFAULT now()
);

-- ---------------------------------------------------------------------
-- NOTIFICATION & AUDIT
-- ---------------------------------------------------------------------
CREATE TABLE notifications (
  id          UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  user_id     UUID NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  report_id   UUID REFERENCES reports(id) ON DELETE CASCADE,
  type        notification_type NOT NULL,
  message     VARCHAR(255) NOT NULL,
  is_read     BOOLEAN NOT NULL DEFAULT FALSE,
  created_at  TIMESTAMPTZ NOT NULL DEFAULT now()
);
CREATE INDEX idx_notif_user_unread ON notifications (user_id, created_at DESC) WHERE NOT is_read;

CREATE TABLE audit_logs (
  id           BIGSERIAL PRIMARY KEY,
  actor_id     UUID REFERENCES users(id) ON DELETE SET NULL,
  action       VARCHAR(80) NOT NULL,        -- mis. report.verify, ai.correct, priority.change
  entity_type  VARCHAR(50) NOT NULL,
  entity_id    UUID,
  before_data  JSONB,
  after_data   JSONB,
  ip_address   INET,
  created_at   TIMESTAMPTZ NOT NULL DEFAULT now()
);
CREATE INDEX idx_audit_entity ON audit_logs (entity_type, entity_id);
CREATE INDEX idx_audit_actor  ON audit_logs (actor_id, created_at DESC);

-- ---------------------------------------------------------------------
-- VIEW untuk dashboard publik (tanpa data pribadi)
-- ---------------------------------------------------------------------
CREATE VIEW v_public_reports AS
SELECT r.id, r.title, c.name AS category, r.status, r.priority_final,
       l.latitude, l.longitude, l.region, r.created_at, r.resolved_at
FROM reports r
LEFT JOIN categories c ON c.id = r.category_id
LEFT JOIN locations  l ON l.report_id = r.id
WHERE r.is_public AND r.merged_into_id IS NULL AND r.status <> 'rejected';

-- ---------------------------------------------------------------------
-- SEED DATA
-- ---------------------------------------------------------------------
INSERT INTO roles (name) VALUES ('user'), ('operator'), ('admin');

INSERT INTO categories (code, name, sort_order) VALUES
  ('jalan_rusak',          'Jalan Rusak',                    1),
  ('sampah',               'Sampah',                         2),
  ('lampu_jalan_rusak',    'Lampu Jalan Rusak',              3),
  ('drainase_rusak',       'Drainase Rusak',                 4),
  ('fasum_rusak',          'Fasilitas Umum Rusak',           5),
  ('lainnya',              'Lainnya / Tidak Teridentifikasi', 99);
