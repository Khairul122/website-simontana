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
                  <h4 class="card-title"><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> Provinsi</h4>
                  <p class="card-description"><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> data provinsi baru</p>
                  
                  <form action="index.php?controller=Wilayah&action=<?php echo $isEdit ? 'updateProvinsi&id=' . $provinsi['id'] : 'storeProvinsi'; ?>" method="POST">
                    <div class="form-group">
                      <label for="nama">Nama Provinsi</label>
                      <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama provinsi" 
                        value="<?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? ''); ?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2"><?php echo $isEdit ? 'Update' : 'Simpan'; ?></button>
                    <a href="index.php?controller=Wilayah&action=indexProvinsi" class="btn btn-light">Batal</a>
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
</body>
</html>