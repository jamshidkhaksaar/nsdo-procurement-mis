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
    Route::post('assets/{asset}/mark-damaged', [AssetController::class, 'markDamaged'])->name('assets.mark-damaged');
    Route::get('assets-room-list', [AssetController::class, 'roomList'])->name('assets.room-list');
    Route::get('assets-room-list/export', [AssetController::class, 'exportRoomList'])->name('assets.room-list.export');
    Route::get('assets/{asset}/export-pdf', [AssetController::class, 'exportShowPdf'])->name('assets.export-pdf');
    
    Route::resource('contracts', ContractController::class);
    Route::resource('contracts.amendments', ContractAmendmentController::class)->shallow();

    // Reporting Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/export/excel', [ReportController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/pdf', [ReportController::class, 'exportPdf'])->name('export.pdf');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('can:isAdmin')->group(function () {
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        
        Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
        
        Route::get('/audits', [App\Http\Controllers\Admin\AuditLogController::class, 'index'])->name('audits.index');
    });

    // Manager Routes
    Route::prefix('manager')->name('manager.')->middleware('can:isManager')->group(function () {
        Route::get('/settings', [App\Http\Controllers\Manager\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [App\Http\Controllers\Manager\SettingController::class, 'update'])->name('settings.update');

        Route::resource('asset-types', App\Http\Controllers\Manager\AssetTypeController::class);
        Route::resource('provinces', App\Http\Controllers\Manager\ProvinceController::class);
        Route::resource('departments', App\Http\Controllers\Manager\DepartmentController::class);
        Route::resource('staff', App\Http\Controllers\Manager\StaffController::class);
    });
});

// Temporary debug route
Route::get('/debug', function() {
    return [
        'auth_status' => Auth::check(),
        'user' => Auth::user(),
    ];
});

Route::get('/debug-smtp', function() {
    try {
        $user = \App\Models\User::first();
        
        // Test 1: Welcome Email
        \Illuminate\Support\Facades\Mail::to('jamshid.khaksaar@gmail.com')->send(new \App\Mail\UserWelcomeMail($user, 'password123'));

        // Test 2: Report Notification
        \Illuminate\Support\Facades\Mail::to('jamshid.khaksaar@gmail.com')->send(new \App\Mail\ReportNotificationMail($user, 'PDF Asset Report', 'asset_report.pdf'));

        return 'SUCCESS: Welcome Email and Report Notification sent to jamshid.khaksaar@gmail.com';
    } catch (\Exception $e) {
        return 'ERROR: ' . $e->getMessage();
    }
});
