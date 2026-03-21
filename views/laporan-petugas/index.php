<?php include('template/header.php'); ?>

<?php
function laporanPetugasStatusBadge($statusRaw) {
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

$reports = isset($laporanList['data']) ? $laporanList['data'] : $laporanList;
if (!is_array($reports)) {
  $reports = [];
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
            <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-900">Laporan Bencana BPBD</h1>
            <p class="text-sm text-slate-500 mt-1">Saring dan tindak lanjuti laporan bencana yang masuk ke otoritas BPBD.</p>
          </div>
          <div class="shrink-0 flex gap-3">
             <button onclick="window.location.reload();" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 hover:text-brand-600 transition-all shadow-sm">
               <i class="fa-solid fa-rotate-right"></i> Refresh
             </button>
          </div>
        </div>

        <?php if (isset($error_message) && !empty($error_message)): ?>
          <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6 flex items-start gap-4">
            <div class="flex-shrink-0 text-red-500 mt-0.5"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
            <div class="flex-1">
              <h3 class="text-sm font-bold text-red-800">Gagal Memuat Laporan</h3>
              <p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars((string)$error_message); ?></p>
            </div>
          </div>
        <?php endif; ?>

        <!-- Filter Bar -->
        <div class="rounded-2xl bg-white border border-slate-200 p-5 md:p-6 shadow-sm mb-6 flex flex-col md:flex-row gap-4 items-end">
           <div class="w-full md:w-1/4">
             <label for="statusFilter" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Status</label>
             <div class="relative">
               <select id="statusFilter" class="w-full h-11 pl-4 pr-10 rounded-xl border border-slate-200 bg-slate-50 text-slate-700 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 appearance-none transition-all">
                 <option value="">Semua Status</option>
                 <option value="Draft" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Draft') ? 'selected' : ''; ?>>Draft</option>
                 <option value="Menunggu Verifikasi" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Menunggu Verifikasi') ? 'selected' : ''; ?>>Menunggu Verifikasi</option>
                 <option value="Diverifikasi" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Diverifikasi') ? 'selected' : ''; ?>>Diverifikasi</option>
                 <option value="Diproses" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                 <option value="Tindak Lanjut" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Tindak Lanjut') ? 'selected' : ''; ?>>Tindak Lanjut</option>
                 <option value="Selesai" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                 <option value="Ditolak" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Ditolak') ? 'selected' : ''; ?>>Ditolak</option>
               </select>
               <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                 <i class="fa-solid fa-chevron-down text-sm"></i>
               </div>
             </div>
           </div>
           
           <div class="w-full md:w-2/4">
             <label for="searchFilter" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Pencarian Cepat</label>
             <div class="relative">
                <input type="text" id="searchFilter" class="w-full h-11 pl-11 pr-4 rounded-xl border border-slate-200 bg-slate-50 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all font-medium" placeholder="Cari judul laporan atau alamat titik duga..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <div class="absolute inset-y-0 left-0 flex items-center px-4 pointer-events-none text-slate-400">
                   <i class="fa-solid fa-magnifying-glass"></i>
                </div>
             </div>
           </div>
           
           <div class="w-full md:w-1/4">
             <button type="button" id="applyFilterBtn" class="w-full h-11 px-5 rounded-xl bg-brand-600 text-white font-bold text-sm hover:bg-brand-700 transition shadow-sm hover:shadow-float flex items-center justify-center gap-2">
               <i class="fa-solid fa-filter"></i> Terapkan Filter
             </button>
           </div>
        </div>

        <!-- Data Table -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                  <th class="px-5 py-4 w-16 text-center">ID</th>
                  <th class="px-5 py-4">Informasi Bencana</th>
                  <th class="px-5 py-4">Kategori & Lokasi</th>
                  <th class="px-5 py-4 text-center">Status Laporan</th>
                  <th class="px-5 py-4 text-center">Tanggal</th>
                  <th class="px-5 py-4 text-center w-32">Aksi Petugas</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-sm">
                <?php if (!empty($reports)): ?>
                  <?php foreach ($reports as $laporan): ?>
                    <?php [$label, $badge] = laporanPetugasStatusBadge($laporan['status'] ?? ''); ?>
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                      <td class="px-5 py-4 text-center font-bold text-slate-400">#<?php echo (int) ($laporan['id'] ?? 0); ?></td>
                      <td class="px-5 py-4 font-bold text-slate-800">
                        <p class="group-hover:text-brand-600 transition-colors line-clamp-1"><?php echo htmlspecialchars($laporan['judul_laporan'] ?? '-'); ?></p>
                      </td>
                      <td class="px-5 py-4">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-semibold mb-1">
                          <i class="fa-solid fa-layer-group text-[10px] text-slate-400"></i> <?php echo htmlspecialchars($laporan['kategori']['nama_kategori'] ?? '-'); ?>
                        </div>
                        <p class="text-xs text-slate-500 font-medium ml-1 line-clamp-1"><i class="fa-solid fa-location-dot mr-1 text-red-400"></i> <?php echo htmlspecialchars($laporan['alamat_lengkap'] ?? '-'); ?></p>
                      </td>
                      <td class="px-5 py-4 text-center">
                        <?php 
                          $classes = explode(' ', $badge); 
                          $icon = array_pop($classes);
                          if(strpos($icon, 'fa-') === false) { $icon = 'fa-circle-info'; } else {
                             if(strpos($badge, 'fa-spin') !== false) {
                                array_pop($classes);
                                $icon = $icon . ' fa-spin';
                             }
                          }
                          $colorClasses = implode(' ', $classes);
                        ?>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border <?php echo $colorClasses; ?> text-xs font-bold shadow-sm whitespace-nowrap">
                          <i class="fa-solid <?php echo $icon; ?>"></i> <?php echo htmlspecialchars($label); ?>
                        </div>
                      </td>
                      <td class="px-5 py-4 text-center">
                         <div class="inline-flex items-center justify-center p-2 rounded-lg bg-slate-50 border border-slate-100 text-slate-600 font-medium whitespace-nowrap">
                           <?php echo date('d M Y', strtotime($laporan['waktu_laporan'] ?? 'now')); ?>
                         </div>
                      </td>
                      <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                          <a href="index.php?controller=LaporanPetugas&action=detail&id=<?php echo (int) $laporan['id']; ?>" class="inline-flex items-center justify-center px-3 py-2 rounded-lg bg-brand-50 text-brand-600 hover:bg-brand-100 hover:text-brand-700 transition font-bold" title="Rincian Tindak Lanjut">
                            <i class="fa-solid fa-eye text-sm mr-1.5"></i> Masuk
                          </a>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="px-5 py-12 text-center">
                      <div class="inline-flex h-16 w-16 rounded-full bg-slate-50 border border-slate-100 text-slate-300 items-center justify-center mb-4 text-2xl shadow-inner"><i class="fa-solid fa-folder-open"></i></div>
                      <h3 class="font-display font-bold text-slate-700 text-lg mb-1">Tidak Ada Laporan</h3>
                      <p class="text-sm font-medium text-slate-500">Belum ada laporan yang sesuai dengan filter pencarian petugas.</p>
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
  (function () {
    function applyFilters() {
      const status = document.getElementById('statusFilter').value;
      const search = document.getElementById('searchFilter').value.trim();
      const query = new URLSearchParams();

      query.set('controller', 'LaporanPetugas');
      query.set('action', 'index');

      if (status) {
        query.set('status', status);
      }
      if (search) {
        query.set('search', search);
      }

      window.location.href = 'index.php?' + query.toString();
    }

    document.getElementById('applyFilterBtn').addEventListener('click', applyFilters);
    document.getElementById('searchFilter').addEventListener('keydown', function (event) {
      if (event.key === 'Enter') {
        event.preventDefault();
        applyFilters();
      }
    });
  })();
</script>
