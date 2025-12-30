<?php include('template/header.php'); ?>

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
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="font-weight-bold text-primary">Dashboard Operator Desa</h2>
                <div class="d-flex">
                  <div class="input-group" style="max-width: 300px;">
                    <input type="text" class="form-control" placeholder="Cari laporan...">
                    <div class="input-group-append">
                      <button class="btn btn-outline-primary" type="button">
                        <i class="mdi mdi-magnify"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <?php if (isset($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <i class="mdi mdi-alert-circle-outline"></i> <?php echo htmlspecialchars($error_message); ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <?php else: ?>
                <?php if (isset($dashboardData) && $dashboardData['success']): ?>
                  <!-- Statistik Cards Row -->
                  <div class="row mb-4">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 stretch-card">
                      <div class="card card-statistics shadow-sm border-0 rounded-lg">
                        <div class="card-body p-4">
                          <div class="d-flex align-items-center">
                            <div class="icon-statistics icon-rounded bg-primary text-white">
                              <i class="mdi mdi-clipboard-text mdi-24px"></i>
                            </div>
                            <div class="ml-3">
                              <p class="card-text text-muted font-14 mb-1">Total Laporan</p>
                              <h3 class="font-weight-bold mb-0"><?php echo htmlspecialchars($dashboardData['data']['total_laporan'] ?? 0); ?></h3>
                              <div class="d-flex align-items-center">
                                <span class="text-success font-12">
                                  <i class="mdi mdi-arrow-up"></i> 12%
                                </span>
                                <span class="text-muted font-12 ml-1">dari bulan lalu</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 stretch-card">
                      <div class="card card-statistics shadow-sm border-0 rounded-lg">
                        <div class="card-body p-4">
                          <div class="d-flex align-items-center">
                            <div class="icon-statistics icon-rounded bg-warning text-white">
                              <i class="mdi mdi-account-group mdi-24px"></i>
                            </div>
                            <div class="ml-3">
                              <p class="card-text text-muted font-14 mb-1">Warga Terdampak</p>
                              <h3 class="font-weight-bold mb-0"><?php echo htmlspecialchars($dashboardData['data']['total_warga_terdampak'] ?? 0); ?></h3>
                              <div class="d-flex align-items-center">
                                <span class="text-danger font-12">
                                  <i class="mdi mdi-account-multiple"></i> <?php echo htmlspecialchars($dashboardData['data']['total_warga_terdampak'] ?? 0); ?> jiwa
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 stretch-card">
                      <div class="card card-statistics shadow-sm border-0 rounded-lg">
                        <div class="card-body p-4">
                          <div class="d-flex align-items-center">
                            <div class="icon-statistics icon-rounded bg-info text-white">
                              <i class="mdi mdi-package-variant mdi-24px"></i>
                            </div>
                            <div class="ml-3">
                              <p class="card-text text-muted font-14 mb-1">Status Logistik</p>
                              <h3 class="font-weight-bold mb-0"><?php echo htmlspecialchars($dashboardData['data']['logistik_status']['status_terakhir'] ?? 'Tersedia'); ?></h3>
                              <div class="d-flex align-items-center">
                                <span class="text-success font-12">
                                  <i class="mdi mdi-package-variant"></i> <?php echo htmlspecialchars($dashboardData['data']['logistik_status']['total_distribusi'] ?? 0); ?> paket
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 stretch-card">
                      <div class="card card-statistics shadow-sm border-0 rounded-lg">
                        <div class="card-body p-4">
                          <div class="d-flex align-items-center">
                            <div class="icon-statistics icon-rounded bg-success text-white">
                              <i class="mdi mdi-shield-check mdi-24px"></i>
                            </div>
                            <div class="ml-3">
                              <p class="card-text text-muted font-14 mb-1">Status Desa</p>
                              <h3 class="font-weight-bold mb-0"><?php echo htmlspecialchars($dashboardData['data']['desa_info']['status'] ?? 'Aman'); ?></h3>
                              <div class="d-flex align-items-center">
                                <span class="text-success font-12">
                                  <i class="mdi mdi-check-circle"></i> Aman
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Charts and Recent Reports Row -->
                  <div class="row">
                    <!-- Chart Section -->
                    <div class="col-lg-8 grid-margin stretch-card">
                      <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-body">
                          <h4 class="card-title">Statistik Laporan</h4>
                          <div style="height: 250px;">
                            <canvas id="reportChart"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Recent Reports Section -->
                    <div class="col-lg-4 grid-margin stretch-card">
                      <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-body">
                          <h4 class="card-title">Status Terbaru</h4>
                          <div class="d-flex justify-content-between mb-3">
                            <div class="text-center">
                              <h5 class="font-weight-bold text-info"><?php echo htmlspecialchars($dashboardData['data']['laporan_stats']['laporan_perlu_verifikasi'] ?? 0); ?></h5>
                              <p class="text-muted mb-0">Verifikasi</p>
                            </div>
                            <div class="text-center">
                              <h5 class="font-weight-bold text-warning"><?php echo htmlspecialchars($dashboardData['data']['laporan_stats']['laporan_ditindak'] ?? 0); ?></h5>
                              <p class="text-muted mb-0">Diproses</p>
                            </div>
                            <div class="text-center">
                              <h5 class="font-weight-bold text-success"><?php echo htmlspecialchars($dashboardData['data']['laporan_stats']['laporan_selesai'] ?? 0); ?></h5>
                              <p class="text-muted mb-0">Selesai</p>
                            </div>
                          </div>

                          <div class="progress mb-4" style="height: 8px;">
                            <?php
                              $total_laporan = $dashboardData['data']['total_laporan'] ?? 1; // Gunakan 1 untuk menghindari pembagian dengan nol
                              $verifikasi_percent = $total_laporan > 0 ? round(($dashboardData['data']['laporan_stats']['laporan_perlu_verifikasi'] ?? 0) / $total_laporan * 100) : 0;
                              $proses_percent = $total_laporan > 0 ? round(($dashboardData['data']['laporan_stats']['laporan_ditindak'] ?? 0) / $total_laporan * 100) : 0;
                              $selesai_percent = $total_laporan > 0 ? round(($dashboardData['data']['laporan_stats']['laporan_selesai'] ?? 0) / $total_laporan * 100) : 0;
                            ?>
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $verifikasi_percent; ?>%" aria-valuenow="<?php echo htmlspecialchars($dashboardData['data']['laporan_stats']['laporan_perlu_verifikasi'] ?? 0); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $proses_percent; ?>%" aria-valuenow="<?php echo htmlspecialchars($dashboardData['data']['laporan_stats']['laporan_ditindak'] ?? 0); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $selesai_percent; ?>%" aria-valuenow="<?php echo htmlspecialchars($dashboardData['data']['laporan_stats']['laporan_selesai'] ?? 0); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>

                          <h5 class="mt-4">Aktivitas Terbaru</h5>
                          <div class="timeline timeline-one">
                            <?php if (!empty($dashboardData['data']['laporan_terbaru'])): ?>
                              <?php foreach (array_slice($dashboardData['data']['laporan_terbaru'], 0, 3) as $laporan): ?>
                                <div class="timeline-item">
                                  <div class="content">
                                    <h6 class="mb-0"><?php echo htmlspecialchars($laporan['judul_laporan'] ?? 'Tidak ada judul'); ?></h6>
                                    <p class="text-muted mb-1"><?php echo htmlspecialchars(date('d M Y', strtotime($laporan['waktu_laporan'] ?? ''))); ?></p>
                                    <span class="badge badge-gradient-<?php
                                      $status = $laporan['status'] ?? '';
                                      switch($status) {
                                        case 'Draft':
                                        case 'Menunggu Verifikasi':
                                          echo 'warning';
                                          break;
                                        case 'Diverifikasi':
                                        case 'Diproses':
                                        case 'Tindak Lanjut':
                                          echo 'info';
                                          break;
                                        case 'Selesai':
                                          echo 'success';
                                          break;
                                        case 'Ditolak':
                                          echo 'danger';
                                          break;
                                        default:
                                          echo 'secondary';
                                      }
                                    ?>">
                                      <?php echo htmlspecialchars($status); ?>
                                    </span>
                                  </div>
                                </div>
                              <?php endforeach; ?>
                            <?php else: ?>
                              <div class="text-center py-4">
                                <i class="mdi mdi-inbox text-muted mdi-36px"></i>
                                <p class="text-muted">Belum ada aktivitas terbaru</p>
                              </div>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Recent Reports Table -->
                  <div class="row">
                    <div class="col-12 grid-margin">
                      <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-body">
                          <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">5 Laporan Terbaru</h4>
                            <a href="index.php?controller=LaporanAdmin&action=index" class="btn btn-primary btn-sm">Lihat Semua</a>
                          </div>
                          <div class="table-responsive">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>Tanggal</th>
                                  <th>Judul Laporan</th>
                                  <th>Kategori</th>
                                  <th>Status</th>
                                  <th>Warga Terdampak</th>
                                  <th>Aksi</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php if (!empty($dashboardData['data']['laporan_terbaru'])): ?>
                                  <?php foreach ($dashboardData['data']['laporan_terbaru'] as $laporan): ?>
                                    <tr>
                                      <td><?php echo htmlspecialchars(date('d M Y', strtotime($laporan['waktu_laporan'] ?? ''))); ?></td>
                                      <td>
                                        <div class="d-flex align-items-center">
                                          <div class="mr-2">
                                            <i class="mdi mdi-clipboard-text text-primary"></i>
                                          </div>
                                          <div>
                                            <span class="font-weight-medium"><?php echo htmlspecialchars($laporan['judul_laporan'] ?? 'Tidak ada judul'); ?></span>
                                            <small class="d-block text-muted"><?php echo htmlspecialchars(substr($laporan['deskripsi'] ?? '', 0, 50)) . (strlen($laporan['deskripsi'] ?? '') > 50 ? '...' : ''); ?></small>
                                          </div>
                                        </div>
                                      </td>
                                      <td><?php echo htmlspecialchars($laporan['kategori']['nama_kategori'] ?? 'Umum'); ?></td>
                                      <td>
                                        <label class="badge badge-gradient-<?php
                                          $status = $laporan['status'] ?? '';
                                          switch($status) {
                                            case 'Draft':
                                            case 'Menunggu Verifikasi':
                                              echo 'warning';
                                              break;
                                            case 'Diverifikasi':
                                            case 'Diproses':
                                            case 'Tindak Lanjut':
                                              echo 'info';
                                              break;
                                            case 'Selesai':
                                              echo 'success';
                                              break;
                                            case 'Ditolak':
                                              echo 'danger';
                                              break;
                                            default:
                                              echo 'secondary';
                                          }
                                        ?>">
                                          <?php echo htmlspecialchars($status); ?>
                                        </label>
                                      </td>
                                      <td>
                                        <span class="text-danger">
                                          <i class="mdi mdi-account-multiple"></i> <?php echo htmlspecialchars($laporan['jumlah_korban'] ?? 0); ?>
                                        </span>
                                      </td>
                                      <td>
                                        <div class="btn-group" role="group">
                                          <a href="index.php?controller=LaporanAdmin&action=detail&id=<?php echo $laporan['id']; ?>" class="btn btn-outline-primary btn-sm" title="Lihat Detail">
                                            <i class="mdi mdi-eye"></i>
                                          </a>
                                          <a href="index.php?controller=LaporanAdmin&action=edit&id=<?php echo $laporan['id']; ?>" class="btn btn-outline-info btn-sm" title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                          </a>
                                        </div>
                                      </td>
                                    </tr>
                                  <?php endforeach; ?>
                                <?php else: ?>
                                  <tr>
                                    <td colspan="6" class="text-center py-5">
                                      <i class="mdi mdi-inbox text-muted mdi-48px"></i>
                                      <p class="text-muted mt-2">Belum ada data laporan</p>
                                    </td>
                                  </tr>
                                <?php endif; ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php else: ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-alert-circle-outline"></i> <?php echo htmlspecialchars($dashboardData['message'] ?? 'Gagal memuat data dashboard'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Add Chart.js for dynamic charts -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
          // Initialize charts when the page loads
          document.addEventListener('DOMContentLoaded', function() {
            // Prepare chart data from dashboard data
            const dashboardData = <?php echo json_encode($dashboardData['data']['laporan_terbaru'] ?? []); ?>;

            // Extract data for the chart
            const labels = dashboardData.map(item => item.judul_laporan ? item.judul_laporan.substring(0, 15) + (item.judul_laporan.length > 15 ? '...' : '') : 'Laporan');
            const korbanData = dashboardData.map(item => item.jumlah_korban || 0);
            const rumahRusakData = dashboardData.map(item => item.jumlah_rumah_rusak || 0);

            // Create the chart
            const ctx = document.getElementById('reportChart').getContext('2d');
            const reportChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: labels.length > 0 ? labels : ['Tidak Ada Data'],
                datasets: [
                  {
                    label: 'Warga Terdampak',
                    data: korbanData.length > 0 ? korbanData : [0],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 1
                  },
                  {
                    label: 'Rumah Rusak',
                    data: rumahRusakData.length > 0 ? rumahRusakData : [0],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    borderWidth: 1
                  }
                ]
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                  legend: {
                    position: 'top',
                  },
                  title: {
                    display: true,
                    text: 'Laporan Terbaru & Dampak Bencana'
                  }
                },
                scales: {
                  y: {
                    beginAtZero: true,
                    title: {
                      display: true,
                      text: 'Jumlah'
                    }
                  },
                  x: {
                    ticks: {
                      maxRotation: 45,
                      minRotation: 0
                    }
                  }
                }
              }
            });
          });

          // Add responsive behavior for mobile
          window.addEventListener('resize', function() {
            if (reportChart) {
              reportChart.resize();
            }
          });
        </script>
      </div>
    </div>
  </div>
  <?php include 'template/script.php'; ?>
</body>

</html>