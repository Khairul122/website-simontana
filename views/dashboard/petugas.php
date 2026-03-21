<?php



function formatTanggalIndo($dateString) {
    if (empty($dateString)) {
        return '-';
    }
    try {
        $date = new DateTime($dateString);
        $namaHari = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
        $namaBulan = ['January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'];
        
        $hariIndo = $namaHari[$date->format('l')] ?? $date->format('l');
        $bulanIndo = $namaBulan[$date->format('F')] ?? $date->format('F');
        
        return "{$hariIndo}, {$date->format('d')} {$bulanIndo} {$date->format('Y')}";
    } catch (Exception $e) {
        return $dateString;
    }
}
include('template/header.php');
?>
<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative p-4 md:p-6 lg:p-8">
      
      
      <div class="rounded-3xl bg-indigo-900 border-none shadow-card overflow-hidden text-white relative mb-6">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-bl-[150px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-10 w-32 h-32 bg-indigo-500/20 rounded-t-full filter blur-2xl pointer-events-none"></div>
        <div class="p-8 md:p-10 relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div>
            <h1 class="font-display text-2xl md:text-4xl font-bold mb-2">Selamat Datang, Petugas BPBD</h1>
            <p class="text-indigo-200 text-sm font-medium">Platform operasional terpadu. Verifikasi, pantau, dan tangani penanggulangan prabencana hingga pascabencana secara real-time.</p>
          </div>
          <div class="shrink-0 flex gap-3">
             <button onclick="window.location.reload();" class="px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-sm transition-all border border-white/10 backdrop-blur-sm flex items-center justify-center gap-2">
               <i class="fa-solid fa-rotate-right"></i> Muat Ulang Panel
             </button>
          </div>
        </div>
      </div>

      <?php if (isset($stats) && !$stats['success'] && !empty($stats['errors'])): ?>
        <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6 flex items-start gap-4">
          <div class="flex-shrink-0 text-red-500 mt-0.5"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
          <div class="flex-1">
            <h3 class="text-sm font-bold text-red-800">Gagal Memuat Statistik Utama</h3>
            <ul class="text-sm text-red-600 mt-1 list-disc ml-4">
              <?php foreach ($stats['errors'] as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      <?php endif; ?>

      
      <?php if (isset($stats) && isset($stats['success']) && $stats['success']): ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
         <div class="rounded-2xl bg-white border border-slate-200 p-6 flex flex-col shadow-sm relative overflow-hidden group hover:border-brand-300 transition-colors">
            <div class="absolute -right-4 -bottom-4 text-slate-50 opacity-50 group-hover:scale-110 transition-transform"><i class="fa-solid fa-layer-group text-8xl"></i></div>
            <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center text-xl mb-4 relative z-10"><i class="fa-solid fa-file-contract"></i></div>
            <h3 class="text-slate-500 text-sm font-bold uppercase tracking-widest relative z-10">Total Terhimpun</h3>
            <div class="mt-1 flex items-baseline gap-2 relative z-10">
               <span class="text-3xl font-display font-bold text-slate-800"><?php echo htmlspecialchars($stats['data']['total_laporan'] ?? 0); ?></span>
            </div>
         </div>
         <div class="rounded-2xl bg-white border border-slate-200 p-6 flex flex-col shadow-sm relative overflow-hidden group hover:border-amber-300 transition-colors">
            <div class="absolute -right-4 -bottom-4 text-amber-50 opacity-50 group-hover:scale-110 transition-transform"><i class="fa-solid fa-hourglass-start text-8xl"></i></div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl mb-4 relative z-10"><i class="fa-solid fa-clock-rotate-left"></i></div>
            <h3 class="text-slate-500 text-sm font-bold uppercase tracking-widest relative z-10">Perlu Verifikasi</h3>
            <div class="mt-1 flex items-baseline gap-2 relative z-10">
               <span class="text-3xl font-display font-bold text-amber-600"><?php echo htmlspecialchars($stats['data']['laporan_perlu_verifikasi'] ?? 0); ?></span>
            </div>
         </div>
         <div class="rounded-2xl bg-white border border-slate-200 p-6 flex flex-col shadow-sm relative overflow-hidden group hover:border-indigo-300 transition-colors">
            <div class="absolute -right-4 -bottom-4 text-indigo-50 opacity-50 group-hover:scale-110 transition-transform"><i class="fa-solid fa-spinner text-8xl"></i></div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-xl mb-4 relative z-10"><i class="fa-solid fa-helmet-safety"></i></div>
            <h3 class="text-slate-500 text-sm font-bold uppercase tracking-widest relative z-10">Dalam Penanganan</h3>
            <div class="mt-1 flex items-baseline gap-2 relative z-10">
               <span class="text-3xl font-display font-bold text-indigo-600"><?php echo htmlspecialchars($stats['data']['laporan_ditindak'] ?? 0); ?></span>
            </div>
         </div>
         <div class="rounded-2xl bg-white border border-slate-200 p-6 flex flex-col shadow-sm relative overflow-hidden group hover:border-emerald-300 transition-colors">
            <div class="absolute -right-4 -bottom-4 text-emerald-50 opacity-50 group-hover:scale-110 transition-transform"><i class="fa-solid fa-check text-8xl"></i></div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl mb-4 relative z-10"><i class="fa-solid fa-clipboard-check"></i></div>
            <h3 class="text-slate-500 text-sm font-bold uppercase tracking-widest relative z-10">Telah Selesai</h3>
            <div class="mt-1 flex items-baseline gap-2 relative z-10">
               <span class="text-3xl font-display font-bold text-emerald-600"><?php echo htmlspecialchars($stats['data']['laporan_selesai'] ?? 0); ?></span>
            </div>
         </div>
      </div>
      <?php endif; ?>

      
      <?php if (isset($bmkgData) && $bmkgData['success']): ?>
      <div class="rounded-3xl bg-gradient-to-r from-rose-700 to-rose-900 border-none shadow-card overflow-hidden text-white relative mb-8">
        <div class="absolute top-0 right-0 h-full w-1/3 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-repeat pointer-events-none"></div>
        <div class="p-6 md:px-8 md:py-6 relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
          <div class="flex items-center gap-4">
             <div class="w-14 h-14 rounded-full bg-white/10 flex items-center justify-center text-3xl border border-white/20 shadow-sm shrink-0">
                <i class="fa-solid fa-house-crack text-rose-200 animate-pulse"></i>
             </div>
             <div>
                <h3 class="font-display font-bold text-xl mb-1 flex items-center gap-2">Peringatan Gempa Terkini (BMKG) <span class="px-2 py-0.5 rounded-full bg-red-500 text-[10px] uppercase tracking-widest font-bold shadow-sm live-ping">LIVE</span></h3>
                <?php if (isset($bmkgData['data']['Magnitude'])): $gempa = $bmkgData['data']; ?>
                  <p class="text-rose-100 text-sm font-medium">
                     <strong class="text-white">Mag:</strong> <?php echo htmlspecialchars($gempa['Magnitude'] ?? '-'); ?> SR &bull; 
                     <strong class="text-white">Kedalaman:</strong> <?php echo htmlspecialchars($gempa['Kedalaman'] ?? '-'); ?> &bull; 
                     <strong class="text-white">Pusat:</strong> <?php echo htmlspecialchars($gempa['Wilayah'] ?? '-'); ?>
                  </p>
                  <p class="text-xs text-rose-300 mt-1 font-mono"><i class="fa-regular fa-clock mr-1"></i> Terpantau: <?php echo htmlspecialchars($gempa['Tanggal'] ?? '-'); ?> - <?php echo htmlspecialchars($gempa['Jam'] ?? '-'); ?></p>
                <?php else: ?>
                  <p class="text-rose-200 text-sm">Tidak ada kejadian gempa dalam waktu dekat.</p>
                <?php endif; ?>
             </div>
          </div>
          <div class="shrink-0 text-right hidden md:block">
             <img src="https://data.bmkg.go.id/pws/img/logo-bmkg.png" alt="BMKG" class="h-10 opacity-60 mix-blend-screen grayscale">
          </div>
        </div>
      </div>
      <?php endif; ?>

      
      <?php if (isset($weeklyStats) && $weeklyStats['success']): ?>
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="rounded-3xl bg-white border border-slate-200 shadow-card p-6 md:p-8">
           <h3 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2">
             <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm"><i class="fa-solid fa-chart-line"></i></div>
             Tren Laporan Mingguan
           </h3>
           <div class="relative h-64 w-full">
             <canvas id="barChart"></canvas>
           </div>
        </div>
        <div class="rounded-3xl bg-white border border-slate-200 shadow-card p-6 md:p-8">
           <h3 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2">
             <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center text-sm"><i class="fa-solid fa-chart-pie"></i></div>
             Distribusi Kategori Bencana
           </h3>
           <div class="relative h-64 w-full">
             <canvas id="doughnutChart"></canvas>
           </div>
        </div>
      </div>
      <?php endif; ?>

      
      <div class="rounded-3xl bg-white border border-slate-200 shadow-card overflow-hidden">
        <div class="p-6 md:p-8 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
           <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
             <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center text-sm"><i class="fa-solid fa-folder-open"></i></div>
             Laporan Teranyar yang Masuk
           </h3>
           <a href="index.php?controller=LaporanPetugas&action=index" class="text-sm font-bold text-brand-600 hover:text-brand-700 transition flex items-center gap-1 bg-brand-50 px-4 py-2 rounded-xl">Lihat Semua Laporan <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="overflow-x-auto">
           <table class="w-full text-left border-collapse">
             <thead>
               <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                 <th class="px-6 py-4 w-16 text-center">ID</th>
                 <th class="px-6 py-4">Kategori Bencana</th>
                 <th class="px-6 py-4">Titik Kejadian</th>
                 <th class="px-6 py-4 text-center">Kondisi</th>
                 <th class="px-6 py-4 text-center">Tgl Masuk</th>
               </tr>
             </thead>
             <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
               <?php
               $reportsData = (isset($latestReports['success']) && $latestReports['success'] && !empty($latestReports['data'])) ? $latestReports['data'] : [];
               if (!empty($reportsData) && is_array($reportsData)):
                 foreach ($reportsData as $report):
                   $status = strtolower($report['status'] ?? '');
                   $badgeClass = 'bg-slate-100 text-slate-600';
                   $badgeIcon = 'fa-circle-info';
                   if (in_array($status, ['draft'])) { $badgeClass = 'bg-slate-100 text-slate-600'; $badgeIcon = 'fa-pen-ruler'; }
                   if (in_array($status, ['menunggu verifikasi', 'verifikasi'])) { $badgeClass = 'bg-amber-50 text-amber-600'; $badgeIcon = 'fa-hourglass-half'; }
                   if (in_array($status, ['diverifikasi'])) { $badgeClass = 'bg-blue-50 text-blue-600'; $badgeIcon = 'fa-shield-check'; }
                   if (in_array($status, ['diproses', 'ditangani'])) { $badgeClass = 'bg-indigo-50 text-indigo-600'; $badgeIcon = 'fa-spinner fa-spin'; }
                   if (in_array($status, ['tindak lanjut'])) { $badgeClass = 'bg-teal-50 text-teal-600'; $badgeIcon = 'fa-truck-fast'; }
                   if (in_array($status, ['selesai'])) { $badgeClass = 'bg-emerald-50 text-emerald-600'; $badgeIcon = 'fa-check'; }
                   if (in_array($status, ['ditolak'])) { $badgeClass = 'bg-rose-50 text-rose-600'; $badgeIcon = 'fa-ban'; }
               ?>
                 <tr class="hover:bg-slate-50/50 transition-colors">
                   <td class="px-6 py-4 text-center font-bold text-slate-400">#<?php echo (int)($report['id'] ?? 0); ?></td>
                   <td class="px-6 py-4">
                     <p class="font-bold text-slate-800"><?php echo htmlspecialchars($report['kategori']['nama_kategori'] ?? $report['nama_kategori_bencana'] ?? $report['kategori_bencana'] ?? 'Umum'); ?></p>
                     <p class="text-xs text-slate-500 flex items-center gap-1 mt-0.5"><i class="fa-solid fa-user-tag text-slate-300"></i> by <?php echo htmlspecialchars($report['nama_pelapor'] ?? ($report['pelapor']['nama'] ?? '-')); ?></p>
                   </td>
                   <td class="px-6 py-4 text-slate-600 line-clamp-2 leading-relaxed">
                     <i class="fa-solid fa-location-dot text-red-400 mr-1.5"></i><?php echo htmlspecialchars($report['alamat_lengkap'] ?? $report['lokasi'] ?? '-'); ?>
                   </td>
                   <td class="px-6 py-4 text-center">
                     <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md <?php echo $badgeClass; ?> text-xs font-bold border border-current shadow-[0_0_0_1px_rgba(255,255,255,1)]">
                       <i class="fa-solid <?php echo $badgeIcon; ?>"></i> <?php echo htmlspecialchars($report['status'] ?? '-'); ?>
                     </div>
                   </td>
                   <td class="px-6 py-4 text-center text-xs text-slate-500 border-l border-slate-100 border-dashed">
                     <?php echo formatTanggalIndo($report['created_at'] ?? $report['waktu_laporan'] ?? 'now'); ?>
                   </td>
                 </tr>
                 <?php endforeach; else: ?>
                 <tr>
                   <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-medium">
                      <div class="inline-flex h-16 w-16 rounded-full bg-slate-50 items-center justify-center mb-4 text-2xl text-slate-300 shadow-inner"><i class="fa-solid fa-folder-open"></i></div>
                      <p>Kondisi aman, tidak ada laporan yang sedang masuk untuk hari ini.</p>
                   </td>
                 </tr>
               <?php endif; ?>
             </tbody>
           </table>
        </div>
      </div>

    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const dashboardData = {
      weeklyStats: <?php echo json_encode($weeklyStats ?? []); ?>,
  };

  document.addEventListener('DOMContentLoaded', function() {

      const barCtx = document.getElementById('barChart');
      if (barCtx && dashboardData.weeklyStats && dashboardData.weeklyStats.success) {
          const weeklyStats = dashboardData.weeklyStats.data?.weekly_stats || {};
          const dayMapping = { 'mon': 'Senin', 'tue': 'Selasa', 'wed': 'Rabu', 'thu': 'Kamis', 'fri': 'Jumat', 'sat': 'Sabtu', 'sun': 'Minggu' };
          const orderedDays = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
          
          const labels = orderedDays.map(day => dayMapping[day]);
          const data = orderedDays.map(day => weeklyStats[day] || 0);

          new Chart(barCtx, {
              type: 'bar',
              data: {
                  labels: labels,
                  datasets: [{
                      label: 'Masuk Bencana',
                      data: data,
                      backgroundColor: 'rgba(79, 70, 229, 0.8)', // brand-600
                      borderRadius: 6,
                      barPercentage: 0.6
                  }]
              },
              options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  plugins: { legend: { display: false } },
                  scales: {
                      y: { beginAtZero: true, grid: { borderDash: [4, 4], color: '#f1f5f9' }, border: { display: false }, ticks: { stepSize: 1, color: '#94a3b8', font: {family: "'Plus Jakarta Sans', sans-serif"} } },
                      x: { grid: { display: false }, border: { display: false }, ticks: { color: '#64748b', font: {family: "'Plus Jakarta Sans', sans-serif"} } }
                  }
              }
          });
      }

      const dogCtx = document.getElementById('doughnutChart');
      if (dogCtx && dashboardData.weeklyStats && dashboardData.weeklyStats.success) {
          const catStats = dashboardData.weeklyStats.data?.categories_stats || {};
          let dogLabels = Object.keys(catStats);
          let dogData = Object.values(catStats);
          
          if (dogLabels.length === 0) { dogLabels = ['Nihil Bencana']; dogData = [1]; }

          new Chart(dogCtx, {
              type: 'doughnut',
              data: {
                  labels: dogLabels,
                  datasets: [{
                      data: dogData,
                      backgroundColor: ['#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#64748b'],
                      borderWidth: 0,
                      hoverOffset: 4
                  }]
              },
              options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  cutout: '70%',
                  plugins: {
                      legend: { position: 'right', labels: { usePointStyle: true, boxWidth: 8, padding: 20, font: {family: "'Plus Jakarta Sans', sans-serif"} } }
                  }
              }
          });
      }
  });
</script>
