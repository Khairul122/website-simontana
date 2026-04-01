<?php include('template/header.php'); ?>

<?php
function laporanPetugasEditStatusBadge($statusRaw) {
  $status = strtolower(trim((string) $statusRaw));
  if ($status === 'menunggu verifikasi' || $status === 'verifikasi' || $status === 'diverifikasi') {
    return ['Diverifikasi', 'bg-blue-50 text-blue-600 border-blue-200 fa-shield-check'];
  }
  if ($status === 'diproses' || $status === 'ditangani') {
    return ['Diproses', 'bg-indigo-50 text-indigo-600 border-indigo-200 fa-spinner fa-spin'];
  }
  if ($status === 'tindak lanjut') {
    return ['Tindak Lanjut', 'bg-amber-50 text-amber-600 border-amber-200 fa-truck-fast'];
  }
  if ($status === 'selesai') {
    return ['Selesai', 'bg-emerald-50 text-emerald-600 border-emerald-200 fa-check-double'];
  }
  if ($status === 'ditolak') {
    return ['Ditolak', 'bg-rose-50 text-rose-600 border-rose-200 fa-ban'];
  }
  if ($status === 'draft') {
    return ['Draft', 'bg-slate-100 text-slate-600 border-slate-200 fa-pen-ruler'];
  }
  return [$statusRaw ?: '-', 'bg-slate-50 text-slate-500 border-slate-200 fa-circle-info'];
}
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full max-w-6xl mx-auto"> 

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div>
            <div class="flex items-center gap-2 mb-2">
              <a href="index.php?controller=LaporanPetugas&action=detail&id=<?php echo (int) ($laporan['id'] ?? 0); ?>" class="text-sm font-bold text-slate-400 hover:text-brand-600 transition flex items-center gap-1"><i class="fa-solid fa-arrow-left"></i> Batal / Kembali ke Detail</a>
            </div>
            <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-900">Perbarui Status Penanganan</h1>
            <p class="text-sm text-slate-500 mt-1">Lakukan pembaruan progres kerja terkait penanganan di lapangan agar terus sinkron secara sistem.</p>
          </div>
        </div>

        <?php if (isset($error_message)): ?>
          <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6 flex items-start gap-4 shadow-sm">
            <div class="flex-shrink-0 text-red-500 mt-0.5"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
            <div class="flex-1">
              <h3 class="text-sm font-bold text-red-800">Ups! Sesuatu Terjadi</h3>
              <p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($error_message); ?></p>
            </div>
          </div>
        <?php endif; ?>

        <?php if (isset($laporan) && $laporan): ?>
          <?php [$label, $badge] = laporanPetugasEditStatusBadge($laporan['status'] ?? ''); ?>
          
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            
            <div class="lg:col-span-8">
              <div class="rounded-3xl bg-white border border-slate-200 shadow-card overflow-hidden">
                <div class="bg-indigo-50 border-b border-indigo-100 p-6 md:px-8 md:py-6 flex items-start gap-4">
                  <div class="w-10 h-10 rounded-xl bg-white text-indigo-500 flex items-center justify-center shrink-0 shadow-sm border border-indigo-100">
                     <i class="fa-solid fa-helmet-safety"></i>
                  </div>
                  <div>
                    <h3 class="font-bold text-lg text-indigo-900 leading-tight"><?php echo htmlspecialchars($laporan['judul_laporan'] ?? '-'); ?></h3>
                    <p class="text-xs text-indigo-600/70 font-medium mt-0.5">Penetapan status harus mencantumkan keterangan logis yang sesuai fakta lapangan.</p>
                  </div>
                </div>

                <form method="POST" action="index.php?controller=LaporanPetugas&action=update&id=<?php echo (int) $laporan['id']; ?>" class="p-6 md:p-8 space-y-6">
                  
                  <div>
                    <label for="status" class="block text-sm font-bold text-slate-700 mb-2">Pilar Status Proses <span class="text-red-500">*</span></label>
                    <div class="relative">
                      <select class="w-full h-12 pl-4 pr-10 rounded-xl border border-slate-300 bg-white text-slate-700 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 appearance-none transition-shadow" id="status" name="status" required>
                        <option value="">Pilih Status Pergerakan</option>
                        <option value="Draft" <?php echo (isset($laporan['status']) && $laporan['status'] === 'Draft') ? 'selected' : ''; ?>>📝 Draft</option>
                        <option value="Menunggu Verifikasi" <?php echo (isset($laporan['status']) && $laporan['status'] === 'Menunggu Verifikasi') ? 'selected' : ''; ?>>🕒 Menunggu Verifikasi</option>
                        <option value="Diverifikasi" <?php echo (isset($laporan['status']) && $laporan['status'] === 'Diverifikasi') ? 'selected' : ''; ?>>✅ Diverifikasi Pusat</option>
                        <option value="Diproses" <?php echo (isset($laporan['status']) && $laporan['status'] === 'Diproses') ? 'selected' : ''; ?>>⚙️ Diproses Pelaksanaan</option>
                        <option value="Tindak Lanjut" <?php echo (isset($laporan['status']) && $laporan['status'] === 'Tindak Lanjut') ? 'selected' : ''; ?>>🚚 Tindak Lanjut Unit Keliling</option>
                        <option value="Selesai" <?php echo (isset($laporan['status']) && $laporan['status'] === 'Selesai') ? 'selected' : ''; ?>>🏁 Selesai Tangani Seluruhnya</option>
                        <option value="Ditolak" <?php echo (isset($laporan['status']) && $laporan['status'] === 'Ditolak') ? 'selected' : ''; ?>>⛔ Ditolak</option>
                      </select>
                      <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-chevron-down text-sm"></i>
                      </div>
                    </div>
                  </div>

                  
                  <div>
                    <label for="keterangan" class="block text-sm font-bold text-slate-700 mb-2">Berita Keterangan Progress Baru</label>
                    <textarea class="w-full rounded-xl border border-slate-300 bg-white p-4 text-slate-700 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-shadow placeholder-slate-400 resize-none" id="keterangan" name="keterangan" rows="5" placeholder="Tambahkan catatan progres kerja lapangan secara rinci di mari..."><?php echo htmlspecialchars($laporan['keterangan'] ?? ''); ?></textarea>
                  </div>

                  
                  <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="index.php?controller=LaporanPetugas&action=detail&id=<?php echo (int) $laporan['id']; ?>" class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 font-bold text-sm hover:bg-slate-50 transition shadow-sm">
                      Urungkan Balik
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-600 text-white font-bold text-sm hover:bg-brand-700 transition shadow-sm hover:shadow-float flex items-center gap-2">
                      <i class="fa-solid fa-floppy-disk"></i> Sebarkan Perubahan
                    </button>
                  </div>
                </form>

              </div>
            </div>

            
            <div class="lg:col-span-4">
              <div class="rounded-3xl bg-slate-800 text-white shadow-card overflow-hidden sticky top-6">
                 <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-[100px] -mr-10 -mt-10 pointer-events-none"></div>
                 <div class="p-6 md:p-8 relative z-10">
                    <h3 class="text-sm font-bold text-white mb-5 uppercase tracking-widest border-b border-white/10 pb-3 flex items-center gap-2">
                       <i class="fa-solid fa-circle-info text-slate-400"></i> Rekapan Insiden (#<?php echo (int) ($laporan['id'] ?? 0); ?>)
                    </h3>
                    
                    <div class="space-y-4 text-sm font-medium">
                       <div>
                          <p class="text-[10px] text-slate-400 uppercase tracking-widest mb-1">Status Sistem Sekarang</p>
                          <?php 
                            $classes = explode(' ', $badge); 
                            $icon = array_pop($classes);
                            if(strpos($icon, 'fa-') === false) { $icon = 'fa-circle-info'; } else {
                               if(strpos($badge, 'fa-spin') !== false) {
                                  array_pop($classes);
                                  $icon = $icon . ' fa-spin';
                               }
                            }
                            $colorClasses = str_replace(['bg-blue-50', 'bg-emerald-50', 'bg-amber-50', 'bg-rose-50', 'bg-indigo-50'], ['bg-blue-500/20', 'bg-emerald-500/20', 'bg-amber-500/20', 'bg-rose-500/20', 'bg-indigo-500/20'], implode(' ', $classes));
                          ?>
                          <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border <?php echo $colorClasses; ?> text-xs font-bold shadow-sm mb-2">
                            <i class="fa-solid <?php echo $icon; ?>"></i> <?php echo htmlspecialchars($label); ?>
                          </div>
                       </div>
                       
                       <div>
                          <p class="text-[10px] text-slate-400 uppercase tracking-widest mb-1">Waktu Kedatangan Laporan</p>
                          <p class="text-slate-100 flex items-center gap-2"><i class="fa-regular fa-clock text-slate-500"></i> <?php echo date('d M Y - H:i', strtotime($laporan['waktu_laporan'] ?? 'now')); ?></p>
                       </div>
                       
                       <div class="pt-3 border-t border-white/10">
                          <p class="text-[10px] text-slate-400 uppercase tracking-widest mb-1">Pihak Terkait (Pelapor)</p>
                          <p class="text-slate-100"><?php echo htmlspecialchars($laporan['pelapor']['nama'] ?? '-'); ?></p>
                       </div>
                       
                       <div>
                          <p class="text-[10px] text-slate-400 uppercase tracking-widest mb-1">Titik Masalah (Alamat)</p>
                          <p class="text-slate-100 leading-relaxed"><?php echo htmlspecialchars($laporan['alamat_laporan'] ?? ($laporan['alamat_lengkap'] ?? '-')); ?></p>
                          <p class="text-xs text-slate-400 mt-1"><?php echo htmlspecialchars($laporan['administrative_area'] ?? '-'); ?></p>
                       </div>
                    </div>
                 </div>
              </div>
            </div>

          </div>
        <?php else: ?>
          <div class="rounded-2xl bg-amber-50 border border-amber-200 p-8 text-center max-w-2xl mx-auto mt-10 shadow-sm">
            <div class="inline-flex h-20 w-20 rounded-full bg-white text-amber-500 items-center justify-center mb-5 shadow-sm text-3xl"><i class="fa-solid fa-file-circle-xmark"></i></div>
            <h3 class="font-display font-bold text-amber-800 text-xl mb-2">Data Laporan Bodong</h3>
            <p class="text-sm font-medium text-amber-700 mb-6">Berkas laporan petugas BPBD ini sudah tidak ada atau telah ditarik kembali.</p>
            <a href="index.php?controller=LaporanPetugas&action=index" class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-amber-600 text-sm font-bold text-white hover:bg-amber-700 transition shadow-sm">
              Kembali ke Daftar Utama
            </a>
          </div>
        <?php endif; ?>

      </div>
    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>
