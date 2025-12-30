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
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Status Laporan</h4>

                  <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
                  <?php endif; ?>

                  <?php if (!empty($report)): ?>
                    <form action="index.php?controller=LaporanOperator&action=update" method="POST">
                      <input type="hidden" name="id" value="<?php echo $report['id']; ?>">

                      <div class="form-group">
                        <label for="judul_laporan">Judul Laporan</label>
                        <input type="text" class="form-control" id="judul_laporan" value="<?php echo htmlspecialchars($report['judul_laporan'] ?? ''); ?>" readonly>
                      </div>

                      <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="status" name="status" required>
                          <option value="">Pilih Status</option>
                          <option value="Menunggu Verifikasi" <?php echo ($report['status'] ?? '') === 'Menunggu Verifikasi' ? 'selected' : ''; ?>>Menunggu Verifikasi</option>
                          <option value="Diverifikasi" <?php echo ($report['status'] ?? '') === 'Diverifikasi' ? 'selected' : ''; ?>>Diverifikasi</option>
                          <option value="Ditolak" <?php echo ($report['status'] ?? '') === 'Ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                          <option value="Selesai" <?php echo ($report['status'] ?? '') === 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="catatan_verifikasi">Catatan Verifikasi</label>
                        <textarea class="form-control" id="catatan_verifikasi" name="catatan_verifikasi" rows="4" placeholder="Masukkan catatan verifikasi..."><?php echo htmlspecialchars($report['catatan_verifikasi'] ?? ''); ?></textarea>
                        <small class="form-text text-muted">Catatan tambahan dari operator</small>
                      </div>

                      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                      <a href="index.php?controller=LaporanOperator&action=detail&id=<?php echo $report['id']; ?>" class="btn btn-secondary">Batal</a>
                    </form>
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
</body>
</html>