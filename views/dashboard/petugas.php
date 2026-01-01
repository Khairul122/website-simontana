<?php
// Debug configuration - Set to true to enable console logging
define('DASHBOARD_DEBUG', false);

// ==========================================
// HELPER FUNCTION - Indonesian Date Formatter
// ==========================================
function formatTanggalIndo($dateString) {
    if (empty($dateString)) {
        return '-';
    }

    try {
        // Parse tanggal dari berbagai format yang mungkin
        $date = new DateTime($dateString);

        // Arrays untuk nama hari dan bulan dalam Bahasa Indonesia
        $namaHari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $namaBulan = [
            'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
            'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
            'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September',
            'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
        ];

        // Format: Hari, Tanggal Bulan Tahun
        $hariInggris = $date->format('l');
        $tanggal = $date->format('d');
        $bulanInggris = $date->format('F');
        $tahun = $date->format('Y');

        $hariIndo = $namaHari[$hariInggris] ?? $hariInggris;
        $bulanIndo = $namaBulan[$bulanInggris] ?? $bulanInggris;

        return "{$hariIndo}, {$tanggal} {$bulanIndo} {$tahun}";

    } catch (Exception $e) {
        // Fallback untuk format yang tidak bisa diparse
        return $dateString;
    }
}

include('template/header.php');
?>

