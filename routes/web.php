<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

Route::prefix('dashboard')->middleware([])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/add', [DashboardController::class, 'add'])->name('dashboard.add');
    Route::get('/edit/{uuid}', [DashboardController::class, 'edit'])->name('dashboard.edit');
    Route::get('/dokumentasi/{uuid}', [DashboardController::class, 'dokumentasi'])->name('dashboard.dokumentasi');
    Route::delete('/delete/{uuid}', [DashboardController::class, 'delete'])->name('dashboard.delete');
    Route::put('/update/{uuid}', [DashboardController::class, 'update'])->name('dashboard.update');
    Route::post('/store', [DashboardController::class, 'store'])->name('dashboard.store');
    Route::get('/report', [DashboardController::class, 'report'])->name('dashboard.report');
});
