@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="row g-4">
  
  <div class="col-lg-4">
    
    @if(session('success'))
      <div class="alert alert-important alert-success alert-dismissible mb-3" role="alert">
        <div>{{ session('success') }}</div>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-important alert-danger mb-3" role="alert">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="card shadow-sm">
      <div class="card-status-top bg-blue"></div>
      <div class="card-header">
        <h3 class="card-title fw-bold text-white">Tambah Pengguna Baru</h3>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
          @csrf
          
          <div class="mb-3">
            <label class="form-label text-white">Kode Pegawai / ID Unik</label>
            <input type="text" name="kode_pegawai" class="form-control bg-dark text-white border-secondary font-monospace" placeholder="Contoh: EMP-2026-002" value="{{ old('kode_pegawai') }}" required>
            <small class="form-hint text-muted">Kode ini yang dicetak menjadi Barcode/QR Code.</small>
          </div>

          <div class="mb-3">
            <label class="form-label text-white">Nama Lengkap</label>
            <input type="text" name="name" class="form-control bg-dark text-white border-secondary" placeholder="Masukkan nama" value="{{ old('name') }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label text-white">Alamat Email</label>
            <input type="email" name="email" class="form-control bg-dark text-white border-secondary" placeholder="nama@gmail.com" value="{{ old('email') }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label text-white">Divisi / Bagian</label>
            <select name="divisi" class="form-select bg-dark text-white border-secondary" required>
              <option value="">-- Pilih Divisi --</option>
              <option value="Divisi TRA">Divisi TRA (Tunggakan Rekening Air)</option>
              <option value="Divisi Umum">Divisi Umum</option>
              <option value="Unit Lawe-Lawe">Unit Lawe-Lawe</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label text-white">Hak Akses Sistem (Role)</label>
            <div class="form-selectgroup form-selectgroup-boxes d-flex">
              <label class="form-selectgroup-item flex-fill">
                <input type="radio" name="role" value="pegawai" class="form-selectgroup-input" checked>
                <span class="form-selectgroup-label d-flex align-items-center p-3bg-dark">
                  <span class="me-3"><span class="form-selectgroup-check"></span></span>
                  <span class="form-selectgroup-label-content text-start">
                    <span class="form-selectgroup-title text-white fw-bold">Pegawai</span>
                    <span class="d-block text-muted small">Bisa absen & cek riwayat</span>
                  </span>
                </span>
              </label>
              <label class="form-selectgroup-item flex-fill">
                <input type="radio" name="role" value="admin" class="form-selectgroup-input">
                <span class="form-selectgroup-label d-flex align-items-center p-3 bg-dark">
                  <span class="me-3"><span class="form-selectgroup-check"></span></span>
                  <span class="form-selectgroup-label-content text-start">
                    <span class="form-selectgroup-title text-warning fw-bold">Admin</span>
                    <span class="d-block text-muted small">Akses semua rekap data</span>
                  </span>
                </span>
              </label>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label text-white">Password Awal</label>
            <input type="password" name="password" class="form-control bg-dark text-white border-secondary" placeholder="Minimal 6 karakter" required>
          </div>

          <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mt-2">SIMPAN PENGGUNA</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-header bg-dark">
        <h3 class="card-title fw-bold text-white">Daftar Pengguna Sistem</h3>
      </div>
      <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped table-hover text-white">
          <thead>
            <tr class="bg-dark text-muted">
              <th>ID Code</th>
              <th>Nama Pengguna</th>
              <th>Email</th>
              <th>Divisi</th>
              <th class="text-center">Role</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              <tr>
                <td class="font-monospace text-info fw-bold">{{ $user->kode_pegawai }}</td>
                <td class="fw-medium text-white">{{ $user->name }}</td>
                <td class="text-muted small">{{ $user->email }}</td>
                <td><span class="badge bg-secondary-lt">{{ $user->divisi }}</span></td>
                <td class="text-center">
                  @if($user->role === 'admin')
                    <span class="badge bg-warning text-dark fw-bold">ADMIN</span>
                  @else
                    <span class="badge bg-blue text-blue-fg fw-bold">PEGAWAI</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection