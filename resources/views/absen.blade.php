@extends('layouts.app')

@section('title', 'Presensi Kamera')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-10">
    
    @if(session('success'))
      <div class="alert alert-important alert-success alert-dismissible mb-3" role="alert">
        <div class="fw-bold">{{ session('success') }}</div>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-important alert-danger alert-dismissible mb-3" role="alert">
        <div class="fw-bold">{{ session('error') }}</div>
      </div>
    @endif
    
    <div class="card card-lg border-0 shadow-lg" style="background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px);">
      <div class="card-status-top bg-blue"></div>
      <div class="card-body p-4 p-md-5">
        <div class="row align-items-center">
          
          <div class="col-md-6 mb-4 mb-md-0 border-end border-secondary pe-md-4">
            <h2 class="h1 mb-2 text-white fw-bold">Presensi Kehadiran</h2>
            <p class="text-muted mb-4 small">Hadapkan kode barcode/QR pada ID Card Anda ke area sorotan kamera di bawah ini.</p>
            
            <div id="reader" class="rounded-3 border border-2 border-primary overflow-hidden shadow" style="background: #020617; width: 100%; min-height: 250px;"></div>
          </div>
          
          <div class="col-md-6 ps-md-4">
            <form action="{{ route('absen.store') }}" method="POST" class="p-3 bg-dark-lt rounded border border-secondary">
              @csrf
              
              <div class="mb-3">
                <label class="form-label text-uppercase fw-bold text-primary small">Hasil Scan ID Card</label>
                <input type="text" id="employee_code" name="employee_code" class="form-control form-control-lg bg-dark border-secondary text-center text-white font-monospace fw-bold" placeholder="WAITING SCAN..." readonly required>
              </div>

              <div class="row g-2 mb-4">
                <div class="col-6">
                  <label class="form-label small text-muted m-0">Gps Latitude</label>
                  <input type="text" id="lat" name="latitude" class="form-control bg-transparent border-0 text-center font-monospace text-light fw-bold" readonly required placeholder="Mencari...">
                </div>
                <div class="col-6">
                  <label class="form-label small text-muted m-0">Gps Longitude</label>
                  <input type="text" id="lng" name="longitude" class="form-control bg-transparent border-0 text-center font-monospace text-light fw-bold" readonly required placeholder="Mencari...">
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-lg w-100 shadow fw-bold py-2">SUBMIT KEHADIRAN</button>
            </form>
            
            <div class="mt-4 p-3 bg-blue-lt rounded small d-flex align-items-center">
              <div>💡 <strong>Informasi Keamanan:</strong> Sistem mendeteksi koordinat lokasi satelit Anda secara otomatis untuk validasi di area kantor.</div>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('js')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
  // 1. KONTROL KOORDINAT GPS LOKASI
  if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
          document.getElementById('lat').value = position.coords.latitude;
          document.getElementById('lng').value = position.coords.longitude;
      }, function(error) {
          alert("Akses lokasi ditolak! Harap aktifkan izin GPS browser Anda agar koordinat terisi.");
      });
  }

  // 2. KONTROL KAMERA PEMINDAI
  function onScanSuccess(decodedText, decodedResult) {
      document.getElementById('employee_code').value = decodedText;
      alert("Barcode Sukses Terbaca: " + decodedText);
  }

  let html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", { fps: 15, qrbox: { width: 220, height: 220 }, rememberLastUsedCamera: true }
  );
  html5QrcodeScanner.render(onScanSuccess);
</script>
@endpush