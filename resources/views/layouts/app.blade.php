<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>@yield('title') - Attendance Pro</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
      
      :root {
        --tb-font-sans-serif: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }

      body {
        font-family: var(--tb-font-sans-serif);
        background-color: #f8fafc !important; /* Abu-abu ultra terang khas aplikasi modern */
        color: #1e293b;
      }

      /* Modifikasi Bar Atas agar Premium */
      .navbar {
        background: #ffffff !important;
        box-shadow: 0 1px 3px 0 rgba(15, 23, 42, 0.05), 0 1px 2px -1px rgba(15, 23, 42, 0.05) !important;
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 0.75rem 0;
      }

      .navbar-brand {
        font-size: 1.25rem;
        letter-spacing: -0.03em;
      }

      /* Pengaturan Navigasi Menu Atas */
      .navbar-nav .nav-link {
        color: #64748b !important;
        font-weight: 500;
        font-size: 0.875rem;
        padding: 0.5rem 1rem !important;
        border-radius: 6px;
        transition: all 0.2s ease;
      }

      .navbar-nav .nav-link:hover {
        color: #1d4ed8 !important; /* Biru gelap saat hover */
        background-color: #f1f5f9;
      }

      .navbar-nav .nav-item.active .nav-link {
        color: #2563eb !important; /* Biru aktif */
        background-color: #eff6ff;
        font-weight: 600;
      }

      /* Desain Komponen Halaman Anak (Card Global) agar Seragam */
      .card {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -2px rgba(0, 0, 0, 0.02) !important;
        border-radius: 12px !important;
      }

      .card-header {
        background: #ffffff !important;
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 1.25rem !important;
      }

      .card-title {
        color: #0f172a !important;
        font-weight: 600 !important;
      }

      /* Custom Input field agar serasi di tema putih */
      .form-control, .form-select {
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #0f172a !important;
        border-radius: 8px;
      }

      .form-control:focus, .form-select:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
      }

      .form-control[readonly] {
        background-color: #f8fafc !important;
        color: #64748b !important;
      }

      .form-label {
        color: #344054 !important;
        font-weight: 500 !important;
      }

      /* Avatar Karyawan */
      .avatar {
        border-radius: 8px !important;
        background-color: #dbeafe !important;
        color: #1e40af !important;
      }
    </style>
    @stack('css')
  </head>
  <body>
    <div class="page">
      
      <header class="navbar navbar-expand-md d-print-none sticky-top">
        <div class="container-xl">
          
          <h1 class="navbar-brand pe-0 pe-md-3">
            <a href="{{ route('absen.index') }}" class="text-decoration-none fw-bold text-dark">
              ATTENDANCE<span class="text-primary">PRO</span>
            </a>
          </h1>
          
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                <span class="avatar avatar-sm fw-bold">{{ substr(Auth::user()->name ?? 'User', 0, 2) }}</span>
                <div class="d-none d-xl-block ps-2">
                  <div class="fw-semibold text-dark">{{ Auth::user()->name ?? 'Karyawan' }}</div>
                  <div class="mt-1 small text-muted text-uppercase fw-bold" style="font-size: 9px; letter-spacing: 0.05em;">{{ Auth::user()->role ?? 'Pegawai' }}</div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow shadow-sm">
                <a href="{{ route('logout') }}" class="dropdown-item text-danger fw-medium" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M9 12h12l-3 -3m0 6l3 -3" /></svg>
                  Logout Aplikasi
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
              </div>
            </div>
          </div>

          <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
              <ul class="navbar-nav">
                
                <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                  <a class="nav-link d-flex align-items-center" href="{{ route('absen.index') }}">
                    <span class="nav-link-title">Absen Scanner</span>
                  </a>
                </li>
                
                <li class="nav-item {{ Request::is('riwayat') ? 'active' : '' }}">
                  <a class="nav-link d-flex align-items-center" href="{{ route('absen.riwayat') }}">
                    <span class="nav-link-title">Riwayat Absen</span>
                  </a>
                </li>

                <li class="nav-item {{ Request::is('akun') ? 'active' : '' }}">
                  <a class="nav-link d-flex align-items-center" href="{{ route('absen.akun') }}">
                    <span class="nav-link-title">Pengaturan Akun</span>
                  </a>
                </li>

                @if(Auth::user() && Auth::user()->role === 'admin')
                  <li class="nav-item {{ Request::is('admin/rekap') ? 'active' : '' }}">
                    <a class="nav-link text-primary" href="{{ route('admin.rekap') }}">
                      <span class="nav-link-title fw-semibold">Rekap Absen Global</span>
                    </a>
                  </li>

                  <li class="nav-item {{ Request::is('admin/users') ? 'active' : '' }}">
                    <a class="nav-link text-primary" href="{{ route('admin.users.index') }}">
                      <span class="nav-link-title fw-semibold">Manajemen User</span>
                    </a>
                  </li>
                @endif

              </ul>
            </div>
          </div>

        </div>
      </header>

      <div class="page-wrapper">
        <div class="page-body">
          <div class="container-xl">
            @yield('content')
          </div>
        </div>
      </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js" defer></script>
    @stack('js')
  </body>
</html>