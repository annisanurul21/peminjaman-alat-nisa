<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\ToolController; // Pastikan ini sudah di-import
use App\Http\Controllers\Petugas\PetugasDashboardController;
use App\Http\Controllers\Petugas\LoanApprovalController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserLoanController;
use App\Http\Controllers\LoanHistoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// 1. AUTH ROUTES
Auth::routes();

// 2. REDIRECT BERDASARKAN ROLE
Route::get('/home', function () {
    $role = auth()->user()->role;
    
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'petugas') {
        return redirect()->route('petugas.dashboard');
    }
    
    return redirect()->route('user.dashboard');
})->middleware('auth')->name('home');

// 3. ADMIN ROUTES
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Kategori
    Route::resource('categories', CategoryController::class);

    // CRUD Alat (BARU)
    Route::resource('tools', ToolController::class);
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('tools', ToolController::class);

    // Tambahkan baris ini agar error Route Not Found hilang
    Route::get('/history', function() { return "Halaman Riwayat"; })->name('loans.history');
});

    // Rute Dummy (Hapus rute products jika sudah menggunakan tools)
    Route::get('/loans', function() { return "Halaman Peminjaman"; })->name('loans.index');
    Route::get('/history', function() { return "Halaman Riwayat"; })->name('loans.history');
});

// 4. PETUGAS ROUTES
Route::prefix('petugas')
    ->middleware(['auth', 'role:petugas'])
    ->name('petugas.')
    ->group(function () {
        Route::get('/', [PetugasDashboardController::class, 'index'])->name('dashboard');
        Route::get('loans/approval', [LoanApprovalController::class, 'index'])->name('loans.approval');
        Route::get('loans/history', [LoanHistoryController::class, 'index'])->name('loans.history');
    });

// 5. USER ROUTES
Route::prefix('user')
    ->middleware(['auth', 'role:user'])
    ->name('user.')
    ->group(function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::resource('loans', UserLoanController::class)->only(['index', 'create', 'store']);
    });

require __DIR__.'/auth.php';