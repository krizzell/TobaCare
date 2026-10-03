<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ReportImageController;

Route::prefix('v1')->group(function () {
    Route::post('auth/register', [AuthController::class, 'register'])->middleware('throttle:10,1');
    Route::post('auth/login',    [AuthController::class, 'login'])->middleware('throttle:5,1');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/me',      [AuthController::class, 'me']);
        Route::post('auth/logout', [AuthController::class, 'logout']);

        // sementara, untuk menguji pembatasan role
        Route::get('admin/ping', fn () => ['ok' => true])->middleware('role:admin');

        Route::post('reports/images', [ReportImageController::class, 'store'])->middleware(['role:user', 'throttle:20,1']);
        Route::post('reports', [ReportController::class, 'store'])->middleware(['role:user', 'throttle:10,1']);
        Route::get('reports/{id}', [ReportController::class, 'show'])->whereUuid('id');
    });
});