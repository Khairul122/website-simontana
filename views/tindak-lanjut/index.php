<?php include('template/header.php'); ?>

<?php
function tindakLanjutStatusTheme($statusRaw) {
  $status = strtolower(trim((string)$statusRaw));
  if ($status === 'menuju lokasi') return ['Menuju Lokasi', 'bg-rose-50 text-rose-700 border-rose-200', 'fa-truck-fast'];
  if ($status === 'sedang ditangani') return ['Sedang Ditangani', 'bg-amber-50 text-amber-700 border-amber-200', 'fa-person-digging'];
  if ($status === 'selesai') return ['Selesai', 'bg-emerald-50 text-emerald-700 border-emerald-200', 'fa-check-double'];
  if ($status === 'ditolak') return ['Ditolak', 'bg-slate-100 text-slate-500 border-slate-200', 'fa-xmark'];
  return [$statusRaw ?: '-', 'bg-slate-100 text-slate-700 border-slate-200', 'fa-circle-info'];
}

$rows = isset($tindakLanjutList['data']) ? $tindakLanjutList['data'] : ($tindakLanjutList ?? []);
if (!is_array($rows)) {
  $rows = [];
}

$countTotal = count($rows);
$countMenuju = 0;
$countDitangani = 0;
$countSelesai = 0;

