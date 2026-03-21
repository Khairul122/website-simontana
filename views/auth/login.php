<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $title ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="shortcut icon" href="assets/images/favicon.png" />
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Plus Jakarta Sans', 'sans-serif'],
            display: ['Space Grotesk', 'sans-serif']
          },
          colors: {
            brand: {
              50: '#f2f7ff',
              100: '#e0edff',
              200: '#bfd8ff',
              300: '#95bfff',
              400: '#619dff',
              500: '#3b82f6',
              600: '#235fdb',
              700: '#1d4db2',
              800: '#1d438f',
              900: '#1d3b76'
            }
          },
          boxShadow: {
            auth: '0 30px 70px rgba(15, 35, 72, 0.18)',
            pane: '0 14px 38px rgba(15, 35, 72, 0.12)'
          },
          keyframes: {
            floaty: {
              '0%, 100%': { transform: 'translateY(0px)' },
              '50%': { transform: 'translateY(-10px)' }
            },
            pulseSoft: {
              '0%, 100%': { transform: 'scale(1)', opacity: '0.85' },
              '50%': { transform: 'scale(1.06)', opacity: '1' }
            },
            cardReveal: {
              '0%': { opacity: '0', transform: 'translateY(16px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' }
            },
            toastIn: {
              '0%': { opacity: '0', transform: 'translateY(-10px) translateX(10px)' },
              '100%': { opacity: '1', transform: 'translateY(0) translateX(0)' }
            }
          },
          animation: {
            floaty: 'floaty 7s ease-in-out infinite',
            pulseSoft: 'pulseSoft 8s ease-in-out infinite',
            cardReveal: 'cardReveal .6s ease-out both',
            toastIn: 'toastIn .35s ease-out both'
          }
        }
      }
    }
  </script>
