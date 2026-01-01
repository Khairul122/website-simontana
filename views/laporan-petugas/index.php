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
                <h3 class="font-weight-bold">Daftar Laporan Bencana</h3>
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
                        <option value="Draft" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Draft') ? 'selected' : ''; ?>>Draft</option>
                        <option value="Menunggu Verifikasi" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Menunggu Verifikasi') ? 'selected' : ''; ?>>Menunggu Verifikasi</option>
                        <option value="Diverifikasi" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Diverifikasi') ? 'selected' : ''; ?>>Diverifikasi</option>
                        <option value="Diproses" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                        <option value="Tindak Lanjut" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Tindak Lanjut') ? 'selected' : ''; ?>>Tindak Lanjut</option>
                        <option value="Selesai" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                        <option value="Ditolak" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label for="searchFilter" class="form-label">Pencarian</label>
                      <input type="text" id="searchFilter" class="form-control" placeholder="Cari judul atau lokasi..." 
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

                  <!-- Reports Table -->
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Judul Laporan</th>
                          <th>Kategori</th>
                          <th>Lokasi</th>
                          <th>Status</th>
                          <th>Tanggal</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (isset($laporanList) && !empty($laporanList)): ?>
                          <?php 
                          // Handle both paginated and non-paginated responses
                          $reports = isset($laporanList['data']) ? $laporanList['data'] : $laporanList;
                          if (!is_array($reports)) $reports = [];
                          ?>
                          <?php foreach ($reports as $laporan): ?>
                          <tr>
                            <td><?php echo $laporan['id'] ?? '-'; ?></td>
                            <td><?php echo htmlspecialchars($laporan['judul_laporan'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($laporan['kategori']['nama_kategori'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($laporan['alamat_lengkap'] ?? '-'); ?></td>
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
                            <td><?php echo date('d M Y', strtotime($laporan['waktu_laporan'] ?? 'now')); ?></td>
                            <td>
                              <a href="index.php?controller=LaporanPetugas&action=detail&id=<?php echo $laporan['id']; ?>" 
                                 class="btn btn-sm btn-info">Detail</a>
                              <a href="index.php?controller=LaporanPetugas&action=edit&id=<?php echo $laporan['id']; ?>" 
                                 class="btn btn-sm btn-warning">Edit</a>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="7" class="text-center">Tidak ada data laporan</td>
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
      
      let url = 'index.php?controller=LaporanPetugas&action=index';
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