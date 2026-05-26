@extends('layouts.app')

@section('title', 'Riwayat Absensi Saya')

@section('content')
<div class="card border-0 shadow-sm bg-white">
  <div class="card-header bg-white border-bottom">
    <h3 class="card-title text-dark fw-bold m-0">Log Riwayat Kehadiran Anda</h3>
  </div>
  <div class="table-responsive">
    <table class="table table-vcenter card-table table-striped table-hover text-dark">
      <thead>
        <tr class="bg-light text-muted">
          <th>No</th>
          <th>Kode Pegawai</th>
          <th>Waktu Log Absen</th>
          <th>Koordinat Maps (Latitude, Longitude)</th>
          <th class="w-1 text-center">Tipe Absen</th>
        </tr>
      </thead>
      <tbody>
        @php
          // PERBAIKAN UTAMA: Kelompokkan jumlah absen per hari untuk menentukan Masuk/Pulang secara akurat
          $counterPerHari = [];
          
          // Balik data dari urutan terlama ke terbaru untuk menghitung index masuk/pulang secara kronologis
          $dataUrutKronologis = $data_absen->reverse();
          
          foreach($dataUrutKronologis as $item) {
              $tanggal = date('Y-m-d', strtotime($item->waktu_absen));
              if(!isset($counterPerHari[$tanggal])) {
                  $counterPerHari[$tanggal] = 0;
              }
              $counterPerHari[$tanggal]++;
              
              // Simpan tipe virtual ke dalam objek data secara dinamis
              $item->tipe_virtual = ($counterPerHari[$tanggal] == 1) ? 'masuk' : 'pulang';
          }
        @endphp

        @forelse($data_absen as $key => $row)
          <tr>
            <td class="text-dark fw-medium">{{ $key + 1 }}</td>
            <td class="font-monospace text-info fw-bold">{{ $row->kode_pegawai }}</td>
            <td class="text-dark fw-bold fs-3">{{ date('d F Y - H:i:s', strtotime($row->waktu_absen)) }}</td>
            <td class="text-dark font-monospace small fw-medium">{{ $row->latitude }}, {{ $row->longitude }}</td>
            <td class="text-center">
              @if(($row->tipe_virtual ?? 'masuk') === 'pulang')
                <span class="badge bg-blue text-white fw-bold">PULANG</span>
              @else
                <span class="badge bg-success text-white fw-bold">MASUK</span>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center py-4 text-muted fw-medium">Belum ada riwayat absensi pada akun Anda.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection