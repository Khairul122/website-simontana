<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title><?= $title ?? 'Login - SIMONTA Bencana' ?></title>
  <meta name="description" content="Masuk ke SIMONTA untuk memantau laporan bencana, data BMKG, dan operasional tanggap darurat sesuai role Anda." />
  <meta name="keywords" content="login simonta, dashboard bencana, monitoring bencana, bmkg" />
  <meta name="robots" content="noindex, nofollow" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="shortcut icon" href="assets/images/favicon.png" />
  
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
            display: ['Outfit', 'sans-serif']
          },
          colors: {
            brand: {
              50: '#fff7ed', 100: '#ffedd5', 200: '#fed7aa', 300: '#fdba74',
              400: '#fb923c', 500: '#f97316', 600: '#ea580c', 700: '#c2410c',
              800: '#9a3412', 900: '#7c2d12', 950: '#431407',
            }
          },
          animation: {
            'blob': 'blob 10s infinite',
            'slide-up': 'slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
            'fade-in': 'fadeIn 1s ease-out forwards',
            'toast-in': 'toastIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards'
          },
          keyframes: {
            blob: {
              '0%': { transform: 'translate(0px, 0px) scale(1)' },
              '33%': { transform: 'translate(30px, -40px) scale(1.1)' },
              '66%': { transform: 'translate(-20px, 20px) scale(0.95)' },
              '100%': { transform: 'translate(0px, 0px) scale(1)' }
            },
            slideUp: {
              '0%': { opacity: '0', transform: 'translateY(30px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' }
            },
            fadeIn: {
              '0%': { opacity: '0' },
              '100%': { opacity: '1' }
            },
            toastIn: {
              '0%': { opacity: '0', transform: 'translateX(100px)' },
              '100%': { opacity: '1', transform: 'translateX(0)' }
            }
          }
        }
      }
    }
  </script>
  <style>
    /* Styling khusus input form fokus */
    .input-floating:focus-within label {
      transform: translateY(-28px) scale(0.85);
      color: #ea580c;
    }
    .input-floating input:not(:placeholder-shown) + label {
      transform: translateY(-28px) scale(0.85);
    }
    .glass-effect {
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.5);
    }
    .dark-glass {
      background: rgba(15, 23, 42, 0.4);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
  </style>
</head>
<body class="bg-white font-sans text-slate-800 antialiased h-screen overflow-hidden selection:bg-brand-500 selection:text-white">

  <div class="flex h-full w-full">
    <!-- Kolom Kiri: Form Login (Responsive: w-full di mobile, setengah di lg) -->
    <div class="relative flex w-full flex-col lg:w-1/2 xl:w-5/12 h-full overflow-y-auto bg-slate-50/50">
      
      <!-- Dekorasi Blob Background -->
      <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -left-24 -top-24 h-96 w-96 rounded-full bg-brand-300/30 mix-blend-multiply blur-[64px] animate-blob"></div>
        <div class="absolute right-0 top-1/3 h-80 w-80 rounded-full bg-blue-300/30 mix-blend-multiply blur-[64px] animate-blob" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-0 -left-10 h-72 w-72 rounded-full bg-amber-200/40 mix-blend-multiply blur-[64px] animate-blob" style="animation-delay: 4s;"></div>
      </div>

      <!-- Container Utama Konten -->
      <div class="relative z-10 flex flex-col justify-center px-6 py-10 sm:px-12 md:px-20 lg:px-16 xl:px-24 min-h-full">
        
        <div class="w-full max-w-md mx-auto animate-slide-up">
          
          <!-- Header Logo & Judul -->
          <div class="mb-10 text-center sm:text-left">
            <div class="inline-flex items-center justify-center p-3 sm:p-4 mb-6 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 shadow-xl shadow-brand-500/30 text-white transform transition-transform hover:scale-105">
              <i class="fa-solid fa-shield-halved text-3xl sm:text-4xl"></i>
            </div>
            <h1 class="font-display text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 mb-3">Login SIMONTA</h1>
            <p class="text-sm sm:text-base text-slate-500">Sistem Informasi Monitoring Tanggap Bencana. Masuk untuk melanjutkan.</p>
          </div>

          <!-- Card Form -->
          <div class="glass-effect rounded-[2rem] p-6 sm:p-10 shadow-2xl shadow-slate-200/50 border border-white">
            <form method="POST" action="index.php?controller=Auth&action=processLogin" id="loginForm" class="space-y-6">
              
              <!-- Input Username -->
              <div class="relative input-floating group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 sm:pl-5 text-slate-400 group-focus-within:text-brand-600 transition-colors pointer-events-none z-10">
                  <i class="fa-regular fa-user text-lg"></i>
                </div>
                <input id="username" name="username" type="text" placeholder=" " required 
                  class="block w-full rounded-2xl border-0 bg-white/80 py-4 sm:py-4 pl-12 sm:pl-14 pr-4 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-brand-500 sm:text-base transition-all peer" />
                <label for="username" class="absolute left-12 sm:left-14 top-4 text-slate-400 text-base transition-all pointer-events-none origin-left bg-transparent peer-focus:text-brand-600">
                  Username / Email
                </label>
              </div>

              <!-- Input Password -->
              <div class="relative input-floating group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 sm:pl-5 text-slate-400 group-focus-within:text-brand-600 transition-colors pointer-events-none z-10">
                  <i class="fa-solid fa-lock text-lg"></i>
                </div>
                <input id="password" name="password" type="password" placeholder=" " required 
                  class="block w-full rounded-2xl border-0 bg-white/80 py-4 sm:py-4 pl-12 sm:pl-14 pr-12 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-brand-500 sm:text-base transition-all peer" />
                <label for="password" class="absolute left-12 sm:left-14 top-4 text-slate-400 text-base transition-all pointer-events-none origin-left bg-transparent peer-focus:text-brand-600">
                  Kata Sandi
                </label>
                <button id="togglePassword" type="button" class="absolute inset-y-0 right-0 flex items-center pr-4 sm:pr-5 text-slate-400 hover:text-brand-600 transition-colors z-10" aria-label="Tampilkan kata sandi">
                  <i class="fa-regular fa-eye text-lg"></i>
                </button>
              </div>

              <!-- Lupa Sandi -->
              <div class="flex items-center justify-end px-1">
                <a href="#" class="text-sm font-semibold text-brand-600 hover:text-brand-800 transition-colors">Lupa sandi?</a>
              </div>

              <!-- Tombol Submit -->
              <button id="submitBtn" type="submit" 
                class="group relative flex w-full items-center justify-center gap-3 overflow-hidden rounded-2xl bg-brand-600 px-4 py-4 text-base font-bold text-white shadow-lg shadow-brand-500/30 transition-all hover:bg-brand-500 hover:shadow-brand-500/40 focus:outline-none focus:ring-4 focus:ring-brand-500/30 active:scale-[0.98]">
                <span class="absolute inset-0 -translate-x-full bg-white/20 transition-transform duration-500 ease-out group-hover:translate-x-0"></span>
                <span class="relative">Masuk Sistem</span>
                <i class="fa-solid fa-arrow-right-to-bracket relative group-hover:translate-x-1 transition-transform"></i>
              </button>

            </form>
          </div>

          <!-- Footer/Daftar -->
          <div class="mt-8 text-center text-sm text-slate-600">
            Belum tergabung dengan SIMONTA? <br class="sm:hidden">
            <a href="index.php?controller=Auth&action=register" class="font-bold text-brand-600 hover:text-brand-500 hover:underline underline-offset-4 transition-all ml-1">Buat Akun Sekarang</a>
          </div>

        </div>
      </div>
      
    </div>

    <!-- Kolom Kanan: Visual Cover (Tersembunyi di Mobile/Tablet) -->
    <div class="hidden lg:flex lg:w-1/2 xl:w-7/12 relative bg-slate-900 group overflow-hidden">
      <!-- Background Image dengan Zoom Effect -->
      <img src="https://images.unsplash.com/photo-1599839619722-39751411ea63?auto=format&fit=crop&q=80&w=1600" 
           alt="Visual Response Bencana" class="absolute inset-0 h-full w-full object-cover opacity-60 mix-blend-overlay group-hover:scale-105 transition-transform duration-[10s] ease-out">
      
      <!-- Gradient Overlay -->
      <div class="absolute inset-0 bg-gradient-to-br from-slate-900/90 via-slate-900/40 to-brand-900/60"></div>
      
      <!-- Konten Teks di Kanan -->
      <div class="absolute bottom-0 left-0 right-0 p-12 xl:p-20 z-10 animate-fade-in" style="animation-delay: 0.3s">
        <div class="dark-glass rounded-[2rem] p-8 xl:p-10 border-l-4 border-l-brand-500 shadow-2xl backdrop-blur-md max-w-2xl transform transition-transform hover:-translate-y-2">
          <div class="inline-flex items-center gap-2 rounded-full bg-brand-500/20 px-4 py-2 text-sm font-bold uppercase tracking-widest text-brand-400 mb-6 border border-brand-500/20">
            <span class="h-2 w-2 rounded-full bg-brand-500 animate-pulse"></span>
            Siaga & Tanggap Darurat
          </div>
          <h2 class="font-display text-4xl xl:text-5xl font-bold text-white mb-6 leading-tight">Kolaborasi Aktif <br/> Menyelamatkan Jiwa.</h2>
          <p class="text-slate-300 text-lg leading-relaxed max-w-xl">
            Dari laporan awal warga hingga tindakan di lapangan. SIMONTA mengintegrasikan semua langkah evakuasi dan mitigasi dalam satu platform sentral yang responsif.
          </p>
          
          <div class="mt-8 flex gap-6">
            <div class="flex items-center gap-3">
              <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 text-brand-400 text-xl"><i class="fa-solid fa-clock"></i></div>
              <div><p class="text-white font-bold leading-tight">Realtime</p><p class="text-slate-400 text-sm">Monitoring</p></div>
            </div>
            <div class="flex items-center gap-3">
              <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 text-brand-400 text-xl"><i class="fa-solid fa-tower-observation"></i></div>
              <div><p class="text-white font-bold leading-tight">Terpadu</p><p class="text-slate-400 text-sm">Koordinasi</p></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Container -->
  <div class="fixed right-0 top-6 z-50 flex w-full max-w-sm flex-col gap-3 px-4 sm:right-6 sm:pl-0" id="toastContainer"></div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const togglePassword = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('password');
      const eyeIcon = togglePassword ? togglePassword.querySelector('i') : null;
      const submitBtn = document.getElementById('submitBtn');
      const loginForm = document.getElementById('loginForm');

      if (togglePassword && passwordInput && eyeIcon) {
        togglePassword.addEventListener('click', function () {
          const show = passwordInput.getAttribute('type') === 'password';
          passwordInput.setAttribute('type', show ? 'text' : 'password');
          eyeIcon.classList.toggle('fa-eye', !show);
          eyeIcon.classList.toggle('fa-eye-slash', show);
        });
      }

      if (loginForm && submitBtn) {
        loginForm.addEventListener('submit', function () {
          submitBtn.disabled = true;
          submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
          submitBtn.innerHTML = '<span class="relative">Memproses... <i class="fa-solid fa-circle-notch fa-spin ml-2"></i></span>';
        });
      }

      function showToast(type, title, message) {
        const toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) return;

        const styleMap = {
          success: 'border-emerald-500 bg-emerald-50 text-emerald-800 shadow-emerald-500/20',
          error: 'border-rose-500 bg-rose-50 text-rose-800 shadow-rose-500/20',
          warning: 'border-amber-500 bg-amber-50 text-amber-800 shadow-amber-500/20',
          info: 'border-blue-500 bg-blue-50 text-blue-800 shadow-blue-500/20'
        };
        const iconMap = {
          success: 'fa-circle-check text-emerald-500',
          error: 'fa-circle-xmark text-rose-500',
          warning: 'fa-triangle-exclamation text-amber-500',
          info: 'fa-circle-info text-blue-500'
        };
        const key = styleMap[type] ? type : 'info';

        const toast = document.createElement('div');
        toast.className = `glass-effect animate-toast-in overflow-hidden rounded-2xl border-l-4 p-4 shadow-xl ${styleMap[key]} transform transition-all`;
        toast.innerHTML = `
          <div class="flex items-start gap-4">
            <span class="mt-0.5 text-xl"><i class="fa-solid ${iconMap[key]}"></i></span>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-bold truncate">${title}</p>
              <p class="text-sm mt-0.5 opacity-90 leading-relaxed">${message}</p>
            </div>
            <button type="button" class="ml-4 shrink-0 text-current opacity-50 hover:opacity-100 focus:outline-none transition-opacity" aria-label="Tutup">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>
        `;

        const closeButton = toast.querySelector('button');
        if (closeButton) {
          closeButton.addEventListener('click', function () {
            toast.style.transform = 'translateX(100px)';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
          });
        }

        toastContainer.appendChild(toast);
        setTimeout(() => {
          if (toast.parentNode) {
            toast.style.transform = 'translateX(100px)';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
          }
        }, 5000);
      }

      <?php $hasToast = isset($_SESSION['toast']); ?>
      <?php if (isset($_SESSION['toast'])): ?>
      <?php
        $toastType = addslashes($_SESSION['toast']['type'] ?? 'info');
        $toastTitle = addslashes($_SESSION['toast']['title'] ?? 'Informasi');
        $toastMessage = addslashes($_SESSION['toast']['message'] ?? '');
        unset($_SESSION['toast']);
      ?>
      showToast('<?php echo $toastType; ?>', '<?php echo $toastTitle; ?>', '<?php echo $toastMessage; ?>');
      
      <?php if (isset($should_redirect) && $should_redirect): ?>
      setTimeout(function () {
        const role = '<?php echo $_SESSION['user']['role'] ?? 'Warga'; ?>';
        let redirectUrl = 'index.php?controller=Dashboard&action=warga';
        if (role === 'Admin') redirectUrl = 'index.php?controller=Dashboard&action=admin';
        if (role === 'PetugasBPBD') redirectUrl = 'index.php?controller=Dashboard&action=petugas';
        if (role === 'OperatorDesa') redirectUrl = 'index.php?controller=Dashboard&action=operator';
        window.location.replace(redirectUrl);
      }, 1500);
      <?php endif; ?>
      <?php endif; ?>

      <?php if (isset($should_redirect) && $should_redirect && !$hasToast): ?>
      const role = '<?php echo $_SESSION['user']['role'] ?? 'Warga'; ?>';
      let redirectUrl = 'index.php?controller=Dashboard&action=warga';
      if (role === 'Admin') redirectUrl = 'index.php?controller=Dashboard&action=admin';
      if (role === 'PetugasBPBD') redirectUrl = 'index.php?controller=Dashboard&action=petugas';
      if (role === 'OperatorDesa') redirectUrl = 'index.php?controller=Dashboard&action=operator';
      window.location.replace(redirectUrl);
      <?php endif; ?>
    });
  </script>
</body>
</html>
