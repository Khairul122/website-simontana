<?php include('template/header.php'); ?>

<?php
$isEditMode = (bool) ($isEdit ?? false);
$pageTitle = $isEditMode ? 'Edit Informasi Desa' : 'Input Area Posko Desa';
$saveLabel = $isEditMode ? 'Simpan Perubahan' : 'Registrasi Desa';
$idDesa = (int) ($desa['id'] ?? 0);

$selectedProvinsiId = $_GET['provinsi_id'] ?? null;
$selectedKabupatenId = $_GET['kabupaten_id'] ?? null;
$selectedKecamatanId = $_GET['kecamatan_id'] ?? null;

if ($selectedProvinsiId === null && isset($desa['kecamatan']['kabupaten']['id_provinsi'])) {
  $selectedProvinsiId = $desa['kecamatan']['kabupaten']['id_provinsi'];
}
if ($selectedProvinsiId === null && isset($desa['kecamatan']['kabupaten']['id_parent'])) {
  $selectedProvinsiId = $desa['kecamatan']['kabupaten']['id_parent'];
}
if ($selectedKabupatenId === null && isset($desa['kecamatan']['id_kabupaten'])) {
  $selectedKabupatenId = $desa['kecamatan']['id_kabupaten'];
}
if ($selectedKabupatenId === null && isset($desa['kecamatan']['id_parent'])) {
  $selectedKabupatenId = $desa['kecamatan']['id_parent'];
}
if ($selectedKecamatanId === null && isset($desa['id_kecamatan'])) {
  $selectedKecamatanId = $desa['id_kecamatan'];
}
if ($selectedKecamatanId === null && isset($desa['id_parent'])) {
  $selectedKecamatanId = $desa['id_parent'];
}
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
          <div class="flex items-center gap-4">
            <a href="index.php?controller=Wilayah&action=indexDesa<?php echo $selectedKecamatanId ? ('&kecamatan_id=' . urlencode((string)$selectedKecamatanId)) : ''; ?>" class="flex items-center justify-center h-10 w-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-brand-600 hover:bg-brand-50 hover:border-brand-200 transition-all shadow-sm">
              <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
              <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight"><?php echo $pageTitle; ?></h1>
              <p class="text-sm text-slate-500">Ikat penamaan kelurahan atau desa ke rantai tree wilayah dari pusat.</p>
            </div>
          </div>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-card overflow-hidden">
          <form action="index.php?controller=Wilayah&action=<?php echo $isEditMode ? ('updateDesa&id=' . $idDesa) : 'storeDesa'; ?>" method="POST" class="p-6 md:p-8">
            
            <div class="space-y-6">
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-slate-100">
                <div>
                  <label for="id_provinsi" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Induk Provinsi <span class="text-red-500">*</span></label>
                  <div class="relative">
                    <select class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 pl-4 pr-10 text-sm font-bold text-slate-600 outline-none transition-all focus:border-amber-500 focus:bg-white appearance-none cursor-pointer" id="id_provinsi" name="id_provinsi" required <?php echo $isEditMode ? 'disabled' : ''; ?>>
                      <option value="">-- Pemetaan Provinsi Hub --</option>
                      <?php foreach ($provinsiList as $provinsi): ?>
                        <option value="<?php echo (int)$provinsi['id']; ?>" <?php echo ((string)$selectedProvinsiId === (string)$provinsi['id']) ? 'selected' : ''; ?>>
                          <?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? '-'); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                  </div>
                  <?php if ($isEditMode): ?>
                    <input type="hidden" name="id_provinsi" value="<?php echo htmlspecialchars((string)$selectedProvinsiId); ?>">
                  <?php endif; ?>
                </div>

                <div>
                  <label for="id_kabupaten" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Induk Kab/Kota Target <span class="text-red-500">*</span></label>
                  <div class="relative">
                    <select class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 pl-4 pr-10 text-sm font-bold text-slate-600 outline-none transition-all focus:border-amber-500 focus:bg-white appearance-none cursor-pointer" id="id_kabupaten" name="id_kabupaten" required <?php echo $isEditMode ? 'disabled' : ''; ?>>
                      <option value="">-- Pilih Kab target --</option>
                      <?php foreach ($kabupatenList as $kabupaten): ?>
                        <option value="<?php echo (int)$kabupaten['id']; ?>" <?php echo ((string)$selectedKabupatenId === (string)$kabupaten['id']) ? 'selected' : ''; ?>>
                          <?php echo htmlspecialchars($kabupaten['nama'] ?? $kabupaten['name'] ?? '-'); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                  </div>
                  <?php if ($isEditMode): ?>
                    <input type="hidden" name="id_kabupaten" value="<?php echo htmlspecialchars((string)$selectedKabupatenId); ?>">
                  <?php endif; ?>
                </div>
              </div>

              <div>
                <label for="id_kecamatan" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cabang Kecamatan Target <span class="text-red-500">*</span></label>
                <div class="relative">
                  <select class="w-full md:w-1/2 rounded-xl border border-slate-300 bg-slate-50 py-3 pl-4 pr-10 text-sm font-bold text-emerald-700 outline-none transition-all focus:border-amber-500 focus:bg-white appearance-none cursor-pointer" id="id_kecamatan" name="id_kecamatan" required>
                    <option value="">-- Pilih Kecamatan Akhir --</option>
                    <?php foreach ($kecamatanList as $kecamatan): ?>
                      <option value="<?php echo (int)$kecamatan['id']; ?>" <?php echo ((string)$selectedKecamatanId === (string)$kecamatan['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($kecamatan['nama'] ?? $kecamatan['name'] ?? '-'); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none md:right-[52%]"></i>
                </div>
              </div>


              <div class="pt-4 border-t border-slate-100">
                <label for="nama" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Leaf Kel/Desa <span class="text-red-500">*</span></label>
                <div class="relative">
                  <i class="fa-solid fa-house-flag absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                  <input
                    type="text"
                    class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 pl-11 pr-4 text-sm font-bold text-slate-800 outline-none transition-all focus:border-amber-500 focus:bg-white"
                    id="nama"
                    name="nama"
                    value="<?php echo htmlspecialchars($desa['nama'] ?? $desa['name'] ?? ''); ?>"
                    placeholder="Contoh: Desa Sukamaju, Kel. Kebon Kacang"
                    required
                  >
                </div>
                <p class="text-xs text-slate-400 mt-1.5 font-medium">Beri prefix 'Desa' atau 'Kelurahan' untuk membedakan birokrasi, sistem posko sering terpisah karenanya.</p>
              </div>

            </div>
            
            <div class="mt-8 pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
              <a href="index.php?controller=Wilayah&action=indexDesa<?php echo $selectedKecamatanId ? ('&kecamatan_id=' . urlencode((string)$selectedKecamatanId)) : ''; ?>" class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                Kembali
              </a>
              <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-600 text-sm font-bold text-white hover:bg-amber-700 hover:shadow-float transition-all shadow-sm">
                <i class="fa-solid fa-database mr-1.5"></i> <?php echo $saveLabel; ?>
              </button>
            </div>

          </form>
        </div>

      </div>
    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>

<?php if (!$isEditMode): ?>
<script>
  (function () {
    const provinsiSelect = document.getElementById('id_provinsi');
    const kabupatenSelect = document.getElementById('id_kabupaten');
    const kecamatanSelect = document.getElementById('id_kecamatan');

    async function fetchList(url) {
      const res = await fetch(url, { credentials: 'same-origin' });
      return res.json();
    }

    function resetSelect(select, placeholder) {
      select.innerHTML = '<option value="">' + placeholder + '</option>';
    }

    async function loadKabupaten(provinsiId) {
      kabupatenSelect.disabled = true;
      resetSelect(kabupatenSelect, 'Memuat network...');
      resetSelect(kecamatanSelect, '-- Tunggu Kab --');
      try {
        const data = await fetchList('index.php?controller=Wilayah&action=getKabupatenByProvinsi&id=' + encodeURIComponent(provinsiId));
        resetSelect(kabupatenSelect, '-- Pilih Kab Target --');
        if (data.success && Array.isArray(data.data)) {
          data.data.forEach(function (item) {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.nama || item.name || '-';
            kabupatenSelect.appendChild(option);
          });
        }
      } catch (e) {
        resetSelect(kabupatenSelect, '-- Gagal Load --');
      } finally {
        kabupatenSelect.disabled = false;
      }
    }

    async function loadKecamatan(kabupatenId) {
      kecamatanSelect.disabled = true;
      resetSelect(kecamatanSelect, 'Menyamakan jalur...');
      try {
        const data = await fetchList('index.php?controller=Wilayah&action=getKecamatanByKabupaten&id=' + encodeURIComponent(kabupatenId));
        resetSelect(kecamatanSelect, '-- Pilih Kecamatan Akhir --');
        if (data.success && Array.isArray(data.data)) {
          data.data.forEach(function (item) {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.nama || item.name || '-';
            kecamatanSelect.appendChild(option);
          });
        }
      } catch (e) {
        resetSelect(kecamatanSelect, '-- Gagal sinkron --');
      } finally {
        kecamatanSelect.disabled = false;
      }
    }

    provinsiSelect.addEventListener('change', function () {
      if (!this.value) {
        resetSelect(kabupatenSelect, '-- Pilih Kab target --');
        resetSelect(kecamatanSelect, '-- Pilih Kecamatan Akhir --');
        return;
      }
      loadKabupaten(this.value);
    });

    kabupatenSelect.addEventListener('change', function () {
      if (!this.value) {
        resetSelect(kecamatanSelect, '-- Pilih Kecamatan Akhir --');
        return;
      }
      loadKecamatan(this.value);
    });
  })();
</script>
<?php endif; ?>
