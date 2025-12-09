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
                <h4 class="mb-3">Dashboard Petugas BPBD</h4>
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
                      <i class="mdi mdi-clock-outline text-info icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="card-text text-right">Laporan Menunggu</p>
                      <div class="fluid-container">
                        <h3 class="card-title font-weight-bold text-right mb-0"><?php echo number_format($dashboard['stats']['laporan_menunggu']); ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <span class="text-info">
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
                      <i class="mdi mdi-progress-clock text-warning icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="card-text text-right">Laporan Diproses</p>
                      <div class="fluid-container">
                        <h3 class="card-title font-weight-bold text-right mb-0"><?php echo number_format($dashboard['stats']['laporan_diproses']); ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <span class="text-warning">
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
                      <p class="card-text text-right">Laporan Selesai</p>
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

            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-alert text-danger icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="card-text text-right">Peringatan Aktif</p>
                      <div class="fluid-container">
                        <h3 class="card-title font-weight-bold text-right mb-0"><?php echo number_format($dashboard['stats']['peringatan_aktif']); ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <span class="text-danger">
                      <i class="mdi mdi-bell"></i>
                      Waspada bencana
                    </span>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->
          <div class="row">
            <!-- Pending Reports -->
            <div class="col-lg-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Laporan Menunggu Verifikasi</h4>
                  <p class="card-description">Laporan dari masyarakat yang perlu diverifikasi oleh BPBD</p>
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
                        <?php if (!empty($dashboard['pending_laporan'])): ?>
                          <?php foreach (array_slice($dashboard['pending_laporan'], 0, 5) as $laporan): ?>
                          <tr>
                            <td><?php echo date('d/m/Y', strtotime($laporan['created_at'])); ?></td>
                            <td><?php echo htmlspecialchars($laporan['pelapor'] ?? $laporan['nama_pelapor'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($laporan['kategori'] ?? $laporan['jenis_bencana'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($laporan['lokasi'] ?? $laporan['alamat'] ?? ''); ?></td>
                            <td>
                              <span class="badge badge-info">Menunggu</span>
                            </td>
                            <td>
                              <button class="btn btn-sm btn-primary" onclick="verifyReport(<?php echo $laporan['id']; ?>)">
                                <i class="mdi mdi-check"></i> Verifikasi
                              </button>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="6" class="text-center">Tidak ada laporan menunggu verifikasi</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                  <?php if (count($dashboard['pending_laporan']) > 5): ?>
                  <div class="mt-3 text-center">
                    <a href="index.php?controller=laporan&action=pending" class="btn btn-sm btn-primary">
                      Lihat Semua Laporan Menunggu
                    </a>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <!-- Recent Monitoring -->
            <div class="col-lg-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Monitoring Terbaru</h4>
                  <p class="card-description">Kegiatan monitoring yang sedang berlangsung</p>
                  <div class="border-bottom py-2">
                    <?php if (!empty($dashboard['recent_monitoring'])): ?>
                      <?php foreach (array_slice($dashboard['recent_monitoring'], 0, 4) as $monitoring): ?>
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
                            <?php echo date('H:i', strtotime($monitoring['created_at'])); ?>
                          </small>
                        </div>
                      </div>
                      <hr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <p class="text-muted">Tidak ada monitoring aktif</p>
                    <?php endif; ?>
                  </div>
                  <?php if (count($dashboard['recent_monitoring']) > 4): ?>
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

          <!-- BMKG Warnings -->
          <?php if (!empty($dashboard['bmkg_warnings'])): ?>
          <div class="row mt-4">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Peringatan Cuaca BMKG</h4>
                  <div class="row">
                    <?php foreach (array_slice($dashboard['bmkg_warnings'], 0, 4) as $warning): ?>
                    <div class="col-md-6 col-lg-3">
                      <div class="alert alert-<?php echo $warning['level'] === 'high' ? 'danger' : ($warning['level'] === 'medium' ? 'warning' : 'info'); ?>">
                        <h5 class="alert-heading">
                          <i class="mdi mdi-<?php echo $warning['icon'] ?? 'alert'; ?>"></i>
                          <?php echo htmlspecialchars($warning['jenis'] ?? $warning['title'] ?? 'Peringatan Cuaca'); ?>
                        </h5>
                        <p class="mb-1">
                          <strong>Wilayah:</strong> <?php echo htmlspecialchars($warning['wilayah'] ?? $warning['area'] ?? ''); ?>
                        </p>
                        <p class="mb-0">
                          <?php echo htmlspecialchars($warning['pesan'] ?? $warning['description'] ?? ''); ?>
                        </p>
                        <small class="text-muted">
                          <i class="mdi mdi-clock"></i>
                          <?php echo date('d M Y, H:i', strtotime($warning['created_at'] ?? $warning['issued_at'] ?? 'now')); ?>
                        </small>
                      </div>
                    </div>
                    <?php endforeach; ?>
                  </div>
                  <?php if (count($dashboard['bmkg_warnings']) > 4): ?>
                  <div class="mt-3 text-center">
                    <a href="index.php?controller=bmkg&action=warnings" class="btn btn-sm btn-warning">
                      Lihat Semua Peringatan
                    </a>
                  </div>
                  <?php endif; ?>
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
                  <h4 class="card-title">Aksi Cepat</h4>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="d-grid">
                        <a href="index.php?controller=laporan&action=create" class="btn btn-primary">
                          <i class="mdi mdi-plus-circle"></i>
                          Buat Laporan Baru
                        </a>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="d-grid">
                        <a href="index.php?controller=monitoring&action=create" class="btn btn-success">
                          <i class="mdi mdi-eye-plus"></i>
                          Tambah Monitoring
                        </a>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="d-grid">
                        <a href="index.php?controller=bmkg&action=dashboard" class="btn btn-info">
                          <i class="mdi mdi-weather-cloudy"></i>
                          Info BMKG
                        </a>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="d-grid">
                        <a href="index.php?controller=tindaklanjut&action=index" class="btn btn-warning">
                          <i class="mdi mdi-clipboard-check"></i>
                          Tindak Lanjut
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
    function verifyReport(id) {
      if (confirm('Apakah Anda yakin ingin memverifikasi laporan ini?')) {
        window.location.href = 'index.php?controller=laporan&action=verify&id=' + id;
      }
    }

    function viewDetail(id) {
      window.location.href = 'index.php?controller=laporan&action=detail&id=' + id;
    }
  </script>
</body>

</html>