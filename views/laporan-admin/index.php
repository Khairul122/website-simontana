<?php include('template/header.php'); ?>

<?php
$reportRows = is_array($laporanList ?? null) ? $laporanList : [];
$reportTotal = count($reportRows);
$reportPending = 0;
$reportProgress = 0;
$reportDone = 0;

foreach ($reportRows as $reportItem) {
  $statusRaw = strtolower(trim((string)($reportItem['status'] ?? '')));
  if ($statusRaw === 'menunggu verifikasi') {
    $reportPending++;
  } elseif ($statusRaw === 'diproses' || $statusRaw === 'ditangani') {
    $reportProgress++;
  } elseif ($statusRaw === 'selesai') {
    $reportDone++;
  }
}
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div>
            <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-900">Data Laporan Bencana</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola laporan masyarakat, status validasi, dan rincian kejadian darurat.</p>
          </div>
          <div class="shrink-0 flex gap-3">
            <a href="index.php?controller=LaporanAdmin&action=create" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-600 text-white font-bold text-sm hover:bg-brand-700 hover:shadow-float transition-all shadow-sm">
              <i class="fa-solid fa-plus"></i> Buat Laporan
            </a>
          </div>
        </div>

        
        <div class="flex flex-wrap items-center gap-3 mb-6">
          <div class="flex items-center gap-3 px-4 py-2 bg-white border border-slate-200 rounded-full shadow-sm">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Semua Data</p>
            <span class="inline-flex h-6 min-w-[24px] items-center justify-center rounded-full bg-slate-100 px-2 text-xs font-bold text-slate-700"><?php echo $reportTotal; ?></span>
          </div>
          <div class="flex items-center gap-3 px-4 py-2 bg-red-50 border border-red-200 rounded-full shadow-sm">
            <span class="flex h-2 w-2 rounded-full bg-red-500"></span>
            <p class="text-xs font-bold text-red-700 uppercase tracking-widest">Menunggu Validasi</p>
            <span class="inline-flex h-6 min-w-[24px] items-center justify-center rounded-full bg-red-100 px-2 text-xs font-bold text-red-800"><?php echo $reportPending; ?></span>
          </div>
          <div class="flex items-center gap-3 px-4 py-2 bg-amber-50 border border-amber-200 rounded-full shadow-sm">
            <span class="flex h-2 w-2 rounded-full bg-amber-500"></span>
            <p class="text-xs font-bold text-amber-700 uppercase tracking-widest">Diproses Tim</p>
            <span class="inline-flex h-6 min-w-[24px] items-center justify-center rounded-full bg-amber-100 px-2 text-xs font-bold text-amber-800"><?php echo $reportProgress; ?></span>
          </div>
          <div class="flex items-center gap-3 px-4 py-2 bg-emerald-50 border border-emerald-200 rounded-full shadow-sm">
            <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
            <p class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Penanganan Selesai</p>
            <span class="inline-flex h-6 min-w-[24px] items-center justify-center rounded-full bg-emerald-100 px-2 text-xs font-bold text-emerald-800"><?php echo $reportDone; ?></span>
          </div>
        </div>

        
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-card mb-6">
          <form method="GET" class="flex flex-col md:flex-row flex-wrap gap-4 items-end">
            <input type="hidden" name="controller" value="LaporanAdmin">
            <input type="hidden" name="action" value="index">
            
            <div class="w-full md:w-auto flex-1 min-w-[200px]">
              <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pencarian</label>
              <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" placeholder="Cari judul, pelapor, atau wilayah..." class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-11 pr-4 text-sm font-medium text-slate-800 outline-none transition-all placeholder:text-slate-400 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10">
              </div>
            </div>

            <div class="w-full md:w-48 shrink-0">
              <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status</label>
              <select name="status" id="status" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 px-4 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 appearance-none">
                <option value="">Semua Status</option>
                <option value="Menunggu Verifikasi" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Menunggu Verifikasi') ? 'selected' : ''; ?>>Menunggu Verifikasi</option>
                <option value="Diproses" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                <option value="Selesai" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                <option value="Ditolak" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Ditolak') ? 'selected' : ''; ?>>Ditolak</option>
              </select>
            </div>

            <div class="w-full md:w-56 shrink-0">
              <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tingkat Darurat</label>
              <select name="tingkat_keparahan" id="tingkat_keparahan" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 px-4 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 appearance-none">
                <option value="">Semua Tingkat</option>
                <option value="Rendah" <?php echo (isset($_GET['tingkat_keparahan']) && $_GET['tingkat_keparahan'] == 'Rendah') ? 'selected' : ''; ?>>Rendah</option>
                <option value="Sedang" <?php echo (isset($_GET['tingkat_keparahan']) && $_GET['tingkat_keparahan'] == 'Sedang') ? 'selected' : ''; ?>>Sedang</option>
                <option value="Tinggi" <?php echo (isset($_GET['tingkat_keparahan']) && $_GET['tingkat_keparahan'] == 'Tinggi') ? 'selected' : ''; ?>>Tinggi</option>
                <option value="Sangat Tinggi" <?php echo (isset($_GET['tingkat_keparahan']) && $_GET['tingkat_keparahan'] == 'Sangat Tinggi') ? 'selected' : ''; ?>>Sangat Tinggi</option>
              </select>
            </div>

            <div class="flex w-full md:w-auto gap-2">
              <button type="submit" class="flex-1 md:flex-none flex items-center justify-center gap-2 rounded-xl bg-slate-800 px-5 py-2.5 text-sm font-bold text-white hover:bg-slate-900 transition-colors shadow-sm">
                <i class="fa-solid fa-filter text-xs"></i> Terapkan
              </button>
              <?php if (isset($_GET['status']) || isset($_GET['tingkat_keparahan']) || !empty($_GET['search'])): ?>
              <a href="index.php?controller=LaporanAdmin&action=index" class="flex items-center justify-center rounded-xl bg-slate-100 border border-slate-200 px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-200 transition-colors" title="Reset Filter">
                <i class="fa-solid fa-rotate-left"></i>
              </a>
              <?php endif; ?>
            </div>
            
            <div class="w-full md:w-auto md:ml-auto">
              <button type="button" onclick="bulkDelete()" class="w-full flex items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 hover:border-red-300 transition-colors shadow-sm">
                <i class="fa-solid fa-trash-can text-xs"></i> Hapus Massal
              </button>
            </div>
          </form>
        </div>

        
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="laporanTable">
              <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap">
                  <th class="px-5 py-4 w-12 text-center">
                    <input type="checkbox" id="selectAll" class="w-4 h-4 text-brand-600 rounded border-slate-300 focus:ring-brand-500">
                  </th>
                  <th class="px-5 py-4 cursor-pointer hover:text-slate-800 sortable">ID Kejadian</th>
                  <th class="px-5 py-4 cursor-pointer hover:text-slate-800 sortable">Info Laporan</th>
                  <th class="px-5 py-4 cursor-pointer hover:text-slate-800 sortable">Lokasi</th>
                  <th class="px-5 py-4 cursor-pointer hover:text-slate-800 sortable">Tingkat</th>
                  <th class="px-5 py-4 cursor-pointer hover:text-slate-800 sortable">Status</th>
                  <th class="px-5 py-4 cursor-pointer hover:text-slate-800 sortable text-right">Tanggal Masuk</th>
                  <th class="px-5 py-4 text-center">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-sm">
                <?php if (!empty($laporanList)): ?>
                  <?php $no = (($_GET['page'] ?? 1) - 1) * ($pagination['per_page'] ?? 15) + 1; ?>
                  <?php foreach ($laporanList as $laporan): ?>
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                      <td class="px-5 py-4 text-center">
                        <input type="checkbox" class="row-checkbox w-4 h-4 text-brand-600 rounded border-slate-300 focus:ring-brand-500" value="<?php echo $laporan['id']; ?>">
                      </td>
                      <td class="px-5 py-4 font-bold text-slate-400">#<?php echo $laporan['id']; ?></td>
                      <td class="px-5 py-4">
                        <p class="font-bold text-slate-800 mb-0.5 group-hover:text-brand-600 transition-colors"><?php echo htmlspecialchars($laporan['judul_laporan'] ?? $laporan['judul'] ?? $laporan['name'] ?? ''); ?></p>
                        <p class="text-[11px] font-bold text-slate-500 tracking-wide uppercase"><i class="fa-solid fa-user text-slate-400 mr-1"></i> <?php echo htmlspecialchars($laporan['pelapor']['nama'] ?? $laporan['pelapor']['username'] ?? $laporan['user']['nama'] ?? $laporan['user']['username'] ?? ''); ?></p>
                      </td>
                      <td class="px-5 py-4">
                        <?php
                          $desa = $laporan['desa']['nama'] ?? '';
                          $kecamatan = $laporan['desa']['kecamatan']['nama'] ?? '';
                          $kabupaten = $laporan['desa']['kecamatan']['kabupaten']['nama'] ?? '';
                          $lokasi = [];
                          if ($desa) $lokasi[] = $desa;
                          if ($kecamatan) $lokasi[] = $kecamatan;
                          if ($kabupaten) $lokasi[] = $kabupaten;
                          $lokasiStr = implode(', ', $lokasi);
                        ?>
                        <div class="flex items-start gap-1.5 min-w-[140px]">
                          <i class="fa-solid fa-location-dot mt-0.5 text-brand-500"></i>
                          <p class="font-medium text-slate-600 leading-tight"><?php echo htmlspecialchars($lokasiStr ?: '-'); ?></p>
                        </div>
                      </td>
                      <td class="px-5 py-4">
                        <?php
                          $tingkat = $laporan['tingkat_keparahan'] ?? $laporan['tingkat_kedaruratan'] ?? '';
                          $tingkatClass = 'bg-slate-100 text-slate-700 border-slate-200';
                          $tingkatIcon = 'fa-circle-info';
                          if ($tingkat === 'Rendah') { $tingkatClass = 'bg-emerald-50 text-emerald-700 border-emerald-200'; $tingkatIcon = 'fa-check'; }
                          if ($tingkat === 'Sedang') { $tingkatClass = 'bg-amber-50 text-amber-700 border-amber-200'; $tingkatIcon = 'fa-triangle-exclamation'; }
                          if ($tingkat === 'Tinggi') { $tingkatClass = 'bg-orange-50 text-orange-700 border-orange-200'; $tingkatIcon = 'fa-fire'; }
                          if ($tingkat === 'Sangat Tinggi') { $tingkatClass = 'bg-red-50 text-red-700 border-red-200'; $tingkatIcon = 'fa-radiation'; }
                        ?>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg border text-[11px] font-bold tracking-widest uppercase <?php echo $tingkatClass; ?> whitespace-nowrap">
                          <i class="fa-solid <?php echo $tingkatIcon; ?>"></i> <?php echo htmlspecialchars($tingkat); ?>
                        </span>
                      </td>
                      <td class="px-5 py-4">
                        <?php
                          $status = $laporan['status'] ?? '';
                          $badgeTheme = 'bg-slate-100 text-slate-700 border-slate-200';
                          $statusIcon = 'fa-spinner';
                          if ($status === 'Menunggu Verifikasi') { $badgeTheme = 'bg-red-50 text-red-700 border-red-200'; $statusIcon = 'fa-clock'; }
                          if ($status === 'Diproses' || $status === 'Ditangani') { $badgeTheme = 'bg-amber-50 text-amber-700 border-amber-200'; $statusIcon = 'fa-helmet-safety'; }
                          if ($status === 'Selesai') { $badgeTheme = 'bg-emerald-50 text-emerald-700 border-emerald-200'; $statusIcon = 'fa-check-double'; }
                          if ($status === 'Ditolak') { $badgeTheme = 'bg-slate-100 text-slate-500 border-slate-200'; $statusIcon = 'fa-xmark'; }
                        ?>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg border text-[11px] font-bold tracking-widest uppercase <?php echo $badgeTheme; ?> whitespace-nowrap">
                          <i class="fa-solid <?php echo $statusIcon; ?>"></i> <?php echo htmlspecialchars($status); ?>
                        </span>
                      </td>
                      <td class="px-5 py-4 text-right font-medium text-slate-500 whitespace-nowrap">
                        <?php echo date('d M Y', strtotime($laporan['waktu_laporan'] ?? $laporan['created_at'] ?? 'now')); ?>
                      </td>
                      <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-1.5">
                          <a href="index.php?controller=LaporanAdmin&action=detail&id=<?php echo $laporan['id']; ?>" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-700 transition" title="Lihat Detail">
                            <i class="fa-solid fa-eye text-sm"></i>
                          </a>
                          <a href="index.php?controller=LaporanAdmin&action=edit&id=<?php echo $laporan['id']; ?>" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-700 transition" title="Edit Laporan">
                            <i class="fa-solid fa-pen text-sm"></i>
                          </a>
                          <form method="POST" action="index.php?controller=LaporanAdmin&action=delete&id=<?php echo $laporan['id']; ?>" class="inline-block delete-laporan-form">
                            <button type="submit" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition" title="Hapus Laporan">
                              <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="8" class="px-5 py-16 text-center">
                      <div class="inline-flex h-16 w-16 rounded-full bg-slate-50 border border-slate-100 text-slate-300 items-center justify-center mb-4 text-3xl shadow-inner"><i class="fa-solid fa-box-open"></i></div>
                      <h3 class="font-display font-bold text-slate-700 text-lg mb-1">Data Kosong</h3>
                      <p class="text-sm font-medium text-slate-500">Tidak ada laporan yang dapat ditampilkan saat ini.</p>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          
          <?php if (!empty($pagination) && isset($pagination['last_page']) && $pagination['last_page'] > 1): ?>
          <div class="p-4 border-t border-slate-100 flex items-center justify-center bg-slate-50/50">
            <nav class="flex items-center gap-1">
              <?php if ($pagination['current_page'] > 1): ?>
                <a href="index.php?controller=LaporanAdmin&action=index&page=<?php echo $pagination['current_page'] - 1; ?>&<?php echo http_build_query(array_filter($_GET, function($key) { return $key !== 'page'; }, ARRAY_FILTER_USE_KEY)); ?>" class="flex items-center justify-center h-9 px-3 rounded-lg border border-slate-200 bg-white text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-600 transition">
                  <i class="fa-solid fa-chevron-left mr-1.5 text-[10px]"></i> Prev
                </a>
              <?php endif; ?>

              <div class="hidden sm:flex items-center gap-1 mx-2">
                <?php for ($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['last_page'], $pagination['current_page'] + 2); $i++): ?>
                  <?php if ($i == $pagination['current_page']): ?>
                    <span class="flex items-center justify-center h-9 w-9 rounded-lg bg-brand-600 border border-brand-600 text-sm font-bold text-white shadow-sm"><?php echo $i; ?></span>
                  <?php else: ?>
                    <a href="index.php?controller=LaporanAdmin&action=index&page=<?php echo $i; ?>&<?php echo http_build_query(array_filter($_GET, function($key) { return $key !== 'page'; }, ARRAY_FILTER_USE_KEY)); ?>" class="flex items-center justify-center h-9 w-9 rounded-lg border border-slate-200 bg-white text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-600 transition"><?php echo $i; ?></a>
                  <?php endif; ?>
                <?php endfor; ?>
              </div>

              <?php if ($pagination['current_page'] < $pagination['last_page']): ?>
                <a href="index.php?controller=LaporanAdmin&action=index&page=<?php echo $pagination['current_page'] + 1; ?>&<?php echo http_build_query(array_filter($_GET, function($key) { return $key !== 'page'; }, ARRAY_FILTER_USE_KEY)); ?>" class="flex items-center justify-center h-9 px-3 rounded-lg border border-slate-200 bg-white text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand-600 transition">
                  Next <i class="fa-solid fa-chevron-right ml-1.5 text-[10px]"></i>
                </a>
              <?php endif; ?>
            </nav>
          </div>
          <?php endif; ?>

        </div>
      </div>
    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>

