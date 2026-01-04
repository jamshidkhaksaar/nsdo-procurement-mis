<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ContractAmendmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.post');
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('projects', ProjectController::class);
    Route::resource('assets', AssetController::class);
    Route::resource('contracts', ContractController::class);
    Route::resource('contracts.amendments', ContractAmendmentController::class)->shallow();

    // Reporting Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/export/excel', [ReportController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/pdf', [ReportController::class, 'exportPdf'])->name('export.pdf');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        
        Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
        
        Route::get('/audits', [App\Http\Controllers\Admin\AuditLogController::class, 'index'])->name('audits.index');
    });
});

// Temporary debug route
Route::get('/debug', function() {
    return [
        'auth_status' => Auth::check(),
        'user' => Auth::user(),
    ];
});
