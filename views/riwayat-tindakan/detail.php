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
                <h3 class="font-weight-bold">Detail Riwayat Tindakan #<?php echo $riwayatTindakan['id'] ?? '-'; ?></h3>
                <div class="d-flex justify-content-between">
                  <a href="index.php?controller=RiwayatTindakan&action=index" class="btn btn-secondary">Kembali ke Daftar</a>
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

              <?php if (isset($riwayatTindakan) && $riwayatTindakan): ?>
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Waktu: <?php echo date('d M Y H:i', strtotime($riwayatTindakan['waktu_tindakan'] ?? 'now')); ?></h4>

                  <div class="row">
                    <div class="col-md-8">
                      <!-- Keterangan -->
                      <div class="form-group">
                        <label class="font-weight-bold">Keterangan</label>
                        <div class="border p-3 bg-light">
                          <p class="mb-0"><?php echo htmlspecialchars($riwayatTindakan['keterangan'] ?? '-'); ?></p>
                        </div>
                      </div>

                      <!-- Row 2: Actors -->
                      <div class="row mt-4">
                        <div class="col-md-6">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">Petugas</h5>
                              <p class="card-text">
                                <strong>Nama:</strong> <?php echo htmlspecialchars($riwayatTindakan['petugas']['nama'] ?? '-'); ?><br>
                              </p>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">Pelapor</h5>
                              <p class="card-text">
                                <strong>Nama:</strong> <?php echo htmlspecialchars($riwayatTindakan['tindak_lanjut']['laporan']['pelapor']['nama'] ?? '-'); ?><br>
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Row 3: Context - Laporan -->
                      <div class="mt-4">
                        <h5>Laporan Terkait</h5>
                        <div class="card">
                          <div class="card-body">
                            <p class="card-text">
                              <strong>Judul Laporan:</strong> <?php echo htmlspecialchars($riwayatTindakan['tindak_lanjut']['laporan']['judul_laporan'] ?? '-'); ?><br>
                              <strong>Alamat:</strong> <?php echo htmlspecialchars($riwayatTindakan['tindak_lanjut']['laporan']['alamat_lengkap'] ?? '-'); ?><br>
                              <strong>Status Terkini:</strong> 
                              <?php
                                $status = $riwayatTindakan['tindak_lanjut']['status'] ?? '-';
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
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Ringkasan</h5>
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                              <strong>ID:</strong>
                              <span class="float-right"><?php echo $riwayatTindakan['id'] ?? '-'; ?></span>
                            </li>
                            <li class="list-group-item">
                              <strong>Tindak Lanjut ID:</strong>
                              <span class="float-right"><?php echo $riwayatTindakan['tindaklanjut_id'] ?? '-'; ?></span>
                            </li>
                            <li class="list-group-item">
                              <strong>Waktu Tindakan:</strong>
                              <span class="float-right"><?php echo date('d M Y H:i', strtotime($riwayatTindakan['waktu_tindakan'] ?? 'now')); ?></span>
                            </li>
                            <li class="list-group-item">
                              <strong>Petugas:</strong>
                              <span class="float-right"><?php echo htmlspecialchars($riwayatTindakan['petugas']['nama'] ?? '-'); ?></span>
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
                <p>Riwayat tindakan dengan ID yang dimaksud tidak ditemukan atau telah dihapus.</p>
                <a href="index.php?controller=RiwayatTindakan&action=index" class="btn btn-primary">Kembali ke Daftar</a>
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
      alert("<?php echo $_SESSION['toast']['title'] . ': ' . $_SESSION['toast']['message']; ?>");
  </script>
  <?php unset($_SESSION['toast']); endif; ?>

</body>
</html>