<?php include('template/header.php'); ?>

<?php
$isEditMode = (bool) ($isEdit ?? false);
$pageTitle = $isEditMode ? 'Edit Informasi Kabupaten' : 'Input Kabupaten / Kota';
$saveLabel = $isEditMode ? 'Simpan Perubahan' : 'Registrasi Kabupaten';
$idKabupaten = (int) ($kabupaten['id'] ?? 0);


$selectedProvinsiId = $_GET['provinsi_id'] ?? null;
if ($selectedProvinsiId === null && isset($kabupaten['id_provinsi'])) {
  $selectedProvinsiId = $kabupaten['id_provinsi'];
}
if ($selectedProvinsiId === null && isset($kabupaten['id_parent'])) {
  $selectedProvinsiId = $kabupaten['id_parent'];
}
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
          <div class="flex items-center gap-4">
            <a href="index.php?controller=Wilayah&action=indexKabupaten<?php echo $selectedProvinsiId ? ('&provinsi_id=' . urlencode((string)$selectedProvinsiId)) : ''; ?>" class="flex items-center justify-center h-10 w-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-brand-600 hover:bg-brand-50 hover:border-brand-200 transition-all shadow-sm">
              <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
              <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight"><?php echo $pageTitle; ?></h1>
              <p class="text-sm text-slate-500">Ikat penamaan kota / kabupaten ke simpul provinsi yang relevan.</p>
            </div>
          </div>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-card overflow-hidden">
          <form method="POST" action="index.php?controller=Wilayah&action=<?php echo $isEditMode ? ('updateKabupaten&id=' . $idKabupaten) : 'storeKabupaten'; ?>" class="p-6 md:p-8">
            
            <div class="space-y-6">
              
              <div>
                <label for="id_provinsi" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Induk Provinsi <span class="text-red-500">*</span></label>
                <div class="relative">
                  <select class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 pl-4 pr-10 text-sm font-bold text-slate-800 outline-none transition-all focus:border-indigo-500 focus:bg-white appearance-none cursor-pointer" id="id_provinsi" name="id_provinsi" required <?php echo $isEditMode ? 'disabled' : ''; ?>>
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
                  <p class="text-xs text-amber-600 mt-1.5 font-medium"><i class="fa-solid fa-lock mr-1"></i> Data induk tidak dapat diganti jika mode edit.</p>
                <?php endif; ?>
              </div>

              <div>
                <label for="nama" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Distrik Kabupaten / Kota <span class="text-red-500">*</span></label>
                <div class="relative">
                  <i class="fa-solid fa-map-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                  <input
                    type="text"
                    class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 pl-11 pr-4 text-sm font-bold text-slate-800 outline-none transition-all focus:border-indigo-500 focus:bg-white"
                    id="nama"
                    name="nama"
                    value="<?php echo htmlspecialchars($kabupaten['nama'] ?? $kabupaten['name'] ?? ''); ?>"
                    placeholder="Contoh: Kabupaten Sidoarjo, Kota Surabaya"
                    required
                  >
                </div>
                <p class="text-xs text-slate-400 mt-1.5 font-medium">Jangan lupakan prefix 'Kabupaten / Kota' untuk memperjelas konteksnya karena nama wilayah kadang ambigu.</p>
              </div>

            </div>
            
            <div class="mt-8 pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
              <a href="index.php?controller=Wilayah&action=indexKabupaten<?php echo $selectedProvinsiId ? ('&provinsi_id=' . urlencode((string)$selectedProvinsiId)) : ''; ?>" class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                Kembali
              </a>
              <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-sm font-bold text-white hover:bg-indigo-700 hover:shadow-float transition-all shadow-sm">
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
