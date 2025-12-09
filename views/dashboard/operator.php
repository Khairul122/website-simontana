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
                <h4 class="mb-3">Dashboard Operator Desa</h4>
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
                      <i class="mdi mdi-file-document text-warning icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="card-text text-right">Total Laporan Desa</p>
                      <div class="fluid-container">
                        <h3 class="card-title font-weight-bold text-right mb-0"><?php echo number_format($dashboard['stats']['total_laporan_desa']); ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <span class="text-success">
                      <i class="mdi mdi-arrow-up-bold"></i>
                      <?php echo $dashboard['stats']['laporan_hari_ini']; ?> hari ini
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
                      <i class="mdi mdi-clock-fast text-info icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="card-text text-right">Menunggu Monitoring</p>
                      <div class="fluid-container">
                        <h3 class="card-title font-weight-bold text-right mb-0"><?php echo number_format($dashboard['stats']['monitoring_menunggu']); ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <span class="text-info">Perlu penanganan segera</span>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <?php
                      $statusClass = $dashboard['stats']['status_desa'] === 'aman' ? 'success' : 'warning';
                      $statusIcon = $dashboard['stats']['status_desa'] === 'aman' ? 'check-circle' : 'alert';
                      ?>
                      <i class="mdi mdi-<?php echo $statusIcon; ?> text-<?php echo $statusClass; ?> icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="card-text text-right">Status Desa</p>
                      <div class="fluid-container">
                        <h3 class="card-title font-weight-bold text-right mb-0 text-uppercase"><?php echo $dashboard['stats']['status_desa']; ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <span class="text-<?php echo $statusClass; ?>">
                      <?php echo $dashboard['stats']['status_desa'] === 'aman' ? 'Kondisi Normal' : 'Waspada Potensi Bencana'; ?>
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
                      <i class="mdi mdi-weather-cloudy text-primary icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="card-text text-right">Cuaca Lokal</p>
                      <div class="fluid-container">
                        <h3 class="card-title font-weight-bold text-right mb-0">
                          <?php echo $dashboard['local_bmkg']['temperature'] ?? '28'; ?>°C
                        </h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <span class="text-primary">
                      <i class="mdi mdi-water"></i>
                      <?php echo $dashboard['local_bmkg']['humidity'] ?? '75'; ?>% Kelembaban
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
                  <h4 class="card-title">Laporan Terbaru Desa</h4>
                  <p class="card-description">Daftar laporan terbaru dari desa Anda</p>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Tanggal</th>
                          <th>Kategori</th>
                          <th>Lokasi</th>
                          <th>Status</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($dashboard['desa_laporan'])): ?>
                          <?php foreach (array_slice($dashboard['desa_laporan'], 0, 5) as $laporan): ?>
                          <tr>
                            <td><?php echo date('d/m/Y', strtotime($laporan['created_at'])); ?></td>
                            <td><?php echo htmlspecialchars($laporan['kategori'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($laporan['lokasi'] ?? ''); ?></td>
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
                            <td colspan="5" class="text-center">Belum ada laporan dari desa</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                  <?php if (count($dashboard['desa_laporan']) > 5): ?>
                  <div class="mt-3 text-center">
                    <a href="index.php?controller=laporan&action=index" class="btn btn-sm btn-primary">
                      Lihat Semua Laporan
                    </a>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <!-- Pending Monitoring -->
            <div class="col-lg-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Monitoring Pending</h4>
                  <p class="card-description">Daftar monitoring yang perlu ditindaklanjuti</p>
                  <div class="list-todo">
                    <?php if (!empty($dashboard['pending_monitoring'])): ?>
                      <?php foreach (array_slice($dashboard['pending_monitoring'], 0, 5) as $monitoring): ?>
                      <div class="list-todo-item">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="checkbox" type="checkbox">
                            <?php echo htmlspecialchars($monitoring['judul'] ?? ''); ?>
                            <i class="input-helper"></i>
                          </label>
                        </div>
                        <div class="text-muted small">
                          <i class="mdi mdi-clock"></i>
                          <?php echo date('d M Y, H:i', strtotime($monitoring['created_at'])); ?>
                        </div>
                      </div>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <p class="text-muted">Tidak ada monitoring pending</p>
                    <?php endif; ?>
                  </div>
                  <?php if (count($dashboard['pending_monitoring']) > 5): ?>
                  <div class="mt-3">
                    <a href="index.php?controller=monitoring&action=index" class="btn btn-sm btn-outline-primary btn-block">
                      Lihat Semua Monitoring
                    </a>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Weather Information -->
          <?php if (!empty($dashboard['local_bmkg']['cuaca']) || !empty($dashboard['local_bmkg']['warnings'])): ?>
          <div class="row mt-4">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Informasi Cuaca BMKG</h4>
                  <div class="row">
                    <?php if (!empty($dashboard['local_bmkg']['cuaca'])): ?>
                    <div class="col-md-6">
                      <h5>Cuaca Saat Ini</h5>
                      <div class="weather-info">
                        <div class="d-flex align-items-center">
                          <i class="mdi mdi-<?php echo $dashboard['local_bmkg']['icon']; ?> text-primary mr-3" style="font-size: 2rem;"></i>
                          <div>
                            <h4 class="mb-0"><?php echo $dashboard['local_bmkg']['temperature']; ?>°C</h4>
                            <p class="mb-0"><?php echo $dashboard['local_bmkg']['description']; ?></p>
                          </div>
                        </div>
                        <div class="mt-3">
                          <span class="badge badge-info">Kelembaban: <?php echo $dashboard['local_bmkg']['humidity']; ?>%</span>
                          <span class="badge badge-info">Angin: <?php echo $dashboard['local_bmkg']['wind']; ?> km/jam</span>
                        </div>
                      </div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($dashboard['local_bmkg']['warnings'])): ?>
                    <div class="col-md-6">
                      <h5>Peringatan Cuaca</h5>
                      <?php foreach (array_slice($dashboard['local_bmkg']['warnings'], 0, 3) as $warning): ?>
                      <div class="alert alert-warning">
                        <i class="mdi mdi-alert"></i>
                        <?php echo htmlspecialchars($warning['pesan'] ?? $warning['description'] ?? ''); ?>
                      </div>
                      <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
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
  <?php include 'template/script.php'; ?>
</body>

</html>