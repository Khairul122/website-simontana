<?php include('template/header.php'); ?>

<?php
$isEditMode = (bool) ($isEdit ?? false);
$pageTitle = $isEditMode ? 'Edit Informasi Provinsi' : 'Input Provinsi Baru';
$saveLabel = $isEditMode ? 'Simpan Perubahan' : 'Registrasi Provinsi';
$idProvinsi = (int) ($provinsi['id'] ?? 0);
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
          <div class="flex items-center gap-4">
            <a href="index.php?controller=Wilayah&action=indexProvinsi" class="flex items-center justify-center h-10 w-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-brand-600 hover:bg-brand-50 hover:border-brand-200 transition-all shadow-sm">
              <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
              <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight"><?php echo $pageTitle; ?></h1>
              <p class="text-sm text-slate-500">Kelola record data provinsi sebagai fondasi struktur daerah.</p>
            </div>
          </div>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-card overflow-hidden">
          <form method="POST" action="index.php?controller=Wilayah&action=<?php echo $isEditMode ? ('updateProvinsi&id=' . $idProvinsi) : 'storeProvinsi'; ?>" class="p-6 md:p-8">
            
            <div class="space-y-6">
              <div>
                <label for="nama" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Provinsi Valid (Level 1) <span class="text-red-500">*</span></label>
                <div class="relative">
                  <i class="fa-solid fa-map absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                  <input
                    type="text"
                    class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 pl-11 pr-4 text-sm font-bold text-slate-800 outline-none transition-all focus:border-brand-500 focus:bg-white"
                    id="nama"
                    name="nama"
                    value="<?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? ''); ?>"
                    placeholder="Contoh: Jawa Timur, DKI Jakarta"
                    required
                  >
                </div>
                <p class="text-xs text-slate-400 mt-1.5 font-medium">Beri penamaan yang representatif tanpa disingkat jika memungkinkan (Cth: Kalimantan Barat vs Kalbar).</p>
              </div>
            </div>
            
            <div class="mt-8 pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
              <a href="index.php?controller=Wilayah&action=indexProvinsi" class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                Kembali
              </a>
              <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-600 text-sm font-bold text-white hover:bg-brand-700 hover:shadow-float transition-all shadow-sm">
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
