<?php include('template/header.php'); ?>

<?php
$isEditMode = isset($riwayatTindakan);
$formAction = $isEditMode
  ? 'index.php?controller=RiwayatTindakan&action=update&id=' . (int)($riwayatTindakan['id'] ?? 0)
  : 'index.php?controller=RiwayatTindakan&action=store';
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative p-4 md:p-6 lg:p-8">
      
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
          <a href="index.php?controller=RiwayatTindakan&action=index" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-brand-600 hover:bg-brand-50 transition-all shadow-sm"><i class="fa-solid fa-arrow-left"></i></a>
          <div>
            <h1 class="text-2xl md:text-3xl font-display font-bold text-slate-800"><?php echo $isEditMode ? 'Edit Riwayat Tindakan' : 'Tambah Riwayat'; ?></h1>
            <p class="text-slate-500 mt-1">Dokumentasikan tindakan lapangan untuk rekam jejak operasional.</p>
          </div>
        </div>
      </div>

      <?php if (isset($error_message)): ?>
        <div class="rounded-xl bg-rose-50 border border-rose-200 p-4 mb-6 flex items-start gap-3">
          <div class="flex-shrink-0 text-rose-500 mt-0.5"><i class="fa-solid fa-circle-exclamation text-lg"></i></div>
          <div class="text-sm text-rose-700 font-medium"><?php echo htmlspecialchars($error_message); ?></div>
        </div>
      <?php endif; ?>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
           <div class="bg-white rounded-3xl border border-slate-200 shadow-card overflow-hidden">
              <div class="p-6 md:p-8">
                 <form method="POST" action="<?php echo $formAction; ?>">
                    
                    <div class="space-y-6">
                       
                       <div>
                          <label for="tindaklanjut_id" class="block text-sm font-bold text-slate-700 mb-2">Tindak Lanjut Terkait <span class="text-rose-500">*</span></label>
                          <select class="block w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors cursor-pointer appearance-none" id="tindaklanjut_id" name="tindaklanjut_id" required>
                             <option value="">-- Pilih Data Tindak Lanjut --</option>
                             <?php if (!empty($tindakLanjutList) && is_array($tindakLanjutList)): ?>
                               <?php foreach ($tindakLanjutList as $item): ?>
                                 <option value="<?php echo (int)$item['id_tindaklanjut']; ?>" <?php echo ($isEditMode && (string)($riwayatTindakan['tindaklanjut_id'] ?? '') === (string)$item['id_tindaklanjut']) ? 'selected' : ''; ?>>
                                   <?php echo htmlspecialchars($item['laporan_judul'] ?? $item['laporan']['judul_laporan'] ?? '-'); ?> (<?php echo htmlspecialchars($item['status'] ?? '-'); ?>)
                                 </option>
                               <?php endforeach; ?>
                             <?php else: ?>
                               <option value="" disabled>Data tindak lanjut tidak tersedia</option>
                             <?php endif; ?>
                          </select>
                       </div>

                       <div>
                          <label for="waktu_tindakan" class="block text-sm font-bold text-slate-700 mb-2">Waktu Eksekusi Tindakan <span class="text-rose-500">*</span></label>
                          <input type="datetime-local" class="block w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors" id="waktu_tindakan" name="waktu_tindakan" value="<?php echo $isEditMode ? date('Y-m-d\TH:i', strtotime($riwayatTindakan['waktu_tindakan'] ?? 'now')) : date('Y-m-d\TH:i'); ?>" required>
                       </div>

                       <div>
                          <label for="keterangan" class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Keterangan Tindakan <span class="text-rose-500">*</span></label>
                          <textarea class="block w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors" id="keterangan" name="keterangan" rows="6" placeholder="Tuliskan prosedur yang dilakukan secara ringkas dan rinci..." required><?php echo $isEditMode ? htmlspecialchars($riwayatTindakan['keterangan'] ?? '') : ''; ?></textarea>
                       </div>

                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                       <a href="index.php?controller=RiwayatTindakan&action=index" class="px-5 py-2.5 rounded-xl text-slate-600 bg-slate-100 hover:bg-slate-200 font-bold transition-colors">Batal</a>
                       <button type="submit" class="px-5 py-2.5 rounded-xl text-white bg-brand-600 hover:bg-brand-700 shadow-sm font-bold transition-all focus:ring-4 focus:ring-brand-500/20 flex items-center gap-2">
                          <i class="fa-solid fa-save"></i> <?php echo $isEditMode ? 'Simpan Perubahan Data' : 'Simpan Riwayat Baru'; ?>
                       </button>
                    </div>

                 </form>
              </div>
           </div>
        </div>

        <div class="lg:col-span-1">
           <div class="bg-amber-50 rounded-3xl border border-amber-200 shadow-sm p-6 relative overflow-hidden">
              <div class="absolute -right-4 -top-4 text-amber-500 opacity-20"><i class="fa-solid fa-lightbulb text-8xl"></i></div>
              <h3 class="font-bold text-amber-800 text-lg mb-4 flex items-center gap-2 relative z-10"><i class="fa-solid fa-book-open"></i> Panduan Pengisian Poin</h3>
              <ul class="space-y-3 relative z-10">
                 <li class="flex items-start gap-3 text-sm text-amber-700"><i class="fa-solid fa-check mt-1"></i> <span>Pilih tindak lanjut yang paling tepat sebelum membuat riwayat.</span></li>
                 <li class="flex items-start gap-3 text-sm text-amber-700"><i class="fa-solid fa-check mt-1"></i> <span>Gunakan waktu tindakan <strong>seaktual mungkin</strong>.</span></li>
                 <li class="flex items-start gap-3 text-sm text-amber-700"><i class="fa-solid fa-check mt-1"></i> <span>Jelaskan langkah apa saja yang sudah dikerjakan di bagian Keterangan.</span></li>
                 <li class="flex items-start gap-3 text-sm text-amber-700"><i class="fa-solid fa-shield mt-1"></i> <span class="font-medium">Jaga kerahasiaan data; pastikan catatan ini benar karena akan dipakai sebagai bahan audit BPKP/BPBD.</span></li>
              </ul>
           </div>
        </div>
      </div>

    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>
