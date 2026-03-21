<?php include('template/header.php'); ?>

<?php
$isEditMode = (bool) ($isEdit ?? false);
$formTitle = $isEditMode ? 'Modify User Profile' : 'Onboard User Baru';
$userId = (int) ($user['id'] ?? 0);
$currentDesaId = $user['id_desa'] ?? null;
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div class="flex items-center gap-4">
            <a href="index.php?controller=User&action=index" class="flex items-center justify-center h-10 w-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-brand-600 hover:bg-brand-50 hover:border-brand-200 transition-all shadow-sm">
              <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
              <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight"><?php echo $formTitle; ?></h1>
              <p class="text-sm text-slate-500">Konfigurasi info login, privilese, dan pemetaan geo-demografi untuk user bersangkutan.</p>
            </div>
          </div>
        </div>

        <?php if ($isEditMode && empty($user)): ?>
          <div class="rounded-xl bg-amber-50 border border-amber-200 p-6 text-center">
            <i class="fa-solid fa-user-ninja text-amber-500 text-3xl mb-3"></i>
            <h3 class="font-bold text-amber-800 mb-1">User Telah Dihapus / Hilang</h3>
            <p class="text-sm text-amber-700 mb-4">Profil akun yang ingin dimodifikasi gagal ditemukan pada database.</p>
            <a href="index.php?controller=User&action=index" class="inline-flex items-center px-5 py-2 rounded-xl bg-amber-600 text-sm font-bold text-white hover:bg-amber-700 transition">Kembali Ke Panel Admin</a>
          </div>
        <?php else: ?>
          
          <form id="userForm" method="POST" action="index.php?controller=User&action=<?php echo $isEditMode ? ('update&id=' . $userId) : 'store'; ?>">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
              
              <!-- Left Column: Credentials -->
              <div class="rounded-2xl bg-white border border-slate-200 shadow-card overflow-hidden h-fit">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                  <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-brand-500"></i> Informasi Identitas
                  </h3>
                </div>
                <div class="p-6 space-y-5">
                  
                  <div>
                    <label for="nama" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap (Sesuai KTP) <span class="text-red-500">*</span></label>
                    <input type="text" class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 px-4 text-sm font-bold text-slate-800 outline-none transition-all focus:border-brand-500 focus:bg-white" id="nama" name="nama" value="<?php echo htmlspecialchars($user['nama'] ?? ''); ?>" required>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                      <label for="username" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Username Login SSO <span class="text-red-500">*</span></label>
                      <input type="text" class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 px-4 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white lowercase font-mono" id="username" name="username" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required>
                    </div>

                    <div>
                      <label for="role" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tingkat Hak Akses <span class="text-red-500">*</span></label>
                      <div class="relative">
                        <select class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-4 pr-10 text-sm font-bold text-brand-700 outline-none transition-all focus:border-brand-500 focus:bg-white appearance-none" id="role" name="role" required>
                          <option value="">Pilih Posisi Sistem</option>
                          <option value="Admin" <?php echo (isset($user['role']) && $user['role'] === 'Admin') ? 'selected' : ''; ?>>Root Admin</option>
                          <option value="PetugasBPBD" <?php echo (isset($user['role']) && $user['role'] === 'PetugasBPBD') ? 'selected' : ''; ?>>Dinas Petugas BPBD</option>
                          <option value="OperatorDesa" <?php echo (isset($user['role']) && $user['role'] === 'OperatorDesa') ? 'selected' : ''; ?>>Posko Operator Desa</option>
                          <option value="Warga" <?php echo (isset($user['role']) && $user['role'] === 'Warga') ? 'selected' : ''; ?>>Publik / Warga</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                      </div>
                    </div>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                      <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Email Surel</label>
                      <div class="relative">
                        <i class="fa-solid fa-at absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="email" class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-10 pr-4 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                      </div>
                    </div>

                    <div>
                      <label for="no_telepon" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Telp / Whatsapp Aktif</label>
                      <div class="relative">
                        <i class="fa-solid fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-10 pr-4 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white" id="no_telepon" name="no_telepon" value="<?php echo htmlspecialchars($user['no_telepon'] ?? ''); ?>">
                      </div>
                    </div>
                  </div>

                  <div class="pt-4 border-t border-slate-100">
                    <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                       <?php echo $isEditMode ? 'Ganti Hash OTP Password <span class="text-yellow-600 lowercase">(Biarkan kosong bila tidak ganti)</span>' : 'Kata Sandi / Security Kunci Akses <span class="text-red-500">*</span>'; ?>
                    </label>
                    <div class="relative">
                      <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                      <input type="password" class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-10 pr-4 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white tracking-widest" id="password" name="password" <?php echo $isEditMode ? '' : 'required'; ?>>
                    </div>
                  </div>

                </div>
              </div>

              <!-- Right Column: Location Mapping -->
              <div class="rounded-2xl bg-white border border-slate-200 shadow-card overflow-hidden h-fit">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                  <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-map-pin text-indigo-500"></i> Batasan Wilayah Operasional
                  </h3>
                </div>
                <div class="p-6 space-y-5">
                  
                  <div class="rounded-xl border border-indigo-100 bg-indigo-50/50 p-4 mb-2 flex">
                    <i class="fa-solid fa-server text-indigo-400 text-lg mr-3 mt-0.5"></i>
                    <div>
                      <p class="text-xs font-bold text-indigo-800 uppercase tracking-wider mb-1">Koneksi Database AJAX Aktif</p>
                      <p class="text-[11px] font-medium text-indigo-600 leading-tight">Pengguna terikat secara hierarki ke wilayah spesifik untuk limitasi laporan yang mereka pantau dan verifikasi.</p>
                    </div>
                  </div>

                  <div>
                    <label for="provinsi_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cluster Provinsi <span class="text-red-500">*</span></label>
                    <div class="relative">
                      <select class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-4 pr-10 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white appearance-none" id="provinsi_id" name="id_provinsi" required>
                        <option value="">Sedang sinkronisasi data api...</option>
                      </select>
                      <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    </div>
                  </div>

                  <div>
                    <label for="kabupaten_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Titik Kabupaten / Kota <span class="text-red-500">*</span></label>
                    <div class="relative">
                      <select class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-4 pr-10 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white appearance-none" id="kabupaten_id" name="id_kabupaten" required disabled>
                        <option value="">-- Kunci Sub-Wilayah Dahulu --</option>
                      </select>
                      <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    </div>
                  </div>

                  <div>
                    <label for="kecamatan_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Zona Rayon Kecamatan <span class="text-red-500">*</span></label>
                    <div class="relative">
                      <select class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-4 pr-10 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white appearance-none" id="kecamatan_id" name="id_kecamatan" required disabled>
                        <option value="">-- Kunci Sub-Wilayah Dahulu --</option>
                      </select>
                      <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    </div>
                  </div>

                  <div>
                    <label for="desa_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Otoritas Desa / Kelurahan Posko <span class="text-red-500">*</span></label>
                    <div class="relative">
                      <select class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-4 pr-10 text-sm font-bold text-brand-700 outline-none transition-all focus:border-brand-500 focus:bg-white appearance-none" id="desa_id" name="id_desa" required disabled>
                        <option value="">-- Kunci Sub-Wilayah Dahulu --</option>
                      </select>
                      <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    </div>
                  </div>

                  <div class="pt-4 border-t border-slate-100">
                    <label for="alamat" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Penulisan Alamat Detail</label>
                    <textarea class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 px-4 text-sm font-medium text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white" id="alamat" name="alamat" rows="2" placeholder="Nama gang, patokan jalan..."><?php echo htmlspecialchars($user['alamat'] ?? ''); ?></textarea>
                  </div>

                </div>
              </div>

              <!-- Save Strip Container Footer -->
              <div class="lg:col-span-2 rounded-2xl bg-white border border-slate-200 shadow-card p-4 flex items-center justify-end gap-3">
                <a href="index.php?controller=User&action=index" class="px-6 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                  Batal
                </a>
                <button type="submit" class="px-8 py-2.5 rounded-xl bg-brand-600 text-sm font-bold text-white hover:bg-brand-700 hover:shadow-float transition-all shadow-sm">
                  <i class="fa-solid fa-server mr-2"></i> <?php echo $isEditMode ? 'Commit Perubahan' : 'Generate Akun Valid'; ?>
                </button>
              </div>

            </div>
          </form>

        <?php endif; ?>

      </div>
    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>

