<?php

use App\Http\Controllers\AbsenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Auth;

// GERBANG UNTUK AKUN YANG BELUM LOGIN
Route::get('/login', [AbsenController::class, 'showLogin'])->name('login');
Route::post('/login/post', [AbsenController::class, 'login'])->name('login.post');

// GERBANG WAJIB LOGIN (PROTEKSI SISTEM)
Route::middleware(['auth'])->group(function () {
    
    // Halaman utama langsung diarahkan ke Scanner Absen
    Route::get('/', [AbsenController::class, 'index'])->name('absen.index');
    Route::post('/absen/store', [AbsenController::class, 'store'])->name('absen.store');
    
    Route::get('/riwayat', [AbsenController::class, 'riwayat'])->name('absen.riwayat');
    
    Route::get('/akun', [AbsenController::class, 'akun'])->name('absen.akun');
    Route::post('/akun/post', [AbsenController::class, 'changePassword'])->name('absen.akun.post');
    
    Route::post('/logout', [AbsenController::class, 'logout'])->name('logout');

    // ========================================================
    // PERBAIKAN: GRUP PROTEKSI KHUSUS LEVEL ADMIN (BEBAS ERROR CLOSURE)
    // ========================================================
    Route::group(['middleware' => function ($request, $next) {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini!');
        }
        return $next($request);
    }], function () {
        
        // Rute Rekap Admin Anda (Utuh)
        Route::get('/admin/rekap', [AbsenController::class, 'adminRekap'])->name('admin.rekap');

        // Rute Manajemen Pengguna Anda (Utuh)
        Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::post('/admin/users/store', [AdminUserController::class, 'store'])->name('admin.users.store');
        
        // Rute Aksi CRUD (Utuh)
        Route::put('/admin/users/update/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/destroy/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
        
    });
});