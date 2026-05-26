@extends('layouts.app')

@section('title', 'Panel Rekap Direksi Admin')

@section('content')
<div class="card border-0 shadow-lg border-warning">
  <div class="card-header bg-dark d-flex justify-content-between align-items-center">
    <h3 class="card-title text-warning fw-bold">PANEL MONITORING SELURUH ABSENSI PEGAWAI</h3>
    <span class="badge bg-warning text-dark fw-bold">ADMIN MODE</span>
  </div>
  <div class="table-responsive">
    <table class="table table-vcenter card-table table-striped text-white">
      <thead>
        <tr class="bg-dark text-light">
          <th>Nama Pegawai</th>
          <th>Divisi / Unit</th>
          <th>ID Code</th>
          <th>Waktu Tempel Absen</th>
          <th>Lokasi GPS Alat</th>
        </tr>
      </thead>
      <tbody>
        @forelse($semua_absen as $row)
          <tr>
            <td class="fw-bold text-info">{{ $row->nama_pegawai }}</td>
            <td><span class="badge bg-secondary-lt">{{ $row->divisi }}</span></td>
            <td class="font-monospace text-muted">{{ $row->kode_pegawai }}</td>
            <td>{{ date('d-M-Y H:i:s', strtotime($row->waktu_absen)) }}</td>
            <td class="small text-yellow">{{ $row->latitude }}, {{ $row->longitude }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center py-4 text-muted">Belum ada satupun pegawai yang menginput data absen hari ini.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection