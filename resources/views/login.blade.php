<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Login - Attendance Pro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
  </head>
  <body class="d-flex flex-column bg-dark">
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <h1 class="navbar-brand-autodark fw-bold text-white fs-1">ATTENDANCE<span class="text-primary">PRO</span></h1>
        </div>
        
        @if(session('error'))
          <div class="alert alert-danger mb-3">{{ session('error') }}</div>
        @endif

        <div class="card card-md border-0 shadow-lg" style="background: #1e293b;">
          <div class="card-body">
            <h2 class="h2 text-center mb-4 text-white">Silakan Masuk ke Akun Anda</h2>
            <form action="{{ route('login.post') }}" method="POST" autocomplete="off">
              @csrf
              <div class="mb-3">
                <label class="form-label text-white">Alamat Email</label>
                <input type="email" name="email" class="form-control bg-dark border-secondary text-white" placeholder="Masukkan email anda" required>
              </div>
              <div class="mb-3">
                <label class="form-label text-white">Password</label>
                <input type="password" name="password" class="form-control bg-dark border-secondary text-white" placeholder="Masukkan password anda" required>
              </div>
              <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100 py-2 fs-3">Sign In</button>
              </div>
            </form>
          </div>
        </div>
        <div class="text-center text-muted mt-3">
          Akun Uji Coba Pegawai: <span class="text-light">pegawai@gmail.com</span> / <span class="text-light">password123</span><br>
          Akun Uji Coba Admin: <span class="text-light">admin@gmail.com</span> / <span class="text-light">admin123</span>
        </div>
      </div>
    </div>
  </body>
</html>