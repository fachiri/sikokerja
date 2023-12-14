<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProgressController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Helper\ProgressIndicator;

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth_login'])->name('auth.login');

Route::prefix('dashboard')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/progress/add', [ProgressController::class, 'add'])->name('progress.add');
    Route::post('/progress/store', [ProgressController::class, 'store'])->name('progress.store');
    Route::middleware(['roles:ADMIN,MANAJER'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('dashboard.users.index');
        Route::post('/users', [UserController::class, 'store'])->name('dashboard.users.store');
        Route::put('/users/{uuid}', [UserController::class, 'update'])->name('dashboard.users.update');
        Route::delete('/users/{uuid}', [UserController::class, 'delete'])->name('dashboard.users.delete');
        Route::get('/report', [DashboardController::class, 'report'])->name('dashboard.report');
        Route::get('/report/export', [TaskController::class, 'export'])->name('dashboard.report.export');
    });
    Route::get('/add', [DashboardController::class, 'add'])->name('dashboard.add');
    Route::get('/detail/{uuid}', [DashboardController::class, 'detail'])->name('dashboard.detail');
    Route::put('/update/{uuid}', [DashboardController::class, 'update'])->name('dashboard.update');
    Route::delete('/delete/{uuid}', [DashboardController::class, 'delete'])->name('dashboard.delete');
    Route::post('/store', [DashboardController::class, 'store'])->name('dashboard.store');
    Route::get('/pekerjaan', [TaskController::class, 'task'])->name('dashboard.task');
    Route::get('/pekerjaan/{uuid}', [TaskController::class, 'progres'])->name('dashboard.task.progres');
    Route::put('/pekerjaan/{uuid}/pengawas', [TaskController::class, 'update_pengawas'])->name('dashboard.task.update_pengawas');
    Route::put('/pekerjaan/{uuid}/progress', [TaskController::class, 'update_progress'])->name('dashboard.task.update_progress');
    Route::get('/dokumentasi/{uuid}', [DashboardController::class, 'dokumentasi'])->name('dashboard.dokumentasi');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::post('/profile/update', [DashboardController::class, 'update_profile'])->name('dashboard.profile.update');
    Route::post('/profile/change_password', [DashboardController::class, 'change_password_profile'])->name('dashboard.profile.change_password');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});
