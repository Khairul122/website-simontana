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
                <h3 class="font-weight-bold">Daftar Riwayat Tindakan</h3>
                <div class="d-flex justify-content-between">
                  <a href="index.php?controller=RiwayatTindakan&action=create" class="btn btn-primary">Tambah Data</a>
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
                  <h4 class="card-title">Data Riwayat Tindakan</h4>

                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Petugas</th>
                          <th>Terkait Laporan (Judul)</th>
                          <th>Keterangan</th>
                          <th>Waktu</th>
                          <th>Status</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($riwayatTindakanList)): ?>
                          <?php $no = 1; ?>
                          <?php foreach ($riwayatTindakanList as $item): ?>
                            <tr>
                              <td><?php echo $no++; ?></td>
                              <td><?php echo htmlspecialchars($item['petugas']['nama'] ?? '-'); ?></td>
                              <td><?php echo htmlspecialchars($item['tindak_lanjut']['laporan']['judul_laporan'] ?? '-'); ?></td>
                              <td><?php echo htmlspecialchars(substr($item['keterangan'] ?? '-', 0, 50)) . (strlen($item['keterangan'] ?? '') > 50 ? '...' : ''); ?></td>
                              <td><?php echo date('d M Y H:i', strtotime($item['waktu_tindakan'] ?? 'now')); ?></td>
                              <td>
                                <?php
                                  $status = $item['tindak_lanjut']['status'] ?? '-';
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
                              <td>
                                <a href="index.php?controller=RiwayatTindakan&action=detail&id=<?php echo $item['id']; ?>" class="btn btn-info btn-sm">Detail</a>
                                <a href="index.php?controller=RiwayatTindakan&action=edit&id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <form method="POST" action="index.php?controller=RiwayatTindakan&action=delete&id=<?php echo $item['id']; ?>" style="display: inline;" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat tindakan ini?');">
                                  <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="7" class="text-center">Tidak ada data riwayat tindakan</td>
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
      alert("<?php echo $_SESSION['toast']['title'] . ': ' . $_SESSION['toast']['message']; ?>");
  </script>
  <?php unset($_SESSION['toast']); endif; ?>

</body>
</html>