<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Report;
use App\Models\ReportImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminFacilityController extends Controller
{
    /**
     * POST /api/v1/admin/resolved-facilities
     * Upload and publish a resolved/completed facility improvement directly from Admin Dashboard.
     */
    public function store(Request $request): JsonResponse
    {
        $admin = $request->user();

        $data = $request->validate([
            'title'           => ['required', 'string', 'min:5', 'max:120'],
            'category_id'     => ['required', 'integer', Rule::exists('categories', 'id')->where('is_active', true)],
            'description'     => ['required', 'string', 'min:10', 'max:1000'],
            'address'         => ['required', 'string', 'min:3', 'max:255'],
            'latitude'        => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'       => ['nullable', 'numeric', 'between:-180,180'],
            'resolution_note' => ['required', 'string', 'min:5', 'max:500'],
            'image'           => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:5120'], // Max 5MB
        ], [
            'title.required'           => 'Judul pekerjaan perbaikan fasilitas wajib diisi.',
            'title.min'                => 'Judul minimal 5 karakter.',
            'category_id.required'     => 'Kategori fasilitas wajib dipilih.',
            'description.required'     => 'Deskripsi pekerjaan perbaikan wajib diisi.',
            'address.required'         => 'Alamat atau lokasi fasilitas wajib diisi.',
            'resolution_note.required' => 'Catatan resmi penuntasan dinas wajib diisi.',
            'image.image'              => 'Berkas foto harus berupa gambar (JPG, PNG, atau WebP).',
            'image.max'                => 'Ukuran foto maksimal 5 MB.',
        ]);

        $report = DB::transaction(function () use ($data, $admin, $request) {
            $lat = ! empty($data['latitude']) ? (float) $data['latitude'] : 2.333878;
            $lng = ! empty($data['longitude']) ? (float) $data['longitude'] : 99.062534;

            // Create Report directly in 'resolved' status
            $report = Report::create([
                'user_id'         => $admin->id,
                'category_id'     => $data['category_id'],
                'title'           => strip_tags($data['title']),
                'description'     => strip_tags($data['description']),
                'additional_info' => 'Fasilitas diunggah dan diverifikasi tuntas oleh Tim Admin Pemkab Toba.',
                'event_time'      => now(),
                'status'          => 'resolved',
                'priority_final'  => 'medium',
                'priority_source' => 'admin',
                'verified_at'     => now(),
                'resolved_at'     => now(),
            ]);

            // Create Location
            Location::create([
                'report_id'    => $report->id,
                'latitude'     => $lat,
                'longitude'    => $lng,
                'address_text' => strip_tags($data['address']),
                'region'       => 'Kabupaten Toba',
            ]);

            // Handle optional image upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = Str::uuid() . '.' . $ext;
                $storageKey = 'reports/' . $filename;

                $file->storeAs('reports', $filename, 'public');

                ReportImage::create([
                    'report_id'   => $report->id,
                    'uploaded_by' => $admin->id,
                    'storage_key' => $storageKey,
                    'mime_type'   => $file->getClientMimeType(),
                    'size_bytes'  => $file->getSize(),
                    'file_hash'   => hash_file('sha256', $file->getRealPath()),
                    'sort_order'  => 0,
                ]);
            }

            // Write status history
            $report->statusHistory()->create([
                'from_status' => null,
                'to_status'   => 'submitted',
                'changed_by'  => $admin->id,
                'note'        => 'Dokumentasi fasilitas masuk ke sistem.',
            ]);

            $report->statusHistory()->create([
                'from_status' => 'submitted',
                'to_status'   => 'verified',
                'changed_by'  => $admin->id,
                'note'        => 'Diverifikasi oleh Administrator Dinas.',
            ]);

            $report->statusHistory()->create([
                'from_status' => 'verified',
                'to_status'   => 'resolved',
                'changed_by'  => $admin->id,
                'note'        => strip_tags($data['resolution_note']),
            ]);

            return $report;
        });

        return response()->json([
            'message'  => 'Fasilitas selesai diperbaiki berhasil diunggah dan dipublikasikan ke portal publik!',
            'facility' => $report->fresh(['category', 'location', 'images', 'statusHistory']),
        ], 201);
    }
}
