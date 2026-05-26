<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Login Account - Attendance Pro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
      body {
        font-family: 'Inter', sans-serif;
        background: radial-gradient(circle at 10% 10%, rgba(0, 118, 246, 0.08) 0%, transparent 45%),
                    linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1.5rem;
        overflow-x: hidden;
      }

      /* KARTU UTAMA SPLIT SCREEN */
      .blueprint-login-card {
        width: 100%;
        max-width: 960px;
        min-height: 560px;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.15);
        display: flex;
        overflow: hidden;
        z-index: 1;
        border: 1px solid rgba(0, 0, 0, 0.05);
        animation: cardEntrance 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
      }

      @keyframes cardEntrance {
        from { opacity: 0; transform: scale(0.97) translateY(20px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
      }

      /* SISI KIRI: BLUEPRINT & TECH WAVE BANNER */
      .side-blueprint {
        flex: 1;
        background: linear-gradient(180deg, #38bdf8 0%, #0284c7 50%, #0369a1 100%);
        position: relative;
        padding: 4.5rem 3.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: #ffffff;
        overflow: hidden;
      }

      .side-blueprint::before {
        content: '';
        position: absolute;
        inset: 0;
        background-size: 30px 30px;
        background-image: linear-gradient(to right, rgba(255, 255, 255, 0.08) 1px, transparent 1px),
                          linear-gradient(to bottom, rgba(255, 255, 255, 0.08) 1px, transparent 1px);
        z-index: 1;
      }

      .tech-wave-1 {
        position: absolute;
        width: 150%;
        height: 60%;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 43% 45% 40% 41%;
        top: -15%;
        left: -20%;
        z-index: 2;
        animation: waveMotion 12s linear infinite alternate;
      }

      .tech-wave-2 {
        position: absolute;
        width: 160%;
        height: 50%;
        background: rgba(3, 105, 161, 0.4);
        border-radius: 40% 42% 44% 41%;
        bottom: -10%;
        right: -30%;
        z-index: 2;
        animation: waveMotion 16s linear infinite alternate-reverse;
      }

      .tech-node {
        position: absolute;
        width: 10px;
        height: 10px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        z-index: 2;
      }
      .node-1 { top: 20%; right: 20%; box-shadow: 0 0 12px #ffffff; }
      .node-2 { bottom: 25%; left: 15%; width: 14px; height: 14px; background: rgba(255, 255, 255, 0.2); }

      @keyframes waveMotion {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(15deg); }
      }

      .blueprint-content {
        position: relative;
        z-index: 3;
      }

      .text-company {
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 5rem;
        display: flex;
        align-items: center;
        gap: 6px;
      }

      .text-sub-welcome {
        font-size: 1.1rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 0.5rem;
      }

      .text-main-welcome {
        font-size: 3rem;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        line-height: 1.1;
        margin-bottom: 1.25rem;
      }

      .welcome-line-indicator {
        width: 32px;
        height: 4px;
        background: #ffffff;
        border-radius: 2px;
        margin-bottom: 2rem;
      }

      .text-blueprint-desc {
        font-size: 0.8rem;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.7);
        max-width: 360px;
      }

      /* SISI KANAN: PURE WHITE MINIMALIST FORM */
      .side-clean-form {
        flex: 1;
        background: #ffffff;
        padding: 4.5rem 4rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
      }

      .text-login-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #0284c7;
        margin-bottom: 0.5rem;
        text-align: center;
      }

      .text-login-subtitle {
        font-size: 0.75rem;
        color: #94a3b8;
        line-height: 1.5;
        text-align: center;
        max-width: 320px;
        margin: 0 auto 3rem auto;
      }

      /* INPUT FIELD DENGAN INDIKATOR GARIS BIRU TEBAL VERTIKAL */
      .blueprint-input-box {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border-left: 4px solid #0284c7;
        border-radius: 0 8px 8px 0;
        padding: 0.4rem 1.25rem;
        margin-bottom: 1.25rem;
        transition: all 0.2s ease;
      }

      .blueprint-input-box:focus-within {
        background: #f0fdf4;
        border-left-color: #16a34a;
      }

      .blueprint-input-box .form-control-blank {
        border: none !important;
        background: transparent !important;
        padding: 0.6rem 0;
        font-size: 0.9rem;
        color: #1e293b !important;
        width: 100%;
      }

      .blueprint-input-box .form-control-blank::placeholder {
        color: #cbd5e1;
      }

      .blueprint-input-box .form-control-blank:focus {
        outline: none !important;
        box-shadow: none !important;
      }

      .btn-eye-toggle {
        background: transparent;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 0.25rem;
        transition: color 0.2s;
      }
      
      .btn-eye-toggle:hover {
        color: #0284c7;
      }

      .row-options-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.8rem;
        margin-bottom: 2.5rem;
      }

      .row-options-bar .form-check-label {
        color: #64748b;
        font-weight: 500;
      }

      .row-options-bar .form-check-input:checked {
        background-color: #0284c7;
        border-color: #0284c7;
      }

      .link-member-check {
        color: #0284c7;
        text-decoration: none;
        font-weight: 600;
      }
      .link-member-check:hover { text-decoration: underline; }

      .btn-blueprint-submit {
        background: #0284c7;
        color: #ffffff;
        border: none;
        border-radius: 50px;
        padding: 0.9rem;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        width: 100%;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(2, 132, 199, 0.25);
        transition: all 0.2s ease;
      }

      .btn-blueprint-submit:hover {
        background: #0369a1;
        transform: translateY(-1px);
        box-shadow: 0 12px 24px rgba(2, 132, 199, 0.35);
      }

      @media (max-width: 880px) {
        .side-blueprint { display: none !important; }
        .blueprint-login-card { max-width: 440px; min-height: auto; }
        .side-clean-form { padding: 3.5rem 2rem; }
      }
    </style>
  </head>
  <body>

    <div class="blueprint-login-card">
      
      <div class="side-blueprint">
        <div class="tech-wave-1"></div>
        <div class="tech-wave-2"></div>
        <div class="tech-node node-1"></div>
        <div class="tech-node node-2"></div>
        
        <div class="blueprint-content">
          <div class="text-company">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-dot" width="24" height="24" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" style="width:16px; height:16px;">
               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
               <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
               <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
            </svg>
            COMPANY NAME
          </div>
          
          <p class="text-sub-welcome">Hallo</p>
          <h1 class="text-main-welcome">Selamat<br>Datang</h1>
          <div class="welcome-line-indicator"></div>
          
          <p class="text-blueprint-desc">
            Sistem Absensi Karyawan berbasis QR Code yang memudahkan proses pencatatan kehadiran dengan cepat, akurat, dan aman. Cukup scan QR Code untuk melakukan absensi masuk dan pulang, serta akses riwayat kehadiran kapan saja.
          </p>
        </div>
      </div>

      <div class="side-clean-form">
        <h2 class="text-login-title">Login Account</h2> <br> <br> <br>

        @if(session('error'))
          <div class="alert alert-important alert-danger alert-dismissible mb-4" role="alert" style="border-radius: 8px;">
            <div class="fw-semibold small">{{ session('error') }}</div>
          </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" autocomplete="off">
          @csrf
          
          <div class="blueprint-input-box">
            <input type="email" name="email" class="form-control-blank" placeholder="Email ID" required>
          </div>

          <div class="blueprint-input-box">
            <input type="password" id="login_password" name="password" class="form-control-blank" placeholder="Password" required>
            <button type="button" class="btn-eye-toggle" onclick="togglePasswordVisibility()">
              <svg xmlns="http://www.w3.org/2000/svg" id="icon_eye" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
              </svg>
            </button>
          </div>

          <div class="row-options-bar">
            <label class="form-check m-0">
              <input type="checkbox" class="form-check-input" checked>
              <span class="form-check-label">Keep me signed in</span>
            </label>
            <a href="#" class="link-member-check">Already a member?</a>
          </div>

          <button type="submit" class="btn-blueprint-submit">LOGIN</button>

        </form>
      </div>

    </div>

    <script>
      function togglePasswordVisibility() {
        const passwordField = document.getElementById('login_password');
        const eyeIcon = document.getElementById('icon_eye');
        
        if (passwordField.type === "password") {
          passwordField.type = "text";
          eyeIcon.innerHTML = `
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M10.584 10.587a2 2 0 0 0 2.829 2.83" />
            <path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" />
            <path d="M3 3l18 18" />
          `;
        } else {
          passwordField.type = "password";
          eyeIcon.innerHTML = `
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
          `;
        }
      }
    </script>
  </body>
</html>