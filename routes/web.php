

<?php

use App\Http\Controllers\AdminUserController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin-panel/update-name', function() {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::post('/admin-panel/clear-cache', [AdminUserController::class, 'clearCache'])->name('admin.panel.clearCache');
    Route::post('/admin-panel/clear-views', [AdminUserController::class, 'clearViews'])->name('admin.panel.clearViews');
    Route::post('/admin-panel/clear-sessions', [AdminUserController::class, 'clearSessions'])->name('admin.panel.clearSessions');
    Route::get('/admin-panel/system-logs', [AdminUserController::class, 'showSystemLogs'])->name('admin.panel.systemLogs');
    Route::get('/admin-panel/audit-logs', function() {
        return view('profile.audit-logs');
    })->name('admin.panel.auditLogs');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/admin-panel', [AdminUserController::class, 'index'])->name('admin.panel');
    Route::post('/admin-panel/update-name', [AdminUserController::class, 'updateSystemName'])->name('admin.settings.updateName');
    Route::post('/admin-panel/update-logo', [AdminUserController::class, 'updateLogo'])->name('admin.settings.updateLogo');

    Route::post('/admin-panel/user', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin-panel/user/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin-panel/user/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin-panel/user/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin-panel/user/{id}/reset-password', [AdminUserController::class, 'showResetPasswordForm'])->name('admin.users.showResetPasswordForm');
    Route::post('/admin-panel/user/{id}/reset-password', [AdminUserController::class, 'resetPassword'])->name('admin.users.resetPassword');
});
