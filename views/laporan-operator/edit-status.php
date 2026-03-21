<?php include('template/header.php'); ?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full max-w-4xl mx-auto"> 

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div>
            <div class="flex items-center gap-2 mb-2">
              <a href="index.php?controller=LaporanOperator&action=index" class="text-sm font-bold text-slate-400 hover:text-brand-600 transition flex items-center gap-1"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            </div>
            <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-900">Perbarui Status Pelaporan</h1>
            <p class="text-sm text-slate-500 mt-1">Lakukan verifikasi atau tolak laporan yang masuk dari wilayah Anda.</p>
          </div>
        </div>

        <?php if (isset($error_message)): ?>
          <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6 flex items-start gap-4 shadow-sm">
            <div class="flex-shrink-0 text-red-500 mt-0.5"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
            <div class="flex-1">
              <h3 class="text-sm font-bold text-red-800">Validasi Gagal</h3>
              <p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($error_message); ?></p>
            </div>
          </div>
        <?php endif; ?>

        <?php if (!empty($report)): ?>
          <div class="rounded-3xl bg-white border border-slate-200 shadow-card overflow-hidden">
             
            
            <div class="bg-indigo-50 border-b border-indigo-100 p-6 md:px-8 md:py-6 flex items-start gap-5">
               <div class="w-12 h-12 rounded-xl bg-white text-indigo-500 flex items-center justify-center text-xl shrink-0 shadow-sm border border-indigo-100">
                  <i class="fa-solid fa-file-invoice"></i>
               </div>
               <div>
                  <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-1 mt-1">Laporan Target</p>
                  <h3 class="font-bold text-lg text-indigo-900 leading-tight"><?php echo htmlspecialchars($report['judul_laporan'] ?? ''); ?></h3>
               </div>
            </div>

            <form action="index.php?controller=LaporanOperator&action=update" method="POST" class="p-6 md:p-8">
              <input type="hidden" name="id" value="<?php echo (int)$report['id']; ?>">

              <div class="space-y-6">
                
                <div>
                  <label for="status" class="block text-sm font-bold text-slate-700 mb-2">Status Penanganan <span class="text-red-500">*</span></label>
                  <div class="relative">
                    <select class="w-full h-12 pl-4 pr-10 rounded-xl border border-slate-300 bg-white text-slate-700 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 appearance-none transition-shadow" id="status" name="status" required>
                      <option value="">Pilih Status</option>
                      <option value="Menunggu Verifikasi" <?php echo ($report['status'] ?? '') === 'Menunggu Verifikasi' ? 'selected' : ''; ?>>🕒 Menunggu Verifikasi</option>
                      <option value="Diverifikasi" <?php echo ($report['status'] ?? '') === 'Diverifikasi' ? 'selected' : ''; ?>>✅ Diverifikasi (Valid)</option>
                      <option value="Ditolak" <?php echo ($report['status'] ?? '') === 'Ditolak' ? 'selected' : ''; ?>>⛔ Ditolak (Spam / Palsu)</option>
                      <option value="Selesai" <?php echo ($report['status'] ?? '') === 'Selesai' ? 'selected' : ''; ?>>🏁 Selesai Tangani</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                      <i class="fa-solid fa-chevron-down text-sm"></i>
                    </div>
                  </div>
                  <p class="text-xs text-slate-500 mt-2 font-medium">Ubah ke <b>Diverifikasi</b> jika laporan dinyatakan sah. Jika tergolong SPAM, ubah ke <b>Ditolak</b>.</p>
                </div>

                
                <div>
                  <label for="catatan_verifikasi" class="block text-sm font-bold text-slate-700 mb-2">Catatan Operator</label>
                  <textarea class="w-full rounded-xl border border-slate-300 bg-white p-4 text-slate-700 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-shadow placeholder-slate-400 resize-none" id="catatan_verifikasi" name="catatan_verifikasi" rows="4" placeholder="Jelaskan alasan verifikasi atau penolakan ini untuk rujukan tim di lapangan..."><?php echo htmlspecialchars($report['catatan_verifikasi'] ?? ''); ?></textarea>
                  <p class="text-xs text-slate-500 mt-2 font-medium">Opsional: Boleh tidak diisi, sangat disarankan bila berstatus "Ditolak".</p>
                </div>
              </div>

              
              <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="index.php?controller=LaporanOperator&action=detail&id=<?php echo $report['id']; ?>" class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 font-bold text-sm hover:bg-slate-50 transition shadow-sm">
                  Batalkan
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-600 text-white font-bold text-sm hover:bg-brand-700 transition shadow-sm hover:shadow-float flex items-center gap-2">
                  <i class="fa-solid fa-check"></i> Simpan Status
                </button>
              </div>
            </form>
          </div>
        <?php else: ?>
          <div class="rounded-2xl bg-amber-50 border border-amber-200 p-8 text-center max-w-2xl mx-auto mt-10 shadow-sm">
            <div class="inline-flex h-20 w-20 rounded-full bg-white text-amber-500 items-center justify-center mb-5 shadow-sm text-3xl"><i class="fa-solid fa-file-circle-xmark"></i></div>
            <h3 class="font-display font-bold text-amber-800 text-xl mb-2">Data Laporan Bodong</h3>
            <p class="text-sm font-medium text-amber-700 mb-6">Berkas laporan sudah tidak ada atau telah ditarik kembali.</p>
            <a href="index.php?controller=LaporanOperator&action=index" class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-amber-600 text-sm font-bold text-white hover:bg-amber-700 transition shadow-sm">
              Kembali ke Daftar
            </a>
          </div>
        <?php endif; ?>

      </div>
    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>