</head>
<body class="h-full overflow-x-hidden bg-slate-100 font-sans text-slate-800">
  <div class="relative min-h-screen">
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
      <div class="absolute -top-20 -left-24 h-72 w-72 rounded-full bg-brand-300/55 blur-3xl animate-pulseSoft"></div>
      <div class="absolute top-[18%] right-[-90px] h-80 w-80 rounded-full bg-cyan-300/40 blur-3xl animate-pulseSoft" style="animation-delay: .8s"></div>
      <div class="absolute bottom-[-140px] left-[38%] h-96 w-96 rounded-full bg-brand-200/45 blur-3xl animate-pulseSoft" style="animation-delay: 1.6s"></div>
    </div>

    <div class="relative z-10 mx-auto flex min-h-screen w-full flex-col items-stretch lg:grid lg:grid-cols-2">
      <section class="relative hidden overflow-hidden lg:block">
        <div class="absolute inset-0">
          <div class="absolute inset-0 bg-[radial-gradient(circle_at_18%_20%,rgba(59,130,246,.26),transparent_38%),radial-gradient(circle_at_80%_12%,rgba(34,211,238,.24),transparent_30%),linear-gradient(135deg,#0b1f42_0%,#122f63_50%,#1b3f7a_100%)]"></div>
          <div class="absolute inset-0 opacity-[.14]" style="background-image: url('https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=1800&q=80'); background-size: cover; background-position: center;"></div>
          <div class="absolute inset-0 bg-[linear-gradient(125deg,rgba(11,31,66,.9),rgba(22,52,101,.75))]"></div>
        </div>

        <div class="relative flex h-full flex-col justify-between px-14 py-14 text-white xl:px-16 xl:py-16">
          <div class="animate-cardReveal">
            <div class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 px-4 py-2 text-sm font-semibold backdrop-blur-sm">
              <i class="fa-solid fa-shield-heart text-cyan-200"></i>
              <span>SIMONTA BENCANA</span>
            </div>

            <h1 class="mt-8 max-w-xl font-display text-5xl font-bold leading-tight xl:text-6xl">
              Koordinasi cepat untuk respon bencana yang tepat.
            </h1>
            <p class="mt-5 max-w-xl text-base leading-relaxed text-slate-200 xl:text-lg">
              Satu platform terpadu untuk pelaporan warga, validasi operator desa, dan tindak lanjut petugas BPBD secara real-time.
            </p>
          </div>

          <div class="grid grid-cols-2 gap-4 text-white/95">
            <article class="rounded-2xl border border-white/25 bg-white/10 p-4 backdrop-blur-sm animate-floaty">
              <p class="text-xs uppercase tracking-widest text-cyan-100">Respons</p>
              <p class="mt-1 font-display text-2xl font-semibold">24/7</p>
              <p class="mt-2 text-sm text-slate-200">Monitoring dan pembaruan status terus berjalan.</p>
            </article>
            <article class="rounded-2xl border border-white/25 bg-white/10 p-4 backdrop-blur-sm animate-floaty" style="animation-delay: .6s">
              <p class="text-xs uppercase tracking-widest text-cyan-100">Aktor</p>
              <p class="mt-1 font-display text-2xl font-semibold">4 Peran</p>
              <p class="mt-2 text-sm text-slate-200">Warga, Operator, Petugas BPBD, dan Admin.</p>
            </article>
          </div>
        </div>
      </section>

      <section class="relative flex min-h-screen items-center justify-center px-5 py-7 sm:px-8 lg:px-12">
        <div class="w-full max-w-lg animate-cardReveal rounded-[30px] border border-white/70 bg-white/90 p-6 shadow-auth backdrop-blur-xl sm:p-9">
          <div class="mb-8">
            <div class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1.5 text-xs font-semibold text-brand-700">
              <span class="h-2 w-2 rounded-full bg-brand-600"></span>
              Akses Dashboard
            </div>
            <h2 class="mt-4 font-display text-3xl font-bold text-slate-900 sm:text-4xl">Masuk ke SIMONTA</h2>
            <p class="mt-2 text-sm text-slate-500">Gunakan akun Anda untuk mengelola laporan dan monitoring.</p>
          </div>

          <form method="POST" action="index.php?controller=Auth&action=processLogin" class="space-y-5" id="loginForm">
            <div>
              <label for="username" class="mb-1.5 block text-sm font-semibold text-slate-700">Username atau Email</label>
              <div class="group relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 transition group-focus-within:text-brand-700">
                  <i class="fa-solid fa-user"></i>
                </span>
                <input id="username" name="username" type="text" required class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-10 pr-3 text-sm outline-none transition focus:border-brand-700 focus:ring-4 focus:ring-brand-100" placeholder="contoh: petugas.bpbd">
              </div>
            </div>

            <div>
              <div class="mb-1.5 flex items-center justify-between">
                <label for="password" class="block text-sm font-semibold text-slate-700">Kata Sandi</label>
                <span class="text-xs text-slate-400">Pastikan perangkat aman</span>
              </div>
              <div class="group relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 transition group-focus-within:text-brand-700">
                  <i class="fa-solid fa-lock"></i>
                </span>
                <input id="password" name="password" type="password" required class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-10 pr-12 text-sm outline-none transition focus:border-brand-700 focus:ring-4 focus:ring-brand-100" placeholder="Masukkan kata sandi">
                <button id="togglePassword" type="button" class="absolute inset-y-0 right-0 px-3 text-slate-400 transition hover:text-brand-700" aria-label="Tampilkan kata sandi">
                  <i class="fa-solid fa-eye"></i>
                </button>
              </div>
            </div>

            <button id="submitBtn" type="submit" class="group relative inline-flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-brand-700 px-4 py-3 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-brand-800 focus:outline-none focus:ring-4 focus:ring-brand-200">
              <span class="absolute inset-0 -translate-x-full bg-white/20 transition duration-500 group-hover:translate-x-0"></span>
              <i class="fa-solid fa-right-to-bracket relative"></i>
              <span class="relative">Masuk Sekarang</span>
            </button>

            <p class="text-center text-sm text-slate-500">
              Belum punya akun?
              <a href="index.php?controller=Auth&action=register" class="font-semibold text-brand-700 transition hover:text-brand-900">Daftar di sini</a>
            </p>
          </form>
        </div>
      </section>
    </div>
  </div>

  <div class="fixed right-4 top-4 z-50 flex w-[calc(100%-2rem)] max-w-sm flex-col gap-2 sm:w-full" id="toastContainer"></div>

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
          submitBtn.querySelector('span:last-child').textContent = 'Memproses...';
        });
      }

      function showToast(type, title, message) {
        const toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) return;

        const styleMap = {
          success: 'border-emerald-200 bg-emerald-50 text-emerald-700',
          error: 'border-rose-200 bg-rose-50 text-rose-700',
          warning: 'border-amber-200 bg-amber-50 text-amber-700',
          info: 'border-brand-200 bg-brand-50 text-brand-700'
        };
        const iconMap = {
          success: 'fa-circle-check',
          error: 'fa-circle-xmark',
          warning: 'fa-triangle-exclamation',
          info: 'fa-circle-info'
        };
        const key = styleMap[type] ? type : 'info';

        const toast = document.createElement('div');
        toast.className = 'animate-toastIn rounded-xl border px-4 py-3 shadow-pane backdrop-blur-sm ' + styleMap[key];
        toast.innerHTML =
          '<div class="flex items-start gap-3">' +
            '<span class="pt-0.5"><i class="fa-solid ' + iconMap[key] + '"></i></span>' +
            '<div class="flex-1">' +
              '<p class="text-sm font-bold text-slate-800">' + title + '</p>' +
              '<p class="text-sm text-slate-600">' + message + '</p>' +
            '</div>' +
            '<button type="button" class="text-slate-400 hover:text-slate-700" aria-label="Tutup">&times;</button>' +
          '</div>';

        const closeButton = toast.querySelector('button');
        if (closeButton) {
          closeButton.addEventListener('click', function () {
            toast.remove();
          });
        }

        toastContainer.appendChild(toast);
        setTimeout(function () {
          toast.remove();
        }, 4500);
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
        window.location.href = redirectUrl;
      }, 1200);
      <?php endif; ?>
      <?php endif; ?>

      <?php if (isset($should_redirect) && $should_redirect && !$hasToast): ?>
      const role = '<?php echo $_SESSION['user']['role'] ?? 'Warga'; ?>';
      let redirectUrl = 'index.php?controller=Dashboard&action=warga';
      if (role === 'Admin') redirectUrl = 'index.php?controller=Dashboard&action=admin';
      if (role === 'PetugasBPBD') redirectUrl = 'index.php?controller=Dashboard&action=petugas';
      if (role === 'OperatorDesa') redirectUrl = 'index.php?controller=Dashboard&action=operator';
      window.location.href = redirectUrl;
      <?php endif; ?>
    });
  </script>
</body>
</html>
