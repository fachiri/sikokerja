<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth_login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::prefix('dashboard')->middleware(['web', 'auth'])->group(function () {
    // admin
    Route::get('/users', [UserController::class, 'index'])->name('dashboard.users.index');
    Route::post('/users', [UserController::class, 'store'])->name('dashboard.users.store');
    Route::put('/users/{uuid}', [UserController::class, 'update'])->name('dashboard.users.update');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/add', [DashboardController::class, 'add'])->name('dashboard.add');
    Route::get('/edit/{uuid}', [DashboardController::class, 'edit'])->name('dashboard.edit');
    Route::get('/dokumentasi/{uuid}', [DashboardController::class, 'dokumentasi'])->name('dashboard.dokumentasi');
    Route::delete('/delete/{uuid}', [DashboardController::class, 'delete'])->name('dashboard.delete');
    Route::put('/update/{uuid}', [DashboardController::class, 'update'])->name('dashboard.update');
    Route::post('/store', [DashboardController::class, 'store'])->name('dashboard.store');
    Route::get('/report', [DashboardController::class, 'report'])->name('dashboard.report');
});
