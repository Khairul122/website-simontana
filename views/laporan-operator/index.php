<?php include('template/header.php'); ?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div>
            <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-900">Daftar Laporan Operator</h1>
            <p class="text-sm text-slate-500 mt-1">Pantau laporan wilayah kerja operator tingkat desa dan lakukan update status respons.</p>
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

        
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card overflow-hidden">
          <div class="p-5 md:p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50">
             <h3 class="font-bold text-lg text-slate-800">Daftar Laporan Bencana</h3>
          </div>
          
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                  <th class="px-5 py-4 w-16 text-center">No</th>
                  <th class="px-5 py-4">Informasi Laporan</th>
                  <th class="px-5 py-4">Kategori & Lokasi</th>
                  <th class="px-5 py-4 text-center">Status</th>
                  <th class="px-5 py-4 text-center">Tanggal</th>
                  <th class="px-5 py-4 text-center w-32">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-sm">
                <?php if (!empty($reports)): ?>
                  <?php
                  $nomor = 1;
                  if (isset($pagination)) {
                      $nomor = ($pagination['current_page'] - 1) * ($pagination['per_page'] ?? 10) + 1;
                  }
                  ?>
                  <?php foreach ($reports as $report): ?>
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                      <td class="px-5 py-4 text-center font-bold text-slate-400"><?php echo $nomor++; ?></td>
                      <td class="px-5 py-4">
                        <p class="font-bold text-slate-800 group-hover:text-brand-600 transition-colors line-clamp-1"><?php echo htmlspecialchars($report['judul_laporan'] ?? '-'); ?></p>
                        <p class="text-xs text-slate-500 mt-0.5"><i class="fa-solid fa-user-circle mr-1 text-slate-400"></i> <?php echo htmlspecialchars($report['pelapor']['nama'] ?? '-'); ?></p>
                      </td>
                      <td class="px-5 py-4">
                         <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-semibold mb-1">
                           <i class="fa-solid fa-layer-group text-[10px] text-slate-400"></i> <?php echo htmlspecialchars($report['kategori']['nama_kategori'] ?? '-'); ?>
                         </div>
                         <p class="text-xs text-slate-500 font-medium ml-1"><i class="fa-solid fa-location-dot mr-1 text-red-400"></i> <?php echo htmlspecialchars($report['desa']['nama'] ?? '-'); ?></p>
                      </td>
                      <td class="px-5 py-4 text-center">
                        <?php
                        $status = strtolower($report['status'] ?? 'Draft');
                        $badgeConfig = [
                            'draft' => ['bg-slate-100', 'text-slate-600', 'border-slate-200', 'fa-pen-ruler'],
                            'menunggu verifikasi' => ['bg-amber-50', 'text-amber-600', 'border-amber-200', 'fa-hourglass-half'],
                            'diverifikasi' => ['bg-blue-50', 'text-blue-600', 'border-blue-200', 'fa-shield-check'],
                            'sedang diproses' => ['bg-indigo-50', 'text-indigo-600', 'border-indigo-200', 'fa-spinner fa-spin'],
                            'selesai' => ['bg-emerald-50', 'text-emerald-600', 'border-emerald-200', 'fa-check-double'],
                            'ditolak' => ['bg-rose-50', 'text-rose-600', 'border-rose-200', 'fa-ban']
                        ];
                        
                        $conf = $badgeConfig[$status] ?? ['bg-slate-50', 'text-slate-500', 'border-slate-200', 'fa-circle-info'];
                        ?>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border <?php echo $conf[0]; ?> <?php echo $conf[1]; ?> <?php echo $conf[2]; ?> text-xs font-bold shadow-sm whitespace-nowrap">
                          <i class="fa-solid <?php echo $conf[3]; ?>"></i>
                          <?php echo htmlspecialchars(ucwords($report['status'] ?? 'Draft')); ?>
                        </div>
                      </td>
                      <td class="px-5 py-4 text-center">
                         <div class="inline-flex items-center justify-center p-2 rounded-lg bg-slate-50 border border-slate-100 text-slate-600 font-medium">
                           <?php echo date('d M Y', strtotime($report['waktu_laporan'] ?? '')); ?>
                         </div>
                      </td>
                      <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                          <a href="index.php?controller=LaporanOperator&action=detail&id=<?php echo $report['id'] ?? ''; ?>" class="inline-flex items-center justify-center px-3 py-2 rounded-lg bg-slate-100 text-slate-600 hover:bg-brand-50 hover:text-brand-600 transition" title="Lihat Detail">
                            <i class="fa-solid fa-eye text-sm mr-1.5"></i> Detail
                          </a>
                          <?php if(in_array(strtolower($report['status'] ?? ''), ['menunggu verifikasi', 'diverifikasi', 'sedang diproses'])): ?>
                            <a href="index.php?controller=LaporanOperator&action=edit-status&id=<?php echo $report['id'] ?? ''; ?>" class="inline-flex items-center justify-center px-3 py-2 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-700 transition" title="Update Status">
                              <i class="fa-solid fa-pen-to-square text-sm mr-1.5"></i> Tindakan
                            </a>
                          <?php endif; ?>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="px-5 py-12 text-center">
                      <div class="inline-flex h-16 w-16 rounded-full bg-slate-50 border border-slate-100 text-slate-300 items-center justify-center mb-4 text-2xl shadow-inner"><i class="fa-solid fa-inbox"></i></div>
                      <h3 class="font-display font-bold text-slate-700 text-lg mb-1">Daftar Kosong</h3>
                      <p class="text-sm font-medium text-slate-500">Belum ada laporan bencana di wilayah kerja Anda.</p>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          
          
          <?php if (!empty($pagination) && $pagination['last_page'] > 1): ?>
            <div class="p-5 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
               <p class="text-sm text-slate-500 font-medium">
                 Menampilkan <span class="font-bold text-slate-800"><?php echo htmlspecialchars($pagination['from'] ?? 0); ?></span> 
                 - <span class="font-bold text-slate-800"><?php echo htmlspecialchars($pagination['to'] ?? 0); ?></span> 
                 dari <span class="font-bold text-slate-800"><?php echo htmlspecialchars($pagination['total'] ?? 0); ?></span> data
               </p>
               
               <div class="flex items-center gap-1.5">
                  <?php if ($pagination['current_page'] > 1): ?>
                    <a href="index.php?controller=LaporanOperator&action=index&page=<?php echo $pagination['current_page'] - 1; ?>" class="h-9 px-3 inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:text-brand-600 transition text-sm font-bold shadow-sm">
                      <i class="fa-solid fa-chevron-left mr-1.5 text-xs"></i> Prev
                    </a>
                  <?php endif; ?>
                  
                  <?php for ($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['last_page'], $pagination['current_page'] + 2); $i++): ?>
                    <a href="index.php?controller=LaporanOperator&action=index&page=<?php echo $i; ?>" class="h-9 w-9 inline-flex items-center justify-center rounded-lg border <?php echo $i == $pagination['current_page'] ? 'border-brand-600 bg-brand-600 text-white shadow-md' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'; ?> font-bold text-sm transition">
                      <?php echo $i; ?>
                    </a>
                  <?php endfor; ?>
                  
                  <?php if ($pagination['current_page'] < $pagination['last_page']): ?>
                    <a href="index.php?controller=LaporanOperator&action=index&page=<?php echo $pagination['current_page'] + 1; ?>" class="h-9 px-3 inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:text-brand-600 transition text-sm font-bold shadow-sm">
                      Next <i class="fa-solid fa-chevron-right ml-1.5 text-xs"></i>
                    </a>
                  <?php endif; ?>
               </div>
            </div>
          <?php endif; ?>
        </div>

      </div>
    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>
