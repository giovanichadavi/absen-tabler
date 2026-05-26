@extends('layouts.app')

@section('title', 'Manajemen CRUD User')

@section('content')
<div class="row g-4">
  
  <div class="col-lg-4">
    
    @if(session('success'))
      <div class="alert alert-important alert-success alert-dismissible mb-3" role="alert">
        <div>{{ session('success') }}</div>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-important alert-danger alert-dismissible mb-3" role="alert">
        <div>{{ session('error') }}</div>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-important alert-danger mb-3" role="alert">
        <ul class="mb-0 small">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="card shadow-sm">
      <div class="card-status-top bg-blue"></div>
      <div class="card-header">
        <h3 class="card-title fw-bold text-dark">Tambah Pengguna Baru</h3>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
          @csrf
          
          <input type="hidden" name="kode_pegawai" value="AUTOMATIC_GENERATED">

          <div class="mb-3">
            <label class="form-label text-dark fw-medium">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label text-dark fw-medium">Alamat Email</label>
            <input type="email" name="email" class="form-control" placeholder="nama@gmail.com" value="{{ old('email') }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label text-dark fw-medium">Hak Akses Sistem (Role)</label>
            <select name="role" class="form-select" required>
              <option value="pegawai">Pegawai</option>
              <option value="admin">Admin</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label text-dark fw-medium">Password Awal</label>
            <div class="input-group input-group-flat">
              <input type="password" id="pass_tambah" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
              <span class="input-group-text bg-transparent border-start-0" style="cursor: pointer;" onclick="togglePassword('pass_tambah')">
                <svg xmlns="http://www.w3.org/2000/svg" id="icon_pass_tambah" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                  <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                </svg>
              </span>
            </div>
          </div>

          <button type="submit" class="btn btn-primary w-100 fw-bold py-2">SIMPAN DATA PENGGUNA</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-header bg-white border-bottom">
        <h3 class="card-title fw-bold text-dark">Daftar Pengguna Sistem</h3>
      </div>
      <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped table-hover">
          <thead>
            <tr class="bg-light text-muted">
              <th>ID Code</th>
              <th>Nama Pengguna & QR Barcode</th>
              <th class="text-center">Role</th>
              <th class="w-1 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              <tr>
                <td class="font-monospace text-info fw-bold">{{ $user->kode_pegawai ?? '-' }}</td>
                <td class="text-dark">
                  <div class="d-flex align-items-center gap-3">
                    <div class="p-2 bg-white border rounded shadow-sm d-inline-block label-qr-container" 
                         style="cursor: pointer;" 
                         title="Klik untuk memperbesar & download"
                         onclick="previewQrCode('{{ $user->kode_pegawai }}', '{{ $user->name }}', this)">
                      @if($user->kode_pegawai)
                        {!! QrCode::size(65)->generate($user->kode_pegawai) !!}
                      @else
                        <span class="text-muted small">No QR</span>
                      @endif
                    </div>
                    <div>
                      <div class="fw-bold fs-3 text-dark mb-1">{{ $user->name }}</div>
                      <div class="small text-muted font-monospace">{{ $user->email }}</div>
                    </div>
                  </div>
                </td>
                <td class="text-center">
                  @if($user->role === 'admin')
                    <span class="badge bg-warning text-dark fw-bold">ADMIN</span>
                  @else
                    <span class="badge bg-blue text-blue-fg fw-bold">PEGAWAI</span>
                  @endif
                </td>
                <td class="text-center">
                  <div class="btn-list flex-nowrap justify-content-center">
                    <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $user->id }}">
                      Edit
                    </button>
                    
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini? Seluruh log absen terkait juga akan ikut terhapus otomatis.');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger">
                        Hapus
                      </button>
                    </form>
                  </div>
                </td>
              </tr>

              <div class="modal modal-blur fade" id="modal-edit-{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content bg-white text-dark">
                    <div class="modal-header border-bottom">
                      <h5 class="modal-title fw-bold text-dark">Edit Data: {{ $user->name }}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="modal-body">
                        
                        <div class="mb-3 text-center">
                          <label class="form-label text-start text-dark fw-medium mb-2">QR Code ID Pegawai</label>
                          <div class="p-3 bg-white border rounded shadow-sm d-inline-block mx-auto label-qr-container" 
                               style="cursor: pointer;" 
                               title="Klik untuk memperbesar & download"
                               onclick="previewQrCode('{{ $user->kode_pegawai }}', '{{ $user->name }}', this)">
                            @if($user->kode_pegawai)
                              {!! QrCode::size(120)->generate($user->kode_pegawai) !!}
                            @endif
                          </div>
                          <div class="mt-2 font-monospace text-muted small">{{ $user->kode_pegawai ?? '-' }}</div>
                        </div>

                        <div class="mb-3">
                          <label class="form-label text-dark fw-medium">Nama Lengkap</label>
                          <input type="text" name="name" class="form-control text-dark" value="{{ $user->name }}" required>
                        </div>

                        <div class="mb-3">
                          <label class="form-label text-dark fw-medium">Alamat Email</label>
                          <input type="email" name="email" class="form-control text-dark" value="{{ $user->email }}" required>
                        </div>

                        <div class="mb-3">
                          <label class="form-label text-dark fw-medium">Role Akses</label>
                          <select name="role" class="form-select text-dark" required>
                            <option value="pegawai" {{ $user->role == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                          </select>
                        </div>

                        <div class="mb-3">
                          <label class="form-label text-dark fw-medium">Password Baru <span class="text-muted small">(*Kosongkan jika tidak ingin diubah)</span></label>
                          <div class="input-group input-group-flat">
                            <input type="password" id="pass_edit_{{ $user->id }}" name="password" class="form-control text-dark" placeholder="Masukkan password baru jika ingin diganti">
                            <span class="input-group-text bg-transparent border-start-0" style="cursor: pointer;" onclick="togglePassword('pass_edit_{{ $user->id }}')">
                              <svg xmlns="http://www.w3.org/2000/svg" id="icon_pass_edit_{{ $user->id }}" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                              </svg>
                            </span>
                          </div>
                        </div>

                      </div>
                      <div class="modal-footer border-top">
                        <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info fw-bold">SIMPAN PERUBAHAN</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<div class="modal modal-blur fade" id="modal-preview-qrcode" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content bg-white text-dark text-center shadow-lg border-0">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold text-dark mx-auto" id="preview-user-name">Nama Pengguna</h5>
        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <div id="preview-qrcode-target" class="p-4 bg-white border rounded shadow-sm d-inline-block mb-3"></div>
        <div class="font-monospace fw-bold text-info fs-3 mb-1" id="preview-user-code">EMP-XXXXXX</div>
        <p class="text-muted small mb-0">Scan barcode ini melalui aplikasi kamera presensi alat kerja.</p>
      </div>
      <div class="modal-footer bg-light border-0 justify-content-center py-3">
        <a href="#" id="btn-download-qrcode" class="btn btn-primary fw-bold w-100" download="qrcode.png">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
             <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
             <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
             <path d="M7 11l5 5l5 -5"></path>
             <path d="M12 4l0 12"></path>
          </svg>
          UNDUH GAMBAR QR
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
  function togglePassword(inputId) {
    const passwordInput = document.getElementById(inputId);
    const eyeIcon = document.getElementById('icon_' + inputId);
    
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      eyeIcon.innerHTML = `
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M10.584 10.587a2 2 0 0 0 2.829 2.83" />
        <path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" />
        <path d="M3 3l18 18" />
      `;
    } else {
      passwordInput.type = "password";
      eyeIcon.innerHTML = `
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
      `;
    }
  }

  // JAVASCRIPT BARU: PROSES ZOOM & CONVERT SVG KE PNG UNTUK FITUR DOWNLOAD
  function previewQrCode(userCode, userName, element) {
    // 1. Ambil mentahan tag SVG dari QR Code yang diklik
    const svgElement = element.querySelector('svg');
    if (!svgElement) return;

    // 2. Kloning SVG dan perbesar ukurannya agar kualitas cetak unduhan tajam (tidak pecah)
    const clonedSvg = svgElement.cloneNode(true);
    clonedSvg.setAttribute('width', '200');
    clonedSvg.setAttribute('height', '200');

    // 3. Masukkan ke dalam target area modal preview
    const targetContainer = document.getElementById('preview-qrcode-target');
    targetContainer.innerHTML = '';
    targetContainer.appendChild(clonedSvg);

    // 4. Ubah teks deskripsi modal sesuai user yang dipilih
    document.getElementById('preview-user-name').innerText = userName;
    document.getElementById('preview-user-code').innerText = userCode;

    // 5. LOGIKA EKSTRAKSI DAN KONVERSI DATA SVG BIAR BISA DI-DOWNLOAD SEBAGAI FILE PNG 
    const svgString = new XMLSerializer().serializeToString(clonedSvg);
    const svgBlob = new Blob([svgString], { type: 'image/svg+xml;charset=utf-8' });
    const URL = window.URL || window.webkitURL || window;
    const blobURL = URL.createObjectURL(svgBlob);
    
    const image = new Image();
    image.onload = function () {
        const canvas = document.createElement('canvas');
        canvas.width = 240;
        canvas.height = 240;
        const context = canvas.getContext('2d');
        
        // Buat background putih bersih di canvas agar QR Code mudah dibaca mesin scan HP
        context.fillStyle = '#FFFFFF';
        context.fillRect(0, 0, canvas.width, canvas.height);
        
        // Gambar QR Code tepat di tengah canvas
        context.drawImage(image, 20, 20);
        
        const pngDataUrl = canvas.toDataURL('image/png');
        const downloadBtn = document.getElementById('btn-download-qrcode');
        downloadBtn.href = pngDataUrl;
        downloadBtn.download = `QR_Code_${userCode}_${userName.replace(/\s+/g, '_')}.png`;
    };
    image.src = blobURL;

    // 6. Tampilkan Modal Zoom ke layar browser
    const previewModal = new bootstrap.Modal(document.getElementById('modal-preview-qrcode'));
    previewModal.show();
  }
</script>
@endpush