foreach ($rows as $metricRow) {
  $statusRaw = strtolower(trim((string)($metricRow['status'] ?? '')));
  if ($statusRaw === 'menuju lokasi') $countMenuju++;
  elseif ($statusRaw === 'sedang ditangani') $countDitangani++;
  elseif ($statusRaw === 'selesai') $countSelesai++;
}
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
            <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-900">Operasi Tindak Lanjut</h1>
            <p class="text-sm text-slate-500 mt-1">Lacak mobilitas dan penanganan riil oleh tim rescue BPBD di lapangan.</p>
          </div>
          <div class="shrink-0 flex gap-3">
            <a href="index.php?controller=TindakLanjut&action=create" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-600 text-white font-bold text-sm hover:bg-brand-700 hover:shadow-float transition-all shadow-sm">
              <i class="fa-solid fa-plus"></i> Rekam Operasi
            </a>
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

        <!-- Active Operations KPI -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
          <div class="rounded-xl bg-white border border-slate-200 p-4 shadow-sm">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Data</p>
            <h3 class="font-display text-2xl font-bold text-slate-800"><?php echo $countTotal; ?></h3>
          </div>
          <div class="rounded-xl bg-white border border-slate-200 p-4 shadow-sm border-l-4 border-l-rose-500">
            <p class="text-[10px] font-bold text-rose-600 uppercase tracking-widest mb-1">OTW / Menuju Lokasi</p>
            <h3 class="font-display text-2xl font-bold text-rose-700"><?php echo $countMenuju; ?></h3>
          </div>
          <div class="rounded-xl bg-white border border-slate-200 p-4 shadow-sm border-l-4 border-l-amber-500">
            <p class="text-[10px] font-bold text-amber-600 uppercase tracking-widest mb-1">Sedang Operasi</p>
            <h3 class="font-display text-2xl font-bold text-amber-700"><?php echo $countDitangani; ?></h3>
          </div>
          <div class="rounded-xl bg-white border border-slate-200 p-4 shadow-sm border-l-4 border-l-emerald-500">
            <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest mb-1">Tuntas Diselesaikan</p>
            <h3 class="font-display text-2xl font-bold text-emerald-700"><?php echo $countSelesai; ?></h3>
          </div>
        </div>

        <!-- Filter & Search Panel -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-end">
          <div class="w-full md:w-64 shrink-0">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Filter Tahapan</label>
            <div class="relative">
              <select id="statusFilter" class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-4 pr-10 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white appearance-none">
                <option value="">Semua Tahapan</option>
                <option value="Menuju Lokasi" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Menuju Lokasi') ? 'selected' : ''; ?>>Menuju Lokasi</option>
                <option value="Sedang Ditangani" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Sedang Ditangani') ? 'selected' : ''; ?>>Sedang Ditangani</option>
                <option value="Selesai" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                <option value="Ditolak" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Ditolak') ? 'selected' : ''; ?>>Dibatalkan</option>
              </select>
              <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
            </div>
          </div>
          
          <div class="w-full md:flex-1">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pencarian Referensi Laporan</label>
            <div class="relative">
              <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
              <input type="text" id="searchFilter" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" placeholder="Ketik judul, alamat kejadian..." class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-11 pr-4 text-sm font-medium outline-none transition-all focus:border-brand-500 focus:bg-white">
            </div>
          </div>
          
          <div class="w-full md:w-auto shrink-0 flex gap-2">
            <button type="button" id="applyFilterBtn" class="flex-1 md:flex-none flex items-center justify-center gap-2 rounded-xl bg-slate-800 px-6 py-2.5 text-sm font-bold text-white hover:bg-slate-900 transition-colors">
              <i class="fa-solid fa-filter text-xs"></i> Terapkan
            </button>
            <?php if (isset($_GET['status']) || isset($_GET['search'])): ?>
              <a href="index.php?controller=TindakLanjut&action=index" class="flex items-center justify-center rounded-xl bg-slate-100 border border-slate-200 px-4 py-2.5 text-slate-500 hover:text-slate-800 transition" title="Reset Data">
                <i class="fa-solid fa-rotate-left"></i>
              </a>
            <?php endif; ?>
          </div>
        </div>

        <!-- Table View -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap">
                  <th class="px-5 py-4 w-12 text-center">No</th>
                  <th class="px-5 py-4 min-w-[220px]">Referensi Insiden</th>
                  <th class="px-5 py-4">Tim Action</th>
                  <th class="px-5 py-4">Sumber Laporan</th>
                  <th class="px-5 py-4">Status & Waktu</th>
                  <th class="px-5 py-4 text-center w-36">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-sm">
                <?php if (!empty($rows)): ?>
                  <?php $no = 1; foreach ($rows as $row): ?>
                    <?php [$label, $badgeClass, $iconClass] = tindakLanjutStatusTheme($row['status'] ?? ''); ?>
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                      <td class="px-5 py-4 text-center font-bold text-slate-400"><?php echo $no++; ?></td>
                      <td class="px-5 py-4">
                        <p class="font-bold text-slate-800 mb-0.5 group-hover:text-brand-600 transition-colors"><?php echo htmlspecialchars($row['laporan_judul'] ?? $row['laporan']['judul_laporan'] ?? '-'); ?></p>
                        <p class="text-xs text-slate-500 flex items-start gap-1"><i class="fa-solid fa-location-dot mt-[3px] text-slate-400"></i> <span class="leading-tight"><?php echo htmlspecialchars($row['laporan']['alamat_lengkap'] ?? '-'); ?></span></p>
                      </td>
                      <td class="px-5 py-4 font-semibold text-indigo-700">
                        <i class="fa-solid fa-shield-halved text-indigo-300 mr-1"></i> <?php echo htmlspecialchars($row['petugas_nama'] ?? $row['petugas']['nama'] ?? '-'); ?>
                      </td>
                      <td class="px-5 py-4 font-medium text-slate-600">
                        <?php echo htmlspecialchars($row['pelapor_nama'] ?? '-'); ?>
                      </td>
                      <td class="px-5 py-4">
                        <div class="flex flex-col items-start gap-1.5 whitespace-nowrap">
                          <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md border text-[10px] font-bold tracking-widest uppercase <?php echo $badgeClass; ?>">
                            <i class="fa-solid <?php echo $iconClass; ?>"></i> <?php echo htmlspecialchars($label); ?>
                          </span>
                          <span class="text-xs font-semibold text-slate-500">
                            <?php echo date('d M Y, H:i', strtotime($row['tanggal_tanggapan'] ?? 'now')); ?>
                          </span>
                        </div>
                      </td>
                      <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-1.5">
                          <?php $tindakLanjutId = (int)($row['id_tindaklanjut'] ?? 0); if($tindakLanjutId > 0): ?>
                            <a href="index.php?controller=TindakLanjut&action=detail&id=<?php echo $tindakLanjutId; ?>" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition" title="Lihat Detail">
                              <i class="fa-solid fa-file-invoice text-sm"></i>
                            </a>
                            <a href="index.php?controller=TindakLanjut&action=edit&id=<?php echo $tindakLanjutId; ?>" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-700 transition" title="Edit">
                              <i class="fa-solid fa-pen text-sm"></i>
                            </a>
                            <form method="POST" action="index.php?controller=TindakLanjut&action=delete&id=<?php echo $tindakLanjutId; ?>" class="inline-block delete-tindak-form">
                              <button type="submit" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition" title="Hapus Data">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                              </button>
                            </form>
                          <?php endif; ?>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="px-5 py-16 text-center">
                      <div class="inline-flex h-16 w-16 rounded-full bg-slate-50 border border-slate-100 text-slate-300 items-center justify-center mb-4 text-3xl shadow-inner"><i class="fa-solid fa-xmark"></i></div>
                      <h3 class="font-display font-bold text-slate-700 text-lg mb-1">Tidak Ada Data</h3>
                      <p class="text-sm font-medium text-slate-500">Log tindak lanjut masih kosong.</p>
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
  document.addEventListener('DOMContentLoaded', function () {
    const applyButton = document.getElementById('applyFilterBtn');
    const searchInput = document.getElementById('searchFilter');

    function applyFilters() {
      const status = document.getElementById('statusFilter').value;
      const search = searchInput.value.trim();
      const query = new URLSearchParams({ controller: 'TindakLanjut', action: 'index' });

      if (status) query.set('status', status);
      if (search) query.set('search', search);
      
      window.location.href = 'index.php?' + query.toString();
    }

    applyButton.addEventListener('click', applyFilters);
    searchInput.addEventListener('keydown', function (event) {
      if (event.key === 'Enter') {
        event.preventDefault();
        applyFilters();
      }
    });

    document.addEventListener('submit', function (event) {
      const form = event.target.closest('.delete-tindak-form');
      if (!form) return;
      event.preventDefault();

      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'warning',
          title: 'Batalkan Tindak Lanjut?',
          text: 'Data riwayat operasional tim akan dihapus permanen.',
          showCancelButton: true,
          confirmButtonText: 'Ya, Hapus',
          cancelButtonText: 'Kembali',
          confirmButtonColor: '#ef4444',
          customClass: {
            popup: 'rounded-2xl',
            confirmButton: 'rounded-xl px-5 py-2.5 font-bold shadow-sm',
            cancelButton: 'rounded-xl px-5 py-2.5 font-bold border border-slate-200 bg-white text-slate-700 hover:bg-slate-50'
          }
        }).then(function (result) {
          if (result.isConfirmed) form.submit();
        });
      } else {
        if (window.confirm('Yakin ingin menghapus tindak lanjut ini?')) form.submit();
      }
    });
  });
</script>
