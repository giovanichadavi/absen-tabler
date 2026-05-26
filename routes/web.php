<?php
use App\Http\Controllers\AbsenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminUserController;
Route::get('/', function () {
    return view('welcome');
});
// GERBANG UNTUK AKUN YANG BELUM LOGIN
Route::get('/login', [AbsenController::class, 'showLogin'])->name('login');
Route::post('/login/post', [AbsenController::class, 'login'])->name('login.post');

// GERBANG WAJIB LOGIN (PROTEKSI SISTEM)
Route::middleware(['auth'])->group(function () {
    
    Route::get('/', [AbsenController::class, 'index'])->name('absen.index');
    Route::post('/absen/store', [AbsenController::class, 'store'])->name('absen.store');
    
    Route::get('/riwayat', [AbsenController::class, 'riwayat'])->name('absen.riwayat');
    
    Route::get('/akun', [AbsenController::class, 'akun'])->name('absen.akun');
    Route::post('/akun/post', [AbsenController::class, 'changePassword'])->name('absen.akun.post');
    
    Route::post('/logout', [AbsenController::class, 'logout'])->name('logout');

    // PROTEKSI KHUSUS LEVEL: ADMIN
    
    Route::get('/admin/rekap', [AbsenController::class, 'adminRekap'])->name('admin.rekap');

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/store', [AdminUserController::class, 'store'])->name('admin.users.store');
});
