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
                <h3 class="font-weight-bold"><?php echo isset($tindakLanjut) ? 'Edit Tindak Lanjut' : 'Tambah Tindak Lanjut'; ?></h3>
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

              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"><?php echo isset($tindakLanjut) ? 'Edit Tindak Lanjut' : 'Tambah Tindak Lanjut Baru'; ?></h4>
                  
                  <form method="POST" action="<?php echo isset($tindakLanjut) ? 'index.php?controller=TindakLanjut&action=update&id=' . $tindakLanjut['id_tindaklanjut'] : 'index.php?controller=TindakLanjut&action=store'; ?>" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-6">
                        <?php if (isset($tindakLanjut)): ?>
                        <!-- Edit Mode: Read-only field with hidden input -->
                        <div class="form-group">
                          <label for="laporan_title">Laporan Terkait</label>
                          <input type="text" class="form-control" id="laporan_title" value="<?php echo htmlspecialchars('ID Laporan : ' . ($tindakLanjut['laporan']['id'] ?? '-') . ' | Judul Laporan : ' . ($tindakLanjut['laporan']['judul_laporan'] ?? '-')); ?>" readonly>
                          <input type="hidden" name="laporan_id" value="<?php echo $tindakLanjut['laporan_id'] ?? ''; ?>">
                        </div>
                        <?php else: ?>
                        <!-- Create Mode: Dropdown to select laporan -->
                        <div class="form-group">
                          <label for="laporan_id">Pilih Laporan Bencana</label>
                          <select class="form-control" id="laporan_id" name="laporan_id" required>
                            <option value="">-- Pilih Laporan Bencana --</option>
                            <?php if (!empty($laporanList)): ?>
                                <?php foreach ($laporanList as $laporan): ?>
                                    <option value="<?php echo $laporan['id']; ?>">
                                        ID Laporan : <?php echo $laporan['id']; ?> | Judul Laporan : <?php echo htmlspecialchars($laporan['judul_laporan']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>Data laporan tidak ditemukan</option>
                            <?php endif; ?>
                          </select>
                        </div>
                        <?php endif; ?>
                        
                        <div class="form-group">
                          <label for="tanggal_tanggapan">Tanggal Tanggapan *</label>
                          <input type="datetime-local" class="form-control" id="tanggal_tanggapan" name="tanggal_tanggapan"
                            value="<?php echo isset($tindakLanjut) ? date('Y-m-d\TH:i', strtotime($tindakLanjut['tanggal_tanggapan'])) : date('Y-m-d\TH:i'); ?>" required>
                        </div>
                        
                        <div class="form-group">
                          <label for="status">Status *</label>
                          <select class="form-control" id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="Menuju Lokasi" <?php echo (isset($tindakLanjut) && $tindakLanjut['status'] == 'Menuju Lokasi') ? 'selected' : ''; ?>>Menuju Lokasi</option>
                            <option value="Selesai" <?php echo (isset($tindakLanjut) && $tindakLanjut['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                          </select>
                        </div>
                        
                        
                        
                        <button type="submit" class="btn btn-primary"><?php echo isset($tindakLanjut) ? 'Perbarui' : 'Simpan'; ?></button>
                        <a href="index.php?controller=TindakLanjut&action=index" class="btn btn-secondary">Batal</a>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="card">
                          <div class="card-body">
                            <h5 class="card-title">Informasi Tambahan</h5>
                            <p>Gunakan form ini untuk mencatat tindak lanjut terhadap laporan bencana.</p>
                            
                            <h6 class="mt-3">Catatan:</h6>
                            <ul>
                              <li>Field dengan tanda bintang (*) wajib diisi</li>
                              <li>Pilih laporan yang akan ditindaklanjuti</li>
                              <li>Isi tanggal tanggapan sesuai dengan waktu pelaksanaan</li>
                              <li>Gunakan status yang sesuai dengan kondisi terkini</li>
                              <li>Unggah foto kegiatan sebagai dokumentasi (jika ada)</li>
                            </ul>
                            
                            <?php if (isset($tindakLanjut)): ?>
                            <div class="mt-3">
                              <h6>Detail Tindak Lanjut Saat Ini:</h6>
                              <table class="table table-sm">
                                <tr>
                                  <td width="40%"><strong>ID Tindak Lanjut</strong></td>
                                  <td><?php echo $tindakLanjut['id_tindaklanjut'] ?? '-'; ?></td>
                                </tr>
                                <tr>
                                  <td><strong>Status Saat Ini</strong></td>
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
                                  <td><strong>Tanggal Tanggapan</strong></td>
                                  <td><?php echo date('d M Y H:i', strtotime($tindakLanjut['tanggal_tanggapan'] ?? 'now')); ?></td>
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