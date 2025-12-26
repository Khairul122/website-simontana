<?php include('template/header.php'); ?>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
  .card {
    border: none;
    box-shadow: 0 0.1rem 0.7rem rgba(0, 0, 0, 0.1);
    border-radius: 0.5rem;
    transition: all 0.3s ease;
  }
  
  .card:hover {
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15);
  }
  
  .page-title {
    font-weight: 600;
    color: #2c2c2c;
  }
  
  .card-title {
    font-weight: 600;
    color: #2c2c2c;
  }
  
  .detail-label {
    font-weight: 500;
    color: #495057;
  }
  
  .detail-value {
    color: #212529;
    font-weight: 400;
  }
  
  .status-badge {
    font-size: 0.85em;
    font-weight: 500;
    padding: 0.5em 0.75em;
    border-radius: 0.375rem;
  }
  
  .info-card {
    background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
  }
  
  .location-card {
    background: linear-gradient(135deg, #f0f7ff 0%, #e6f0ff 100%);
  }
  
  .evidence-card {
    background: linear-gradient(135deg, #fff5f5 0%, #f8f0f0 100%);
  }
  
  .detail-section {
    margin-bottom: 1.5rem;
    padding: 1.5rem;
    border-radius: 0.5rem;
  }
  
  .map-container {
    height: 500px;
    width: 100%;
    border-radius: 0 0 0.5rem 0.5rem;
    overflow: hidden;
    border: none;
    position: relative;
    margin: 0;
  }
  
  #map {
    height: 100%;
    width: 100%;
  }
  
  .leaflet-container {
    height: 100%;
    width: 100%;
  }
  
  .image-preview {
    position: relative;
    overflow: hidden;
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
  }
  
  .image-preview img {
    transition: transform 0.3s ease;
  }
  
  .image-preview:hover img {
    transform: scale(1.05);
  }
  
  .no-evidence {
    background-color: #f8f9fa;
    border: 1px dashed #dee2e6;
    border-radius: 0.5rem;
    padding: 1rem;
    text-align: center;
    color: #6c757d;
  }
  
  .video-preview {
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
  }
  
  .btn-action {
    border-radius: 0.375rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
  }
  
  .info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
  }
  
  .info-item {
    background: white;
    padding: 1rem;
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
  }
  
  .info-label {
    font-size: 0.85rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
  }
  
  .info-value {
    font-size: 1rem;
    font-weight: 500;
    color: #212529;
  }
  
  .evidence-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
  }
  
  .evidence-item {
    text-align: center;
  }
  
  .evidence-label {
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 0.5rem;
  }
  
  .modal-backdrop {
    background-color: rgba(0, 0, 0, 0.8);
  }
  
  .modal-content {
    border-radius: 0.5rem;
    border: none;
  }
</style>

