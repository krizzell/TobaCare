<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.index');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect('/admin/dashboard');
    });

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/reports', function () {
        return view('admin.reports.index');
    });

    Route::get('/reports/{id}', function ($id) {
        return view('admin.reports.show', ['id' => $id]);
    })->whereUuid('id');
});

Route::prefix('operator')->group(function () {
    Route::get('/reports', function () {
        return view('operator.reports.index');
    })->name('operator.reports.index');

    Route::get('/reports/{id}', function ($id) {
        return view('operator.reports.show', ['id' => $id]);
    })->whereUuid('id')->name('operator.reports.show');
});

Route::prefix('citizen')->group(function () {
    Route::get('/', function () {
        return redirect('/citizen/reports');
    });

    Route::get('/reports', function () {
        return view('citizen.reports.index');
    })->name('citizen.reports.index');

    Route::get('/reports/create', function () {
        $categories = \App\Models\Category::where('is_active', true)->orderBy('sort_order')->get();
        return view('citizen.reports.create', compact('categories'));
    })->name('citizen.reports.create');

    Route::get('/reports/{id}', function ($id) {
        $report = \App\Models\Report::with([
            'location',
            'images',
            'category',
            'statusHistory.user',
            'analyses.classifications',
            'activeAssignment.operator'
        ])->find($id);

        return view('citizen.reports.show', [
            'id' => $id,
            'initialReport' => $report,
        ]);
    })->whereUuid('id')->name('citizen.reports.show');
});

