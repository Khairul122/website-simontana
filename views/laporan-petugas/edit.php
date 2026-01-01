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
                <h3 class="font-weight-bold">Edit Status Laporan</h3>
                <a href="index.php?controller=LaporanPetugas&action=detail&id=<?php echo $laporan['id'] ?? ''; ?>" class="btn btn-secondary">Kembali ke Detail</a>
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
                  <h4 class="card-title">Edit Status Laporan: <?php echo htmlspecialchars($laporan['judul_laporan'] ?? '-'); ?></h4>
                  
                  <form method="POST" action="index.php?controller=LaporanPetugas&action=update&id=<?php echo $laporan['id']; ?>">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="status">Status Laporan</label>
                          <select class="form-control" id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="Draft" <?php echo (isset($laporan['status']) && $laporan['status'] == 'Draft') ? 'selected' : ''; ?>>Draft</option>
                            <option value="Menunggu Verifikasi" <?php echo (isset($laporan['status']) && $laporan['status'] == 'Menunggu Verifikasi') ? 'selected' : ''; ?>>Menunggu Verifikasi</option>
                            <option value="Diverifikasi" <?php echo (isset($laporan['status']) && $laporan['status'] == 'Diverifikasi') ? 'selected' : ''; ?>>Diverifikasi</option>
                            <option value="Diproses" <?php echo (isset($laporan['status']) && $laporan['status'] == 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                            <option value="Tindak Lanjut" <?php echo (isset($laporan['status']) && $laporan['status'] == 'Tindak Lanjut') ? 'selected' : ''; ?>>Tindak Lanjut</option>
                            <option value="Selesai" <?php echo (isset($laporan['status']) && $laporan['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                            <option value="Ditolak" <?php echo (isset($laporan['status']) && $laporan['status'] == 'Ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                          </select>
                        </div>
                        
                        <div class="form-group">
                          <label for="keterangan">Keterangan (Opsional)</label>
                          <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Tambahkan keterangan tambahan..."><?php echo htmlspecialchars($laporan['keterangan'] ?? ''); ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Perbarui Status</button>
                        <a href="index.php?controller=LaporanPetugas&action=detail&id=<?php echo $laporan['id']; ?>" class="btn btn-secondary">Batal</a>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="card">
                          <div class="card-body">
                            <h5 class="card-title">Informasi Laporan</h5>
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
                                <td><?php echo htmlspecialchars($laporan['tingkat_keparahan'] ?? '-'); ?></td>
                              </tr>
                              <tr>
                                <td><strong>Status Saat Ini</strong></td>
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
                              <tr>
                                <td><strong>Nama Pelapor</strong></td>
                                <td><?php echo htmlspecialchars($laporan['pelapor']['nama'] ?? '-'); ?></td>
                              </tr>
                              <tr>
                                <td><strong>Alamat Lengkap</strong></td>
                                <td><?php echo htmlspecialchars($laporan['alamat_lengkap'] ?? '-'); ?></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
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
  
</body>
</html>