<body class="with-welcome-text">
  <div class="container-scroller">
    <?php include 'template/navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include 'template/setting_panel.php'; ?>
      <?php include 'template/sidebar.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12">
              <div class="page-header">
                <h3 class="page-title">Detail Laporan Bencana</h3>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="index.php?controller=LaporanAdmin&action=index">Laporan Bencana</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Laporan</li>
                  </ol>
                </nav>
              </div>

              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                        <div>
                          <h4 class="card-title mb-1">Detail Laporan Bencana</h4>
                          <p class="card-description mb-0">Informasi lengkap tentang laporan bencana</p>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                          <a href="index.php?controller=LaporanAdmin&action=edit&id=<?php echo $laporan['id']; ?>" class="btn btn-warning btn-action">
                            <i class="mdi mdi-pencil me-1"></i> Edit
                          </a>
                          <a href="index.php?controller=LaporanAdmin&action=index" class="btn btn-outline-secondary btn-action">
                            <i class="mdi mdi-arrow-left me-1"></i> Kembali
                          </a>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-8">
                          <div class="card info-card detail-section">
                            <h5 class="card-title mb-4 pb-2 border-bottom">
                              <i class="mdi mdi-information me-2 text-primary"></i> Informasi Laporan
                            </h5>

                            <div class="info-grid">
                              <div class="info-item">
                                <div class="info-label">Judul Laporan</div>
                                <div class="info-value"><?php echo htmlspecialchars($laporan['judul_laporan'] ?? $laporan['judul'] ?? $laporan['name'] ?? ''); ?></div>
                              </div>

                              <div class="info-item">
                                <div class="info-label">Status</div>
                                <div>
                                  <?php
                                    $status = $laporan['status'] ?? '';
                                    $badgeClass = '';
                                    switch ($status) {
                                      case 'Menunggu Verifikasi':
                                        $badgeClass = 'bg-warning text-dark';
                                        break;
                                      case 'Diproses':
                                        $badgeClass = 'bg-info text-white';
                                        break;
                                      case 'Selesai':
                                        $badgeClass = 'bg-success text-white';
                                        break;
                                      case 'Ditolak':
                                        $badgeClass = 'bg-danger text-white';
                                        break;
                                      default:
                                        $badgeClass = 'bg-secondary text-white';
                                    }
                                  ?>
                                  <span class="status-badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($status); ?></span>
                                </div>
                              </div>

                              <div class="info-item">
                                <div class="info-label">Tanggal Laporan</div>
                                <div class="info-value"><?php echo date('d M Y H:i', strtotime($laporan['waktu_laporan'] ?? $laporan['created_at'] ?? '')); ?></div>
                              </div>

                              <div class="info-item">
                                <div class="info-label">Tingkat Keparahan</div>
                                <div class="info-value"><?php echo htmlspecialchars($laporan['tingkat_keparahan'] ?? $laporan['tingkat_kedaruratan'] ?? ''); ?></div>
                              </div>

                              <div class="info-item">
                                <div class="info-label">Pelapor</div>
                                <div class="info-value"><?php echo htmlspecialchars($laporan['pelapor']['nama'] ?? $laporan['pelapor']['username'] ?? $laporan['user']['nama'] ?? $laporan['user']['username'] ?? ''); ?></div>
                              </div>

                              <div class="info-item">
                                <div class="info-label">No. Telepon</div>
                                <div class="info-value"><?php echo htmlspecialchars($laporan['pelapor']['no_telepon'] ?? $laporan['user']['no_telepon'] ?? '-'); ?></div>
                              </div>

                              <div class="info-item">
                                <div class="info-label">Jumlah Korban</div>
                                <div class="info-value"><?php echo $laporan['jumlah_korban'] ?? 0; ?></div>
                              </div>

                              <div class="info-item">
                                <div class="info-label">Jumlah Rumah Rusak</div>
                                <div class="info-value"><?php echo $laporan['jumlah_rumah_rusak'] ?? 0; ?></div>
                              </div>
                            </div>

                            <div class="mt-4">
                              <h6 class="detail-label mb-2">Deskripsi Laporan</h6>
                              <div class="border rounded p-3 bg-light">
                                <p class="mb-0 detail-value"><?php echo htmlspecialchars($laporan['deskripsi'] ?? ''); ?></p>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-lg-4">
                          <div class="card location-card detail-section mb-4 overflow-hidden">
                            <div class="card-header bg-white border-0 p-3 pt-3 pb-3">
                              <h5 class="card-title mb-0">
                                <i class="mdi mdi-map-marker me-2 text-primary"></i> Lokasi Kejadian
                              </h5>
                            </div>
                            
                            <div class="card-body p-0 m-0">
                              <div id="map" style="height: 500px; width: 100%; min-height: 500px; z-index: 1;"></div>
                            </div>

                            <div class="p-3 pt-3">
                              <h6 class="detail-label mb-2">Alamat Lengkap</h6>
                              <div class="border rounded p-3 bg-light">
                                <p class="mb-0 detail-value"><?php echo htmlspecialchars($laporan['alamat_lengkap'] ?? ''); ?></p>
                              </div>
                            </div>

                            <div class="p-3 pt-0">
                              <h6 class="detail-label mb-2">Koordinat</h6>
                              <div class="row">
                                <div class="col-md-6">
                                  <small class="text-muted">Latitude</small>
                                  <p class="mb-0 detail-value"><?php echo $laporan['latitude'] ?? '-'; ?></p>
                                </div>
                                <div class="col-md-6">
                                  <small class="text-muted">Longitude</small>
                                  <p class="mb-0 detail-value"><?php echo $laporan['longitude'] ?? '-'; ?></p>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="card evidence-card detail-section">
                            <h5 class="card-title mb-4 pb-2 border-bottom">
                              <i class="mdi mdi-camera me-2 text-primary"></i> Bukti Dokumentasi
                            </h5>

                            <div class="evidence-grid">
                              <div class="evidence-item">
                                <h6 class="evidence-label">Foto Bukti 1</h6>
                                <?php if (!empty($laporan['foto_bukti_1'])): ?>
                                  <div class="image-preview">
                                    <a href="<?php echo htmlspecialchars($laporan['foto_bukti_1_url'] ?? $laporan['foto_bukti_1']); ?>" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="<?php echo htmlspecialchars($laporan['foto_bukti_1_url'] ?? $laporan['foto_bukti_1']); ?>" class="d-block">
                                      <img src="<?php echo htmlspecialchars($laporan['foto_bukti_1_url'] ?? $laporan['foto_bukti_1']); ?>" alt="Foto Bukti 1" class="img-fluid" style="max-height: 200px; object-fit: cover; width: 100%;">
                                    </a>
                                  </div>
                                <?php else: ?>
                                  <div class="no-evidence">
                                    <i class="mdi mdi-image-off mb-2"></i>
                                    <div>Tidak ada foto bukti 1</div>
                                  </div>
                                <?php endif; ?>
                              </div>

                              <div class="evidence-item">
                                <h6 class="evidence-label">Foto Bukti 2</h6>
                                <?php if (!empty($laporan['foto_bukti_2'])): ?>
                                  <div class="image-preview">
                                    <a href="<?php echo htmlspecialchars($laporan['foto_bukti_2_url'] ?? $laporan['foto_bukti_2']); ?>" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="<?php echo htmlspecialchars($laporan['foto_bukti_2_url'] ?? $laporan['foto_bukti_2']); ?>" class="d-block">
                                      <img src="<?php echo htmlspecialchars($laporan['foto_bukti_2_url'] ?? $laporan['foto_bukti_2']); ?>" alt="Foto Bukti 2" class="img-fluid" style="max-height: 200px; object-fit: cover; width: 100%;">
                                    </a>
                                  </div>
                                <?php else: ?>
                                  <div class="no-evidence">
                                    <i class="mdi mdi-image-off mb-2"></i>
                                    <div>Tidak ada foto bukti 2</div>
                                  </div>
                                <?php endif; ?>
                              </div>

                              <div class="evidence-item">
                                <h6 class="evidence-label">Foto Bukti 3</h6>
                                <?php if (!empty($laporan['foto_bukti_3'])): ?>
                                  <div class="image-preview">
                                    <a href="<?php echo htmlspecialchars($laporan['foto_bukti_3_url'] ?? $laporan['foto_bukti_3']); ?>" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="<?php echo htmlspecialchars($laporan['foto_bukti_3_url'] ?? $laporan['foto_bukti_3']); ?>" class="d-block">
                                      <img src="<?php echo htmlspecialchars($laporan['foto_bukti_3_url'] ?? $laporan['foto_bukti_3']); ?>" alt="Foto Bukti 3" class="img-fluid" style="max-height: 200px; object-fit: cover; width: 100%;">
                                    </a>
                                  </div>
                                <?php else: ?>
                                  <div class="no-evidence">
                                    <i class="mdi mdi-image-off mb-2"></i>
                                    <div>Tidak ada foto bukti 3</div>
                                  </div>
                                <?php endif; ?>
                              </div>
                            </div>

                            <div class="mt-4">
                              <h6 class="evidence-label">Video Bukti</h6>
                              <?php if (!empty($laporan['video_bukti'])): ?>
                                <div class="video-preview">
                                  <video width="100%" height="auto" controls class="w-100" style="max-height: 200px;">
                                    <source src="<?php echo htmlspecialchars($laporan['video_bukti_url'] ?? $laporan['video_bukti']); ?>" type="video/mp4">
                                    Browser Anda tidak mendukung elemen video.
                                  </video>
                                </div>
                              <?php else: ?>
                                <div class="no-evidence mt-2">
                                  <i class="mdi mdi-video-off mb-2"></i>
                                  <div>Tidak ada video bukti</div>
                                </div>
                              <?php endif; ?>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="mt-4 pt-3 border-top d-flex flex-wrap justify-content-end gap-2">
                        <a href="index.php?controller=LaporanAdmin&action=edit&id=<?php echo $laporan['id']; ?>" class="btn btn-warning btn-action">
                          <i class="mdi mdi-pencil me-1"></i> Edit
                        </a>
                        <a href="index.php?controller=LaporanAdmin&action=index" class="btn btn-outline-secondary btn-action">
                          <i class="mdi mdi-arrow-left me-1"></i> Kembali
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
  
  <!-- Image Modal -->
  <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Gambar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <img id="modalImage" src="" alt="Detail Gambar" class="img-fluid rounded">
        </div>
      </div>
    </div>
  </div>
  
  <?php include 'template/script.php'; ?>
  
  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  
  <script>
    // Image modal functionality
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(item => {
      item.addEventListener('click', function() {
        const imageUrl = this.getAttribute('data-image');
        document.getElementById('modalImage').src = imageUrl;
      });
    });
    
    // Initialize map if coordinates are available
    document.addEventListener("DOMContentLoaded", function() {
        // Safe parsing of PHP variables
        var latitude = parseFloat("<?php echo $laporan['latitude'] ?? 0; ?>");
        var longitude = parseFloat("<?php echo $laporan['longitude'] ?? 0; ?>");

        // Check if coordinates exist
        if (latitude && longitude && latitude !== 0 && longitude !== 0) {
            // Initialize map with appropriate zoom level
            var map = L.map('map').setView([latitude, longitude], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            L.marker([latitude, longitude]).addTo(map)
                .bindPopup("<b>Lokasi Kejadian</b><br>" + latitude + ", " + longitude)
                .openPopup();
            
            // Fix Leaflet rendering issue - ensure proper sizing
            setTimeout(function() {
                map.invalidateSize();
            }, 100);
            
            // Additional resize after a bit more time to ensure proper rendering
            setTimeout(function() {
                map.invalidateSize();
            }, 500);
        } else {
            document.getElementById('map').innerHTML = '<div class="alert alert-warning text-center m-0 p-3">Lokasi koordinat tidak tersedia.</div>';
        }
    });
  </script>
</body>
</html>