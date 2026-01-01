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
                <h3 class="font-weight-bold"><?php echo isset($riwayatTindakan) ? 'Edit Riwayat Tindakan' : 'Tambah Riwayat Tindakan'; ?></h3>
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

              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"><?php echo isset($riwayatTindakan) ? 'Edit Riwayat Tindakan' : 'Tambah Riwayat Tindakan Baru'; ?></h4>

                  <form method="POST" action="<?php echo isset($riwayatTindakan) ? 'index.php?controller=RiwayatTindakan&action=update&id=' . $riwayatTindakan['id'] : 'index.php?controller=RiwayatTindakan&action=store'; ?>">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="tindaklanjut_id">Tindak Lanjut *</label>
                          <select class="form-control" id="tindaklanjut_id" name="tindaklanjut_id" required>
                            <option value="">Pilih Tindak Lanjut</option>
                            <?php if (!empty($tindakLanjutList)): ?>
                              <?php foreach ($tindakLanjutList as $tindakLanjut): ?>
                                <option value="<?php echo $tindakLanjut['id_tindaklanjut']; ?>"
                                  <?php echo (isset($riwayatTindakan) && $riwayatTindakan['tindaklanjut_id'] == $tindakLanjut['id_tindaklanjut']) ? 'selected' : ''; ?>>
                                  ID <?php echo $tindakLanjut['id_tindaklanjut']; ?> - <?php echo htmlspecialchars($tindakLanjut['laporan']['judul_laporan'] ?? $tindakLanjut['id_tindaklanjut']); ?> (<?php echo htmlspecialchars($tindakLanjut['status'] ?? ''); ?>)
                                </option>
                              <?php endforeach; ?>
                            <?php else: ?>
                              <option value="" disabled>Tidak ada data tindak lanjut tersedia</option>
                            <?php endif; ?>
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="waktu_tindakan">Waktu Tindakan *</label>
                          <input type="datetime-local" class="form-control" id="waktu_tindakan" name="waktu_tindakan"
                            value="<?php echo isset($riwayatTindakan) ? date('Y-m-d\TH:i', strtotime($riwayatTindakan['waktu_tindakan'])) : date('Y-m-d\TH:i'); ?>" required>
                        </div>

                        <div class="form-group">
                          <label for="keterangan">Keterangan *</label>
                          <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Tambahkan keterangan tindakan..." required><?php echo isset($riwayatTindakan) ? htmlspecialchars($riwayatTindakan['keterangan']) : ''; ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary"><?php echo isset($riwayatTindakan) ? 'Perbarui' : 'Simpan'; ?></button>
                        <a href="index.php?controller=RiwayatTindakan&action=index" class="btn btn-secondary">Batal</a>
                      </div>

                      <div class="col-md-6">
                        <div class="card">
                          <div class="card-body">
                            <h5 class="card-title">Informasi Tambahan</h5>
                            <p>Gunakan form ini untuk mencatat riwayat tindakan terhadap laporan bencana.</p>

                            <h6 class="mt-3">Catatan:</h6>
                            <ul>
                              <li>Field dengan tanda bintang (*) wajib diisi</li>
                              <li>Pilih tindak lanjut yang akan dicatat riwayatnya</li>
                              <li>Isi waktu tindakan sesuai dengan waktu pelaksanaan</li>
                              <li>Gunakan keterangan yang jelas dan informatif</li>
                            </ul>

                            <?php if (isset($riwayatTindakan)): ?>
                            <div class="mt-3">
                              <h6>Detail Riwayat Tindakan Saat Ini:</h6>
                              <table class="table table-sm">
                                <tr>
                                  <td width="40%"><strong>ID Riwayat</strong></td>
                                  <td><?php echo $riwayatTindakan['id'] ?? '-'; ?></td>
                                </tr>
                                <tr>
                                  <td><strong>Waktu Tindakan</strong></td>
                                  <td><?php echo date('d M Y H:i', strtotime($riwayatTindakan['waktu_tindakan'] ?? 'now')); ?></td>
                                </tr>
                                <tr>
                                  <td><strong>Petugas</strong></td>
                                  <td><?php echo htmlspecialchars($riwayatTindakan['petugas']['nama'] ?? '-'); ?></td>
                                </tr>
                              </table>
                            </div>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
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

</body>
</html>