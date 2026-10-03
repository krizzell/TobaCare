<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\Category;
use App\Models\Location;
use App\Models\Report;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OperatorEndpointsTest extends TestCase
{
    use RefreshDatabase;

    protected $dropViews = true;
    protected $dropTypes = true;

    protected function migrateFreshUsing(): array
    {
        return array_merge(parent::migrateFreshUsing(), [
            '--drop-views' => true,
            '--drop-types' => true,
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['id' => 1], ['name' => 'user']);
        Role::firstOrCreate(['id' => 2], ['name' => 'operator']);
        Role::firstOrCreate(['id' => 3], ['name' => 'admin']);

        Category::firstOrCreate(['id' => 1], [
            'name' => 'Jalan Rusak',
            'slug' => 'jalan-rusak',
            'is_active' => true,
        ]);
    }



    private function createAssignedReport(User $operator, string $status = 'assigned'): Report
    {
        $admin = $this->createUser('admin');
        $citizen = $this->createUser('user');

        $report = Report::create([
            'id' => (string) Str::uuid(),
            'user_id' => $citizen->id,
            'category_id' => 1,
            'title' => 'Jalan Berlubang di Porsea',
            'description' => 'Lubang cukup dalam di badan jalan sangat membahayakan pengendara motor.',
            'status' => $status,
            'priority_final' => 'high',
        ]);

        Location::create([
            'id' => (string) Str::uuid(),
            'report_id' => $report->id,
            'latitude' => 2.3456,
            'longitude' => 99.1234,
            'address_text' => 'Jl. Lintas Porsea',
        ]);

        Assignment::create([
            'id' => (string) Str::uuid(),
            'report_id' => $report->id,
            'assigned_by' => $admin->id,
            'operator_id' => $operator->id,
            'is_active' => true,
            'due_date' => now()->addDays(3),
        ]);

        return $report;
    }

    public function test_guest_cannot_access_operator_endpoints(): void
    {
        $this->getJson('/api/v1/operator/reports')
            ->assertStatus(401)
            ->assertJsonPath('error.code', 'UNAUTHENTICATED');
    }

    public function test_admin_and_regular_user_cannot_access_operator_endpoints(): void
    {
        $admin = $this->createUser('admin');
        $user = $this->createUser('user');

        foreach ([$admin, $user] as $forbiddenUser) {
            Sanctum::actingAs($forbiddenUser);

            $this->getJson('/api/v1/operator/reports')
                ->assertStatus(403)
                ->assertJsonPath('error.code', 'FORBIDDEN');
        }
    }

    public function test_operator_can_list_assigned_reports_only(): void
    {
        $operator1 = $this->createUser('operator');
        $operator2 = $this->createUser('operator');

        $report1 = $this->createAssignedReport($operator1);
        $this->createAssignedReport($operator2); // Assigned to another operator

        Sanctum::actingAs($operator1);

        $res = $this->getJson('/api/v1/operator/reports')
            ->assertStatus(200)
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.id', $report1->id);
    }

    public function test_operator_can_start_progress_and_resolve_report(): void
    {
        $operator = $this->createUser('operator');
        $report = $this->createAssignedReport($operator, 'assigned');

        Sanctum::actingAs($operator);

        // 1. Start progress
        $startRes = $this->postJson("/api/v1/operator/reports/{$report->id}/start-progress")
            ->assertStatus(200);

        $this->assertDatabaseHas('reports', [
            'id' => $report->id,
            'status' => 'in_progress',
        ]);

        // 2. Resolve
        $resolveRes = $this->postJson("/api/v1/operator/reports/{$report->id}/resolve", [
            'note' => 'Penambalan aspal telah selesai dikerjakan.',
        ])->assertStatus(200);

        $this->assertDatabaseHas('reports', [
            'id' => $report->id,
            'status' => 'resolved',
        ]);
    }
}