<script>
  // Select all checkbox functionality
  document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
      checkbox.checked = this.checked;
    });
  });

  // Search logic (live filtering client-side for visible rows)
  document.getElementById('search').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#laporanTable tbody tr');
    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
  });

  // Table Sorting logic
  document.querySelectorAll('#laporanTable th.sortable').forEach((header, index) => {
    header.addEventListener('click', function() {
      // Index is +1 because of checkbox column check
      sortTable(index + 1);
    });
  });

  function sortTable(columnIndex) {
    const table = document.getElementById('laporanTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    if(rows.length <= 1 && rows[0].cells.length === 1) return; // empty state

    const currentHeader = document.querySelectorAll('#laporanTable th')[columnIndex];
    const isAscending = !currentHeader.classList.contains('asc');
    
    document.querySelectorAll('#laporanTable th').forEach(th => th.classList.remove('asc', 'desc'));
    currentHeader.classList.add(isAscending ? 'asc' : 'desc');

    rows.sort((a, b) => {
      const aVal = a.cells[columnIndex].textContent.trim();
      const bVal = b.cells[columnIndex].textContent.trim();
      const aNum = parseFloat(aVal.replace(/,/g, '').replace(/#/g, ''));
      const bNum = parseFloat(bVal.replace(/,/g, '').replace(/#/g, ''));

      if (!isNaN(aNum) && !isNaN(bNum)) {
        return isAscending ? aNum - bNum : bNum - aNum;
      }
      return isAscending ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
    });

    tbody.innerHTML = '';
    rows.forEach(row => tbody.appendChild(row));
  }

  // Bulk Delete
  function bulkDelete() {
    const selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
    if (selectedCheckboxes.length === 0) {
      Swal.fire({
        icon: 'info',
        title: 'Pilih Data',
        text: 'Silakan pilih setidaknya satu laporan terlebih dahulu.',
        confirmButtonColor: '#b91c1c',
        customClass: { popup: 'rounded-2xl shadow-xl' }
      });
      return;
    }

    Swal.fire({
      icon: 'warning',
      title: 'Hapus Massal',
      text: `Total ${selectedCheckboxes.length} laporan akan dihapus secara permanen. Lanjutkan?`,
      showCancelButton: true,
      confirmButtonText: 'Ya, Hapus Semua!',
      cancelButtonText: 'Batal',
      confirmButtonColor: '#ef4444',
      customClass: {
        popup: 'rounded-2xl',
        confirmButton: 'rounded-xl px-5 py-2.5 font-bold shadow-sm',
        cancelButton: 'rounded-xl px-5 py-2.5 font-bold border border-slate-200 bg-white text-slate-700 hover:bg-slate-50'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?controller=LaporanAdmin&action=bulkDelete';
        
        Array.from(selectedCheckboxes).forEach(checkbox => {
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'ids[]';
          input.value = checkbox.value;
          form.appendChild(input);
        });
        document.body.appendChild(form);
        form.submit();
      }
    });
  }

  // Single Delete
  document.addEventListener('submit', function(event) {
    const form = event.target.closest('.delete-laporan-form');
    if (!form) return;
    
    event.preventDefault();
    Swal.fire({
      icon: 'warning',
      title: 'Hapus Laporan',
      text: 'Laporan bencana ini akan dihapus permanen. Tindakan tidak bisa dibatalkan.',
      showCancelButton: true,
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal',
      confirmButtonColor: '#ef4444',
      customClass: {
        popup: 'rounded-2xl',
        confirmButton: 'rounded-xl px-5 py-2.5 font-bold shadow-sm',
        cancelButton: 'rounded-xl px-5 py-2.5 font-bold border border-slate-200 bg-white text-slate-700 hover:bg-slate-50'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });
</script>
