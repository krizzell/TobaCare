<?php

namespace Tests;

use App\Models\Agency;
use App\Models\AiAnalysis;
use App\Models\AiClassification;
use App\Models\Category;
use App\Models\Location;
use App\Models\Report;
use App\Models\ReportImage;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->ensureRunningOnTestDatabase();
    }

    protected function ensureRunningOnTestDatabase(): void
    {
        try {
            $dbName = DB::selectOne("SELECT current_database() AS db")?->db;
        } catch (\Throwable $e) {
            throw new RuntimeException("Cannot connect to test database: " . $e->getMessage());
        }

        if (! $dbName || ! str_ends_with(strtolower($dbName), '_test')) {
            throw new RuntimeException("DANGER: Tests must only run on a database ending with _test! Current database: [{$dbName}]");
        }
    }

    protected $dropViews = true;
    protected $dropTypes = true;

    protected function migrateFreshUsing()
    {
        return [
            '--drop-views' => true,
            '--drop-types' => true,
            '--seed'       => false,
        ];
    }

    protected function createUser(string $role = 'user', array $attributes = []): User
    {
        $roleId = match ($role) {
            'operator' => 2,
            'admin'    => 3,
            default    => 1,
        };

        return User::create(array_merge([
            'role_id'       => $roleId,
            'name'          => ucfirst($role) . ' ' . Str::random(5),
            'email'         => strtolower($role) . '_' . Str::random(8) . '@tobacare.test',
            'password_hash' => Hash::make('password123'),
            'is_active'     => true,
        ], $attributes));
    }

    protected function createAgency(array $attributes = []): Agency
    {
        return Agency::create(array_merge([
            'name'      => 'Dinas ' . Str::random(6),
            'contact'   => '0812345678',
            'is_active' => true,
        ], $attributes));
    }

    protected function createReport(array $attributes = [], ?User $reporter = null): Report
    {
        $user = $reporter ?? $this->createUser('user');
        $category = Category::first() ?? Category::create([
            'code'       => 'jalan_rusak',
            'name'       => 'Jalan Rusak',
            'sort_order' => 1,
            'is_active'  => true,
        ]);

        $report = Report::create(array_merge([
            'user_id'             => $user->id,
            'category_id'         => $category->id,
            'title'               => 'Laporan Contoh ' . Str::random(5),
            'description'         => 'Ini deskripsi laporan contoh yang memenuhi batas minimum karakter.',
            'status'              => 'pending_verification',
            'needs_manual_review' => true,
            'is_public'           => true,
            'event_time'          => now(),
        ], $attributes));

        Location::create([
            'report_id'    => $report->id,
            'latitude'     => 2.333333,
            'longitude'    => 99.066667,
            'address_text' => 'Jl. Sisingamangaraja No. 1',
        ]);

        return $report;
    }

    protected function createReportImage(Report $report, array $attributes = []): ReportImage
    {
        return ReportImage::create(array_merge([
            'report_id'     => $report->id,
            'uploaded_by'   => $report->user_id,
            'storage_key'   => 'reports/' . Str::uuid() . '.jpg',
            'mime_type'     => 'image/jpeg',
            'size_bytes'    => 10240,
            'width'         => 800,
            'height'        => 600,
            'file_hash'     => hash('sha256', Str::random(32)),
            'quality_flags' => ['blur' => false, 'too_dark' => false],
            'sort_order'    => 0,
        ], $attributes));
    }

    protected function createAiAnalysis(
        Report $report,
        string $status = 'success',
        array $classifications = []
    ): AiAnalysis {
        $analysis = AiAnalysis::create([
            'report_id'           => $report->id,
            'status'              => $status,
            'model_versions'      => ['vision' => 'cv-v0.1'],
            'fused_confidence'    => ! empty($classifications) ? $classifications[0]['confidence'] : null,
            'needs_manual_review' => $status !== 'success',
            'started_at'          => now(),
            'finished_at'         => now(),
        ]);

        foreach ($classifications as $index => $c) {
            AiClassification::create([
                'analysis_id' => $analysis->id,
                'source'      => 'vision',
                'rank'        => $index + 1,
                'label'       => $c['label'],
                'subtype'     => $c['subtype'] ?? null,
                'confidence'  => $c['confidence'],
                'raw_output'  => $c,
            ]);
        }

        return $analysis;
    }
}
