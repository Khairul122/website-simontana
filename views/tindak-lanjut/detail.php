<?php include('template/header.php'); ?>

<body class="with-welcome-text">
  <div class="container-scroller">
    <?php include 'template/navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include 'template/setting_panel.php'; ?>
      <?php include 'template/sidebar.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row mb-4">
             <div class="col-sm-12">
                <h3 class="font-weight-bold">Detail Tindak Lanjut</h3>
                <div class="d-flex justify-content-between">
                  <a href="index.php?controller=TindakLanjut&action=index" class="btn btn-secondary">Kembali ke Daftar</a>
                </div>
             </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <?php if (isset($error_message)): ?>
              <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Kesalahan!</h4>
                <p><?php echo htmlspecialchars($error_message); ?></p>
              </div>
              <?php endif; ?>

              <?php if (isset($tindakLanjut) && $tindakLanjut): ?>
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <h4 class="card-title">Tindak Lanjut ID: <?php echo $tindakLanjut['id_tindaklanjut'] ?? '-'; ?></h4>
                      
                      <div class="row">
                        <div class="col-md-6">
                          <table class="table table-borderless">
                            <tr>
                              <td width="30%"><strong>ID Tindak Lanjut</strong></td>
                              <td><?php echo $tindakLanjut['id_tindaklanjut'] ?? '-'; ?></td>
                            </tr>
                            <tr>
                              <td><strong>Tanggal Tanggapan</strong></td>
                              <td><?php echo date('d M Y H:i', strtotime($tindakLanjut['tanggal_tanggapan'] ?? 'now')); ?></td>
                            </tr>
                            <tr>
                              <td><strong>Status</strong></td>
                              <td>
                                <?php
                                  $status = $tindakLanjut['status'] ?? '-';
                                  $badgeClass = '';

                                  // Sesuaikan status dengan format yang mungkin dikembalikan API
                                  switch(strtolower($status)) {
                                    case 'menuju lokasi':
                                      $badgeClass = 'badge-info';
                                      $displayText = 'Menuju Lokasi';
                                      break;
                                    case 'sedang ditangani':
                                      $badgeClass = 'badge-warning';
                                      $displayText = 'Sedang Ditangani';
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
                            </tr>
                            <tr>
                              <td><strong>Keterangan</strong></td>
                              <td><?php echo htmlspecialchars($tindakLanjut['keterangan'] ?? '-'); ?></td>
                            </tr>
                          </table>
                        </div>
                        
                        <div class="col-md-6">
                          <table class="table table-borderless">
                            <tr>
                              <td width="30%"><strong>Nama Petugas</strong></td>
                              <td><?php echo htmlspecialchars($tindakLanjut['petugas']['nama'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                              <td><strong>Nama Petugas</strong></td>
                              <td><?php echo htmlspecialchars($tindakLanjut['petugas']['nama'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                              <td><strong>Judul Laporan</strong></td>
                              <td><?php echo htmlspecialchars($tindakLanjut['laporan']['judul_laporan'] ?? '-'); ?></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      
                      <!-- Laporan Information -->
                      <div class="mt-4">
                        <h5>Informasi Laporan Terkait</h5>
                        <table class="table table-borderless">
                          <tr>
                            <td width="30%"><strong>Deskripsi Laporan</strong></td>
                            <td><?php echo htmlspecialchars($tindakLanjut['laporan']['deskripsi'] ?? '-'); ?></td>
                          </tr>
                          <tr>
                            <td><strong>Nama Pelapor</strong></td>
                            <td><?php
                              $namaPelapor = $tindakLanjut['laporan']['pelapor']['nama']
                                             ?? $tindakLanjut['laporan']['nama_pelapor']
                                             ?? 'Warga';
                              echo htmlspecialchars($namaPelapor);
                            ?></td>
                          </tr>
                          <tr>
                            <td><strong>Alamat Lengkap</strong></td>
                            <td><?php echo htmlspecialchars($tindakLanjut['laporan']['alamat_lengkap'] ?? '-'); ?></td>
                          </tr>
                        </table>

                        <!-- Dokumentasi Bukti -->
                        <div class="mt-4">
                          <h6>Dokumentasi Bukti</h6>
                          <div class="row">
                            <?php if (!empty($tindakLanjut['laporan']['foto_bukti_1'])): ?>
                            <div class="col-md-4 mb-2">
                              <a href="<?php echo $tindakLanjut['laporan']['foto_bukti_1_url'] ?? $tindakLanjut['laporan']['foto_bukti_1']; ?>" target="_blank">
                                <img src="<?php echo $tindakLanjut['laporan']['foto_bukti_1_url'] ?? $tindakLanjut['laporan']['foto_bukti_1']; ?>" alt="Foto Bukti 1" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                              </a>
                              <small class="text-muted">Foto Bukti 1</small>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($tindakLanjut['laporan']['foto_bukti_2'])): ?>
                            <div class="col-md-4 mb-2">
                              <a href="<?php echo $tindakLanjut['laporan']['foto_bukti_2_url'] ?? $tindakLanjut['laporan']['foto_bukti_2']; ?>" target="_blank">
                                <img src="<?php echo $tindakLanjut['laporan']['foto_bukti_2_url'] ?? $tindakLanjut['laporan']['foto_bukti_2']; ?>" alt="Foto Bukti 2" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                              </a>
                              <small class="text-muted">Foto Bukti 2</small>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($tindakLanjut['laporan']['foto_bukti_3'])): ?>
                            <div class="col-md-4 mb-2">
                              <a href="<?php echo $tindakLanjut['laporan']['foto_bukti_3_url'] ?? $tindakLanjut['laporan']['foto_bukti_3']; ?>" target="_blank">
                                <img src="<?php echo $tindakLanjut['laporan']['foto_bukti_3_url'] ?? $tindakLanjut['laporan']['foto_bukti_3']; ?>" alt="Foto Bukti 3" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                              </a>
                              <small class="text-muted">Foto Bukti 3</small>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($tindakLanjut['laporan']['video_bukti'])): ?>
                            <div class="col-md-4 mb-2">
                              <video width="100%" height="150" controls>
                                <source src="<?php echo $tindakLanjut['laporan']['video_bukti_url'] ?? $tindakLanjut['laporan']['video_bukti']; ?>" type="video/mp4">
                                Browser tidak mendukung pemutar video.
                              </video>
                              <small class="text-muted">Video Bukti</small>
                            </div>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                      
                      <!-- Foto Kegiatan -->
                      <?php if (isset($tindakLanjut['foto_kegiatan']) && !empty($tindakLanjut['foto_kegiatan'])): ?>
                      <div class="mt-4">
                        <h5>Foto Kegiatan</h5>
                        <img src="<?php echo $tindakLanjut['foto_kegiatan']; ?>" alt="Foto Kegiatan Tindak Lanjut" class="img-fluid" style="max-height: 300px; object-fit: cover;">
                      </div>
                      <?php endif; ?>

                      <!-- Peta Lokasi -->
                      <div class="mt-4">
                        <h5>Lokasi Kejadian</h5>
                        <div id="map" style="height: 400px; width: 100%; border: 1px solid #ddd; border-radius: 4px;"></div>

                        <div class="mt-3">
                          <p><strong>Koordinat:</strong></p>
                          <p>Latitude: <?php echo $tindakLanjut['laporan']['latitude'] ?? '-'; ?></p>
                          <p>Longitude: <?php echo $tindakLanjut['laporan']['longitude'] ?? '-'; ?></p>
                        </div>
                      </div>

                      <!-- Action Buttons -->
                      <div class="mt-4">
                        <a href="index.php?controller=TindakLanjut&action=edit&id=<?php echo $tindakLanjut['id_tindaklanjut']; ?>" class="btn btn-warning">Edit</a>
                        <a href="index.php?controller=LaporanPetugas&action=detail&id=<?php echo $tindakLanjut['laporan_id']; ?>" class="btn btn-info">Lihat Laporan</a>
                        <a href="index.php?controller=TindakLanjut&action=index" class="btn btn-secondary">Kembali ke Daftar</a>
                      </div>
                    </div>
                    
                    <div class="col-md-4">
                      <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Ringkasan</h5>
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                              <strong>Status:</strong>
                              <span class="float-right">
                                <?php
                                  $status_sidebar = $tindakLanjut['status'] ?? '-';
                                  $badgeClass_sidebar = '';

                                  // Sesuaikan status dengan format yang mungkin dikembalikan API
                                  switch(strtolower($status_sidebar)) {
                                    case 'menuju lokasi':
                                      $badgeClass_sidebar = 'badge-info';
                                      $displayText_sidebar = 'Menuju Lokasi';
                                      break;
                                    case 'sedang ditangani':
                                      $badgeClass_sidebar = 'badge-warning';
                                      $displayText_sidebar = 'Sedang Ditangani';
                                      break;
                                    case 'selesai':
                                      $badgeClass_sidebar = 'badge-success';
                                      $displayText_sidebar = 'Selesai';
                                      break;
                                    case 'ditolak':
                                      $badgeClass_sidebar = 'badge-danger';
                                      $displayText_sidebar = 'Ditolak';
                                      break;
                                    default:
                                      $badgeClass_sidebar = 'badge-secondary';
                                      $displayText_sidebar = $status_sidebar;
                                  }
                                ?>
                                <label class="badge <?php echo $badgeClass_sidebar; ?>"><?php echo $displayText_sidebar; ?></label>
                              </span>
                            </li>
                            <li class="list-group-item">
                              <strong>Tanggal:</strong> 
                              <span class="float-right"><?php echo date('d M Y', strtotime($tindakLanjut['tanggal_tanggapan'] ?? 'now')); ?></span>
                            </li>
                            <li class="list-group-item">
                              <strong>Petugas:</strong> 
                              <span class="float-right"><?php echo htmlspecialchars($tindakLanjut['petugas']['nama'] ?? '-'); ?></span>
                            </li>
                            <li class="list-group-item">
                              <strong>Laporan:</strong> 
                              <span class="float-right"><?php echo htmlspecialchars($tindakLanjut['laporan']['judul_laporan'] ?? '-'); ?></span>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php else: ?>
              <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">Data Tidak Ditemukan!</h4>
                <p>Tindak lanjut dengan ID yang dimaksud tidak ditemukan atau telah dihapus.</p>
                <a href="index.php?controller=TindakLanjut&action=index" class="btn btn-primary">Kembali ke Daftar</a>
              </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        </div>
    </div>
  </div>
  <?php include 'template/script.php'; ?>

  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Get coordinates from PHP
      const latitude = <?php echo json_encode($tindakLanjut['laporan']['latitude'] ?? -6.200000); ?>;
      const longitude = <?php echo json_encode($tindakLanjut['laporan']['longitude'] ?? 106.816666); ?>;

      // Initialize the map
      const map = L.map('map').setView([latitude, longitude], 15);

      // Add OpenStreetMap tiles
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);

      // Add marker to the map
      const marker = L.marker([latitude, longitude]).addTo(map);

      // Add popup to the marker
      marker.bindPopup('<b>Lokasi Kejadian Bencana</b><br><?php echo addslashes(htmlspecialchars($tindakLanjut['laporan']['judul_laporan'] ?? 'Lokasi Bencana')); ?>').openPopup();
    });
  </script>

  <?php if (isset($_SESSION['toast'])): ?>
    <script>
        // Clean strings to prevent JS errors
        var title = "<?php echo addslashes($_SESSION['toast']['title'] ?? ''); ?>";
        var message = "<?php echo addslashes($_SESSION['toast']['message'] ?? ''); ?>";

        // Display native alert
        if (title && title !== 'null') {
            alert(title + "\n\n" + message);
        } else {
            alert(message);
        }
        <?php unset($_SESSION['toast']); ?>
    </script>
  <?php endif; ?>

</body>
</html>