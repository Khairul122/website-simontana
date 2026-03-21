<?php include('template/header.php'); ?>

<?php
$isEditMode = (bool) ($isEdit ?? false);
$pageTitle = $isEditMode ? 'Edit Tipe Bencana' : 'Definisi Kategori Baru';
$saveLabel = $isEditMode ? 'Update' : 'Simpan Kategori Baru';
$idKategori = (int) ($kategori['id'] ?? 0);
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
            <a href="index.php?controller=KategoriBencana&action=index" class="flex items-center justify-center h-10 w-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-brand-600 hover:bg-brand-50 hover:border-brand-200 transition-all shadow-sm">
              <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
              <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight"><?php echo $pageTitle; ?></h1>
              <p class="text-sm text-slate-500">Konfigurasi nama, warna dan ikon pendukung untuk sistem referensi utama.</p>
            </div>
          </div>
        </div>

        <?php if ($isEditMode && empty($kategori)): ?>
          <div class="rounded-xl bg-amber-50 border border-amber-200 p-6 text-center">
            <i class="fa-solid fa-circle-exclamation text-amber-500 text-3xl mb-3"></i>
            <h3 class="font-bold text-amber-800 mb-1">Referensi Tidak Ditemukan</h3>
            <p class="text-sm text-amber-700 mb-4">Master data kategori yang Anda tuju sepertinya sudah tidak valid.</p>
            <a href="index.php?controller=KategoriBencana&action=index" class="inline-flex items-center px-5 py-2 rounded-xl bg-amber-600 text-sm font-bold text-white hover:bg-amber-700 transition">Kembali</a>
          </div>
        <?php else: ?>
          
          <div class="rounded-2xl bg-white border border-slate-200 shadow-card overflow-hidden">
            <form method="POST" action="index.php?controller=KategoriBencana&action=<?php echo $isEditMode ? ('update&id=' . $idKategori) : 'store'; ?>" class="p-6 md:p-8">
              
              <div class="space-y-6">
                
                <div>
                  <label for="nama_kategori" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Bencana <span class="text-red-500">*</span></label>
                  <input
                    type="text"
                    class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 px-4 text-sm font-bold text-slate-800 outline-none transition-all focus:border-brand-500 focus:bg-white"
                    id="nama_kategori"
                    name="nama_kategori"
                    value="<?php echo htmlspecialchars($kategori['nama_kategori'] ?? $kategori['nama'] ?? ''); ?>"
                    placeholder="Misal: Gempa Bumi Tektonik, Longsor"
                    required
                  >
                  <p class="text-xs text-slate-400 mt-1.5 font-medium"><i class="fa-solid fa-circle-info text-brand-500 mr-1"></i> Nama ini akan muncul di sidebar dan laporan statistik.</p>
                </div>

                <div>
                  <label for="icon" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Identifier Ikon (FontAwesome 6.4)</label>
                  <div class="relative">
                    <i class="fa-solid fa-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input
                      type="text"
                      class="w-full md:w-1/2 rounded-xl border border-slate-300 bg-slate-50 py-3 pl-11 pr-4 text-sm font-medium text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white font-mono"
                      id="icon"
                      name="icon"
                      value="<?php echo htmlspecialchars($kategori['icon'] ?? ''); ?>"
                      placeholder="earthquake, fire, house-crack"
                    >
                  </div>
                  <p class="text-xs text-slate-400 mt-1.5 font-medium">Gunakan prefix-free code (contoh: cukup <code>house-tsunami</code>, tidak perlu <code>fa-house-tsunami</code>).</p>
                </div>

                <div>
                  <label for="deskripsi" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Keterangan / Deskripsi Khusus</label>
                  <textarea 
                    class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 px-4 text-sm font-medium text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white leading-relaxed" 
                    id="deskripsi" 
                    name="deskripsi" 
                    rows="4" 
                    placeholder="Tuliskan indikator khusus untuk laporan bencana dengan jenis ini jika diperlukan..."
                  ><?php echo htmlspecialchars($kategori['deskripsi'] ?? ''); ?></textarea>
                </div>

              </div>
              
              <div class="mt-8 pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="index.php?controller=KategoriBencana&action=index" class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                  Batalkan
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-600 text-sm font-bold text-white hover:bg-brand-700 hover:shadow-float transition-all shadow-sm">
                  <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> <?php echo $saveLabel; ?> Referensi
                </button>
              </div>

            </form>
          </div>

        <?php endif; ?>

      </div>
    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>
