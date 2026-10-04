<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RegionController extends Controller
{
    private const WILAYAH_URL = 'https://wilayah.id/api';

    public function districts()
    {
        return response()->json([
            'data' => Cache::remember('toba-districts', now()->addDay(), function () {
                return $this->wilayahGet('districts/12.12.json');
            }),
        ]);
    }

    public function villages(string $district)
    {
        abort_unless(preg_match('/^12\.12\.\d{2}$/', $district), 404);

        return response()->json([
            'data' => Cache::remember('toba-villages:' . $district, now()->addDay(), function () use ($district) {
                return $this->wilayahGet("villages/{$district}.json");
            }),
        ]);
    }

    public function geocode(Request $request)
    {
        $data = $request->validate([
            'district' => ['required', 'string', 'max:120'],
            'village'  => ['required', 'string', 'max:120'],
        ]);

        $key = 'toba-geocode:' . md5($data['village'] . '|' . $data['district']);
        $location = Cache::remember($key, now()->addMonth(), function () use ($data) {
            $queries = [
                "{$data['village']}, {$data['district']}, Kabupaten Toba, Sumatera Utara, Indonesia",
                "{$data['district']}, Kabupaten Toba, Sumatera Utara, Indonesia",
            ];

            foreach ($queries as $query) {
                $response = Http::withHeaders(['User-Agent' => 'TobaCare/1.0'])
                    ->timeout(10)
                    ->get('https://nominatim.openstreetmap.org/search', [
                        'format' => 'jsonv2',
                        'limit' => 1,
                        'countrycodes' => 'id',
                        'q' => $query,
                    ]);

                if ($response->successful() && $response->json('0.lat') && $response->json('0.lon')) {
                    return [
                        'lat' => (float) $response->json('0.lat'),
                        'lng' => (float) $response->json('0.lon'),
                    ];
                }
            }

            return null;
        });

        if (! $location) {
            return response()->json([
                'error' => ['code' => 'REGION_COORDINATES_NOT_FOUND', 'message' => 'Koordinat desa belum tersedia.'],
            ], 422);
        }

        return response()->json($location);
    }

    private function wilayahGet(string $path): array
    {
        $response = Http::timeout(10)->get(self::WILAYAH_URL . '/' . $path);

        if (! $response->successful()) {
            abort(503, 'Data wilayah sedang tidak tersedia.');
        }

        return $response->json('data', []);
    }
}
