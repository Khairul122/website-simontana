<?php include('template/header.php'); ?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative p-4 md:p-6 lg:p-8">

      
      <div class="rounded-3xl bg-teal-800 border-none shadow-card overflow-hidden text-white relative mb-8">
        <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-br-[150px] pointer-events-none"></div>
        <div class="p-8 md:p-10 relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div>
            <h1 class="font-display text-3xl md:text-4xl font-bold mb-2">Panel Operator Desa</h1>
            <p class="text-teal-100 text-sm font-medium">Bantu warga Anda mendapatkan pertolongan cepat. Pantau semua status pelaporan dan kendalikan keamanan desa Anda.</p>
          </div>
          <div class="shrink-0 flex gap-3">
             <button onclick="window.location.reload();" class="px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-sm transition-all border border-white/10 backdrop-blur-sm flex items-center justify-center gap-2">
               <i class="fa-solid fa-arrows-rotate"></i> Refresh Panel
             </button>
          </div>
        </div>
      </div>

      <?php if (isset($error_message)): ?>
        <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6 flex items-start gap-4">
          <div class="flex-shrink-0 text-red-500 mt-0.5"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
          <div class="flex-1">
            <h3 class="text-sm font-bold text-red-800">Sistem Mendesak Perhatian</h3>
            <p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($error_message); ?></p>
          </div>
        </div>
      <?php elseif (isset($dashboardData) && !$dashboardData['success']): ?>
         <div class="rounded-xl bg-amber-50 border border-amber-200 p-4 mb-6 flex items-start gap-4">
          <div class="flex-shrink-0 text-amber-500 mt-0.5"><i class="fa-solid fa-circle-exclamation text-xl"></i></div>
          <div class="flex-1">
            <h3 class="text-sm font-bold text-amber-800">Kesalahan Pengambilan Data</h3>
            <p class="text-sm text-amber-700 mt-1"><?php echo htmlspecialchars($dashboardData['message'] ?? 'Gagal memuat arsitektur statistik'); ?></p>
          </div>
        </div>
      <?php endif; ?>

      <?php if (isset($dashboardData) && $dashboardData['success']): ?>
      
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
         
         <div class="rounded-2xl bg-white border border-slate-200 p-6 flex items-center shadow-sm">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl mr-4 shrink-0 shadow-sm border border-indigo-100"><i class="fa-solid fa-satellite-dish"></i></div>
            <div>
               <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-1">Total Laporan Warga</p>
               <h3 class="text-2xl font-display font-bold text-slate-800 leading-none"><?php echo htmlspecialchars($dashboardData['data']['total_laporan'] ?? 0); ?></h3>
            </div>
         </div>

         <div class="rounded-2xl bg-white border border-slate-200 p-6 flex items-center shadow-sm">
            <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-2xl mr-4 shrink-0 shadow-sm border border-rose-100"><i class="fa-solid fa-users-slash"></i></div>
            <div>
               <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-1">Warga Terdampak</p>
               <h3 class="text-2xl font-display font-bold text-slate-800 leading-none"><?php echo htmlspecialchars($dashboardData['data']['total_warga_terdampak'] ?? 0); ?> <span class="text-sm font-medium text-slate-500 ml-1">Jiwa</span></h3>
            </div>
         </div>

         <div class="rounded-2xl bg-white border border-slate-200 p-6 flex items-center shadow-sm">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mr-4 shrink-0 shadow-sm border border-emerald-100"><i class="fa-solid fa-boxes-packing"></i></div>
            <div>
               <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-1">Status Logistik Desa</p>
               <h3 class="text-lg font-bold text-slate-800 leading-tight"><?php echo htmlspecialchars($dashboardData['data']['logistik_status']['status_terakhir'] ?? 'Aman / Tersedia'); ?></h3>
               <p class="text-xs text-emerald-600 font-bold mt-1"><i class="fa-solid fa-check mr-1"></i> <?php echo htmlspecialchars($dashboardData['data']['logistik_status']['total_distribusi'] ?? 0); ?> paket disalurkan</p>
            </div>
         </div>

         <div class="rounded-2xl bg-white border border-slate-200 p-6 flex items-center shadow-sm relative overflow-hidden">
            <div class="absolute -right-2 top-0 text-slate-50 opacity-50"><i class="fa-solid fa-shield-halved text-8xl"></i></div>
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mr-4 shrink-0 shadow-sm border border-blue-100 relative z-10"><i class="fa-solid fa-map-location-dot"></i></div>
            <div class="relative z-10">
               <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-1">Kondisi Wilayah Desa</p>
               <?php 
                 $stDs = $dashboardData['data']['desa_info']['status'] ?? 'Aman'; 
                 $clDs = ($stDs == 'Aman') ? 'text-emerald-500' : 'text-amber-500';
               ?>
               <h3 class="text-xl font-display font-bold <?php echo $clDs; ?> leading-none uppercase tracking-wide"><?php echo htmlspecialchars($stDs); ?></h3>
            </div>
         </div>

      </div>

      
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
         
         
         <div class="lg:col-span-8 rounded-3xl bg-white border border-slate-200 shadow-card flex flex-col p-6 md:p-8">
            <h3 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2">
               <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center text-sm"><i class="fa-solid fa-chart-column"></i></div>
               Statistik Laporan & Dampak Berdasarkan Titik
            </h3>
            <div class="relative h-[280px] w-full flex-grow">
               <canvas id="reportChart"></canvas>
            </div>
         </div>

         
         <div class="lg:col-span-4 rounded-3xl bg-slate-800 border-none shadow-card overflow-hidden text-white flex flex-col relative p-6 md:p-8 shrink-0">
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-white/5 rounded-tl-[100px] pointer-events-none"></div>
            
            <h3 class="text-sm font-bold text-white mb-6 uppercase tracking-widest border-b border-white/10 pb-3 flex items-center gap-2">
               <i class="fa-solid fa-bars-progress text-slate-400"></i> Track Penyelesaian Kasus
            </h3>

            <div class="mb-8 relative z-10">
               <div class="flex justify-between items-end mb-2">
                  <div class="text-center">
                    <p class="text-[10px] font-bold text-yellow-500 uppercase tracking-widest mb-1">Verifikasi</p>
                    <h4 class="text-2xl font-display font-bold"><?php echo htmlspecialchars($dashboardData['data']['laporan_stats']['laporan_perlu_verifikasi'] ?? 0); ?></h4>
                  </div>
                  <div class="text-center">
                    <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest mb-1">Diproses</p>
                    <h4 class="text-2xl font-display font-bold"><?php echo htmlspecialchars($dashboardData['data']['laporan_stats']['laporan_ditindak'] ?? 0); ?></h4>
                  </div>
                  <div class="text-center">
                    <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-1">Selesai</p>
                    <h4 class="text-2xl font-display font-bold"><?php echo htmlspecialchars($dashboardData['data']['laporan_stats']['laporan_selesai'] ?? 0); ?></h4>
                  </div>
               </div>

               <?php
                 $totLprn = $dashboardData['data']['total_laporan'] ?? 1;
                 $totLprn = ($totLprn > 0) ? $totLprn : 1;
                 $pctVer = round(($dashboardData['data']['laporan_stats']['laporan_perlu_verifikasi'] ?? 0) / $totLprn * 100);
                 $pctPro = round(($dashboardData['data']['laporan_stats']['laporan_ditindak'] ?? 0) / $totLprn * 100);
                 $pctSel = round(($dashboardData['data']['laporan_stats']['laporan_selesai'] ?? 0) / $totLprn * 100);
               ?>
               <div class="h-2.5 w-full bg-white/10 rounded-full flex overflow-hidden">
                  <div class="h-full bg-yellow-400" style="width: <?php echo $pctVer; ?>%"></div>
                  <div class="h-full bg-blue-500" style="width: <?php echo $pctPro; ?>%"></div>
                  <div class="h-full bg-emerald-500" style="width: <?php echo $pctSel; ?>%"></div>
               </div>
            </div>

            <h3 class="text-[10px] font-bold text-slate-400 mt-2 mb-4 uppercase tracking-widest relative z-10">Aktivitas Laporan Paling Baru</h3>
            <div class="space-y-4 relative z-10">
               <?php if (!empty($dashboardData['data']['laporan_terbaru'])): ?>
                 <?php foreach (array_slice($dashboardData['data']['laporan_terbaru'], 0, 3) as $laporanFlow): ?>
                    <div class="flex items-start gap-4 p-3 rounded-2xl bg-white/10 border border-white/5 backdrop-blur-sm">
                       <div class="w-2 h-2 mt-2 rounded-full bg-brand-400 shrink-0 shadow-[0_0_8px_rgba(99,102,241,0.8)]"></div>
                       <div>
                          <p class="text-sm font-bold text-white line-clamp-1 leading-tight mb-1"><?php echo htmlspecialchars($laporanFlow['judul_laporan'] ?? 'Bencana Titik Koordinat'); ?></p>
                          <div class="flex items-center gap-2">
                             <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md bg-slate-900 border border-slate-700 text-slate-300 uppercase"><?php echo htmlspecialchars($laporanFlow['status'] ?? '-'); ?></span>
                             <span class="text-[10px] font-medium text-slate-400"><i class="fa-regular fa-clock"></i> <?php echo htmlspecialchars(date('d/m/Y', strtotime($laporanFlow['waktu_laporan'] ?? ''))); ?></span>
                          </div>
                       </div>
                    </div>
                 <?php endforeach; ?>
               <?php else: ?>
                 <div class="p-6 rounded-2xl border-2 border-dashed border-white/10 flex flex-col items-center justify-center text-slate-500">
                    <i class="fa-solid fa-moon text-3xl mb-2 text-slate-600"></i>
                    <p class="text-xs font-bold text-center">Desa dalam keadaan sepi aman.</p>
                 </div>
               <?php endif; ?>
            </div>

         </div>
      </div>

      
      <div class="rounded-3xl bg-white border border-slate-200 shadow-card overflow-hidden">
        <div class="p-6 md:p-8 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
           <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
             <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center text-xs"><i class="fa-solid fa-fire"></i></div>
             5 Notifikasi Darurat Anggota Warga
           </h3>
           <a href="index.php?controller=LaporanOperator&action=index" class="text-sm font-bold text-brand-600 hover:text-brand-700 transition flex items-center gap-1 bg-brand-50 px-4 py-2 rounded-xl">Seluruh Arsip Laporan <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        
        <div class="overflow-x-auto">
           <table class="w-full text-left border-collapse">
             <thead>
               <tr class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-200">
                 <th class="px-6 py-4">Informasi Inti Laporan</th>
                 <th class="px-6 py-4">Kategori Bencana</th>
                 <th class="px-6 py-4 text-center">Status Tracking</th>
                 <th class="px-6 py-4 text-center">Korban Masalah</th>
                 <th class="px-6 py-4 text-center w-24">Tindakan</th>
               </tr>
             </thead>
             <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
               <?php if (!empty($dashboardData['data']['laporan_terbaru'])): ?>
                  <?php foreach ($dashboardData['data']['laporan_terbaru'] as $lapTable): 
                    $statBadg = strtolower($lapTable['status'] ?? '');
                    $bCls = 'text-slate-600 border-slate-200 bg-slate-50'; $bIcn = 'fa-info-circle';
                    if($statBadg=='draft') { $bCls='text-slate-500 border-slate-200 bg-slate-100'; $bIcn='fa-pen'; }
                    if(strpos($statBadg,'tunggu')!==false || strpos($statBadg,'verifikasi')!==false) { $bCls='text-amber-600 border-amber-200 bg-amber-50'; $bIcn='fa-hourglass'; }
                    if(strpos($statBadg,'diverifikasi')!==false) { $bCls='text-blue-600 border-blue-200 bg-blue-50'; $bIcn='fa-shield'; }
                    if(strpos($statBadg,'proses')!==false) { $bCls='text-indigo-600 border-indigo-200 bg-indigo-50'; $bIcn='fa-spinner fa-spin'; }
                    if(strpos($statBadg,'lanjut')!==false) { $bCls='text-teal-600 border-teal-200 bg-teal-50'; $bIcn='fa-truck'; }
                    if(strpos($statBadg,'selesai')!==false) { $bCls='text-emerald-600 border-emerald-200 bg-emerald-50'; $bIcn='fa-check-double'; }
                    if(strpos($statBadg,'tolak')!==false) { $bCls='text-rose-600 border-rose-200 bg-rose-50'; $bIcn='fa-ban'; }
                  ?>
                  <tr class="hover:bg-slate-50/70 transition-colors">
                     <td class="px-6 py-4">
                        <div class="flex items-start gap-4">
                           <div class="mt-1 w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center shrink-0 bg-white text-slate-400 text-xs"><i class="fa-regular fa-file-lines"></i></div>
                           <div>
                              <p class="font-bold text-slate-800 line-clamp-1 group-hover:text-brand-600 transition-colors"><?php echo htmlspecialchars($lapTable['judul_laporan'] ?? 'Tidak ada judul'); ?></p>
                              <p class="text-[11px] text-slate-500 mt-1 line-clamp-1 w-64 xl:w-96"><i class="fa-regular fa-clock mr-1"></i> <?php echo htmlspecialchars(date('d M Y - H:i', strtotime($lapTable['waktu_laporan'] ?? ''))); ?> &bull; <?php echo htmlspecialchars(substr($lapTable['deskripsi'] ?? '', 0, 80)); ?></p>
                           </div>
                        </div>
                     </td>
                     <td class="px-6 py-4 font-bold">
                        <span class="px-2 py-1 rounded inline-block border border-slate-100 bg-white text-xs text-slate-600 shadow-sm"><i class="fa-solid fa-cloud-bolt text-slate-400 mr-1 text-[10px]"></i> <?php echo htmlspecialchars($lapTable['kategori']['nama_kategori'] ?? 'Umum'); ?></span>
                     </td>
                     <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold border <?php echo $bCls; ?> shadow-sm whitespace-nowrap"><i class="fa-solid <?php echo $bIcn; ?>"></i> <?php echo htmlspecialchars($lapTable['status'] ?? '-'); ?></span>
                     </td>
                     <td class="px-6 py-4 text-center">
                        <div class="inline-flex h-8 w-12 rounded-lg items-center justify-center font-bold text-xs bg-red-50 text-red-600 border border-red-100"><i class="fa-solid fa-user-injured mr-1.5 opacity-50"></i> <?php echo htmlspecialchars($lapTable['jumlah_korban'] ?? 0); ?></div>
                     </td>
                     <td class="px-6 py-4 text-center">
                        <a href="index.php?controller=LaporanOperator&action=detail&id=<?php echo $lapTable['id']; ?>" class="inline-flex w-8 h-8 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-brand-600 hover:border-brand-200 hover:bg-brand-50 items-center justify-center transition shadow-sm"><i class="fa-solid fa-arrow-right"></i></a>
                     </td>
                  </tr>
                  <?php endforeach; ?>
               <?php else: ?>
                  <tr>
                     <td colspan="5" class="px-6 py-12 text-center border-t border-slate-100">
                        <div class="inline-flex flex-col items-center justify-center text-slate-400">
                           <i class="fa-solid fa-mug-hot text-4xl mb-3 text-slate-300"></i>
                           <p class="font-bold text-sm">Tidak Ada Kegiatan Baru</p>
                           <p class="text-xs font-medium">Laporan akan muncul di sini secara periodik.</p>
                        </div>
                     </td>
                  </tr>
               <?php endif; ?>
             </tbody>
           </table>
        </div>
      </div>
      <?php endif; ?>

    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const dataReportChart = <?php echo json_encode($dashboardData['data']['laporan_terbaru'] ?? []); ?>;
    
    // Safety check ensuring we only have valid canvas container
    const ctxCanvas = document.getElementById('reportChart');
    if (ctxCanvas && dataReportChart.length > 0) {
       const lbl = dataReportChart.map(i => i.judul_laporan ? (i.judul_laporan.substring(0,20) + (i.judul_laporan.length > 20 ? '...' : '')) : 'Incident');
       const korb = dataReportChart.map(i => i.jumlah_korban || 0);
       const rumh = dataReportChart.map(i => i.jumlah_rumah_rusak || 0);

       new Chart(ctxCanvas, {
          type: 'bar',
          data: {
             labels: lbl,
             datasets: [
                {
                   label: 'Manusia (Jiwa Tertimpa)',
                   data: korb,
                   backgroundColor: '#f43f5e', // rose-500
                   borderRadius: 4,
                   barPercentage: 0.7
                },
                {
                   label: 'Unit Rumah / Bangunan Hancur',
                   data: rumh,
                   backgroundColor: '#0ea5e9', // sky-500
                   borderRadius: 4,
                   barPercentage: 0.7
                }
             ]
          },
          options: {
             responsive: true,
             maintainAspectRatio: false,
             plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 6, font: {family: "'Plus Jakarta Sans', sans-serif", weight: 'bold'} } }
             },
             scales: {
                y: { beginAtZero: true, border: {display:false}, grid: {color: '#f1f5f9', borderDash: [4,4]}, ticks: { stepSize: 1, padding: 10, color: '#94a3b8', font: {family: "'Plus Jakarta Sans', sans-serif"} } },
                x: { border: {display:false}, grid: {display: false}, ticks: { crossAlign: 'far', color: '#64748b', font: {family: "'Plus Jakarta Sans', sans-serif"} } }
             }
          }
       });
    } else if (ctxCanvas) {
       // Destroy the non-useful canvas visually
       ctxCanvas.parentElement.innerHTML = '<div class="absolute inset-0 flex items-center justify-center"><p class="text-xs font-bold text-slate-400 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100 flex items-center gap-2"><i class="fa-solid fa-ban"></i> Data Chart Belum Ada.</p></div>';
    }
  });
</script>
