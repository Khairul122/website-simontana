<?php
include('template/header.php');
?>

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
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h2>Manajemen Wilayah - Daftar Kecamatan</h2>
                  <p class="text-muted">Kelola data kecamatan</p>
                </div>
                <a href="index.php?controller=Wilayah&action=createKecamatan" class="btn btn-primary">
                  <i class="mdi mdi-plus"></i> Tambah Kecamatan
                </a>
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Daftar Kecamatan</h4>

                  <!-- Search Box -->
                  <div class="row mb-3">
                    <div class="col-md-4">
                      <form method="GET" action="index.php">
                        <input type="hidden" name="controller" value="Wilayah">
                        <input type="hidden" name="action" value="indexKecamatan">
                        <div class="input-group">
                          <input type="text" name="search" class="form-control" placeholder="Cari nama kecamatan..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                          <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-magnify"></i> Cari
                          </button>
                          <?php if (!empty($_GET['search'])): ?>
                          <a href="index.php?controller=Wilayah&action=indexKecamatan" class="btn btn-secondary">
                            <i class="mdi mdi-close"></i> Reset
                          </a>
                          <?php endif; ?>
                        </div>
                      </form>
                    </div>
                  </div>

                  <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th width="50">No</th>
                          <th>Nama Kecamatan</th>
                          <th>Kabupaten/Kota</th>
                          <th>Provinsi</th>
                          <th width="150">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($kecamatanList)): ?>
                          <?php
                          $no = 1;
                          if (isset($pagination['from']) && $pagination['from'] > 0) {
                              $no = $pagination['from'];
                          }
                          ?>
                          <?php foreach ($kecamatanList as $kecamatan): ?>
                            <tr>
                              <td><?php echo $no++; ?></td>
                              <td><?php echo htmlspecialchars($kecamatan['nama'] ?? '-'); ?></td>
                              <td><?php echo htmlspecialchars($kecamatan['nama_kabupaten'] ?? '-'); ?></td>
                              <td><?php echo htmlspecialchars($kecamatan['nama_provinsi'] ?? '-'); ?></td>
                              <td>
                                <a href="index.php?controller=Wilayah&action=editKecamatan&id=<?php echo $kecamatan['id']; ?>"
                                   class="btn btn-sm btn-info"
                                   title="Edit">
                                  <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="index.php?controller=Wilayah&action=deleteKecamatan&id=<?php echo $kecamatan['id']; ?>"
                                   class="btn btn-sm btn-danger"
                                   title="Hapus"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus kecamatan ini?');">
                                  <i class="mdi mdi-delete"></i>
                                </a>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="5" class="text-center">
                              <p class="text-muted my-3">Tidak ada data kecamatan</p>
                              <a href="index.php?controller=Wilayah&action=createKecamatan" class="btn btn-primary">
                                <i class="mdi mdi-plus"></i> Tambah Kecamatan Baru
                              </a>
                            </td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>

                  <!-- Pagination -->
                  <?php if (!empty($pagination) && isset($pagination['last_page']) && $pagination['last_page'] > 1): ?>
                  <div class="row mt-3">
                    <div class="col-sm-12">
                      <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                          <?php
                          $currentPage = $pagination['current_page'] ?? 1;
                          $lastPage = $pagination['last_page'] ?? 1;
                          $total = $pagination['total'] ?? 0;

                          // Previous button
                          if ($currentPage > 1):
                              $prevPage = $currentPage - 1;
                              $searchParam = !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '';
                          ?>
                            <li class="page-item">
                              <a class="page-link" href="index.php?controller=Wilayah&action=indexKecamatan&page=<?php echo $prevPage . $searchParam; ?>">
                                <i class="mdi mdi-chevron-left"></i> Previous
                              </a>
                            </li>
                          <?php else: ?>
                            <li class="page-item disabled">
                              <span class="page-link"><i class="mdi mdi-chevron-left"></i> Previous</span>
                            </li>
                          <?php endif; ?>

                          <!-- Page numbers -->
                          <?php
                          // Show limited page numbers
                          $startPage = max(1, $currentPage - 2);
                          $endPage = min($lastPage, $currentPage + 2);

                          if ($startPage > 1):
                          ?>
                            <li class="page-item">
                              <a class="page-link" href="index.php?controller=Wilayah&action=indexKecamatan&page=1<?php echo !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>">
                                1
                              </a>
                            </li>
                            <?php if ($startPage > 2): ?>
                            <li class="page-item disabled">
                              <span class="page-link">...</span>
                            </li>
                            <?php endif; ?>
                          <?php endif; ?>

                          <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <?php if ($i == $currentPage): ?>
                            <li class="page-item active">
                              <span class="page-link"><?php echo $i; ?></span>
                            </li>
                            <?php else: ?>
                            <li class="page-item">
                              <a class="page-link" href="index.php?controller=Wilayah&action=indexKecamatan&page=<?php echo $i . (!empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''); ?>">
                                <?php echo $i; ?>
                              </a>
                            </li>
                            <?php endif; ?>
                          <?php endfor; ?>

                          <?php
                          if ($endPage < $lastPage):
                          ?>
                            <li class="page-item disabled">
                              <span class="page-link">...</span>
                            </li>
                            <li class="page-item">
                              <a class="page-link" href="index.php?controller=Wilayah&action=indexKecamatan&page=<?php echo $lastPage . (!empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''); ?>">
                                <?php echo $lastPage; ?>
                              </a>
                            </li>
                          <?php endif; ?>

                          <!-- Next button -->
                          <?php if ($currentPage < $lastPage):
                              $nextPage = $currentPage + 1;
                              $searchParam = !empty($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '';
                          ?>
                            <li class="page-item">
                              <a class="page-link" href="index.php?controller=Wilayah&action=indexKecamatan&page=<?php echo $nextPage . $searchParam; ?>">
                                Next <i class="mdi mdi-chevron-right"></i>
                              </a>
                            </li>
                          <?php else: ?>
                            <li class="page-item disabled">
                              <span class="page-link">Next <i class="mdi mdi-chevron-right"></i></span>
                            </li>
                          <?php endif; ?>
                        </ul>
                      </nav>

                      <div class="text-center mt-2">
                        <small class="text-muted">
                          Menampilkan <?php echo $pagination['from'] ?? 0; ?> sampai <?php echo $pagination['to'] ?? 0; ?>
                          dari total <?php echo $total; ?> data
                          (Halaman <?php echo $currentPage; ?> dari <?php echo $lastPage; ?>)
                        </small>
                      </div>
                    </div>
                  </div>
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

  <!-- Native JavaScript Alerts -->
  <script>
    <?php if (isset($_GET['success'])): ?>
      window.alert('<?php echo htmlspecialchars($_GET['success']); ?>');
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
      window.alert('Error: <?php echo htmlspecialchars($_GET['error']); ?>');
    <?php endif; ?>
  </script>
</body>

</html>