<body class="with-welcome-text">
  <div class="container-scroller">
    <?php include 'template/navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include 'template/setting_panel.php'; ?>
      <?php include 'template/sidebar.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <h2>Selamat Datang, Petugas BPBD</h2>
              <p class="text-muted">Ini adalah dashboard khusus untuk petugas BPBD</p>
            </div>
          </div>

          <?php if (isset($stats) && !$stats['success'] && !empty($stats['errors'])): ?>
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Kesalahan!</h4>
                <ul class="mb-0">
                  <?php foreach ($stats['errors'] as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <?php if (isset($stats) && isset($stats['success']) && $stats['success']): ?>
          <div class="row mt-4">
            <!-- Total Laporan Card -->
            <div class="col-lg-3 col-md-6 grid-margin stretch-card">
              <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <p class="card-title text-white mb-0">Total Laporan</p>
                      <h3 class="font-weight-bold mb-0"><?php echo $stats['data']['total_laporan'] ?? 0; ?></h3>
                    </div>
                    <div class="icon-lg">
                      <i class="mdi mdi-file-document text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Perlu Verifikasi Card -->
            <div class="col-lg-3 col-md-6 grid-margin stretch-card">
              <div class="card bg-gradient-warning text-white">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <p class="card-title text-white mb-0">Perlu Verifikasi</p>
                      <h3 class="font-weight-bold mb-0"><?php echo $stats['data']['laporan_perlu_verifikasi'] ?? 0; ?></h3>
                    </div>
                    <div class="icon-lg">
                      <i class="mdi mdi-alert-circle text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Sedang Diproses Card -->
            <div class="col-lg-3 col-md-6 grid-margin stretch-card">
              <div class="card bg-gradient-info text-white">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <p class="card-title text-white mb-0">Sedang Diproses</p>
                      <h3 class="font-weight-bold mb-0"><?php echo $stats['data']['laporan_ditindak'] ?? 0; ?></h3>
                    </div>
                    <div class="icon-lg">
                      <i class="mdi mdi-cog text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Selesai Card -->
            <div class="col-lg-3 col-md-6 grid-margin stretch-card">
              <div class="card bg-gradient-success text-white">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <p class="card-title text-white mb-0">Selesai</p>
                      <h3 class="font-weight-bold mb-0"><?php echo $stats['data']['laporan_selesai'] ?? 0; ?></h3>
                    </div>
                    <div class="icon-lg">
                      <i class="mdi mdi-check-circle text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <!-- BMKG Widget -->
          <?php if (isset($bmkgData) && $bmkgData['success']): ?>
          <div class="row mt-4">
            <div class="col-12">
              <div class="card bg-danger text-white">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <h4 class="card-title text-white mb-1">
                        <i class="mdi mdi-earthquake"></i> Gempa Terkini BMKG
                      </h4>
                      <?php if (isset($bmkgData['data']['Infogempa']['gempa'])): ?>
                        <?php $gempa = $bmkgData['data']['Infogempa']['gempa']; ?>
                        <p class="mb-1">
                          <strong>Magnitudo:</strong> <?php echo $gempa['Magnitude']; ?> SR |
                          <strong>Kedalaman:</strong> <?php echo $gempa['Kedalaman']; ?>
                        </p>
                        <p class="mb-1">
                          <strong>Lokasi:</strong> <?php echo $gempa['Wilayah']; ?>
                        </p>
                        <p class="mb-0">
                          <strong>Waktu:</strong> <?php echo $gempa['Tanggal']; ?> <?php echo $gempa['Jam']; ?>
                        </p>
                      <?php else: ?>
                        <p class="mb-0">Data gempa tidak tersedia</p>
                      <?php endif; ?>
                    </div>
                    <div class="text-right">
                      <small class="text-white-50">Real-time dari BMKG</small><br>
                      <span class="badge badge-light">Live</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <?php if (isset($weeklyStats) && !$weeklyStats['success'] && !empty($weeklyStats['errors'])): ?>
          <div class="row">
            <div class="col-md-6 grid-margin">
              <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Kesalahan!</h4>
                <ul class="mb-0">
                  <?php foreach ($weeklyStats['errors'] as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <?php if (isset($weeklyStats) && $weeklyStats['success']): ?>
          <div class="row mt-4">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Statistik Laporan Minggu Ini</h4>
                  <div class="chart-container">
                    <canvas id="barChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Jenis Bencana Minggu Ini</h4>
                  <div class="chart-container">
                    <canvas id="doughnutChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <?php if (isset($latestReports) && !$latestReports['success'] && !empty($latestReports['errors'])): ?>
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Kesalahan!</h4>
                <ul class="mb-0">
                  <?php foreach ($latestReports['errors'] as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <?php if (isset($latestReports['success']) && $latestReports['success'] && !empty($latestReports['data'])): ?>
          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Daftar Laporan Terbaru</h4>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nama Pelapor</th>
                          <th>Jenis Bencana</th>
                          <th>Lokasi</th>
                          <th>Status</th>
                          <th>Tanggal</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $reportsData = isset($latestReports['data']['data']) ? $latestReports['data']['data'] :
                                    (isset($latestReports['data']) ? $latestReports['data'] : []);
                        if (!empty($reportsData) && is_array($reportsData)):
                      ?>
                          <?php foreach ($reportsData as $report): ?>
                            <tr>
                              <td><?php echo $report['id'] ?? '-'; ?></td>
                              <td><?php echo $report['nama_pelapor'] ?? ($report['pelapor']['nama'] ?? '-'); ?></td>
                              <td><?php echo $report['kategori']['nama_kategori'] ?? $report['nama_kategori_bencana'] ?? $report['kategori_bencana'] ?? '-'; ?></td>
                              <td><?php echo $report['alamat_lengkap'] ?? $report['lokasi'] ?? '-'; ?></td>
                              <td>
                                <?php
                                $status = $report['status'] ?? '-';
                                $badgeClass = '';

                                // Sesuaikan status dengan format yang mungkin dikembalikan API
                                switch(strtolower($status)) {
                                  case 'draft':
                                    $badgeClass = 'badge-warning';
                                    $displayText = 'Draft';
                                    break;
                                  case 'menunggu verifikasi':
                                  case 'verifikasi':
                                  case 'diverifikasi':
                                    $badgeClass = 'badge-info';
                                    $displayText = 'Diverifikasi';
                                    break;
                                  case 'diproses':
                                  case 'ditangani':
                                    $badgeClass = 'badge-primary';
                                    $displayText = 'Diproses';
                                    break;
                                  case 'selesai':
                                    $badgeClass = 'badge-success';
                                    $displayText = 'Selesai';
                                    break;
                                  case 'ditolak':
                                    $badgeClass = 'badge-danger';
                                    $displayText = 'Ditolak';
                                    break;
                                  default:
                                    $badgeClass = 'badge-secondary';
                                    $displayText = $status;
                                }
                                ?>
                                <label class="badge <?php echo $badgeClass; ?>"><?php echo $displayText; ?></label>
                              </td>
                              <td><?php echo formatTanggalIndo($report['created_at'] ?? $report['waktu_laporan'] ?? 'now'); ?></td>
                            </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="6" class="text-center">Tidak ada data laporan</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Container -->
  <div class="toast-container" id="toastContainer"></div>

  <?php include 'template/script.php'; ?>

  <!-- Custom CSS untuk Chart Fix -->
  <style>
    .chart-container {
      height: 300px !important;
      position: relative;
      width: 100%;
    }

    .chart-container canvas {
      height: 100% !important;
      width: 100% !important;
      max-height: 300px !important;
    }

    /* Prevent vertical stretching */
    canvas#barChart,
    canvas#doughnutChart {
      max-height: 300px !important;
      height: 300px !important;
    }

    /* Fix card body padding */
    .card-body {
      padding: 1.25rem;
    }

    .card-body .chart-container {
      margin-top: 1rem;
    }
  </style>

  <!-- Scripts tambahan untuk dashboard -->
  <script src="assets/vendors/chart.js/Chart.min.js"></script>
  <script>
    // Chart.js availability check (silent)
    if (typeof Chart === 'undefined') {
      console.error('Chart.js failed to load - charts will not be displayed');
    }
  </script>
  <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="assets/js/dataTables.select.min.js"></script>
  <!-- <script src="assets/js/Chart.roundedBarCharts.js"></script> commented out to prevent Chart.js errors -->
  <!-- <script src="assets/js/dashboard.js"></script> commented out to prevent canvas conflicts -->

  <script>
    // ==========================================
    // SINGLE SOURCE OF TRUTH - DASHBOARD DATA
    // ==========================================
    const dashboardData = {
        stats: <?php echo json_encode($stats ?? []); ?>,
        weeklyStats: <?php echo json_encode($weeklyStats ?? []); ?>,
        latestReports: <?php echo json_encode($latestReports ?? []); ?>,
        bmkgData: <?php echo json_encode($bmkgData ?? []); ?>
    };

    // ==========================================
    // IMMEDIATE LOGGING - Server Response Analysis
    // ==========================================
    console.log("🚀 Server Response:", dashboardData);

    // ==========================================
    // TOAST NOTIFICATION SYSTEM
    // ==========================================
    function showToast(type, title, message) {
        const toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) return;

        const toast = document.createElement('div');
        toast.className = `custom-toast ${type}`;

        toast.innerHTML = `
            <div class="toast-icon">${type === 'success' ? '✓' : '!'}</div>
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close">&times;</button>
            <div class="toast-progress"></div>
        `;

        toastContainer.appendChild(toast);

        // Event listeners
        const closeBtn = toast.querySelector('.toast-close');
        closeBtn.addEventListener('click', () => {
            toast.classList.add('hiding');
            setTimeout(() => toast.remove(), 300);
        });

        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (!toast.classList.contains('hiding')) {
                toast.classList.add('hiding');
                setTimeout(() => toast.remove(), 300);
            }
        }, 5000);
    }

    // ==========================================
    // CHART MANAGEMENT SYSTEM
    // ==========================================
    class ChartManager {
        constructor() {
            this.charts = {};
        }

        // Destroy existing charts to prevent canvas conflicts
        destroyExistingCharts() {
            if (typeof Chart !== 'undefined' && Chart.helpers) {
                Chart.helpers.each(Chart.instances, (instance) => {
                    if (instance.canvas.id === 'barChart' || instance.canvas.id === 'doughnutChart') {
                        instance.destroy();
                    }
                });
            }
        }

        // Generate dynamic colors for charts
        generateColors(count) {
            const baseColors = [
                'rgba(255, 99, 132, 0.8)', 'rgba(54, 162, 235, 0.8)', 'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)', 'rgba(153, 102, 255, 0.8)', 'rgba(255, 159, 64, 0.8)',
                'rgba(199, 199, 199, 0.8)', 'rgba(83, 102, 255, 0.8)', 'rgba(255, 99, 255, 0.8)'
            ];

            const borderColors = baseColors.map(color => color.replace('0.8', '1'));

            // Extend colors if needed
            while (baseColors.length < count) {
                baseColors.push(...baseColors);
                borderColors.push(...borderColors);
            }

            return {
                backgrounds: baseColors.slice(0, count),
                borders: borderColors.slice(0, count)
            };
        }

        // Create Bar Chart
        createBarChart() {
            const ctx = document.getElementById('barChart');
            if (!ctx || typeof Chart === 'undefined') return;

            try {
                // Prepare data from dashboardData
                const weeklyData = dashboardData.weeklyStats?.data || dashboardData.weeklyStats || {};
                const weeklyStats = weeklyData.weekly_stats || {};

                // Day mapping
                const dayMapping = {
                    'mon': 'Senin', 'tue': 'Selasa', 'wed': 'Rabu',
                    'thu': 'Kamis', 'fri': 'Jumat', 'sat': 'Sabtu', 'sun': 'Minggu'
                };

                // Create ordered data
                const orderedDays = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                const labels = orderedDays.map(day => dayMapping[day] || day);
                const data = orderedDays.map(day => weeklyStats[day] || 0);

                this.charts.bar = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Laporan',
                            data: data,
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1 }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Statistik Laporan Minggu Ini'
                            },
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Bar chart creation failed:', error.message);
            }
        }

        // Create Doughnut Chart
        createDoughnutChart() {
            const ctx = document.getElementById('doughnutChart');
            if (!ctx || typeof Chart === 'undefined') return;

            try {
                // Prepare data from dashboardData
                const weeklyData = dashboardData.weeklyStats?.data || dashboardData.weeklyStats || {};
                const categoriesStats = weeklyData.categories_stats || {};

                const labels = Object.keys(categoriesStats);
                const data = Object.values(categoriesStats);

                if (labels.length === 0) {
                    labels.push('Tidak Ada Data');
                    data.push(1);
                }

                const colors = this.generateColors(data.length);

                this.charts.doughnut = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: colors.backgrounds,
                            borderColor: colors.borders,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            title: {
                                display: true,
                                text: 'Jenis Bencana Minggu Ini'
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Doughnut chart creation failed:', error.message);
            }
        }

        // Initialize all charts
        initCharts() {
            this.destroyExistingCharts();
            this.createBarChart();
            this.createDoughnutChart();
        }
    }

    // ==========================================
    // ERROR HANDLING SYSTEM
    // ==========================================
    function handleServerErrors() {
        // Handle stats errors
        if (dashboardData.stats && !dashboardData.stats.success && dashboardData.stats.errors) {
            dashboardData.stats.errors.forEach(error => {
                showToast('error', 'Kesalahan Data', error);
            });
        }

        // Handle weeklyStats errors
        if (dashboardData.weeklyStats && !dashboardData.weeklyStats.success && dashboardData.weeklyStats.errors) {
            dashboardData.weeklyStats.errors.forEach(error => {
                showToast('error', 'Kesalahan Data', error);
            });
        }

        // Handle latestReports errors
        if (dashboardData.latestReports && !dashboardData.latestReports.success && dashboardData.latestReports.errors) {
            dashboardData.latestReports.errors.forEach(error => {
                showToast('error', 'Kesalahan Data', error);
            });
        }
    }

    // ==========================================
    // DASHBOARD INITIALIZATION
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
        // Handle server errors first
        handleServerErrors();

        // Initialize charts
        const chartManager = new ChartManager();
        chartManager.initCharts();

        // Log initialization
        console.log('Dashboard initialized successfully');
    });
  </script>
</body>
</html>