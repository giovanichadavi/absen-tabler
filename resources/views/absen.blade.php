@extends('layouts.app')

@section('title', 'Presensi Kamera')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-10">
    
    @if(session('error'))
      <div class="alert alert-important alert-danger alert-dismissible mb-3" role="alert">
        <div class="fw-bold">{{ session('error') }}</div>
      </div>
    @endif
    
    <div class="card border-0 shadow-sm bg-white">
      <div class="card-status-top bg-primary"></div>
      <div class="card-body p-4 p-md-5">
        <div class="row align-items-center">
          
          <div class="col-md-6 mb-4 mb-md-0 border-end border-light pe-md-4">
            <h2 class="h1 mb-2 text-dark fw-bold">Presensi Kehadiran</h2>
            <p class="text-muted mb-4 small">Hadapkan kode barcode/QR pada ID Card Anda ke area sorotan kamera di bawah ini.</p>
            
            <div id="reader" class="rounded-3 border border-2 border-primary overflow-hidden shadow-sm" style="background: #f8fafc; width: 100%; min-height: 250px;"></div>
          </div>
          
          <div class="col-md-6 ps-md-4">
            <form id="form-absen" action="{{ route('absen.store') }}" method="POST" class="p-4 bg-light rounded-3 border border-light">
              @csrf
              
              <div class="mb-3">
                <label class="form-label text-uppercase fw-bold text-primary small">Hasil Scan ID Card</label>
                <input type="text" id="employee_code" name="employee_code" class="form-control form-control-lg bg-white text-center text-dark font-monospace fw-bold fs-2 border-secondary" placeholder="WAITING SCAN..." readonly required>
              </div>

              <div class="row g-2 mb-2">
                <div class="col-6">
                  <label class="form-label small text-muted m-0 fw-medium">Gps Latitude</label>
                  <input type="text" id="lat" name="latitude" class="form-control bg-transparent border-0 text-center font-monospace text-dark fw-bold" readonly required placeholder="Mencari...">
                </div>
                <div class="col-6">
                  <label class="form-label small text-muted m-0 fw-medium">Gps Longitude</label>
                  <input type="text" id="lng" name="longitude" class="form-control bg-transparent border-0 text-center font-monospace text-dark fw-bold" readonly required placeholder="Mencari...">
                </div>
              </div>
            </form>
            
            <div class="mt-4 p-3 bg-blue-lt rounded-3 small d-flex align-items-center text-primary">
              <div>💡 <strong>Informasi Keamanan:</strong> Sistem mendeteksi koordinat lokasi satelit Anda secara otomatis untuk validasi di area kantor.</div>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>

@if(session('success'))
<div class="modal modal-blur fade show" id="modal-success-response" tabindex="-1" role="dialog" aria-modal="true" style="display: block; background: rgba(0, 0, 0, 0.45);">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content bg-white text-dark text-center shadow-lg border-0 animate__animated animate__bounceIn">
      <div class="modal-body py-4">
        <div class="mb-3 text-success">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg icon-tabler icon-tabler-circle-check-filled" width="64" height="64" viewBox="0 0 24 24" stroke-width="2" fill="currentColor">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M17 3.34a10 10 0 1 1 -14.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 14.995 -8.336zm-1.293 5.953a1 1 0 0 0 -1.414 0l-3.293 3.293l-1.293 -1.293l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z" />
          </svg>
        </div>
        <h2 class="fw-bold text-dark mb-2">
          @if(session('tipe_absen') === 'masuk')
            Absen Masuk Berhasil!
          @else
            Absen Pulang Berhasil!
          @endif
        </h2>
        <p class="text-muted small mb-0">{{ session('success') }}</p>
        <h3 class="text-success fw-bold mt-2">
          @if(session('tipe_absen') === 'masuk')
            Selamat Bekerja!
          @else
            Hati-hati di Jalan!
          @endif
        </h3>
      </div>
      <div class="modal-footer bg-light border-0 p-2">
        <button type="button" class="btn btn-success w-100 fw-bold py-2 shadow-sm" onclick="closeSuccessModal()">OK, MENGERTI</button>
      </div>
    </div>
  </div>
</div>
@endif
@endsection

@push('css')
<style>
  #reader video {
    transform: scaleX(-1);
    -webkit-transform: scaleX(-1);
  }
  #reader button {
    background-color: #206bc4 !important;
    color: white !important;
    border: none !important;
    padding: 8px 16px !important;
    border-radius: 6px !important;
    font-weight: 600 !important;
    margin: 10px 0 !important;
    cursor: pointer !important;
  }
  #reader button:hover {
    background-color: #1a569d !important;
  }
</style>
@endpush

@push('js')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
  let isSubmitting = false;

  function closeSuccessModal() {
      const modal = document.getElementById('modal-success-response');
      if (modal) {
          modal.style.display = 'none';
          modal.classList.remove('show');
      }
  }

  // 1. KONTROL KOORDINAT GPS LOKASI
  if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
          document.getElementById('lat').value = position.coords.latitude;
          document.getElementById('lng').value = position.coords.longitude;
      }, function(error) {
          alert("Akses lokasi ditolak! Harap aktifkan izin GPS browser Anda agar koordinat terisi.");
      });
  }

  // 2. KONTROL KAMERA PEMINDAI INSTAN
  function onScanSuccess(decodedText, decodedResult) {
      if (isSubmitting) return;
      isSubmitting = true;

      document.getElementById('employee_code').value = decodedText;
      document.getElementById('form-absen').submit();
  }

  let html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", 
      { 
          fps: 30, 
          rememberLastUsedCamera: true,
          disableFlip: false,
          supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
      }
  );
  html5QrcodeScanner.render(onScanSuccess);
</script>
@endpush