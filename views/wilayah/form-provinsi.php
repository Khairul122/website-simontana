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
                <h3 class="page-title"><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> Provinsi</h3>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="index.php?controller=Wilayah&action=indexProvinsi">Wilayah</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> Provinsi</li>
                  </ol>
                </nav>
              </div>

              <div class="row">
                <div class="col-lg-8 mx-auto">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title"><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> Data Provinsi</h4>
                      <p class="card-description"><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> data provinsi baru</p>

                      <form action="index.php?controller=Wilayah&action=<?php echo $isEdit ? 'updateProvinsi&id=' . $provinsi['id'] : 'storeProvinsi'; ?>" method="POST" class="forms-sample">
                        <div class="form-group row">
                          <label for="nama" class="col-sm-3 col-form-label">Nama Provinsi</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama provinsi"
                              value="<?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? ''); ?>" required>
                          </div>
                        </div>

                        <div class="mt-4">
                          <button type="submit" class="btn btn-primary mr-2"><?php echo $isEdit ? 'Update' : 'Simpan'; ?></button>
                          <a href="index.php?controller=Wilayah&action=indexProvinsi" class="btn btn-light">Batal</a>
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
    </div>
  </div>
  <?php include 'template/script.php'; ?>
</body>
</html>