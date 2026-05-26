<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    // Cek keamanan apakah yang mengakses benar-benar admin
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || Auth::user()->role !== 'admin') {
                abort(403, 'Anda tidak memiliki hak akses ke halaman ini!');
            }
            return $next($request);
        });
    }

    // 1. TAMPILKAN DAFTAR USER & FORM TAMBAH
    public function index()
    {
        // Ambil semua data user dari database MySQL
        $users = DB::table('users')->orderBy('created_at', 'desc')->get();
        return view('admin_users', compact('users'));
    }

    // 2. PROSES SIMPAN USER BARU
    public function store(Request $request)
    {
        // Validasi Input Form Tabler
        $request->validate([
            'kode_pegawai' => 'required|unique:users,kode_pegawai',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'divisi' => 'required',
            'role' => 'required',
            'password' => 'required|min:6',
        ]);

        // Gunakan Database Transaction agar jika salah satu tabel gagal, semua dibatalkan (Aman dari Corrupt)
        DB::transaction(function () use ($request) {
            
            // Input ke tabel 'users' untuk hak akses login
            DB::table('users')->insert([
                'kode_pegawai' => $request->kode_pegawai,
                'name' => $request->name,
                'email' => $request->email,
                'divisi' => $request->divisi,
                'role' => $request->role,
                'password' => Hash::make($request->password),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Jika role-nya pegawai, daftarkan juga ke tabel 'pegawai' agar bisa di-scan
            if ($request->role === 'pegawai') {
                DB::table('pegawai')->insert([
                    'kode_pegawai' => $request->kode_pegawai,
                    'nama_pegawai' => $request->name,
                    'divisi' => $request->divisi,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        return redirect()->back()->with('success', 'User Baru Berhasil Didaftarkan ke Sistem!');
    }
}