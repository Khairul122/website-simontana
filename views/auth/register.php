<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $title ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="shortcut icon" href="assets/images/favicon.png" />
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
          colors: {
            primary: {
              50: '#eef4ff',
              100: '#dce9ff',
              200: '#bed6ff',
              300: '#94bcff',
              400: '#639bff',
              500: '#377dff',
              600: '#1f67f3',
              700: '#0f52ba',
              800: '#124594',
              900: '#153f7c'
            }
          }
        }
      }
    }
  </script>
</head>
<body class="h-full bg-slate-100 font-sans text-slate-800">
  <?php $desaList = is_array($desaList ?? null) ? $desaList : []; ?>
  <div class="min-h-screen lg:grid lg:grid-cols-5">
    <section class="hidden lg:flex lg:col-span-2 bg-primary-900 relative overflow-hidden">
      <div class="absolute inset-0 opacity-20" style="background-image: url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=1400&q=80'); background-size: cover; background-position: center;"></div>
      <div class="absolute -top-20 right-10 h-64 w-64 rounded-full bg-white/10"></div>
      <div class="absolute bottom-0 left-0 h-56 w-56 rounded-full bg-white/10"></div>
      <div class="relative z-10 m-auto w-full max-w-xl px-12 text-white">
        <h1 class="text-4xl font-extrabold leading-tight">Buat akun baru untuk mulai berkolaborasi.</h1>
        <p class="mt-4 text-white/80">Satu platform untuk pelaporan cepat, monitoring lapangan, dan koordinasi penanganan bencana.</p>
        <div class="mt-8 space-y-3 text-sm text-white/85">
          <p><i class="fas fa-circle-check mr-2"></i>Role-based access control</p>
          <p><i class="fas fa-circle-check mr-2"></i>Pelacakan status laporan</p>
          <p><i class="fas fa-circle-check mr-2"></i>Integrasi monitoring tindak lanjut</p>
        </div>
      </div>
    </section>

    <section class="lg:col-span-3 flex items-center justify-center p-6 sm:p-10">
      <div class="w-full max-w-4xl rounded-3xl border border-slate-200 bg-white p-7 sm:p-9 shadow-[0_16px_40px_rgba(15,23,42,0.10)]">
        <div class="mb-6">
          <h2 class="text-3xl font-extrabold text-slate-900">Registrasi Akun</h2>
          <p class="mt-2 text-sm text-slate-500">Lengkapi data berikut untuk membuat akun baru.</p>
        </div>

        <?php if (isset($error_message)): ?>
          <div class="mb-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
            <?php echo htmlspecialchars($error_message); ?>
          </div>
        <?php endif; ?>

        <form method="POST" action="index.php?controller=Auth&action=processRegister" class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <div>
            <label for="nama" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama Lengkap</label>
            <input id="nama" name="nama" type="text" required class="w-full rounded-xl border border-slate-300 px-3 py-3 text-sm outline-none transition focus:border-primary-700 focus:ring-4 focus:ring-primary-100" placeholder="Masukkan nama lengkap">
          </div>
          <div>
            <label for="username" class="mb-1.5 block text-sm font-semibold text-slate-700">Username</label>
            <input id="username" name="username" type="text" required class="w-full rounded-xl border border-slate-300 px-3 py-3 text-sm outline-none transition focus:border-primary-700 focus:ring-4 focus:ring-primary-100" placeholder="Masukkan username">
          </div>
          <div>
            <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Email</label>
            <input id="email" name="email" type="email" required class="w-full rounded-xl border border-slate-300 px-3 py-3 text-sm outline-none transition focus:border-primary-700 focus:ring-4 focus:ring-primary-100" placeholder="Masukkan email">
          </div>
          <div>
            <label for="role" class="mb-1.5 block text-sm font-semibold text-slate-700">Peran</label>
            <select id="role" name="role" required class="w-full rounded-xl border border-slate-300 px-3 py-3 text-sm outline-none transition focus:border-primary-700 focus:ring-4 focus:ring-primary-100">
              <option value="">Pilih Peran</option>
              <option value="Warga">Warga</option>
              <option value="OperatorDesa">Operator Desa</option>
              <option value="PetugasBPBD">Petugas BPBD</option>
              <option value="Admin">Admin</option>
            </select>
          </div>

          <div>
            <label for="provinsi_id" class="mb-1.5 block text-sm font-semibold text-slate-700">Provinsi</label>
            <select id="provinsi_id" name="id_provinsi" class="w-full rounded-xl border border-slate-300 px-3 py-3 text-sm outline-none transition focus:border-primary-700 focus:ring-4 focus:ring-primary-100">
              <option value="">Pilih provinsi</option>
            </select>
          </div>

          <div>
            <label for="kabupaten_id" class="mb-1.5 block text-sm font-semibold text-slate-700">Kabupaten/Kota</label>
            <select id="kabupaten_id" name="id_kabupaten" class="w-full rounded-xl border border-slate-300 px-3 py-3 text-sm outline-none transition focus:border-primary-700 focus:ring-4 focus:ring-primary-100">
              <option value="">Pilih kabupaten/kota</option>
            </select>
          </div>

          <div>
            <label for="kecamatan_id" class="mb-1.5 block text-sm font-semibold text-slate-700">Kecamatan</label>
            <select id="kecamatan_id" name="id_kecamatan" class="w-full rounded-xl border border-slate-300 px-3 py-3 text-sm outline-none transition focus:border-primary-700 focus:ring-4 focus:ring-primary-100">
              <option value="">Pilih kecamatan</option>
            </select>
          </div>
          <div>
            <label for="password" class="mb-1.5 block text-sm font-semibold text-slate-700">Kata Sandi</label>
            <input id="password" name="password" type="password" required class="w-full rounded-xl border border-slate-300 px-3 py-3 text-sm outline-none transition focus:border-primary-700 focus:ring-4 focus:ring-primary-100" placeholder="Masukkan kata sandi">
          </div>
          <div>
            <label for="password_confirmation" class="mb-1.5 block text-sm font-semibold text-slate-700">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full rounded-xl border border-slate-300 px-3 py-3 text-sm outline-none transition focus:border-primary-700 focus:ring-4 focus:ring-primary-100" placeholder="Konfirmasi kata sandi">
          </div>
          <div>
            <label for="no_telepon" class="mb-1.5 block text-sm font-semibold text-slate-700">Nomor Telepon</label>
            <input id="no_telepon" name="no_telepon" type="text" class="w-full rounded-xl border border-slate-300 px-3 py-3 text-sm outline-none transition focus:border-primary-700 focus:ring-4 focus:ring-primary-100" placeholder="Masukkan nomor telepon">
          </div>
          <div>
            <label for="id_desa" class="mb-1.5 block text-sm font-semibold text-slate-700">Desa (opsional)</label>
            <select id="id_desa" name="id_desa" class="w-full rounded-xl border border-slate-300 px-3 py-3 text-sm outline-none transition focus:border-primary-700 focus:ring-4 focus:ring-primary-100">
              <option value="">Pilih desa</option>
            </select>
          </div>
          <div class="md:col-span-2">
            <label for="alamat" class="mb-1.5 block text-sm font-semibold text-slate-700">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-3 text-sm outline-none transition focus:border-primary-700 focus:ring-4 focus:ring-primary-100" placeholder="Masukkan alamat lengkap"></textarea>
          </div>

          <div class="md:col-span-2 mt-2 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <button type="submit" class="rounded-xl bg-primary-700 px-5 py-3 text-sm font-bold tracking-wide text-white transition hover:bg-primary-800">
              <i class="fas fa-user-plus mr-2"></i>DAFTAR
            </button>
            <a href="index.php?controller=Auth&action=login" class="text-sm font-semibold text-primary-700 hover:text-primary-800">Sudah punya akun? Masuk di sini</a>
          </div>
        </form>
      </div>
    </section>
  </div>

  <div class="fixed right-4 top-4 z-50 space-y-2" id="toastContainer"></div>

  <script>
    (function () {
      function setOptions(select, items, placeholder) {
        select.innerHTML = '';
        const first = document.createElement('option');
        first.value = '';
        first.textContent = placeholder;
        select.appendChild(first);

        (items || []).forEach(function (item) {
          const id = String(item.id || '');
          if (!id) return;
          const option = document.createElement('option');
          option.value = id;
          option.textContent = String(item.nama || item.name || '-');
          select.appendChild(option);
        });
      }

      async function fetchWilayah(url, params) {
        const query = new URLSearchParams(params || {}).toString();
        const finalUrl = query ? (url + '&' + query) : url;
        const response = await fetch(finalUrl, { credentials: 'same-origin' });
        return response.json();
      }

      const provinsi = document.getElementById('provinsi_id');
      const kabupaten = document.getElementById('kabupaten_id');
      const kecamatan = document.getElementById('kecamatan_id');
      const desa = document.getElementById('id_desa');
      if (!provinsi || !kabupaten || !kecamatan || !desa) return;

      async function loadProvinsi() {
        const result = await fetchWilayah('index.php?controller=Auth&action=getAllProvinsi');
        setOptions(provinsi, result.success ? result.data : [], 'Pilih provinsi');
      }

      async function loadKabupaten(provinsiId) {
        if (!provinsiId) {
          setOptions(kabupaten, [], 'Pilih kabupaten/kota');
          setOptions(kecamatan, [], 'Pilih kecamatan');
          setOptions(desa, [], 'Pilih desa');
          return;
        }
        const result = await fetchWilayah('index.php?controller=Auth&action=getKabupatenByProvinsi', { id: provinsiId });
        setOptions(kabupaten, result.success ? result.data : [], 'Pilih kabupaten/kota');
        setOptions(kecamatan, [], 'Pilih kecamatan');
        setOptions(desa, [], 'Pilih desa');
      }

      async function loadKecamatan(kabupatenId) {
        if (!kabupatenId) {
          setOptions(kecamatan, [], 'Pilih kecamatan');
          setOptions(desa, [], 'Pilih desa');
          return;
        }
        const result = await fetchWilayah('index.php?controller=Auth&action=getKecamatanByKabupaten', { id: kabupatenId });
        setOptions(kecamatan, result.success ? result.data : [], 'Pilih kecamatan');
        setOptions(desa, [], 'Pilih desa');
      }

      async function loadDesa(kecamatanId) {
        if (!kecamatanId) {
          setOptions(desa, [], 'Pilih desa');
          return;
        }
        const result = await fetchWilayah('index.php?controller=Auth&action=getDesaByKecamatan', { id: kecamatanId });
        setOptions(desa, result.success ? result.data : [], 'Pilih desa');
      }

      provinsi.addEventListener('change', function () {
        loadKabupaten(this.value);
      });

      kabupaten.addEventListener('change', function () {
        loadKecamatan(this.value);
      });

      kecamatan.addEventListener('change', function () {
        loadDesa(this.value);
      });

      loadProvinsi();
    })();

    function showToast(type, title, message) {
      const toastContainer = document.getElementById('toastContainer');
      const toast = document.createElement('div');
      toast.className = `max-w-sm rounded-xl border p-4 shadow-lg ${type === 'success' ? 'border-emerald-200 bg-emerald-50' : type === 'error' ? 'border-red-200 bg-red-50' : type === 'warning' ? 'border-amber-200 bg-amber-50' : 'border-blue-200 bg-blue-50'}`;
      toast.innerHTML = `
        <div class="flex items-start gap-3">
          <div class="mt-0.5 ${type === 'success' ? 'text-emerald-600' : type === 'error' ? 'text-red-600' : type === 'warning' ? 'text-amber-600' : 'text-blue-600'}">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-circle-exclamation' : type === 'warning' ? 'fa-triangle-exclamation' : 'fa-circle-info'}"></i>
          </div>
          <div class="flex-1">
            <p class="text-sm font-bold text-slate-800">${title}</p>
            <p class="text-sm text-slate-600">${message}</p>
          </div>
          <button class="text-slate-400 hover:text-slate-600" onclick="this.closest('div.max-w-sm').remove()">&times;</button>
        </div>
      `;
      toastContainer.appendChild(toast);
      setTimeout(() => { if (toast.parentNode) toast.remove(); }, 4500);
    }

    <?php if (isset($_SESSION['toast'])): ?>
    <?php
      $toastType = addslashes($_SESSION['toast']['type'] ?? 'info');
      $toastTitle = addslashes($_SESSION['toast']['title'] ?? 'Informasi');
      $toastMessage = addslashes($_SESSION['toast']['message'] ?? '');
      unset($_SESSION['toast']);
    ?>
    showToast('<?php echo $toastType; ?>', '<?php echo $toastTitle; ?>', '<?php echo $toastMessage; ?>');
    <?php endif; ?>
  </script>
</body>
</html>
