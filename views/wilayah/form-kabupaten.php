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
                  <h4 class="card-title"><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> Kabupaten</h4>
                  <p class="card-description"><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> data kabupaten baru</p>
                  
                  <form action="index.php?controller=Wilayah&action=<?php echo $isEdit ? 'updateKabupaten&id=' . $kabupaten['id'] : 'storeKabupaten'; ?>" method="POST">
                    <div class="form-group">
                      <label for="id_provinsi">Provinsi</label>
                      <select class="form-control" id="id_provinsi" name="id_provinsi" required>
                        <option value="">-- Pilih Provinsi --</option>
                        <?php foreach ($provinsiList as $provinsi): ?>
                          <option value="<?php echo $provinsi['id']; ?>" 
                            <?php echo ((isset($kabupaten['id_provinsi']) && $kabupaten['id_provinsi'] == $provinsi['id']) ? 'selected' :
                                       ((isset($kabupaten['id_parent']) && $kabupaten['id_parent'] == $provinsi['id']) ? 'selected' :
                                       ((isset($_GET['provinsi_id']) && $_GET['provinsi_id'] == $provinsi['id']) ? 'selected' : ''))); ?>>
                            <?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? ''); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    
                    <div class="form-group">
                      <label for="nama">Nama Kabupaten</label>
                      <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama kabupaten" 
                        value="<?php echo htmlspecialchars($kabupaten['nama'] ?? $kabupaten['name'] ?? ''); ?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2"><?php echo $isEdit ? 'Update' : 'Simpan'; ?></button>
                    <a href="index.php?controller=Wilayah&action=indexKabupaten<?php echo isset($_GET['provinsi_id']) ? '&provinsi_id=' . $_GET['provinsi_id'] : ''; ?>" class="btn btn-light">Batal</a>
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