<!-- AJAX Wilayah Logic remains intact with same DOM target IDs -->
<script>
  (function () {
    const isEditMode = <?php echo json_encode($isEditMode); ?>;
    const currentDesaId = <?php echo json_encode($currentDesaId); ?>;
    const form = document.getElementById('userForm');
    if (!form) return;

    function setSelectOptions(select, items, placeholder, selectedId) {
      select.innerHTML = '';
      const first = document.createElement('option');
      first.value = '';
      first.textContent = placeholder;
      select.appendChild(first);

      items.forEach(function (item) {
        const option = document.createElement('option');
        option.value = String(item.id || '');
        option.textContent = String(item.nama || item.name || '-');
        if (selectedId && String(selectedId) === option.value) {
          option.selected = true;
        }
        select.appendChild(option);
      });
    }

    function setLoading(select, text) {
      select.innerHTML = '<option value="">' + text + '</option>';
      select.disabled = true;
    }

    function clearAndEnable(select, placeholder) {
      select.disabled = false;
      select.innerHTML = '<option value="">' + placeholder + '</option>';
    }

    async function fetchJson(url, params) {
      const query = new URLSearchParams(params || {}).toString();
      const finalUrl = query ? (url + '&' + query) : url;
      const response = await fetch(finalUrl, { credentials: 'same-origin' });
      if (response.status === 401) {
        window.location.href = 'index.php?controller=Auth&action=logout';
        throw new Error('Sesi berakhir.');
      }
      return response.json();
    }

    async function loadProvinsi(selectedId) {
      const select = document.getElementById('provinsi_id');
      setLoading(select, 'Menjemput data server js...');
      try {
        const data = await fetchJson('index.php?controller=Wilayah&action=getAllProvinsi');
        select.disabled = false;
        if (data.success && Array.isArray(data.data)) {
          setSelectOptions(select, data.data, '-- Area Provinsi Terdata --', selectedId);
        } else {
          clearAndEnable(select, '-- Server Provinsi Timeout --');
        }
      } catch (e) {
        clearAndEnable(select, '-- Gagal Load Network --');
      }
    }

    async function loadKabupaten(provinsiId, selectedId) {
      const select = document.getElementById('kabupaten_id');
      if (!provinsiId) {
        clearAndEnable(select, '-- Kunci Sub-Wilayah Dahulu --');
        return;
      }
      setLoading(select, 'Fetch tree kabupaten...');
      const data = await fetchJson('index.php?controller=Wilayah&action=getKabupatenByProvinsi', { id: provinsiId });
      select.disabled = false;
      if (data.success && Array.isArray(data.data)) {
        setSelectOptions(select, data.data, '-- Distrik Kab/Kota --', selectedId);
      } else {
        clearAndEnable(select, '-- Kosong --');
      }
    }

    async function loadKecamatan(kabupatenId, selectedId) {
      const select = document.getElementById('kecamatan_id');
      if (!kabupatenId) {
        clearAndEnable(select, '-- Kunci Sub-Wilayah Dahulu --');
        return;
      }
      setLoading(select, 'Menyamakan area...');
      const data = await fetchJson('index.php?controller=Wilayah&action=getKecamatanByKabupaten', { id: kabupatenId });
      select.disabled = false;
      if (data.success && Array.isArray(data.data)) {
        setSelectOptions(select, data.data, '-- Sektor Kecamatan --', selectedId);
      } else {
        clearAndEnable(select, '-- Kosong --');
      }
    }

    async function loadDesa(kecamatanId, selectedId) {
      const select = document.getElementById('desa_id');
      if (!kecamatanId) {
        clearAndEnable(select, '-- Kunci Sub-Wilayah Dahulu --');
        return;
      }
      setLoading(select, 'Mapping data akar...');
      const data = await fetchJson('index.php?controller=Wilayah&action=getDesaByKecamatan', { id: kecamatanId });
      select.disabled = false;
      if (data.success && Array.isArray(data.data)) {
        setSelectOptions(select, data.data, '-- Endpoint Desa/Kel --', selectedId);
      } else {
        clearAndEnable(select, '-- Kosong --');
      }
    }

    async function loadHierarchyForEdit(desaId) {
      if (!desaId) {
        await loadProvinsi(null);
        return;
      }
      const detail = await fetchJson('index.php?controller=Wilayah&action=getWilayahDetailByDesa', { desa_id: desaId });
      if (!detail.success || !detail.data) {
        await loadProvinsi(null);
        return;
      }
      const desa = detail.data;
      const kecamatan = desa.kecamatan || {};
      const kabupaten = kecamatan.kabupaten || {};
      const provinsi = kabupaten.provinsi || {};

      await loadProvinsi(provinsi.id || null);
      await loadKabupaten(provinsi.id || null, kabupaten.id || null);
      await loadKecamatan(kabupaten.id || null, kecamatan.id || null);
      await loadDesa(kecamatan.id || null, desa.id || null);
    }

    document.getElementById('provinsi_id').addEventListener('change', async function () {
      await loadKabupaten(this.value, null);
      clearAndEnable(document.getElementById('kecamatan_id'), '-- Kunci Sub-Wilayah Dahulu --');
      clearAndEnable(document.getElementById('desa_id'), '-- Kunci Sub-Wilayah Dahulu --');
    });

    document.getElementById('kabupaten_id').addEventListener('change', async function () {
      await loadKecamatan(this.value, null);
      clearAndEnable(document.getElementById('desa_id'), '-- Kunci Sub-Wilayah Dahulu --');
    });

    document.getElementById('kecamatan_id').addEventListener('change', async function () {
      await loadDesa(this.value, null);
    });

    form.addEventListener('submit', function (event) {
      const requiredIds = ['provinsi_id', 'kabupaten_id', 'kecamatan_id', 'desa_id'];
      const missing = requiredIds.some(function (id) {
        return !document.getElementById(id).value;
      });

      if (missing) {
        event.preventDefault();
        if (typeof Swal !== 'undefined') {
          Swal.fire({ 
            icon: 'warning', 
            title: 'Hierarki Wilayah Terputus', 
            text: 'Admin harus melengkapi rantai alur provinsi sampai ke level Desa tempat posko domisili.' 
          });
        }
      }
    });

    (async function init() {
      try {
        if (isEditMode && currentDesaId) {
          await loadHierarchyForEdit(currentDesaId);
        } else {
          await loadProvinsi(null);
        }
      } catch (error) {
        console.error(error);
      }
    })();
  })();
</script>
