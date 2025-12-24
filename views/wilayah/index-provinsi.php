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
                  <h4 class="card-title">Data Provinsi</h4>
                  <p class="card-description">Daftar provinsi di Indonesia</p>
                  
                  <div class="row">
                    <div class="col-12">
                      <div class="template-demo d-flex justify-content-between">
                        <a href="index.php?controller=Wilayah&action=createProvinsi" class="btn btn-primary btn-fw">
                          <i class="mdi mdi-plus"></i>Tambah Provinsi
                        </a>
                      </div>
                      
                      
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Nama Provinsi</th>
                              <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if (!empty($provinsiList)): ?>
                              <?php $no = 1; ?>
                              <?php foreach ($provinsiList as $provinsi): ?>
                                <tr>
                                  <td><?php echo $no++; ?></td>
                                  <td><?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? ''); ?></td>
                                  <td>
                                    <a href="index.php?controller=Wilayah&action=editProvinsi&id=<?php echo $provinsi['id']; ?>" class="btn btn-outline-warning btn-sm">Edit</a>
                                    <form method="POST" action="index.php?controller=Wilayah&action=deleteProvinsi&id=<?php echo $provinsi['id']; ?>" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus provinsi ini?');">
                                      <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                    </form>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            <?php else: ?>
                              <tr>
                                <td colspan="3" class="text-center">Tidak ada data provinsi</td>
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