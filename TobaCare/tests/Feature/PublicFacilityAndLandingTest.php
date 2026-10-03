<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Report;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PublicFacilityAndLandingTest extends TestCase
{
    use RefreshDatabase;

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

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_public_can_access_landing_page(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('TobaCare');
        $response->assertSee('Laporkan Keluhanmu');
    }

    public function test_public_can_fetch_resolved_facilities(): void
    {
        $admin = $this->createUser('admin');

        $report = $this->createReport([
            'user_id'     => $admin->id,
            'status'      => 'resolved',
            'resolved_at' => now(),
            'title'       => 'Perbaikan Jalan Porsea Selesai',
            'description' => 'Pengaspalan hotmix jalan berlubang telah selesai tuntas.',
        ]);

        $response = $this->getJson('/api/v1/public/resolved-facilities');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'category', 'managing_agency', 'resolved_at'],
            ],
            'meta',
            'stats',
        ]);
    }

    public function test_admin_can_upload_resolved_facility(): void
    {
        $admin = $this->createUser('admin');
        Sanctum::actingAs($admin);

        $response = $this->postJson('/api/v1/admin/resolved-facilities', [
            'title'           => 'Perbaikan Drainase Pasar Balige',
            'category_id'     => 1,
            'description'     => 'Pengerukan lumpur dan sedimentasi saluran air sepanjang 50 meter.',
            'address'         => 'Jl. Sisingamangaraja, Balige, Kab. Toba',
            'resolution_note' => 'Pekerjaan selesai 100% oleh Dinas PUTR.',
            'image'           => UploadedFile::fake()->image('hasil_perbaikan.jpg'),
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('facility.status', 'resolved');
        $response->assertJsonPath('facility.title', 'Perbaikan Drainase Pasar Balige');

        $this->assertDatabaseHas('reports', [
            'title'  => 'Perbaikan Drainase Pasar Balige',
            'status' => 'resolved',
        ]);
    }

    public function test_guest_and_citizen_cannot_upload_admin_resolved_facility(): void
    {
        $user = $this->createUser('user');

        // Guest
        $this->postJson('/api/v1/admin/resolved-facilities', [
            'title' => 'Test',
        ])->assertStatus(401);

        // Citizen
        Sanctum::actingAs($user);
        $this->postJson('/api/v1/admin/resolved-facilities', [
            'title' => 'Test',
        ])->assertStatus(403);
    }
}
