<?php include('template/header.php'); ?>

<?php
$isEditMode = isset($monitoring['id']);
$monitoringId = (int) ($monitoring['id'] ?? 0);
$laporanList = is_array($laporanList ?? null) ? $laporanList : [];
$operatorList = is_array($operatorList ?? null) ? $operatorList : [];
$sessionOperatorId = (int)($_SESSION['user']['id'] ?? 0);
$formAction = $isEditMode
  ? 'index.php?controller=Monitoring&action=update&id=' . $monitoringId
  : 'index.php?controller=Monitoring&action=store';
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div class="flex items-center gap-4">
            <a href="index.php?controller=Monitoring&action=index" class="flex items-center justify-center h-10 w-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-brand-600 hover:bg-brand-50 hover:border-brand-200 transition-all shadow-sm">
              <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
              <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight"><?php echo $isEditMode ? 'Edit Hasil Observasi' : 'Catat Monitoring Lapangan'; ?></h1>
              <p class="text-sm text-slate-500">Lengkapi form ini dengan hasil temuan riil oleh tim di garis terdepan.</p>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          
          <div class="lg:col-span-2">
            <div class="rounded-2xl bg-white border border-slate-200 shadow-card overflow-hidden">
              <form method="POST" action="<?php echo $formAction; ?>" class="p-6">
                
                <div class="mb-6 pb-6 border-b border-slate-100">
                  <h3 class="font-bold text-slate-800 flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-file-contract text-brand-500"></i> Referensi Data
                  </h3>
                  
                  <?php if (!$isEditMode): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                      
                      <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Laporan Acuan <span class="text-red-500">*</span></label>
                        <div class="relative">
                          <select class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-4 pr-10 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white appearance-none" name="id_laporan" required>
                            <option value="">-- Pilih Laporan --</option>
                            <?php if (!empty($laporanList)): ?>
                              <?php foreach ($laporanList as $laporan): ?>
                                <?php
                                $laporanId = (int)($laporan['id'] ?? 0);
                                $judul = $laporan['judul_laporan'] ?? $laporan['judul'] ?? 'Tanpa judul';
                                $pelaporNama = $laporan['pelapor']['nama'] ?? null;
                                ?>
                                <?php if ($laporanId > 0): ?>
                                  <option value="<?php echo $laporanId; ?>">
                                    <?php echo htmlspecialchars($judul); ?><?php echo $pelaporNama ? ' (' . htmlspecialchars($pelaporNama) . ')' : ''; ?>
                                  </option>
                                <?php endif; ?>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </select>
                          <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        </div>
                      </div>

                      
                      <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tim Operator <span class="text-red-500">*</span></label>
                        <div class="relative">
                          <select class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-4 pr-10 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white appearance-none" name="id_operator" required>
                            <option value="">-- Pilih Tim Bertugas --</option>
                            <?php if (!empty($operatorList)): ?>
                              <?php foreach ($operatorList as $operator): ?>
                                <?php
                                $operatorId = (int)($operator['id'] ?? 0);
                                $operatorNama = $operator['nama'] ?? $operator['username'] ?? 'Tanpa nama';
                                $selected = $operatorId > 0 && $operatorId === $sessionOperatorId;
                                ?>
                                <?php if ($operatorId > 0): ?>
                                  <option value="<?php echo $operatorId; ?>" <?php echo $selected ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($operatorNama); ?>
                                  </option>
                                <?php endif; ?>
                              <?php endforeach; ?>
                            <?php elseif ($sessionOperatorId > 0): ?>
                              <option value="<?php echo $sessionOperatorId; ?>" selected>Operator aktif</option>
                            <?php endif; ?>
                          </select>
                          <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        </div>
                      </div>
                    </div>
                  <?php else: ?>
                    <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                      <p class="text-sm text-slate-500 mb-1">Laporan Acuan: <strong class="text-slate-700"><?php echo htmlspecialchars((string)($monitoring['laporan_judul'] ?? ('#' . ($monitoring['laporan_id'] ?? $monitoring['id_laporan'] ?? '-')))); ?></strong></p>
                      <p class="text-sm text-slate-500">Operator Bertugas: <strong class="text-slate-700"><?php echo htmlspecialchars((string)($monitoring['operator_nama'] ?? '-')); ?></strong></p>
                      <input type="hidden" name="id_laporan" value="<?php echo htmlspecialchars((string)($monitoring['laporan_id'] ?? $monitoring['id_laporan'] ?? '')); ?>">
                      <input type="hidden" name="id_operator" value="<?php echo htmlspecialchars((string)($monitoring['operator_id'] ?? $monitoring['id_operator'] ?? '')); ?>">
                    </div>
                  <?php endif; ?>
                </div>

                <div class="space-y-5">
                  <h3 class="font-bold text-slate-800 flex items-center gap-2 mb-2">
                    <i class="fa-solid fa-magnifying-glass-chart text-brand-500"></i> Detail Observasi
                  </h3>

                  <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Waktu Pencatatan Monitoring <span class="text-red-500">*</span></label>
                    <input
                      type="datetime-local"
                      class="w-full md:w-1/2 rounded-xl border border-slate-300 bg-slate-50 py-2.5 px-4 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white"
                      name="waktu_monitoring"
                      value="<?php echo isset($monitoring['waktu_monitoring']) ? date('Y-m-d\TH:i', strtotime($monitoring['waktu_monitoring'])) : date('Y-m-d\TH:i'); ?>"
                      required
                    >
                  </div>

                  <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Koordinat Titik Pantau (GPS)</label>
                    <div class="relative">
                      <i class="fa-solid fa-location-crosshairs absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                      <input 
                        type="text" 
                        class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-11 pr-4 text-sm font-medium outline-none transition-all focus:border-brand-500 focus:bg-white" 
                        name="koordinat_gps" 
                        value="<?php echo htmlspecialchars($monitoring['koordinat_gps'] ?? ''); ?>" 
                        placeholder="Contoh: -6.2088,106.8456"
                      >
                    </div>
                  </div>

                  <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Hasil Monitoring / Temuan Lapangan <span class="text-red-500">*</span></label>
                    <textarea 
                      class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 px-4 text-sm font-medium outline-none transition-all focus:border-brand-500 focus:bg-white" 
                      name="hasil_monitoring" 
                      rows="6" 
                      placeholder="Jelaskan secara komprehensif apa yang ditemukan tim ops secara real di lapangan..." 
                      required><?php echo htmlspecialchars($monitoring['hasil_monitoring'] ?? ''); ?></textarea>
                  </div>
                </div>

                
                <div class="mt-8 pt-5 border-t border-slate-100 flex items-center justify-end gap-3">
                  <a href="index.php?controller=Monitoring&action=index" class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                    Batal
                  </a>
                  <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-600 text-sm font-bold text-white hover:bg-brand-700 hover:shadow-float transition-all shadow-sm">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> <?php echo $isEditMode ? 'Simpan Perubahan' : 'Rekam Monitoring'; ?>
                  </button>
                </div>
              </form>
            </div>
          </div>

          <div class="lg:col-span-1">
            <div class="rounded-2xl border border-brand-200 bg-brand-50/50 p-6 sticky top-24">
              <h3 class="font-bold text-brand-900 mb-4 pb-3 border-b border-brand-100 flex items-center gap-2">
                <i class="fa-regular fa-lightbulb text-brand-600"></i> Panduan Pengisian
              </h3>
              
              <ul class="space-y-4">
                <li class="flex items-start gap-3">
                  <div class="flex-shrink-0 w-6 h-6 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-xs font-bold mt-0.5">1</div>
                  <p class="text-sm text-brand-800 leading-relaxed">Pilih referensi <strong>Laporan Acuan</strong> yang tepat jika ini adalah rekam baru.</p>
                </li>
                <li class="flex items-start gap-3">
                  <div class="flex-shrink-0 w-6 h-6 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-xs font-bold mt-0.5">2</div>
                  <p class="text-sm text-brand-800 leading-relaxed">Catat <strong>Waktu Monitoring</strong> yang merepresentasikan kondisi riil saat tim ada di lokasi.</p>
                </li>
                <li class="flex items-start gap-3">
                  <div class="flex-shrink-0 w-6 h-6 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-xs font-bold mt-0.5">3</div>
                  <p class="text-sm text-brand-800 leading-relaxed">Sertakan <strong>Koordinat (Opsional)</strong> jika perlu memetakan ulang area terdampak.</p>
                </li>
                <li class="flex items-start gap-3">
                  <div class="flex-shrink-0 w-6 h-6 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-xs font-bold mt-0.5">4</div>
                  <p class="text-sm text-brand-800 leading-relaxed">Tuliskan <strong>Hasil Monitoring</strong> secara informatif dan obyektif. Hindari spekulasi berlebihan tanpa fakta lapangan.</p>
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
