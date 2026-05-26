<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AbsenController extends Controller
{
    // 1. HALAMAN LOGIN
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('absen.index');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('absen.index');
        }

        return redirect()->back()->with('error', 'Email atau Password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // 2. HALAMAN SCANNER ABSEN
    public function index()
    {
        return view('absen');
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_code' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        // Proteksi keamanan: Pegawai hanya boleh melakukan scan menggunakan kode milik akun mereka sendiri
        if (Auth::user()->role === 'pegawai' && Auth::user()->kode_pegawai !== $request->employee_code) {
            return redirect()->back()->with('error', 'Gagal! Barcode yang Anda scan bukan milik akun Anda!');
        }

        // Cek data pegawai di database MySQL
        $pegawai = DB::table('pegawai')->where('kode_pegawai', $request->employee_code)->first();

        if (!$pegawai) {
            return redirect()->back()->with('error', 'ID Card tidak dikenali sistem!');
        }

        // Simpan log absensi
        DB::table('absensi')->insert([
            'kode_pegawai' => $request->employee_code,
            'waktu_absen' => now(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Absen Berhasil disubmit! Selamat Bekerja, ' . $pegawai->nama_pegawai);
    }

    // 3. HALAMAN RIWAYAT ABSEN USER (Filter berdasarkan user yang login saja)
    public function riwayat()
    {
        $kode_user = Auth::user()->kode_pegawai;
        
        $data_absen = DB::table('absensi')
            ->where('kode_pegawai', $kode_user)
            ->orderBy('waktu_absen', 'desc')
            ->get();

        return view('riwayat', compact('data_absen'));
    }

    // 4. HALAMAN UBAH PASSWORD
    public function akun()
    {
        return view('akun');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->password_lama, Auth::user()->password)) {
            return redirect()->back()->with('error', 'Password lama Anda tidak sesuai!');
        }

        DB::table('users')->where('id', Auth::id())->update([
            'password' => Hash::make($request->password_baru),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }

    // 5. HALAMAN REKAP GLOBAL (Khusus Admin)
// 5. HALAMAN REKAP GLOBAL (Khusus Admin)
    public function adminRekap()
    {
        // Cek hak akses
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki hak akses ke halaman Admin!');
        }

        // AMBIAL SEMUA DATA ABSENSI DENGAN JOIN YANG SUDAH DIPERBAIKI:
        $semua_absen = DB::table('absensi')
            ->join('pegawai', 'absensi.kode_pegawai', '=', 'pegawai.kode_pegawai')
            ->select('absensi.*', 'pegawai.nama_pegawai', 'pegawai.divisi')
            ->orderBy('absensi.waktu_absen', 'desc')
            ->get();

        return view('admin_rekap', compact('semua_absen'));
    }
}