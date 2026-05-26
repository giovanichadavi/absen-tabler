<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        // 1. PASANG PENGAMAN: Matikan pengecekan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        // 2. Sekarang kita bebas mengosongkan tabel tanpa protes dari MySQL
        DB::table('absensi')->truncate();
        DB::table('pegawai')->truncate();
        DB::table('users')->truncate();

        // 3. NYALAKAN KEMBALI PENGAMAN: Setelah tabel bersih
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        // ========================================================
        // PROSES INPUT DATA BARU (Sama seperti sebelumnya)
        // ========================================================

        // Akun Pegawai Biasa
        DB::table('users')->insert([
            'id' => 1,
            'kode_pegawai' => 'EMP-2026-001',
            'name' => 'Fahmi TRA',
            'email' => 'pegawai@gmail.com',
            'divisi' => 'Divisi TRA',
            'password' => Hash::make('password123'),
            'role' => 'pegawai',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pegawai')->insert([
            'kode_pegawai' => 'EMP-2026-001',
            'nama_pegawai' => 'Fahmi TRA',
            'divisi' => 'Divisi TRA',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Akun Admin
        DB::table('users')->insert([
            'id' => 2,
            'kode_pegawai' => 'ADM-2026-999',
            'name' => 'Syarif Admin',
            'email' => 'admin@gmail.com',
            'divisi' => 'Divisi Umum',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}