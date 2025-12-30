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
                  <h4 class="card-title">Daftar Laporan Operator</h4>
                  <p class="card-description">Berikut adalah daftar laporan bencana yang perlu ditangani</p>
                  
                  <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
                  <?php endif; ?>

                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Judul</th>
                          <th>Pelapor</th>
                          <th>Kategori</th>
                          <th>Lokasi (Desa)</th>
                          <th>Status</th>
                          <th>Tanggal</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($reports)): ?>
                          <?php $no = (($pagination['current_page'] ?? 1) - 1) * 10 + 1; ?>
                          <?php foreach ($reports as $report): ?>
                            <tr>
                              <td><?php echo $no++; ?></td>
                              <td><?php echo htmlspecialchars($report['judul_laporan'] ?? '-'); ?></td>
                              <td><?php echo htmlspecialchars($report['pelapor']['nama'] ?? '-'); ?></td>
                              <td><?php echo htmlspecialchars($report['kategori']['nama_kategori'] ?? '-'); ?></td>
                              <td><?php echo htmlspecialchars($report['desa']['nama'] ?? '-'); ?></td>
                              <td>
                                <?php 
                                $status = $report['status'] ?? 'Draft';
                                $badge_class = '';
                                switch (strtolower($status)) {
                                  case 'draft':
                                    $badge_class = 'badge badge-secondary';
                                    break;
                                  case 'menunggu verifikasi':
                                    $badge_class = 'badge badge-warning';
                                    break;
                                  case 'sedang diproses':
                                    $badge_class = 'badge badge-info';
                                    break;
                                  case 'selesai':
                                    $badge_class = 'badge badge-success';
                                    break;
                                  default:
                                    $badge_class = 'badge badge-light';
                                    break;
                                }
                                ?>
                                <span class="<?php echo $badge_class; ?>"><?php echo htmlspecialchars($status); ?></span>
                              </td>
                              <td><?php echo date('d M Y', strtotime($report['waktu_laporan'] ?? '')); ?></td>
                              <td>
                                <a href="index.php?controller=LaporanOperator&action=detail&id=<?php echo $report['id']; ?>" class="btn btn-primary btn-sm">Detail</a>
                                <a href="index.php?controller=LaporanOperator&action=edit-status&id=<?php echo $report['id']; ?>" class="btn btn-warning btn-sm">Edit Status</a>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="8" class="text-center">Tidak ada data laporan</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>

                  <!-- Pagination -->
                  <?php if (!empty($pagination) && $pagination['last_page'] > 1): ?>
                    <nav aria-label="Page navigation">
                      <ul class="pagination justify-content-center">
                        <?php if ($pagination['current_page'] > 1): ?>
                          <li class="page-item">
                            <a class="page-link" href="index.php?controller=LaporanOperator&action=index&page=<?php echo $pagination['current_page'] - 1; ?>">Previous</a>
                          </li>
                        <?php endif; ?>

                        <?php for ($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['last_page'], $pagination['current_page'] + 2); $i++): ?>
                          <li class="page-item <?php echo $i == $pagination['current_page'] ? 'active' : ''; ?>">
                            <a class="page-link" href="index.php?controller=LaporanOperator&action=index&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                          </li>
                        <?php endfor; ?>

                        <?php if ($pagination['current_page'] < $pagination['last_page']): ?>
                          <li class="page-item">
                            <a class="page-link" href="index.php?controller=LaporanOperator&action=index&page=<?php echo $pagination['current_page'] + 1; ?>">Next</a>
                          </li>
                        <?php endif; ?>
                      </ul>
                    </nav>
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