<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReportImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReportImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $path = $request->file('file')->getRealPath();
        $info = @getimagesize($path);

        if (! $info || ! in_array($info['mime'], ['image/jpeg', 'image/png', 'image/webp'], true)
            || $info[0] < 200 || $info[1] < 200) {
            return $this->invalid('File bukan gambar yang valid (minimal 200x200 px)');
        }

        $img = @imagecreatefromstring(file_get_contents($path));
        if (! $img) {
            return $this->invalid('Gambar tidak dapat diproses');
        }

        // koreksi orientasi foto dari kamera ponsel
        if ($info['mime'] === 'image/jpeg' && function_exists('exif_read_data')) {
            $exif = @exif_read_data($path);
            $angle = match ($exif['Orientation'] ?? 1) { 3 => 180, 6 => -90, 8 => 90, default => 0 };
            if ($angle) {
                $img = imagerotate($img, $angle, 0);
            }
        }

        // simpan ulang sebagai JPEG: EXIF/GPS dan payload tersembunyi ikut terbuang
        ob_start();
        imagejpeg($img, null, 85);
        $jpg = ob_get_clean();
        $width = imagesx($img);
        $height = imagesy($img);
        imagedestroy($img);

        $key = 'reports/' . Str::uuid() . '.jpg';
        Storage::disk('public')->put($key, $jpg);

        $image = ReportImage::create([
            'uploaded_by' => $request->user()->id,
            'storage_key' => $key,
            'mime_type'   => 'image/jpeg',
            'size_bytes'  => strlen($jpg),
            'width'       => $width,
            'height'      => $height,
            'file_hash'   => hash('sha256', $jpg),
        ]);

        return response()->json([
            'image_id' => $image->id,
            'url'      => Storage::disk('public')->url($key),
        ], 201);
    }

    private function invalid(string $message)
    {
        return response()->json(['error' => ['code' => 'INVALID_IMAGE', 'message' => $message]], 422);
    }
}