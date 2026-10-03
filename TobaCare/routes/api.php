<?php

use App\Http\Controllers\Api\Admin\AdminDashboardController;
use App\Http\Controllers\Api\Admin\AdminFacilityController;
use App\Http\Controllers\Api\Admin\AdminReportController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Operator\OperatorReportController;
use App\Http\Controllers\Api\PublicFacilityController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ReportImageController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('auth/register', [AuthController::class, 'register'])->middleware('throttle:10,1');
    Route::post('auth/login',    [AuthController::class, 'login'])->middleware('throttle:5,1');

    // Public showcase endpoints (no auth required)
    Route::get('public/resolved-facilities',      [PublicFacilityController::class, 'index']);
    Route::get('public/resolved-facilities/{id}', [PublicFacilityController::class, 'show'])->whereUuid('id');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/me',      [AuthController::class, 'me']);
        Route::post('auth/logout', [AuthController::class, 'logout']);

        // sementara, untuk menguji pembatasan role
        Route::get('admin/ping', fn () => ['ok' => true])->middleware('role:admin');

        // Dropdown kategori untuk pelaporan dan verifikasi
        Route::get('categories', [CategoryController::class, 'index']);

        // User report endpoints
        Route::get('citizen/reports', [ReportController::class, 'index'])->middleware(['role:user']);
        Route::post('reports/images', [ReportImageController::class, 'store'])->middleware(['role:user', 'throttle:20,1']);
        Route::post('reports', [ReportController::class, 'store'])->middleware(['role:user', 'throttle:10,1']);
        Route::get('reports/{id}', [ReportController::class, 'show'])->whereUuid('id');

        // Operator endpoints (FR-23)
        Route::middleware(['role:operator', 'throttle:60,1'])->prefix('operator')->group(function () {
            Route::get('reports',                      [OperatorReportController::class, 'index']);
            Route::get('reports/{id}',                 [OperatorReportController::class, 'show'])->whereUuid('id');
            Route::post('reports/{id}/start-progress', [OperatorReportController::class, 'startProgress'])->whereUuid('id');
            Route::post('reports/{id}/resolve',        [OperatorReportController::class, 'resolve'])->whereUuid('id');
        });

        // Admin endpoints
        Route::middleware(['role:admin', 'throttle:60,1'])->group(function () {
            Route::get('admin/dashboard/stats', [AdminDashboardController::class, 'stats']);
            Route::get('admin/reports',      [AdminReportController::class, 'index']);
            Route::get('admin/reports/{id}', [AdminReportController::class, 'show'])->whereUuid('id');
            Route::get('admin/operators',    [AdminReportController::class, 'operators']);

            Route::post('reports/{id}/verify',           [AdminReportController::class, 'verify'])->whereUuid('id');
            Route::post('reports/{id}/reject',           [AdminReportController::class, 'reject'])->whereUuid('id');
            Route::post('reports/{id}/analysis/correct', [AdminReportController::class, 'correct'])->whereUuid('id');
            Route::post('reports/{id}/assign',           [AdminReportController::class, 'assign'])->whereUuid('id');

            // Upload and publish completed facility improvement directly
            Route::post('admin/resolved-facilities', [AdminFacilityController::class, 'store']);
        });
    });
});