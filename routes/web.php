<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth_login'])->name('auth.login');

Route::prefix('dashboard')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::middleware(['roles:ADMIN'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('dashboard.users.index');
        Route::post('/users', [UserController::class, 'store'])->name('dashboard.users.store');
        Route::put('/users/{uuid}', [UserController::class, 'update'])->name('dashboard.users.update');
        Route::delete('/users/{uuid}', [UserController::class, 'delete'])->name('dashboard.users.delete');
        Route::get('/add', [DashboardController::class, 'add'])->name('dashboard.add');
        Route::get('/edit/{uuid}', [DashboardController::class, 'edit'])->name('dashboard.edit');
        Route::delete('/delete/{uuid}', [DashboardController::class, 'delete'])->name('dashboard.delete');
        Route::post('/store', [DashboardController::class, 'store'])->name('dashboard.store');
        Route::put('/update/{uuid}', [DashboardController::class, 'update'])->name('dashboard.update');
        Route::get('/report', [DashboardController::class, 'report'])->name('dashboard.report');
        Route::get('/report/export', [TaskController::class, 'export'])->name('dashboard.report.export');
    });
    Route::get('/pekerjaan', [TaskController::class, 'task'])->name('dashboard.task');
    Route::get('/pekerjaan/{uuid}', [TaskController::class, 'progres'])->name('dashboard.task.progres');
    Route::put('/pekerjaan/{uuid}/pengawas', [TaskController::class, 'update_pengawas'])->name('dashboard.task.update_pengawas');
    Route::put('/pekerjaan/{uuid}/progress', [TaskController::class, 'update_progress'])->name('dashboard.task.update_progress');
    Route::get('/dokumentasi/{uuid}', [DashboardController::class, 'dokumentasi'])->name('dashboard.dokumentasi');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});
