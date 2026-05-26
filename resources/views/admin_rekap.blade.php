@extends('layouts.app')

@section('title', 'Panel Rekap Direksi Admin')

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
    <h3 class="card-title text-dark fw-bold m-0">PANEL MONITORING SELURUH ABSENSI PEGAWAI</h3>
    <span class="badge bg-warning text-dark fw-bold">ADMIN MODE</span>
  </div>
  <div class="table-responsive">
    <table class="table table-vcenter card-table table-striped table-hover text-dark">
      <thead>
        <tr class="bg-light text-muted">
          <th>Nama Pengguna</th>
          <th>Alamat Email</th>
          <th>ID Code</th>
          <th>Waktu Tempel Absen</th>
          <th class="text-center">Kategori</th>
          <th class="text-end">Lokasi GPS Alat</th>
        </tr>
      </thead>
      <tbody>
        @php
          // PERBAIKAN UTAMA: Hitung urutan absen per orang, per hari secara dinamis
          $counterUrutan = [];
          
          // Balik data dari terlama ke terbaru agar kalkulasi urutannya runut secara kronologis
          $koleksiKronologis = $semua_absen->reverse();
          
          foreach($koleksiKronologis as $item) {
              $tanggal = date('Y-m-d', strtotime($item->waktu_absen));
              $keyUnik = $tanggal . '_' . $item->kode_pegawai;
              
              if(!isset($counterUrutan[$keyUnik])) {
                  $counterUrutan[$keyUnik] = 0;
              }
              $counterUrutan[$keyUnik]++;
              
              // Tentukan status virtual berdasarkan urutan ketuk di tanggal tersebut
              $item->tipe_virtual = ($counterUrutan[$keyUnik] == 1) ? 'masuk' : 'pulang';
          }
        @endphp

        @forelse($semua_absen as $row)
          <tr>
            <td class="fw-bold text-primary fs-3">{{ $row->nama_pegawai }}</td>
            <td class="text-muted font-monospace small">{{ $row->email }}</td>
            <td class="font-monospace text-dark fw-bold">{{ $row->kode_pegawai }}</td>
            <td class="fw-medium">{{ date('d-M-Y H:i:s', strtotime($row->waktu_absen)) }}</td>
            <td class="text-center">
              @if(($row->tipe_virtual ?? 'masuk') === 'pulang')
                <span class="badge bg-blue text-white fw-bold">PULANG</span>
              @else
                <span class="badge bg-success text-white fw-bold">MASUK</span>
              @endif
            </td>
            <td class="text-end font-monospace small text-blue">{{ $row->latitude }}, {{ $row->longitude }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center py-4 text-muted">Belum ada satupun pengguna yang melakukan input data absen hari ini.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection