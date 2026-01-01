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
             <div class="col-sm-12 mb-4">
                <h3 class="font-weight-bold">Detail Laporan Bencana</h3>
                <a href="index.php?controller=LaporanPetugas&action=index" class="btn btn-secondary">Kembali ke Daftar</a>
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

              <?php if (isset($laporan) && $laporan): ?>
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8">
                      <h4 class="card-title"><?php echo htmlspecialchars($laporan['judul_laporan'] ?? '-'); ?></h4>
                      <p class="card-text"><?php echo htmlspecialchars($laporan['deskripsi'] ?? '-'); ?></p>
                      
                      <div class="row">
                        <div class="col-md-6">
                          <table class="table table-borderless">
                            <tr>
                              <td width="30%"><strong>ID Laporan</strong></td>
                              <td><?php echo $laporan['id'] ?? '-'; ?></td>
                            </tr>
                            <tr>
                              <td><strong>Kategori</strong></td>
                              <td><?php echo htmlspecialchars($laporan['kategori']['nama_kategori'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                              <td><strong>Tingkat Keparahan</strong></td>
                              <td>
                                <?php
                                  $tingkat = $laporan['tingkat_keparahan'] ?? '-';
                                  $tingkatClass = '';
                                  switch(strtolower($tingkat)) {
                                    case 'rendah':
                                      $tingkatClass = 'text-success';
                                      break;
                                    case 'sedang':
                                      $tingkatClass = 'text-warning';
                                      break;
                                    case 'tinggi':
                                      $tingkatClass = 'text-danger';
                                      break;
                                    case 'sangat tinggi':
                                      $tingkatClass = 'text-dark';
                                      break;
                                    default:
                                      $tingkatClass = '';
                                  }
                                ?>
                                <span class="<?php echo $tingkatClass; ?>"><strong><?php echo $tingkat; ?></strong></span>
                              </td>
                            </tr>
                            <tr>
                              <td><strong>Status</strong></td>
                              <td>
                                <?php
                                  $status = $laporan['status'] ?? '-';
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
                                    case 'tindak lanjut':
                                      $badgeClass = 'badge-warning';
                                      $displayText = 'Tindak Lanjut';
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
                              <td><strong>Waktu Laporan</strong></td>
                              <td><?php echo date('d M Y H:i', strtotime($laporan['waktu_laporan'] ?? 'now')); ?></td>
                            </tr>
                          </table>
                        </div>
                        
                        <div class="col-md-6">
                          <table class="table table-borderless">
                            <tr>
                              <td width="30%"><strong>Nama Pelapor</strong></td>
                              <td><?php echo htmlspecialchars($laporan['pelapor']['nama'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                              <td><strong>No. Telepon</strong></td>
                              <td><?php echo htmlspecialchars($laporan['pelapor']['no_telepon'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                              <td><strong>Email</strong></td>
                              <td><?php echo htmlspecialchars($laporan['pelapor']['email'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                              <td><strong>Alamat Lengkap</strong></td>
                              <td><?php echo htmlspecialchars($laporan['alamat_lengkap'] ?? '-'); ?></td>
                            </tr>
                            <tr>
                              <td><strong>Wilayah</strong></td>
                              <td><?php echo htmlspecialchars($laporan['administrative_area'] ?? '-'); ?></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      
                      <!-- Tindak Lanjut Section -->
                      <?php if (isset($laporan['tindak_lanjut']) && !empty($laporan['tindak_lanjut'])): ?>
                      <div class="mt-4">
                        <h5>Tindak Lanjut</h5>
                        <div class="table-responsive">
                          <table class="table table-sm">
                            <thead>
                              <tr>
                                <th>Tanggal Tanggapan</th>
                                <th>Status</th>
                                <th>Petugas</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($laporan['tindak_lanjut'] as $tindak): ?>
                              <tr>
                                <td><?php echo date('d M Y H:i', strtotime($tindak['tanggal_tanggapan'] ?? 'now')); ?></td>
                                <td><?php echo htmlspecialchars($tindak['status'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($tindak['petugas']['nama'] ?? '-'); ?></td>
                              </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <?php endif; ?>
                      
                      <!-- Monitoring Section -->
                      <?php if (isset($laporan['monitoring']) && !empty($laporan['monitoring'])): ?>
                      <div class="mt-4">
                        <h5>Monitoring</h5>
                        <div class="table-responsive">
                          <table class="table table-sm">
                            <thead>
                              <tr>
                                <th>Waktu Monitoring</th>
                                <th>Hasil Monitoring</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($laporan['monitoring'] as $monitor): ?>
                              <tr>
                                <td><?php echo date('d M Y H:i', strtotime($monitor['waktu_monitoring'] ?? 'now')); ?></td>
                                <td><?php echo htmlspecialchars($monitor['hasil_monitoring'] ?? '-'); ?></td>
                              </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <?php endif; ?>
                      
                      <!-- Action Buttons -->
                      <div class="mt-4">
                        <a href="index.php?controller=LaporanPetugas&action=edit&id=<?php echo $laporan['id']; ?>" class="btn btn-warning">Edit Status</a>
                        
                        <!-- Quick Status Update Buttons -->
                        <div class="btn-group ml-2" role="group">
                          <form method="POST" action="index.php?controller=LaporanPetugas&action=updateToProses&id=<?php echo $laporan['id']; ?>" style="display:inline;" onsubmit="return confirm('Yakin ingin mengubah status menjadi Diproses?');">
                            <button type="submit" class="btn btn-primary btn-sm">Diproses</button>
                          </form>
                          <form method="POST" action="index.php?controller=LaporanPetugas&action=updateToSelesai&id=<?php echo $laporan['id']; ?>" style="display:inline;" onsubmit="return confirm('Yakin ingin mengubah status menjadi Selesai?');">
                            <button type="submit" class="btn btn-success btn-sm">Selesai</button>
                          </form>
                          <form method="POST" action="index.php?controller=LaporanPetugas&action=updateToDitolak&id=<?php echo $laporan['id']; ?>" style="display:inline;" onsubmit="return confirm('Yakin ingin menolak laporan ini?');">
                            <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                          </form>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-md-4">
                      <h5>Lokasi Kejadian</h5>
                      <div id="map" style="height: 400px; width: 100%; border: 1px solid #ddd; border-radius: 4px;"></div>
                      
                      <div class="mt-3">
                        <p><strong>Koordinat:</strong></p>
                        <p>Latitude: <?php echo $laporan['latitude'] ?? '-'; ?></p>
                        <p>Longitude: <?php echo $laporan['longitude'] ?? '-'; ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php else: ?>
              <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">Data Tidak Ditemukan!</h4>
                <p>Laporan dengan ID yang dimaksud tidak ditemukan atau telah dihapus.</p>
                <a href="index.php?controller=LaporanPetugas&action=index" class="btn btn-primary">Kembali ke Daftar</a>
              </div>
              <?php endif; ?>
            </div>
          </div>

        </div>
        </div>
    </div>
  </div>
  <?php include 'template/script.php'; ?>
  
  <?php if (isset($_SESSION['toast'])): ?>
    <script>
        setTimeout(function() {
            showToast('<?php echo $_SESSION['toast']['type']; ?>', '<?php echo $_SESSION['toast']['title']; ?>', '<?php echo $_SESSION['toast']['message']; ?>');
        }, 500);
        <?php unset($_SESSION['toast']); ?>
    </script>
  <?php endif; ?>
  
  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  
  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Get coordinates from PHP
      const latitude = <?php echo json_encode($laporan['latitude'] ?? -6.200000); ?>;
      const longitude = <?php echo json_encode($laporan['longitude'] ?? 106.816666); ?>;
      
      // Initialize the map
      const map = L.map('map').setView([latitude, longitude], 15);
      
      // Add OpenStreetMap tiles
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);
      
      // Add marker to the map
      const marker = L.marker([latitude, longitude]).addTo(map);
      
      // Add popup to the marker
      marker.bindPopup('<b>Lokasi Kejadian Bencana</b><br><?php echo addslashes(htmlspecialchars($laporan['judul_laporan'] ?? 'Lokasi Bencana')); ?>').openPopup();
    });
  </script>
</body>
</html>