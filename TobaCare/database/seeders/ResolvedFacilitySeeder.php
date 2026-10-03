<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use App\Models\Report;
use App\Models\ReportImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ResolvedFacilitySeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::whereHas('role', fn ($q) => $q->where('name', 'admin'))->first()
            ?? User::first();

        if (! $admin) {
            return;
        }

        $facilities = [
            [
                'title'       => 'Pengaspalan Ulang & Penambalan Lubang Jalan Sisingamangaraja Porsea',
                'category_id' => 1, // Jalan Rusak
                'description' => 'Penanganan kerusakan permukaan jalan berlubang sedalam 15 cm di depan ruko pasar Porsea yang kerap membahayakan pengendara sepeda motor.',
                'address'     => 'Jl. Sisingamangaraja No. 88, Kec. Porsea, Kab. Toba',
                'latitude'    => 2.450200,
                'longitude'   => 99.145600,
                'note'        => 'Pekerjaan perbaikan pelapisan aspal hotmix sepanjang 45 meter telah selesai 100% oleh Dinas PUTR Kab. Toba.',
                'days_ago'    => 2,
            ],
            [
                'title'       => 'Perbaikan & Penggantian 8 Titik Lampu Jalan LED di Jalur Wisata Balige',
                'category_id' => 3, // Lampu Jalan Rusak
                'description' => 'Lampu penerangan jalan umum (PJU) padam sepanjang akses Pantai Bulbul Balige yang menyebabkan area gelap di malam hari.',
                'address'     => 'Kawasan Pantai Bulbul, Kec. Balige, Kab. Toba',
                'latitude'    => 2.337500,
                'longitude'   => 99.072200,
                'note'        => 'Penggantian modul trafo dan lampu LED 100W telah rampung dikerjakan oleh Tim Teknis Dinas Perhubungan Kab. Toba.',
                'days_ago'    => 4,
            ],
            [
                'title'       => 'Pembersihan TPS Liar & Pengangkutan 4 Ton Sampah di Simpang Laguboti',
                'category_id' => 2, // Sampah
                'description' => 'Penumpukan sampah liar di tepi jalan lintas Sumatera simpang Laguboti yang menimbulkan bau tidak sedap.',
                'address'     => 'Jalinsum Simpang 3 Laguboti, Kec. Laguboti, Kab. Toba',
                'latitude'    => 2.368900,
                'longitude'   => 99.112400,
                'note'        => 'Pengangkutan sampah menggunakan 2 armada truk sampah dan pemasangan plang larangan buang sampah oleh Dinas Lingkungan Hidup.',
                'days_ago'    => 6,
            ],
            [
                'title'       => 'Normalisasi & Pengerukan Sedimen Drainase Pasar Tradisional Ajibata',
                'category_id' => 4, // Drainase Rusak
                'description' => 'Saluran drainase tersumbat pasir dan sampah menyebabkan genangan air setinggi 20 cm saat hujan deras.',
                'address'     => 'Area Dermaga Penyeberangan Ajibata, Kec. Ajibata, Kab. Toba',
                'latitude'    => 2.671000,
                'longitude'   => 98.928800,
                'note'        => 'Pengerukan lumpur sedimen sepanjang 120 meter dan perbaikan tutup gorong-gorong beton telah tuntas dikerjakan.',
                'days_ago'    => 9,
            ],
            [
                'title'       => 'Perbaikan Pagar Pembatas & Bangku Taman Kota Balige',
                'category_id' => 5, // Fasum Rusak
                'description' => 'Pagar pengaman taman kota patah dan bangku santai warga rusak akibat pelapukan.',
                'address'     => 'Taman Kota Balige (Depan Kantor Bupati), Kec. Balige, Kab. Toba',
                'latitude'    => 2.333100,
                'longitude'   => 99.062000,
                'note'        => 'Pengecatan ulang, pengelasan pagar pembatas besi, dan peremajaan 6 unit bangku taman telah tuntas diselesaikan.',
                'days_ago'    => 12,
            ],
        ];

        foreach ($facilities as $fac) {
            // Check if already seeded by title
            if (Report::where('title', $fac['title'])->exists()) {
                continue;
            }

            $resolvedTime = now()->subDays($fac['days_ago']);

            $report = Report::create([
                'user_id'         => $admin->id,
                'category_id'     => $fac['category_id'],
                'title'           => $fac['title'],
                'description'     => $fac['description'],
                'additional_info' => 'Fasilitas selesai diperbaiki dan dipublikasikan resmi oleh Pemkab Toba.',
                'event_time'      => $resolvedTime->copy()->subDays(3),
                'status'          => 'resolved',
                'priority_final'  => 'high',
                'priority_source' => 'admin',
                'verified_at'     => $resolvedTime->copy()->subDays(2),
                'resolved_at'     => $resolvedTime,
                'created_at'      => $resolvedTime->copy()->subDays(3),
                'updated_at'      => $resolvedTime,
            ]);

            Location::create([
                'report_id'    => $report->id,
                'latitude'     => $fac['latitude'],
                'longitude'    => $fac['longitude'],
                'address_text' => $fac['address'],
                'region'       => 'Kabupaten Toba',
            ]);

            $report->statusHistory()->create([
                'from_status' => null,
                'to_status'   => 'submitted',
                'changed_by'  => $admin->id,
                'note'        => 'Laporan pengaduan warga diterima.',
                'created_at'  => $resolvedTime->copy()->subDays(3),
            ]);

            $report->statusHistory()->create([
                'from_status' => 'submitted',
                'to_status'   => 'verified',
                'changed_by'  => $admin->id,
                'note'        => 'Verifikasi kelayakan teknis oleh admin dinas.',
                'created_at'  => $resolvedTime->copy()->subDays(2),
            ]);

            $report->statusHistory()->create([
                'from_status' => 'verified',
                'to_status'   => 'in_progress',
                'changed_by'  => $admin->id,
                'note'        => 'Petugas teknis dinas memulai pengerjaan fisik di lokasi.',
                'created_at'  => $resolvedTime->copy()->subDays(1),
            ]);

            $report->statusHistory()->create([
                'from_status' => 'in_progress',
                'to_status'   => 'resolved',
                'changed_by'  => $admin->id,
                'note'        => $fac['note'],
                'created_at'  => $resolvedTime,
            ]);
        }
    }
}
