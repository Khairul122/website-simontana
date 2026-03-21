<?php include('template/header.php'); ?>

<?php
function riwayatStatusBadge($statusRaw) {
  $status = strtolower(trim((string)$statusRaw));
  if ($status === 'menuju lokasi') return ['Menuju Lokasi', 'bg-blue-50 text-blue-600 border-blue-200 fa-truck-fast'];
  if ($status === 'sedang ditangani') return ['Sedang Ditangani', 'bg-amber-50 text-amber-600 border-amber-200 fa-person-digging'];
  if ($status === 'selesai') return ['Selesai', 'bg-emerald-50 text-emerald-600 border-emerald-200 fa-check'];
  if ($status === 'ditolak') return ['Ditolak', 'bg-rose-50 text-rose-600 border-rose-200 fa-ban'];
  return [$statusRaw ?: '-', 'bg-slate-50 text-slate-600 border-slate-200 fa-info-circle'];
}

$rows = is_array($riwayat ?? null) ? $riwayat : [];
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative p-4 md:p-6 lg:p-8">
      
      
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
          <h1 class="text-2xl md:text-3xl font-display font-bold text-slate-800">Riwayat Tindakan Lapangan</h1>
          <p class="text-slate-500 mt-1">Audit histori tindakan untuk evaluasi dan pelaporan manajerial.</p>
        </div>
        <div class="flex items-center gap-3">
          <a href="index.php?controller=RiwayatTindakan&action=create" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm focus:ring-4 focus:ring-brand-500/20">
            <i class="fa-solid fa-plus"></i> Tambah Log Riwayat
          </a>
        </div>
      </div>

      <?php if (isset($error_message)): ?>
        <div class="rounded-xl bg-rose-50 border border-rose-200 p-4 mb-6 flex items-start gap-3">
          <div class="flex-shrink-0 text-rose-500 mt-0.5"><i class="fa-solid fa-circle-exclamation text-lg"></i></div>
          <div class="text-sm text-rose-700 font-medium"><?php echo htmlspecialchars($error_message); ?></div>
        </div>
      <?php endif; ?>

      <div class="rounded-xl bg-brand-50 border border-brand-100 p-4 mb-6 flex items-center gap-4">
        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-lg"><i class="fa-solid fa-clipboard-list"></i></div>
        <div class="text-sm text-brand-800">Total riwayat tercatat: <strong><?php echo count($rows); ?> laporan</strong>. Data ini dipakai untuk evaluasi performa respons lapangan.</div>
      </div>

      
      <div class="bg-white rounded-3xl border border-slate-200 shadow-card overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div class="relative w-full max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fa-solid fa-search text-slate-400"></i>
            </div>
            <input type="text" id="searchInput" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl leading-5 bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-brand-500 focus:border-brand-500 sm:text-sm transition-all" placeholder="Cari data riwayat...">
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse" id="dataTable">
            <thead>
              <tr class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-200">
                <th class="px-6 py-4 w-16 text-center">No</th>
                <th class="px-6 py-4">Informasi Laporan & Keterangan</th>
                <th class="px-6 py-4">Aktor Pengisi</th>
                <th class="px-6 py-4 text-center">Status</th>
                <th class="px-6 py-4 text-center">Waktu</th>
                <th class="px-6 py-4 text-center w-36">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
              <?php if (!empty($rows)): ?>
                <?php $no = 1; foreach ($rows as $item): ?>
                  <?php [$label, $badge] = riwayatStatusBadge($item['tindak_lanjut']['status'] ?? ''); ?>
                  <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 text-center font-bold text-slate-400"><?php echo $no++; ?></td>
                    <td class="px-6 py-4">
                      <p class="font-bold text-slate-800 line-clamp-1"><?php echo htmlspecialchars($item['laporan_judul'] ?? $item['tindak_lanjut']['laporan']['judul_laporan'] ?? '-'); ?></p>
                      <p class="text-xs text-slate-500 mt-1 line-clamp-2 w-64 md:w-96 text-wrap leading-relaxed"><i class="fa-regular fa-comment-dots mr-1"></i> <?php echo htmlspecialchars($item['keterangan'] ?? '-'); ?></p>
                    </td>
                    <td class="px-6 py-4">
                      <div class="flex items-center gap-2 mb-1">
                        <div class="w-5 h-5 rounded bg-brand-50 text-brand-600 flex justify-center items-center text-[10px]"><i class="fa-solid fa-user-shield"></i></div>
                        <span class="font-bold text-slate-700"><?php echo htmlspecialchars($item['petugas_nama'] ?? $item['petugas']['nama'] ?? '-'); ?></span>
                      </div>
                      <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded bg-slate-100 text-slate-500 flex justify-center items-center text-[10px]"><i class="fa-solid fa-user"></i></div>
                        <span class="text-xs text-slate-500"><?php echo htmlspecialchars($item['pelapor_nama'] ?? '-'); ?></span>
                      </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                      <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold border <?php echo $badge; ?> shadow-sm">
                        <i class="fa-solid <?php echo explode(' ', $badge)[3]; ?>"></i> <?php echo htmlspecialchars($label); ?>
                      </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                      <div class="inline-flex flex-col items-center">
                        <span class="text-xs font-bold text-slate-700"><?php echo date('d M Y', strtotime($item['waktu_tindakan'] ?? 'now')); ?></span>
                        <span class="text-[10px] font-mono text-slate-400"><?php echo date('H:i', strtotime($item['waktu_tindakan'] ?? 'now')); ?> WIB</span>
                      </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                      <div class="flex items-center justify-center gap-2">
                        <a href="index.php?controller=RiwayatTindakan&action=detail&id=<?php echo (int)$item['id']; ?>" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-500 hover:text-brand-600 hover:border-brand-200 hover:bg-brand-50 flex items-center justify-center transition shadow-sm" title="Detail"><i class="fa-regular fa-eye"></i></a>
                        <a href="index.php?controller=RiwayatTindakan&action=edit&id=<?php echo (int)$item['id']; ?>" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-500 hover:text-amber-600 hover:border-amber-200 hover:bg-amber-50 flex items-center justify-center transition shadow-sm" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                        <form method="POST" action="index.php?controller=RiwayatTindakan&action=delete&id=<?php echo (int)$item['id']; ?>" class="delete-riwayat-form inline-block" onsubmit="return confirmDelete(event)">
                          <button type="submit" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-500 hover:text-rose-600 hover:border-rose-200 hover:bg-rose-50 flex items-center justify-center transition shadow-sm" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                    <i class="fa-solid fa-folder-open text-4xl mb-3 text-slate-300"></i>
                    <p class="font-bold">Tidak Ada Data</p>
                    <p class="text-xs">Belum ada riwayat tindakan yang tercatat.</p>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        
        
        <div class="p-4 border-t border-slate-100 flex items-center justify-between text-sm text-slate-500">
           <div>Menampilkan <span class="font-bold text-slate-700"><?php echo count($rows); ?></span> data riwayat</div>
        </div>
      </div>
    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function confirmDelete(event) {
    event.preventDefault();
    const form = event.target;
    
    Swal.fire({
      title: 'Hapus Riwayat?',
      text: "Data yang dihapus tidak dapat dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#94a3b8',
      confirmButtonText: 'Ya, Hapus Data!',
      cancelButtonText: 'Batal',
      customClass: {
         popup: 'rounded-2xl border border-slate-100 shadow-xl',
         title: 'font-display font-bold text-slate-800',
         htmlContainer: 'text-slate-600 text-sm',
         confirmButton: 'font-bold rounded-xl',
         cancelButton: 'font-bold rounded-xl'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  }

  document.getElementById('searchInput').addEventListener('keyup', function() {
      let filter = this.value.toLowerCase();
      let rows = document.querySelectorAll('#dataTable tbody tr');
      
      rows.forEach(row => {
          let text = row.textContent.toLowerCase();
          row.style.display = text.includes(filter) ? '' : 'none';
      });
  });
</script>
