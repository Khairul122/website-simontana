<?php include('template/header.php'); ?>

<?php
$isEditMode = isset($tindakLanjut);
$formAction = $isEditMode
  ? 'index.php?controller=TindakLanjut&action=update&id=' . (int)($tindakLanjut['id_tindaklanjut'] ?? 0)
  : 'index.php?controller=TindakLanjut&action=store';
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div class="flex items-center gap-4">
            <a href="index.php?controller=TindakLanjut&action=index" class="flex items-center justify-center h-10 w-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-brand-600 hover:bg-brand-50 hover:border-brand-200 transition-all shadow-sm">
              <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
              <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight"><?php echo $isEditMode ? 'Edit Status Operasi' : 'Rekam Operasi Baru'; ?></h1>
              <p class="text-sm text-slate-500">Update tahapan respons dan dokumentasikan langkah penanganan oleh BPBD.</p>
            </div>
          </div>
        </div>

        <?php if (isset($error_message)): ?>
          <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6 flex items-start gap-4">
            <div class="flex-shrink-0 text-red-500 mt-0.5"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
            <div class="flex-1">
              <h3 class="text-sm font-bold text-red-800">Gagal Memproses Validasi</h3>
              <p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($error_message); ?></p>
            </div>
          </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          
          <div class="lg:col-span-2">
            <div class="rounded-2xl bg-white border border-slate-200 shadow-card overflow-hidden">
              <form method="POST" action="<?php echo $formAction; ?>" enctype="multipart/form-data" class="p-6">
                
                <div class="space-y-6">
                  
                  <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Laporan Target Insiden <span class="text-red-500">*</span></label>
                    <?php if ($isEditMode): ?>
                      <div class="relative">
                        <i class="fa-solid fa-thumbtack absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" class="w-full rounded-xl border border-slate-200 bg-slate-100 py-3 pl-11 pr-4 text-sm font-bold text-slate-600 select-none" value="<?php echo htmlspecialchars($tindakLanjut['laporan_judul'] ?? $tindakLanjut['laporan']['judul_laporan'] ?? '-'); ?>" readonly>
                        <input type="hidden" name="laporan_id" value="<?php echo htmlspecialchars((string)($tindakLanjut['laporan_id'] ?? '')); ?>">
                      </div>
                    <?php else: ?>
                      <div class="relative">
                        <select class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 pl-4 pr-10 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white appearance-none" name="laporan_id" required>
                          <option value="">-- Tentukan Laporan Terkait --</option>
                          <?php if (!empty($laporanList) && is_array($laporanList)): ?>
                            <?php foreach ($laporanList as $laporan): ?>
                              <option value="<?php echo (int)$laporan['id']; ?>">
                                <?php echo htmlspecialchars($laporan['judul_laporan'] ?? '-'); ?>
                              </option>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                      </div>
                    <?php endif; ?>
                  </div>

                  
                  <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Waktu Pembaruan / Keberangkatan <span class="text-red-500">*</span></label>
                    <input
                      type="datetime-local"
                      class="w-full md:w-1/2 rounded-xl border border-slate-300 bg-slate-50 py-2.5 px-4 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white"
                      name="tanggal_tanggapan"
                      value="<?php echo $isEditMode ? date('Y-m-d\TH:i', strtotime($tindakLanjut['tanggal_tanggapan'] ?? 'now')) : date('Y-m-d\TH:i'); ?>"
                      required
                    >
                  </div>

                  
                  <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Stage Penanganan Berjalan <span class="text-red-500">*</span></label>
                    <div class="relative w-full md:w-2/3">
                      <select class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 pl-4 pr-10 text-sm font-bold text-slate-800 outline-none transition-all focus:border-brand-500 focus:bg-white appearance-none" name="status" required>
                        <option value="">-- Pilih Tahapan Operasi --</option>
                        <option value="Menuju Lokasi" <?php echo ($isEditMode && ($tindakLanjut['status'] ?? '') === 'Menuju Lokasi') ? 'selected' : ''; ?>>🚚 Menuju Lokasi</option>
                        <option value="Sedang Ditangani" <?php echo ($isEditMode && ($tindakLanjut['status'] ?? '') === 'Sedang Ditangani') ? 'selected' : ''; ?>>🚧 Sedang Ditangani</option>
                        <option value="Selesai" <?php echo ($isEditMode && ($tindakLanjut['status'] ?? '') === 'Selesai') ? 'selected' : ''; ?>>✅ Telah Selesai</option>
                        <option value="Ditolak" <?php echo ($isEditMode && ($tindakLanjut['status'] ?? '') === 'Ditolak') ? 'selected' : ''; ?>>❌ Dibatalkan / Ditolak</option>
                      </select>
                      <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    </div>
                  </div>

                  
                  <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Log Operasi Lapangan (Opsional)</label>
                    <textarea 
                      class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 px-4 text-sm font-medium outline-none transition-all focus:border-brand-500 focus:bg-white" 
                      name="keterangan" 
                      rows="4" 
                      placeholder="Jelaskan kebutuhan, peralatan yang dibawa, atau rintangan selama penanganan (opsional)..." 
                    ><?php echo htmlspecialchars($tindakLanjut['keterangan'] ?? ''); ?></textarea>
                  </div>
                </div>

                
                <div class="mt-8 pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                  <a href="index.php?controller=TindakLanjut&action=index" class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                  </a>
                  <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-600 text-sm font-bold text-white hover:bg-brand-700 hover:shadow-float transition-all shadow-sm">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> <?php echo $isEditMode ? 'Update' : 'Rekam'; ?> Ke Dalam Sistem
                  </button>
                </div>
              </form>
            </div>
          </div>

          <div class="lg:col-span-1">
            <div class="rounded-2xl border border-indigo-200 bg-indigo-50 p-6 sticky top-24">
              <h3 class="font-bold text-indigo-900 mb-4 pb-3 border-b border-indigo-100 flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-indigo-600"></i> Ketentuan Ops
              </h3>
              
              <ul class="space-y-4">
                <li class="flex items-start gap-3">
                  <div class="flex-shrink-0 w-6 h-6 rounded-full bg-white text-indigo-600 shadow-sm flex items-center justify-center text-xs font-bold mt-0.5"><i class="fa-solid fa-1"></i></div>
                  <p class="text-sm text-indigo-800 leading-relaxed font-medium">Bila laporan belum memanggil operasi penanganan, mulailah dengan memilih status <strong>Menuju Lokasi</strong>.</p>
                </li>
                <li class="flex items-start gap-3">
                  <div class="flex-shrink-0 w-6 h-6 rounded-full bg-white text-indigo-600 shadow-sm flex items-center justify-center text-xs font-bold mt-0.5"><i class="fa-solid fa-2"></i></div>
                  <p class="text-sm text-indigo-800 leading-relaxed font-medium">Anda dapat mengedit data ini secara berkelanjutan (merubah statusnya dari berjalan menjadi <strong>Selesai</strong>).</p>
                </li>
                <li class="flex items-start gap-3">
                  <div class="flex-shrink-0 w-6 h-6 rounded-full bg-white text-indigo-600 shadow-sm flex items-center justify-center text-xs font-bold mt-0.5"><i class="fa-solid fa-3"></i></div>
                  <p class="text-sm text-indigo-800 leading-relaxed font-medium">Semua history pergantian status saat ini dicatat berdasarkan tanggal tanggapan dominan form ini.</p>
                </li>
              </ul>
            </div>
          </div>

        </div>

      </div>
    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>
