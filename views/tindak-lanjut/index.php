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
                <h3 class="font-weight-bold">Daftar Tindak Lanjut</h3>
                <div class="d-flex justify-content-between">
                  <a href="index.php?controller=TindakLanjut&action=create" class="btn btn-primary">Tambah Tindak Lanjut</a>
                </div>
             </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body">
                  <!-- Filter Form -->
                  <div class="row mb-4">
                    <div class="col-md-3">
                      <label for="statusFilter" class="form-label">Status</label>
                      <select id="statusFilter" class="form-control" onchange="applyFilters()">
                        <option value="">Semua Status</option>
                        <option value="Menuju Lokasi" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Menuju Lokasi') ? 'selected' : ''; ?>>Menuju Lokasi</option>
                        <option value="Sedang Ditangani" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Sedang Ditangani') ? 'selected' : ''; ?>>Sedang Ditangani</option>
                        <option value="Selesai" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                        <option value="Ditolak" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label for="searchFilter" class="form-label">Pencarian</label>
                      <input type="text" id="searchFilter" class="form-control" placeholder="Cari keterangan atau laporan..." 
                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
                        onkeypress="if(event.key==='Enter'){applyFilters();}">
                    </div>
                    <div class="col-md-3 align-self-end">
                      <button class="btn btn-primary" onclick="applyFilters()">Terapkan Filter</button>
                    </div>
                  </div>

                  <!-- Error Message -->
                  <?php if (isset($error_message)): ?>
                  <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Kesalahan!</h4>
                    <p><?php echo htmlspecialchars($error_message); ?></p>
                  </div>
                  <?php endif; ?>

                  <!-- Tindak Lanjut Table -->
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Laporan</th>
                          <th>Petugas</th>
                          <th>Tanggal Tanggapan</th>
                          <th>Status</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (isset($tindakLanjutList) && !empty($tindakLanjutList)): ?>
                          <?php 
                          // Handle both paginated and non-paginated responses
                          $tindakLanjuts = isset($tindakLanjutList['data']) ? $tindakLanjutList['data'] : $tindakLanjutList;
                          if (!is_array($tindakLanjuts)) $tindakLanjuts = [];
                          ?>
                          <?php foreach ($tindakLanjuts as $tindakLanjut): ?>
                          <tr>
                            <td><?php echo $tindakLanjut['id_tindaklanjut'] ?? '-'; ?></td>
                            <td>
                              <strong><?php echo htmlspecialchars($tindakLanjut['laporan']['judul_laporan'] ?? '-'); ?></strong><br>
                              <small class="text-muted"><?php echo htmlspecialchars($tindakLanjut['laporan']['alamat_lengkap'] ?? '-'); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($tindakLanjut['petugas']['nama'] ?? '-'); ?></td>
                            <td><?php echo date('d M Y H:i', strtotime($tindakLanjut['tanggal_tanggapan'] ?? 'now')); ?></td>
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
                                echo '<label class="badge ' . $badgeClass . '">' . $displayText . '</label>';
                              ?>
                            </td>
                            <td>
                              <a href="index.php?controller=TindakLanjut&action=detail&id=<?php echo isset($tindakLanjut['id_tindaklanjut']) ? $tindakLanjut['id_tindaklanjut'] : ''; ?>"
                                 class="btn btn-sm btn-info">Detail</a>
                              <a href="index.php?controller=TindakLanjut&action=edit&id=<?php echo isset($tindakLanjut['id_tindaklanjut']) ? $tindakLanjut['id_tindaklanjut'] : ''; ?>"
                                 class="btn btn-sm btn-warning">Edit</a>
                              <form method="POST" action="index.php?controller=TindakLanjut&action=delete&id=<?php echo isset($tindakLanjut['id_tindaklanjut']) ? $tindakLanjut['id_tindaklanjut'] : ''; ?>"
                                    style="display:inline;"
                                    onsubmit="return confirm('Yakin ingin menghapus tindak lanjut ini?');">
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                              </form>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="6" class="text-center">Tidak ada data tindak lanjut</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
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
  
  <script>
    function applyFilters() {
      const status = document.getElementById('statusFilter').value;
      const search = document.getElementById('searchFilter').value;
      
      let url = 'index.php?controller=TindakLanjut&action=index';
      if (status) {
        url += '&status=' + encodeURIComponent(status);
      }
      if (search) {
        url += '&search=' + encodeURIComponent(search);
      }
      
      window.location.href = url;
    }
  </script>
</body>
</html>