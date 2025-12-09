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
              <div class="home-header">
                <h4 class="mb-3">Dashboard Admin</h4>
                <p class="text-muted mb-4">Selamat datang di SIMONTA BENCANA - Sistem Informasi Monitoring dan Pelaporan Bencana</p>
              </div>
            </div>
          </div>

          <!-- Statistics Cards -->
          <div class="row mb-4">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-file-document text-primary icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="card-text text-right">Total Laporan</p>
                      <div class="fluid-container">
                        <h3 class="card-title font-weight-bold text-right mb-0"><?php echo number_format($dashboard['stats']['total_laporan']); ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <span class="text-primary">
                      <i class="mdi mdi-chart-line"></i>
                      Semua laporan masuk
                    </span>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-clock-outline text-warning icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="card-text text-right">Menunggu</p>
                      <div class="fluid-container">
                        <h3 class="card-title font-weight-bold text-right mb-0"><?php echo number_format($dashboard['stats']['laporan_menunggu']); ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <span class="text-warning">
                      <i class="mdi mdi-alert-circle"></i>
                      Perlu verifikasi
                    </span>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-progress-clock text-info icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="card-text text-right">Diproses</p>
                      <div class="fluid-container">
                        <h3 class="card-title font-weight-bold text-right mb-0"><?php echo number_format($dashboard['stats']['laporan_diproses']); ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <span class="text-info">
                      <i class="mdi mdi-trending-up"></i>
                      Sedang ditangani
                    </span>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-check-circle text-success icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="card-text text-right">Selesai</p>
                      <div class="fluid-container">
                        <h3 class="card-title font-weight-bold text-right mb-0"><?php echo number_format($dashboard['stats']['laporan_selesai']); ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <span class="text-success">
                      <i class="mdi mdi-check-all"></i>
                      Selesai ditangani
                    </span>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Additional Statistics Row -->
          <div class="row mb-4">
            <div class="col-xl-6 col-lg-6 col-md-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-account-group text-primary icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="card-text text-right">Total Pengguna</p>
                      <div class="fluid-container">
                        <h3 class="card-title font-weight-bold text-right mb-0"><?php echo number_format($dashboard['stats']['total_pengguna']); ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <span class="text-success">
                      <i class="mdi mdi-account-check"></i>
                      <?php echo $dashboard['stats']['pengguna_aktif']; ?> pengguna aktif
                    </span>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-earth text-warning icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="card-text text-right">Monitoring Aktif</p>
                      <div class="fluid-container">
                        <h3 class="card-title font-weight-bold text-right mb-0"><?php echo count($dashboard['recent_monitoring'] ?? []); ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <span class="text-warning">
                      <i class="mdi mdi-eye"></i>
                      Area dipantau
                    </span>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->
          <div class="row">
            <!-- Recent Reports -->
            <div class="col-lg-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Laporan Terbaru</h4>
                  <p class="card-description">Laporan bencana terbaru yang masuk ke sistem</p>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Tanggal</th>
                          <th>Pelapor</th>
                          <th>Kategori</th>
                          <th>Lokasi</th>
                          <th>Status</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($dashboard['recent_laporan'])): ?>
                          <?php foreach ($dashboard['recent_laporan'] as $laporan): ?>
                          <tr>
                            <td><?php echo date('d/m/Y H:i', strtotime($laporan['created_at'])); ?></td>
                            <td><?php echo htmlspecialchars($laporan['pelapor'] ?? $laporan['nama_pelapor'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($laporan['kategori'] ?? $laporan['jenis_bencana'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($laporan['lokasi'] ?? $laporan['alamat'] ?? ''); ?></td>
                            <td>
                              <span class="badge badge-<?php echo $laporan['status'] === 'selesai' ? 'success' : ($laporan['status'] === 'diproses' ? 'warning' : 'info'); ?>">
                                <?php echo ucfirst($laporan['status']); ?>
                              </span>
                            </td>
                            <td>
                              <button class="btn btn-sm btn-primary" onclick="viewDetail(<?php echo $laporan['id']; ?>)">
                                <i class="mdi mdi-eye"></i>
                              </button>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="6" class="text-center">Belum ada laporan</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="mt-3 text-center">
                    <a href="index.php?controller=laporan&action=index" class="btn btn-sm btn-primary">
                      Lihat Semua Laporan
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Recent Monitoring -->
            <div class="col-lg-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Monitoring Terbaru</h4>
                  <p class="card-description">Kegiatan monitoring terkini</p>
                  <div class="border-bottom py-2">
                    <?php if (!empty($dashboard['recent_monitoring'])): ?>
                      <?php foreach ($dashboard['recent_monitoring'] as $monitoring): ?>
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                          <h6 class="mb-1"><?php echo htmlspecialchars($monitoring['judul'] ?? $monitoring['kegiatan'] ?? ''); ?></h6>
                          <small class="text-muted">
                            <i class="mdi mdi-map-marker"></i>
                            <?php echo htmlspecialchars($monitoring['lokasi'] ?? ''); ?>
                          </small>
                        </div>
                        <div class="text-right">
                          <span class="badge badge-<?php echo $monitoring['status'] === 'selesai' ? 'success' : 'warning'; ?>">
                            <?php echo ucfirst($monitoring['status']); ?>
                          </span>
                          <br>
                          <small class="text-muted">
                            <?php echo date('d M', strtotime($monitoring['created_at'])); ?>
                          </small>
                        </div>
                      </div>
                      <hr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <p class="text-muted">Tidak ada monitoring aktif</p>
                    <?php endif; ?>
                  </div>
                  <div class="mt-3">
                    <a href="index.php?controller=monitoring&action=index" class="btn btn-sm btn-outline-primary btn-block">
                      Lihat Semua Monitoring
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- BMKG Information -->
          <?php if (!empty($dashboard['bmkg_info'])): ?>
          <div class="row mt-4">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Informasi BMKG</h4>
                  <div class="row">
                    <div class="col-md-6">
                      <h5>Gempa Terkini</h5>
                      <?php if (!empty($dashboard['bmkg_info']['gempa'])): ?>
                        <div class="alert alert-info">
                          <strong>Magnitude:</strong> <?php echo $dashboard['bmkg_info']['gempa']['magnitude']; ?> SR<br>
                          <strong>Lokasi:</strong> <?php echo $dashboard['bmkg_info']['gempa']['lokasi']; ?><br>
                          <strong>Kedalaman:</strong> <?php echo $dashboard['bmkg_info']['gempa']['kedalaman']; ?><br>
                          <small class="text-muted"><?php echo $dashboard['bmkg_info']['gempa']['tanggal']; ?></small>
                        </div>
                      <?php else: ?>
                        <p class="text-muted">Tidak ada data gempa terkini</p>
                      <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <h5>Peringatan Cuaca</h5>
                      <?php if (!empty($dashboard['bmkg_info']['cuaca'])): ?>
                        <div class="alert alert-warning">
                          <i class="mdi mdi-alert"></i>
                          <?php echo htmlspecialchars($dashboard['bmkg_info']['cuaca']['pesan'] ?? $dashboard['bmkg_info']['cuaca']['description'] ?? 'Peringatan cuaca aktif'); ?>
                        </div>
                      <?php else: ?>
                        <p class="text-muted">Tidak ada peringatan cuaca</p>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="mt-3 text-center">
                    <a href="index.php?controller=bmkg&action=dashboard" class="btn btn-sm btn-info">
                      <i class="mdi mdi-weather-cloudy"></i> Lihat Detail BMKG
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>

          <!-- Quick Actions -->
          <div class="row mt-4">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Aksi Cepat Admin</h4>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="d-grid">
                        <a href="index.php?controller=users&action=index" class="btn btn-primary">
                          <i class="mdi mdi-account-group"></i>
                          Kelola User
                        </a>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="d-grid">
                        <a href="index.php?controller=laporan&action=index" class="btn btn-info">
                          <i class="mdi mdi-file-document"></i>
                          Semua Laporan
                        </a>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="d-grid">
                        <a href="index.php?controller=monitoring&action=index" class="btn btn-success">
                          <i class="mdi mdi-eye"></i>
                          Monitoring
                        </a>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="d-grid">
                        <a href="index.php?controller=bmkg&action=dashboard" class="btn btn-warning">
                          <i class="mdi mdi-weather-cloudy"></i>
                          BMKG
                        </a>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="d-grid">
                        <a href="index.php?controller=desa&action=index" class="btn btn-secondary">
                          <i class="mdi mdi-map-marker-multiple"></i>
                          Data Desa
                        </a>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="d-grid">
                        <a href="index.php?controller=laporan&action=statistics" class="btn btn-dark">
                          <i class="mdi mdi-chart-pie"></i>
                          Statistik
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <?php include 'template/script.php'; ?>

  <script>
    function viewDetail(id) {
      window.location.href = 'index.php?controller=laporan&action=detail&id=' + id;
    }
  </script>
</body>

</html>