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
              <div class="page-header">
                <h3 class="page-title">Data Provinsi</h3>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Wilayah</li>
                    <li class="breadcrumb-item active" aria-current="page">Provinsi</li>
                  </ol>
                </nav>
              </div>

              <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Daftar Provinsi</h4>
                        <a href="index.php?controller=Wilayah&action=createProvinsi" class="btn btn-primary btn-sm">
                          <i class="mdi mdi-plus-circle-outline mr-1"></i> Tambah Provinsi
                        </a>
                      </div>

                      <div class="table-responsive">
                        <table class="table table-hover">
                          <thead>
                            <tr class="bg-primary text-white">
                              <th>#</th>
                              <th>Nama Provinsi</th>
                              <th class="text-center">Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if (!empty($provinsiList)): ?>
                              <?php $no = 1; ?>
                              <?php foreach ($provinsiList as $provinsi): ?>
                                <tr>
                                  <td><?php echo $no++; ?></td>
                                  <td>
                                    <div class="font-weight-medium"><?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? ''); ?></div>
                                  </td>
                                  <td class="text-center">
                                    <div class="btn-group" role="group">
                                      <a href="index.php?controller=Wilayah&action=editProvinsi&id=<?php echo $provinsi['id']; ?>" class="btn btn-outline-warning btn-sm" title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                      </a>
                                      <form method="POST" action="index.php?controller=Wilayah&action=deleteProvinsi&id=<?php echo $provinsi['id']; ?>" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus provinsi ini?');">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                          <i class="mdi mdi-delete"></i>
                                        </button>
                                      </form>
                                    </div>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            <?php else: ?>
                              <tr>
                                <td colspan="3" class="text-center py-5">
                                  <div class="d-flex flex-column align-items-center justify-content-center">
                                    <i class="mdi mdi-map-marker-off mdi-48px text-muted mb-3"></i>
                                    <h5 class="text-muted">Tidak ada data provinsi</h5>
                                    <p class="text-muted">Belum ada data provinsi yang tersedia</p>
                                  </div>
                                </td>
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
    </div>
  </div>
  <?php include 'template/script.php'; ?>
</body>
</html>