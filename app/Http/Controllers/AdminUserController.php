<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    // Fungsi __construct lama yang memicu error panggil middleware() TELAH DIHAPUS.
    // Proteksi keamanan hak akses kini dipindahkan sepenuhnya ke dalam file routes/web.php.

    // 1. READ: TAMPILKAN DAFTAR USER
    public function index()
    {
        $users = DB::table('users')->orderBy('created_at', 'desc')->get();
        return view('admin_users', compact('users'));
    }

    // 2. CREATE: PROSES SIMPAN USER BARU
    public function store(Request $request)
    {
        // Penyesuaian: Aturan validasi kode_pegawai dan divisi dilepas karena dibuat otomatis oleh sistem
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'password' => 'required|min:6',
        ]);

        // LOGIKA GENERATE ID KODE PEGAWAI RANDOM SECARA OTOMATIS
        // Format: EMP- diikuti 6 digit angka acak (Contoh: EMP-391082)
        $kodeRandom = 'EMP-' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::transaction(function () use ($request, $kodeRandom) {
            DB::table('users')->insert([
                'kode_pegawai' => $kodeRandom, // Menggunakan kode acak otomatis
                'name' => $request->name,
                'email' => $request->email,
                'divisi' => null, // Diset null karena kolom input divisi sudah dihapus
                'role' => $request->role,
                'password' => Hash::make($request->password),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // PERBAIKAN UTAMA: Semua role (baik pegawai maupun admin) wajib masuk ke tabel pegawai
            // Ini untuk mencegah error Foreign Key (Integrity constraint violation) saat submit absen
            DB::table('pegawai')->insert([
                'kode_pegawai' => $kodeRandom,
                'nama_pegawai' => $request->name,
                'divisi' => null, // Diset null karena kolom input divisi sudah dihapus
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()->back()->with('success', 'User Baru Berhasil Didaftarkan dengan ID Unik: ' . $kodeRandom);
    }

    // 3. UPDATE: PROSES PERBARUI DATA USER
    public function update(Request $request, $id)
    {
        // Penyesuaian: Aturan divisi dilepas agar proses edit data tidak menuntut input divisi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
            'password' => 'nullable|min:6',
        ]);

        $userLama = DB::table('users')->where('id', $id)->first();

        DB::transaction(function () use ($request, $id, $userLama) {
            $dataUpdate = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'updated_at' => now(),
            ];

            // Jika password diisi, ganti password baru. Jika kosong, biarkan password lama.
            if ($request->filled('password')) {
                $dataUpdate['password'] = Hash::make($request->password);
            }

            // Update tabel users
            DB::table('users')->where('id', $id)->update($dataUpdate);

            // Selaraskan data ke tabel pegawai jika kodenya ada
            if ($userLama->kode_pegawai) {
                // PERBAIKAN PADA UPDATE: Apapun role hasil editnya, pastikan datanya sinkron di tabel pegawai
                $cekPegawai = DB::table('pegawai')->where('kode_pegawai', $userLama->kode_pegawai)->exists();
                
                if ($cekPegawai) {
                    DB::table('pegawai')->where('kode_pegawai', $userLama->kode_pegawai)->update([
                        'nama_pegawai' => $request->name,
                        'updated_at' => now()
                    ]);
                } else {
                    DB::table('pegawai')->insert([
                        'kode_pegawai' => $userLama->kode_pegawai,
                        'nama_pegawai' => $request->name,
                        'divisi' => null, // Diset null mengikuti form baru
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Data User Berhasil Diperbarui!');
    }

    // 4. DELETE: PROSES HAPUS USER
    public function destroy($id)
    {
        // Cegah Admin menghapus dirinya sendiri saat login
        if (Auth::id() == $id) {
            return redirect()->back()->with('error', 'Gagal! Anda tidak bisa menghapus akun Anda sendiri yang sedang aktif.');
        }

        $user = DB::table('users')->where('id', $id)->first();

        if ($user) {
            DB::transaction(function () use ($user, $id) {
                // Hapus dari tabel pegawai pendukung jika ada
                if ($user->kode_pegawai) {
                    DB::table('pegawai')->where('kode_pegawai', $user->kode_pegawai)->delete();
                    // Hapus juga riwayat absensinya agar tidak menyebabkan error relasi data kosong
                    DB::table('absensi')->where('kode_pegawai', $user->kode_pegawai)->delete();
                }
                // Hapus dari tabel users login
                DB::table('users')->where('id', $id)->delete();
            });
        }

        return redirect()->back()->with('success', 'User dan Seluruh Log Data Terkait Berhasil Dihapus!');
    }
}