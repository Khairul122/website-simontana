<?php include('template/header.php'); ?>

<?php
$rows = is_array($monitoringList ?? null) ? $monitoringList : [];

function monitoringRowId(array $row): int {
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

$countTotal = count($rows);
$countWithCoord = 0;
foreach ($rows as $r) { 
  if (!empty($r['koordinat_gps'])) { $countWithCoord++; } 
}
$countWithoutCoord = max(0, $countTotal - $countWithCoord);
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div>
            <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-900">Monitoring Lapangan</h1>
            <p class="text-sm text-slate-500 mt-1">Pantau rincian observasi dan kondisi riil di lapangan oleh tim respon bencana.</p>
          </div>
          <div class="shrink-0 flex gap-3">
            <a href="index.php?controller=Monitoring&action=create" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-600 text-white font-bold text-sm hover:bg-brand-700 hover:shadow-float transition-all shadow-sm">
              <i class="fa-solid fa-plus"></i> Buat Monitoring
            </a>
          </div>
        </div>

        <?php if (isset($error_message)): ?>
          <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6 flex items-start gap-4">
            <div class="flex-shrink-0 text-red-500 mt-0.5"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
            <div class="flex-1">
              <h3 class="text-sm font-bold text-red-800">Kesalahan Sistem</h3>
              <p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($error_message); ?></p>
            </div>
          </div>
        <?php endif; ?>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6">
          <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0"><i class="fa-solid fa-satellite-dish"></i></div>
            <div>
              <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Total Monitoring</p>
              <h3 class="font-display text-2xl font-bold text-slate-800 leading-none"><?php echo $countTotal; ?></h3>
            </div>
          </div>
          <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl shrink-0"><i class="fa-solid fa-map-location-dot"></i></div>
            <div>
              <p class="text-[11px] font-bold text-emerald-600 uppercase tracking-widest mb-0.5">Dengan Koordinat Pemetaan</p>
              <h3 class="font-display text-2xl font-bold text-emerald-700 leading-none"><?php echo $countWithCoord; ?></h3>
            </div>
          </div>
          <div class="rounded-2xl border border-rose-200 bg-rose-50 p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl shrink-0"><i class="fa-solid fa-location-crosshairs"></i></div>
            <div>
              <p class="text-[11px] font-bold text-rose-600 uppercase tracking-widest mb-0.5">Tanpa Titik Koordinat</p>
              <h3 class="font-display text-2xl font-bold text-rose-700 leading-none"><?php echo $countWithoutCoord; ?></h3>
            </div>
          </div>
        </div>

        <!-- Data Table -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card overflow-hidden">
          <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h2 class="font-bold text-slate-800 text-base"><i class="fa-solid fa-list-check text-slate-400 mr-2"></i> Daftar Log Monitoring</h2>
          </div>
          
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                  <th class="px-5 py-4 w-12 text-center">No</th>
                  <th class="px-5 py-4 min-w-[200px]">Referensi Laporan</th>
                  <th class="px-5 py-4">Tim Operator</th>
                  <th class="px-5 py-4">Pelapor Bencana</th>
                  <th class="px-5 py-4">Waktu Monitor</th>
                  <th class="px-5 py-4 min-w-[250px]">Hasil Observasi Ringkas</th>
                  <th class="px-5 py-4 text-center w-32">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-sm">
                <?php if (!empty($rows)): ?>
                  <?php $no = 1; foreach ($rows as $item): ?>
                    <?php $rowId = monitoringRowId($item); ?>
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                      <td class="px-5 py-4 text-center font-medium text-slate-400"><?php echo $no++; ?></td>
                      <td class="px-5 py-4">
                        <p class="font-bold text-slate-800 mb-0.5 group-hover:text-brand-600 transition-colors cursor-pointer"><?php echo htmlspecialchars((string)($item['laporan_judul'] ?? ('Laporan #' . ((string)($item['laporan_id'] ?? $item['id_laporan'] ?? '-'))))); ?></p>
                      </td>
                      <td class="px-5 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100">
                          <i class="fa-solid fa-user-shield"></i> <?php echo htmlspecialchars((string)($item['operator_nama'] ?? '-')); ?>
                        </span>
                      </td>
                      <td class="px-5 py-4 font-medium text-slate-600">
                        <?php echo htmlspecialchars((string)($item['pelapor_nama'] ?? '-')); ?>
                      </td>
                      <td class="px-5 py-4 text-slate-500 whitespace-nowrap text-xs font-semibold">
                        <i class="fa-regular fa-clock mr-1"></i> <?php echo htmlspecialchars($item['waktu_monitoring'] ?? '-'); ?>
                      </td>
                      <td class="px-5 py-4">
                        <?php 
                          $hasil = (string)($item['hasil_monitoring'] ?? '-'); 
                          $truncated = (strlen($hasil) > 75) ? substr($hasil, 0, 75) . '...' : $hasil;
                        ?>
                        <p class="text-sm text-slate-600 leading-snug"><?php echo htmlspecialchars($truncated); ?></p>
                      </td>
                      <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-1.5">
                          <?php if ($rowId > 0): ?>
                            <a href="index.php?controller=Monitoring&action=detail&id=<?php echo $rowId; ?>" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition" title="Detail">
                              <i class="fa-solid fa-eye text-sm"></i>
                            </a>
                            <a href="index.php?controller=Monitoring&action=edit&id=<?php echo $rowId; ?>" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-700 transition" title="Edit">
                              <i class="fa-solid fa-pen text-sm"></i>
                            </a>
                            <form method="POST" action="index.php?controller=Monitoring&action=delete&id=<?php echo $rowId; ?>" class="inline-block monitoring-delete-form" data-id="<?php echo $rowId; ?>">
                              <button type="submit" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition" title="Hapus">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                              </button>
                            </form>
                          <?php else: ?>
                            <span class="text-xs font-medium text-slate-400 bg-slate-100 px-2 py-1 rounded">Tidak Ada ID</span>
                          <?php endif; ?>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="7" class="px-5 py-12 text-center">
                      <div class="inline-flex h-12 w-12 rounded-full bg-slate-50 text-slate-300 items-center justify-center mb-3 text-2xl"><i class="fa-solid fa-satellite"></i></div>
                      <p class="text-sm font-semibold text-slate-500">Belum ada data monitoring yang terekam.</p>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>
<script>
  document.addEventListener('submit', function (event) {
    const form = event.target.closest('.monitoring-delete-form');
    if (!form) return;

    event.preventDefault();

    if (typeof Swal !== 'undefined') {
      Swal.fire({
        icon: 'warning',
        title: 'Hapus data monitoring?',
        text: 'Aksi ini akan menghapus log obsevasi secara permanen.',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus data',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#ef4444',
        customClass: {
          popup: 'rounded-2xl',
          confirmButton: 'rounded-xl px-5 py-2.5 font-bold shadow-sm',
          cancelButton: 'rounded-xl px-5 py-2.5 font-bold border border-slate-200 bg-white text-slate-700 hover:bg-slate-50'
        }
      }).then(function (result) {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    } else {
      if (window.confirm('Yakin ingin menghapus data monitoring ini?')) form.submit();
    }
  });
</script>
