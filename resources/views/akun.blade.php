@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    
    @if(session('success'))
      <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger mb-3">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow">
      <div class="card-header bg-dark">
        <h3 class="card-title text-white">Ubah Keamanan Password</h3>
      </div>
      <div class="card-body">
        <form action="{{ route('absen.akun.post') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label text-white">Password Lama</label>
            <input type="password" name="password_lama" class="form-control bg-dark text-white border-secondary" required>
          </div>
          <div class="mb-3">
            <label class="form-label text-white">Password Baru</label>
            <input type="password" name="password_baru" class="form-control bg-dark text-white border-secondary" required placeholder="Minimal 6 karakter">
          </div>
          <div class="mb-3">
            <label class="form-label text-white">Konfirmasi Password Baru</label>
            <input type="password" name="password_baru_confirmation" class="form-control bg-dark text-white border-secondary" required>
          </div>
          <button type="submit" class="btn btn-warning w-100 fw-bold">PERBARUI PASSWORD</button>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection