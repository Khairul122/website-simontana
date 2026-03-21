<?php
include('template/header.php');

function formatTanggalIndoDashboard($dateString)
{
    if (empty($dateString)) return '-';
    try {
        $date = new DateTime($dateString);
        $bulan = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        return $date->format('d') . ' ' . ($bulan[(int)$date->format('n')] ?? $date->format('M')) . ' ' . $date->format('Y H:i');
    } catch (Exception $e) {
        return (string)$dateString;
    }
}

$statsData = (isset($stats['success']) && $stats['success'] && is_array($stats['data'] ?? null)) ? $stats['data'] : [];
$totalLaporan = (int)($statsData['total_laporan'] ?? 0);
$laporanBaru = (int)($statsData['laporan_baru'] ?? 0);
$laporanDitangani = (int)($statsData['laporan_ditangani'] ?? 0);
$laporanSelesai = (int)($statsData['laporan_selesai'] ?? 0);
$laporanTertunda = max(0, $totalLaporan - ($laporanDitangani + $laporanSelesai));

$latestRows = [];
if (isset($latestReports['success']) && $latestReports['success'] && is_array($latestReports['data'] ?? null)) {
    $latestRows = $latestReports['data'];
}

$weeklyPayload = is_array($weeklyStats['data'] ?? null) ? $weeklyStats['data'] : (is_array($weeklyStats ?? null) ? $weeklyStats : []);
$weeklySeries = is_array($weeklyPayload['weekly_stats'] ?? null) ? $weeklyPayload['weekly_stats'] : [];
$categorySeries = is_array($weeklyPayload['categories_stats'] ?? null) ? $weeklyPayload['categories_stats'] : [];

$bmkgGempa = (isset($bmkgData['data']['Magnitude'])) ? $bmkgData['data'] : null;
?>


<div class="container-scroller h-screen flex overflow-hidden bg-slate-50">
  
  <?php include 'template/sidebar.php'; ?>
  
  <div class="page-body-wrapper flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="main-panel flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="content-wrapper p-4 md:p-6 lg:p-8 w-full">

        
        <div class="relative overflow-hidden rounded-2xl bg-white border border-slate-200 shadow-card p-6 md:p-8 mb-6 animate-fade-in group">
          <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-brand-50 transition-transform duration-700 ease-out group-hover:scale-110"></div>
          <div class="absolute -right-8 -bottom-12 h-32 w-32 rounded-full bg-brand-100/50 transition-transform duration-500 ease-out delay-75 group-hover:scale-125"></div>
          
          <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
              <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-xs font-bold text-slate-600 tracking-wide uppercase mb-3">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                Sistem Aktif & Normal
              </div>
              <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-900 mb-2">Pusat Komando Darurat</h1>
              <p class="text-slate-500 max-w-2xl leading-relaxed">Pantau validasi, tindak lanjut, dan dinamika laporan bencana dari seluruh wilayah binaan secara terpusat.</p>
            </div>
            
            <div class="flex items-center gap-3 shrink-0">
              <a href="index.php?controller=LaporanAdmin&action=index" class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 font-semibold text-sm hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm">Lihat Semua Data</a>
              <a href="index.php?controller=LaporanAdmin&action=create" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-600 text-white font-semibold text-sm hover:bg-brand-700 hover:shadow-float transition-all shadow-sm">
                <i class="fa-solid fa-plus"></i> Tambah Laporan
              </a>
            </div>
          </div>
        </div>

        <?php if (isset($stats['success']) && !$stats['success']): ?>
          <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6 flex items-start gap-4">
            <div class="flex-shrink-0 text-red-500 mt-0.5"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
            <div>
              <h3 class="text-sm font-bold text-red-800">Gagal memuat statistik</h3>
              <p class="text-sm text-red-600 mt-1"><?= htmlspecialchars($stats['message'] ?? 'Silakan muat ulang halaman.') ?></p>
            </div>
          </div>
        <?php endif; ?>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
          
          
          <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-card hover:-translate-y-1 hover:shadow-lg transition-all transform duration-300">
            <div class="flex items-start justify-between">
              <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Laporan Masuk</p>
                <h3 class="font-display text-3xl font-bold text-slate-800"><?= $totalLaporan ?></h3>
              </div>
              <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 text-xl">
                <i class="fa-solid fa-folder-open"></i>
              </div>
            </div>
          </div>

          
          <div class="rounded-2xl border border-red-200 bg-red-50/50 p-5 shadow-card hover:-translate-y-1 hover:shadow-lg transition-all transform duration-300 delay-75">
            <div class="flex items-start justify-between">
              <div>
                <p class="text-xs font-bold text-red-500 uppercase tracking-wider mb-1">Menunggu Verifikasi</p>
                <h3 class="font-display text-3xl font-bold text-red-700"><?= $laporanBaru ?></h3>
              </div>
              <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center text-red-600 text-xl">
                <i class="fa-solid fa-bell animate-pulse-soft"></i>
              </div>
            </div>
            <?php if($laporanBaru > 0): ?>
              <div class="mt-4"><span class="text-xs font-bold text-white bg-red-500 rounded-md px-2 py-1">Butuh Tindakan Segera</span></div>
            <?php endif; ?>
          </div>

          
          <div class="rounded-2xl border border-amber-200 bg-amber-50/50 p-5 shadow-card hover:-translate-y-1 hover:shadow-lg transition-all transform duration-300 delay-100">
            <div class="flex items-start justify-between">
              <div>
                <p class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">Sedang Ditangani</p>
                <h3 class="font-display text-3xl font-bold text-amber-700"><?= $laporanDitangani ?></h3>
              </div>
              <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 text-xl">
                <i class="fa-solid fa-helmet-safety"></i>
              </div>
            </div>
          </div>

          
          <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-5 shadow-card hover:-translate-y-1 hover:shadow-lg transition-all transform duration-300 delay-150">
            <div class="flex items-start justify-between">
              <div>
                <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Tuntas Diselesaikan</p>
                <h3 class="font-display text-3xl font-bold text-emerald-700"><?= $laporanSelesai ?></h3>
              </div>
              <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 text-xl">
                <i class="fa-regular fa-circle-check"></i>
              </div>
            </div>
          </div>

        </div>

        
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
          
          
          <div class="xl:col-span-2 rounded-2xl border border-slate-200 bg-white shadow-card flex flex-col h-full">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
              <div>
                <h2 class="font-bold text-slate-800 text-lg">Kejadian Terbaru</h2>
                <p class="text-xs text-slate-500 mt-0.5">Laporan terkini yang masuk ke sistem</p>
              </div>
              <a href="index.php?controller=LaporanAdmin&action=index" class="text-sm font-bold text-brand-600 hover:text-brand-800 transition-colors">Lihat Semua</a>
            </div>
            
            <div class="flex-1 overflow-x-auto">
              <table class="w-full text-left border-collapse">
                <thead>
                  <tr class="bg-slate-50 text-xs font-bold text-slate-500 uppercase tracking-wider">
                    <th class="px-6 py-4 border-b border-slate-200">Info Kejadian</th>
                    <th class="px-6 py-4 border-b border-slate-200">Pelapor</th>
                    <th class="px-6 py-4 border-b border-slate-200">Status</th>
                    <th class="px-6 py-4 border-b border-slate-200 text-right">Waktu</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                  <?php if (!empty($latestRows)): ?>
                    <?php foreach ($latestRows as $row): ?>
                      <?php
                        $status = strtolower((string)($row['status'] ?? '-'));
                        $badgeTheme = 'bg-slate-100 text-slate-700 border-slate-200';
                        if ($status === 'menunggu verifikasi') {
                            $badgeTheme = 'bg-red-50 text-red-700 border-red-200';
                        } elseif ($status === 'diproses' || $status === 'ditangani') {
                            $badgeTheme = 'bg-amber-50 text-amber-700 border-amber-200';
                        } elseif ($status === 'selesai') {
                            $badgeTheme = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                        }
                      ?>
                      <tr class="hover:bg-slate-50/70 transition-colors group cursor-pointer" onclick="window.location='index.php?controller=LaporanAdmin&action=detail&id=<?= $row['id'] ?>'">
                        <td class="px-6 py-4">
                          <p class="text-sm font-bold text-slate-800 mb-0.5 group-hover:text-brand-600 transition-colors"><?= htmlspecialchars($row['judul_laporan'] ?? $row['judul'] ?? '-') ?></p>
                          <p class="text-xs text-slate-500 flex items-center gap-1.5"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($row['alamat_lengkap'] ?? '-') ?></p>
                        </td>
                        <td class="px-6 py-4">
                          <p class="text-sm font-semibold text-slate-700"><?= htmlspecialchars($row['nama_pelapor'] ?? ($row['pelapor']['nama'] ?? '-')) ?></p>
                        </td>
                        <td class="px-6 py-4">
                          <span class="inline-flex items-center px-2.5 py-1 rounded-lg border text-xs font-bold <?= $badgeTheme ?>">
                            <?= htmlspecialchars($row['status'] ?? '-') ?>
                          </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                          <p class="text-sm font-medium text-slate-600"><?= htmlspecialchars(formatTanggalIndoDashboard($row['created_at'] ?? $row['waktu_laporan'] ?? '')) ?></p>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="4" class="px-6 py-12 text-center">
                        <div class="inline-flex h-12 w-12 rounded-full bg-slate-100 text-slate-400 items-center justify-center mb-3 text-xl"><i class="fa-regular fa-folder-open"></i></div>
                        <p class="text-sm font-semibold text-slate-500">Belum ada laporan terbaru.</p>
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>

          
          <div class="xl:col-span-1 flex flex-col gap-6">
            
            
            <div class="rounded-2xl bg-gradient-to-br from-[#1e1b4b] to-[#312e81] border border-transparent shadow-card p-1 relative overflow-hidden text-white flex-1">
              <div class="absolute right-0 top-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
              
              <div class="bg-white/10 backdrop-blur-md rounded-[13px] h-full p-6 border border-white/10 relative z-10 flex flex-col">
                <div class="flex items-center justify-between mb-5">
                  <div class="flex items-center gap-2">
                    <i class="fa-solid fa-satellite text-amber-300 text-lg md:animate-bounce mt-1"></i>
                    <h2 class="font-bold text-white text-lg">Info BMKG Terkini</h2>
                  </div>
                  <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded border border-red-400/30 bg-red-500/20 text-[10px] font-bold tracking-widest text-red-200">
                    <span class="h-1.5 w-1.5 rounded-full bg-red-400 animate-pulse"></span> LIVE
                  </span>
                </div>

                <?php if ($bmkgGempa): ?>
                  <div class="flex items-end gap-3 mb-6">
                    <h3 class="font-display font-bold text-5xl tracking-tighter text-amber-300"><?= htmlspecialchars($bmkgGempa['Magnitude'] ?? '-') ?></h3>
                    <p class="text-indigo-200 font-semibold mb-1">Skala<br>Richter</p>
                  </div>
                  
                  <div class="space-y-4 flex-1">
                    <div>
                      <p class="text-xs text-indigo-300/80 uppercase tracking-wider mb-1">Pusat Gempa (Wilayah)</p>
                      <p class="font-semibold text-white leading-snug"><?= htmlspecialchars($bmkgGempa['Wilayah'] ?? '-') ?></p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                      <div class="bg-black/20 rounded-xl p-3 border border-white/5">
                        <p class="text-[10px] text-indigo-300/80 uppercase tracking-widest mb-1">Kedalaman</p>
                        <p class="font-bold text-white"><?= htmlspecialchars($bmkgGempa['Kedalaman'] ?? '-') ?></p>
                      </div>
                      <div class="bg-black/20 rounded-xl p-3 border border-white/5">
                        <p class="text-[10px] text-indigo-300/80 uppercase tracking-widest mb-1">Waktu Kejadian</p>
                        <p class="font-bold text-white text-sm whitespace-nowrap overflow-hidden text-ellipsis"><?= htmlspecialchars(($bmkgGempa['Tanggal'] ?? '-') . ' ' . explode(' ', $bmkgGempa['Jam'] ?? '')[0]) ?></p>
                      </div>
                    </div>
                  </div>
                <?php else: ?>
                  <div class="flex flex-col items-center justify-center flex-1 py-8 opacity-70">
                    <i class="fa-solid fa-tower-broadcast text-4xl mb-4 text-indigo-300/50"></i>
                    <p class="text-sm font-medium text-center text-indigo-200">Tidak ada info gempa bumi signifikan saat ini.</p>
                  </div>
                <?php endif; ?>
              </div>
            </div>

            
            <?php if ($laporanTertunda > 0): ?>
            <div class="rounded-2xl border border-red-200 bg-red-50 p-6 shadow-card">
              <div class="flex items-center justify-between mb-2">
                <h3 class="font-bold text-red-800">Prioritas Operasi</h3>
                <span class="px-2 py-1 rounded bg-red-200 text-red-800 text-[10px] font-bold uppercase tracking-widest">Urgent</span>
              </div>
              <p class="font-display text-4xl font-bold text-red-700 leading-none mb-3"><?= $laporanTertunda ?></p>
              <p class="text-sm text-red-600/80 font-medium mb-4">Laporan belum tuntas ditangani, periksa timeline tindak lanjut segera.</p>
              <a href="index.php?controller=TindakLanjut&action=index" class="inline-flex w-full items-center justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-red-700 transition">
                Tangani Sekarang
              </a>
            </div>
            <?php endif; ?>

          </div>
        </div>

        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-card h-[380px] flex flex-col">
            <h2 class="font-bold text-slate-800 text-lg mb-1">Tren Laporan Mingguan</h2>
            <p class="text-xs text-slate-500 mb-6">Volume insiden dalam 7 hari terakhir</p>
            <div class="flex-1 min-h-0 relative w-full">
              <canvas id="barChart"></canvas>
            </div>
          </div>
          
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-card h-[380px] flex flex-col">
            <h2 class="font-bold text-slate-800 text-lg mb-1">Sebaran Jenis Bencana</h2>
            <p class="text-xs text-slate-500 mb-6">Komposisi berdasarkan kategori pelaporan</p>
            <div class="flex-1 min-h-0 relative w-full flex items-center justify-center">
              <canvas id="doughnutChart"></canvas>
            </div>
          </div>
        </div>

      </div>
    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    if (typeof Chart === 'undefined') return;

    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = "#64748b";
    
    const weeklySeries = <?= json_encode($weeklySeries) ?> || {};
    const categorySeries = <?= json_encode($categorySeries) ?> || {};

    const dayOrder = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
    const dayLabel = { mon: 'Sen', tue: 'Sel', wed: 'Rab', thu: 'Kam', fri: 'Jum', sat: 'Sab', sun: 'Min' };

    const barCtx = document.getElementById('barChart');
    if (barCtx) {
      new Chart(barCtx, {
        type: 'bar',
        data: {
          labels: dayOrder.map(d => dayLabel[d]),
          datasets: [{
            data: dayOrder.map(d => Number(weeklySeries[d] || 0)),
            backgroundColor: '#ef4444',
            hoverBackgroundColor: '#dc2626',
            borderRadius: 6,
            barPercentage: 0.6
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { 
            legend: { display: false },
            tooltip: {
              backgroundColor: '#1e293b',
              padding: 10,
              titleFont: { size: 13, family: "'Plus Jakarta Sans'" },
              bodyFont: { size: 14, weight: 'bold', family: "'Plus Jakarta Sans'" },
              displayColors: false,
              cornerRadius: 8,
            }
          },
          scales: {
            x: { 
              grid: { display: false },
              border: { display: false },
              ticks: { font: { weight: '600' } }
            },
            y: { 
              beginAtZero: true, 
              border: { display: false },
              grid: { color: '#f1f5f9' },
              ticks: { precision: 0, padding: 10 }
            }
          }
        }
      });
    }

    const doughnutCtx = document.getElementById('doughnutChart');
    if (doughnutCtx) {
      const labels = Object.keys(categorySeries);
      const values = Object.values(categorySeries).map(v => Number(v || 0));
      const safeLabels = labels.length ? labels : ['Belum ada data'];
      const safeValues = values.length ? values : [1];

      const colors = ['#dc2626', '#f59e0b', '#0f766e', '#1d4ed8', '#7c2d12', '#475569'];

      new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
          labels: safeLabels,
          datasets: [{
            data: safeValues,
            backgroundColor: values.length ? colors : ['#cbd5e1'],
            borderWidth: 2,
            borderColor: '#ffffff',
            hoverOffset: 4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          cutout: '70%',
          plugins: {
            legend: { 
              position: 'right',
              labels: { 
                padding: 20, 
                usePointStyle: true, 
                pointStyle: 'circle',
                font: { size: 12, weight: '600' }
              }
            },
            tooltip: {
              backgroundColor: '#1e293b',
              padding: 12,
              bodyFont: { size: 14, weight: 'bold' },
              cornerRadius: 8,
            }
          }
        }
      });
    }
  });
</script>
