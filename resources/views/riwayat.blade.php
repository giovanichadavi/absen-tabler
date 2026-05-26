@extends('layouts.app')

@section('title', 'Riwayat Absensi Saya')

@section('content')
<div class="card border-0 shadow">
  <div class="card-header bg-dark">
    <h3 class="card-title text-white">Log Riwayat Kehadiran Anda</h3>
  </div>
  <div class="table-responsive">
    <table class="table table-vcenter card-table table-striped table-hover">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode Pegawai</th>
          <th>Waktu Log Absen</th>
          <th>Koordinat Maps (Latitude, Longitude)</th>
          <th class="w-1">Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse($data_absen as $key => $row)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td class="text-muted font-monospace">{{ $row->kode_pegawai }}</td>
            <td class="text-light fw-medium">{{ date('d F Y - H:i:s', strtotime($row->waktu_absen)) }}</td>
            <td class="text-muted small">{{ $row->latitude }}, {{ $row->longitude }}</td>
            <td><span class="badge bg-green text-green-fg font-weight-bold">HADIR</span></td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat absensi pada akun Anda.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection