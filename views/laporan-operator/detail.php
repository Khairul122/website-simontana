<?php include('template/header.php'); ?>
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Detail Laporan</h4>

                  <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
                  <?php endif; ?>

                  <?php if (!empty($report)): ?>
                    <!-- Informasi Utama -->
                    <div class="row mb-4">
                      <div class="col-md-8">
                        <h5><?php echo htmlspecialchars($report['judul_laporan'] ?? '-'); ?></h5>
                        <p><?php echo htmlspecialchars($report['deskripsi'] ?? '-'); ?></p>
                      </div>
                      <div class="col-md-4 text-md-right">
                        <div class="d-flex flex-column align-items-md-end">
                          <span class="mb-2">
                            <?php
                            $status = $report['status'] ?? 'Draft';
                            $badge_class = '';
                            switch (strtolower($status)) {
                              case 'draft':
                                $badge_class = 'badge badge-secondary';
                                break;
                              case 'menunggu verifikasi':
                                $badge_class = 'badge badge-warning';
                                break;
                              case 'sedang diproses':
                                $badge_class = 'badge badge-info';
                                break;
                              case 'selesai':
                                $badge_class = 'badge badge-success';
                                break;
                              default:
                                $badge_class = 'badge badge-light';
                                break;
                            }
                            ?>
                            <span class="<?php echo $badge_class; ?> h5"><?php echo htmlspecialchars($status); ?></span>
                          </span>
                          <span class="text-muted">Tingkat Keparahan: <?php echo htmlspecialchars($report['tingkat_keparahan'] ?? '-'); ?></span>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <!-- Grid Kiri: Detail Data Laporan -->
                      <div class="col-md-6">
                        <div class="card mb-3">
                          <div class="card-header">
                            <h5>Detail Data Laporan</h5>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-12">
                                <h6>Judul Laporan</h6>
                                <p><?php echo htmlspecialchars($report['judul_laporan'] ?? '-'); ?></p>

                                <h6>Pelapor</h6>
                                <p>Nama: <?php echo htmlspecialchars($report['pelapor']['nama'] ?? '-'); ?></p>
                                <p>No. Telepon: <?php echo htmlspecialchars($report['pelapor']['no_telepon'] ?? '-'); ?></p>

                                <h6>Kategori</h6>
                                <p><?php echo htmlspecialchars($report['kategori']['nama_kategori'] ?? '-'); ?></p>

                                <h6>Desa</h6>
                                <p><?php echo htmlspecialchars($report['desa']['nama'] ?? '-'); ?></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Grid Kanan: Peta (OSM) dan Foto Bukti -->
                      <div class="col-md-6">
                        <div class="card mb-3">
                          <div class="card-header">
                            <h5>Lokasi & Foto Bukti</h5>
                          </div>
                          <div class="card-body">
                            <!-- Peta OpenStreetMap -->
                            <div class="mb-3">
                              <h6>Lokasi</h6>
                              <?php if (isset($report['latitude']) && isset($report['longitude']) &&
                                        !empty($report['latitude']) && !empty($report['longitude'])): ?>
                                <div id="map" style="height: 300px; width: 100%;"></div>
                                <p class="mt-2">Koordinat: <?php echo $report['latitude'] ?? '-'; ?>, <?php echo $report['longitude'] ?? '-'; ?></p>
                              <?php else: ?>
                                <p class="text-muted">Lokasi tidak tersedia</p>
                              <?php endif; ?>
                            </div>

                            <!-- Foto Bukti -->
                            <div>
                              <h6>Foto Bukti</h6>
                              <?php if (!empty($report['foto_bukti_1'])): ?>
                                <img src="<?php echo htmlspecialchars($report['foto_bukti_1']); ?>" class="img-thumbnail mb-2" alt="Foto Bukti" style="max-width: 200px;">
                              <?php else: ?>
                                <p class="text-muted">Tidak ada foto bukti</p>
                              <?php endif; ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Bagian Bawah: Timeline/History -->
                    <div class="row">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-header">
                            <h5>Timeline & Riwayat Tindakan</h5>
                          </div>
                          <div class="card-body">
                            <!-- Monitoring History -->
                            <?php
                            $monitoring_data = [];
                            if (!empty($report['monitoring'])) {
                                $monitoring_data = $report['monitoring'];
                            } elseif (!empty($report['hasil_monitoring'])) {
                                // If monitoring is not an array but a single result, create an array
                                $monitoring_data = [
                                    [
                                        'hasil_monitoring' => $report['hasil_monitoring'],
                                        'waktu_monitoring' => $report['updated_at'] ?? $report['waktu_laporan'] ?? date('Y-m-d H:i:s')
                                    ]
                                ];
                            }
                            ?>
                            <?php if (!empty($monitoring_data)): ?>
                              <h6>Monitoring:</h6>
                              <div class="timeline mb-4">
                                <?php foreach ($monitoring_data as $monitor): ?>
                                  <div class="timeline-item">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                      <p><?php echo htmlspecialchars($monitor['hasil_monitoring'] ?? '-'); ?></p>
                                      <small class="text-muted"><?php echo date('d M Y H:i', strtotime($monitor['waktu_monitoring'] ?? '')); ?></small>
                                    </div>
                                  </div>
                                <?php endforeach; ?>
                              </div>
                            <?php endif; ?>

                            <!-- Tindak Lanjut History -->
                            <?php if (!empty($report['tindak_lanjut'])): ?>
                              <h6>Tindak Lanjut:</h6>
                              <div class="timeline">
                                <?php foreach ($report['tindak_lanjut'] as $tindak): ?>
                                  <div class="timeline-item">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                      <p>Status: <?php echo htmlspecialchars($tindak['status'] ?? '-'); ?></p>
                                      <p>Petugas: <?php echo htmlspecialchars($tindak['petugas']['nama'] ?? '-'); ?></p>
                                      <small class="text-muted"><?php echo date('d M Y H:i', strtotime($tindak['created_at'] ?? $tindak['waktu_tindak_lanjut'] ?? '')); ?></small>
                                    </div>
                                  </div>
                                <?php endforeach; ?>
                              </div>
                            <?php endif; ?>

                            <?php if (empty($report['monitoring']) && empty($report['tindak_lanjut'])): ?>
                              <p class="text-muted">Belum ada riwayat monitoring atau tindak lanjut</p>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="mt-3">
                      <a href="index.php?controller=LaporanOperator&action=index" class="btn btn-secondary">Kembali ke Daftar</a>
                      <a href="index.php?controller=LaporanOperator&action=edit-status&id=<?php echo $report['id']; ?>" class="btn btn-warning">Edit Status</a>
                    </div>
                  <?php else: ?>
                    <div class="alert alert-warning">Data laporan tidak ditemukan.</div>
                    <a href="index.php?controller=LaporanOperator&action=index" class="btn btn-secondary">Kembali ke Daftar</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include 'template/script.php'; ?>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <script>
    <?php if (isset($report['latitude']) && isset($report['longitude']) &&
              !empty($report['latitude']) && !empty($report['longitude'])): ?>
      // Initialize the map
      var map = L.map('map').setView([<?php echo $report['latitude']; ?>, <?php echo $report['longitude']; ?>], 15);

      // Add OpenStreetMap tiles
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);

      // Add marker to the map
      var marker = L.marker([<?php echo $report['latitude']; ?>, <?php echo $report['longitude']; ?>]).addTo(map);

      // Add popup to the marker
      marker.bindPopup("<?php echo addslashes(htmlspecialchars($report['judul_laporan'] ?? 'Laporan Bencana')); ?>").openPopup();
    <?php endif; ?>
  </script>

  <style>
    .timeline {
      position: relative;
      padding-left: 20px;
    }

    .timeline-item {
      position: relative;
      margin-bottom: 20px;
    }

    .timeline-marker {
      position: absolute;
      left: -26px;
      top: 5px;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: #007bff;
    }

    .timeline-content {
      padding-left: 15px;
    }
  </style>
</body>
</html>