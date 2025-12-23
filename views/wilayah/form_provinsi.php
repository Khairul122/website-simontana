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
              <h2>
                <?php echo $isEdit ? 'Edit Provinsi' : 'Tambah Provinsi'; ?>
              </h2>
              <p class="text-muted">
                <?php echo $isEdit ? 'Edit informasi provinsi' : 'Tambahkan provinsi baru ke sistem'; ?>
              </p>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <?php if ($isEdit && !$provinsi): ?>
                  <div class="alert alert-warning m-3" role="alert">
                    <h4 class="alert-heading">Peringatan!</h4>
                    <p>Data provinsi tidak ditemukan.</p>
                    <a href="index.php?controller=Wilayah&action=indexProvinsi" class="btn btn-primary">Kembali ke Daftar</a>
                  </div>
                <?php else: ?>
                <div class="card-body">
                  <h4 class="card-title">
                    <?php echo $isEdit ? 'Edit Provinsi' : 'Form Tambah Provinsi'; ?>
                  </h4>

                  <form method="POST"
                        action="index.php?controller=Wilayah&action=<?php echo $isEdit ? 'updateProvinsi' : 'storeProvinsi'; ?>">
                    <?php if ($isEdit): ?>
                      <input type="hidden" name="id" value="<?php echo htmlspecialchars($provinsi['id'] ?? ''); ?>">
                    <?php endif; ?>

                    <div class="form-group">
                      <label for="nama">Nama Provinsi *</label>
                      <input type="text"
                             class="form-control"
                             id="nama"
                             name="nama"
                             value="<?php echo htmlspecialchars($provinsi['nama'] ?? ''); ?>"
                             required>
                      <small class="form-text text-muted">Nama provinsi</small>
                    </div>

                    <div class="d-flex justify-content-between">
                      <a href="index.php?controller=Wilayah&action=indexProvinsi" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                      </a>

                      <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-content-save"></i>
                        <?php echo $isEdit ? 'Perbarui' : 'Simpan'; ?>
                      </button>
                    </div>
                  </form>
                </div>
                <?php endif; ?>
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