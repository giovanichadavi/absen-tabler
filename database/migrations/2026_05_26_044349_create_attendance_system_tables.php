<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    // 1. MEMBUAT TABEL PEGAWAI
    Schema::create('pegawai', function (Blueprint $table) {
        $table->id();
        $table->string('kode_pegawai')->unique(); // Contoh: EMP-2026-001 (Ini yang nanti dicetak jadi Barcode/QR)
        $table->string('nama_pegawai');
        $table->string('divisi');
        $table->timestamps();
    });

    // 2. MEMBUAT TABEL LOG ABSENSI
    Schema::create('absensi', function (Blueprint $table) {
        $table->id();
        $table->string('kode_pegawai');
        $table->dateTime('waktu_absen');
        $table->string('latitude');
        $table->string('longitude');
        $table->timestamps();

        // Hubungkan relasi kode_pegawai di tabel absensi ke tabel pegawai
        $table->foreign('kode_pegawai')->references('kode_pegawai')->on('pegawai')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_system_tables');
    }
};
