<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>@yield('title') - Attendance Pro</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
      body { font-family: 'Inter', sans-serif; }
    </style>
  </head>
  <body data-bs-theme="dark">
    <div class="page">
      
      <header class="navbar navbar-expand-md d-print-none sticky-top border-bottom">
        <div class="container-xl">
          <h1 class="navbar-brand d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="{{ route('absen.index') }}" class="text-decoration-none fw-bold">
              ATTENDANCE<span class="text-primary">PRO</span>
            </a>
          </h1>
          
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                <span class="avatar avatar-sm bg-blue-lt fw-bold">{{ substr(Auth::user()->name, 0, 2) }}</span>
                <div class="d-none d-xl-block ps-2">
                  <div>{{ Auth::user()->name }}</div>
                  <div class="mt-1 small text-muted text-uppercase" style="font-size: 10px;">{{ Auth::user()->role }}</div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="{{ route('logout') }}" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
              </div>
            </div>
          </div>

          <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
              <ul class="navbar-nav">
                
                <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('absen.index') }}">
                    <span class="nav-link-title">Absen Scanner</span>
                  </a>
                </li>
                
                <li class="nav-item {{ Request::is('riwayat') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('absen.riwayat') }}">
                    <span class="nav-link-title">Riwayat Absen</span>
                  </a>
                </li>

                <li class="nav-item {{ Request::is('akun') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route('absen.akun') }}">
                    <span class="nav-link-title">Pengaturan Akun</span>
                  </a>
                </li>

                @if(Auth::user()->role === 'admin')
                <li class="nav-item {{ Request::is('admin/rekap') ? 'active' : '' }}">
                  <a class="nav-link text-warning fw-bold" href="{{ route('admin.rekap') }}">
                    <span class="nav-link-title">★ Kelola Data Seluruh Absen (Admin)</span>
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