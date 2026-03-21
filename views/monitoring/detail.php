<?php include('template/header.php'); ?>

<?php
$item = is_array($monitoring ?? null) ? $monitoring : null;

function monitoringDetailId(?array $row): int {
  if (!$row) return 0;
  $candidates = [
    $row['id'] ?? null,
    $row['monitoring_id'] ?? null,
    $row['id_monitoring'] ?? null,
    $row['idMonitoring'] ?? null
  ];
  foreach ($candidates as $value) {
    if ($value !== null && $value !== '' && is_numeric($value)) {
      return (int) $value;
    }
  }
  return 0;
}

$detailId = monitoringDetailId($item);
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
              <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight">Detail Observasi <span class="text-slate-400">#<?php echo $detailId > 0 ? $detailId : '-'; ?></span></h1>
              <p class="text-sm text-slate-500">Tinjau hasil pantauan lapangan dari tim ops.</p>
            </div>
          </div>
          <div class="shrink-0 flex gap-2">
            <?php if ($detailId > 0): ?>
              <a href="index.php?controller=Monitoring&action=edit&id=<?php echo $detailId; ?>" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-sm hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm">
                <i class="fa-solid fa-pen"></i> Edit Detail
              </a>
            <?php endif; ?>
          </div>
        </div>

        <?php if (isset($error_message)): ?>
          <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6 flex items-start gap-4">
            <div class="flex-shrink-0 text-red-500 mt-0.5"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
            <div class="flex-1">
              <h3 class="text-sm font-bold text-red-800">Gagal Memuat Data</h3>
              <p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($error_message); ?></p>
            </div>
          </div>
        <?php endif; ?>

        <?php if (!empty($item)): ?>
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
              <div class="rounded-2xl bg-white border border-slate-200 shadow-card overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                  <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-clipboard-check text-slate-400"></i> Hasil Monitoring Lapangan
                  </h3>
                </div>
                <div class="p-6">
                  
                  <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 mb-6 flex flex-wrap gap-x-6 gap-y-3">
                    <div>
                      <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-0.5">ID Ref</span>
                      <strong class="text-slate-700">#<?php echo $detailId > 0 ? $detailId : '-'; ?></strong>
                    </div>
                    <div>
                      <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-0.5">Laporan Acuan</span>
                      <strong class="text-brand-600"><?php echo htmlspecialchars((string)($item['laporan_judul'] ?? ('#' . ($item['laporan_id'] ?? $item['id_laporan'] ?? '-')))); ?></strong>
                    </div>
                    <div>
                      <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-0.5">Auditor / Operator</span>
                      <strong class="text-indigo-600"><?php echo htmlspecialchars((string)($item['operator_nama'] ?? '-')); ?></strong>
                    </div>
                  </div>

                  
                  <div class="space-y-4">
                    <div>
                      <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Waktu Monitoring</p>
                      <p class="font-semibold text-slate-800 bg-slate-50 inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-slate-200"><i class="fa-regular fa-clock text-slate-400"></i> <?php echo htmlspecialchars($item['waktu_monitoring'] ?? '-'); ?></p>
                    </div>
                    
                    <div>
                      <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Pelapor Laporan Asal</p>
                      <p class="font-semibold text-slate-700"><?php echo htmlspecialchars((string)($item['pelapor_nama'] ?? '-')); ?></p>
                    </div>

                    <div>
                      <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Koordinat GPS Tim Saat Ops</p>
                      <p class="font-mono text-sm text-slate-600"><?php echo htmlspecialchars($item['koordinat_gps'] ?? 'Belum ada koordinat spesifik.'); ?></p>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                      <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Penjelasan / Temuan</p>
                      <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 text-slate-700 leading-relaxed whitespace-pre-wrap"><?php echo htmlspecialchars($item['hasil_monitoring'] ?? 'Belum ada penjelasan yang disertakan.'); ?></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            
            <div class="lg:col-span-1">
              <div class="rounded-2xl bg-white border border-slate-200 shadow-card p-6 sticky top-24">
                <h3 class="font-bold text-slate-800 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                  <i class="fa-solid fa-shield-halved text-slate-400 text-sm"></i> Data Ringkasan
                </h3>
                
                <ul class="space-y-3 mb-6">
                  <li class="flex justify-between items-center py-1">
                    <span class="text-sm font-medium text-slate-500">Status Validitas</span>
                    <span class="inline-flex h-6 items-center rounded-full bg-emerald-50 px-2 text-xs font-bold text-emerald-700"><i class="fa-solid fa-check mr-1 text-[10px]"></i> Valid</span>
                  </li>
                  <li class="flex justify-between items-center py-1">
                    <span class="text-sm font-medium text-slate-500">ID Mon</span>
                    <strong class="text-sm text-slate-800">#<?php echo $detailId > 0 ? $detailId : '-'; ?></strong>
                  </li>
                  <li class="flex flex-col py-1">
                    <span class="text-sm font-medium text-slate-500 mb-1">Operator Bertugas</span>
                    <strong class="text-sm text-slate-800"><?php echo htmlspecialchars((string)($item['operator_nama'] ?? '-')); ?></strong>
                  </li>
                </ul>

                <a href="index.php?controller=Monitoring&action=index" class="w-full flex items-center justify-center gap-2 rounded-xl bg-slate-100 px-5 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-200 transition-colors">
                  Kembali ke Daftar
                </a>
              </div>
            </div>

          </div>
        <?php else: ?>
          <div class="rounded-2xl border border-amber-200 bg-amber-50 p-8 text-center flex flex-col items-center">
            <div class="inline-flex h-16 w-16 rounded-full bg-white text-amber-500 items-center justify-center mb-4 text-3xl shadow-sm"><i class="fa-solid fa-file-circle-question"></i></div>
            <h3 class="font-bold text-amber-800 text-lg mb-2">Data Tidak Ditemukan</h3>
            <p class="text-amber-700 max-w-sm mb-6">Data log monitoring ini mungkin telah dihapus sistem atau ID yang diberikan salah.</p>
            <a href="index.php?controller=Monitoring&action=index" class="inline-flex items-center gap-2 rounded-xl bg-amber-600 px-6 py-2.5 text-sm font-bold text-white hover:bg-amber-700 transition">
              Kembali ke Daftar
            </a>
          </div>
        <?php endif; ?>

      </div>
    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>
