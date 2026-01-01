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
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="font-weight-bold">Profil Pengguna</h3>
              </div>

              <?php if (isset($error_message)): ?>
              <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Kesalahan!</h4>
                <p><?php echo htmlspecialchars($error_message); ?></p>
              </div>
              <?php endif; ?>

              <?php if (isset($user) && $user): ?>
              <div class="row">
                <div class="col-md-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body text-center">
                      <div class="d-flex justify-content-center">
                        <div class="text-primary display-4 fw-bold">
                          <?php echo strtoupper(substr($user['nama'] ?? 'U', 0, 1)); ?>
                        </div>
                      </div>
                      <h4 class="card-title mt-3"><?php echo htmlspecialchars($user['nama'] ?? '-'); ?></h4>
                      <p class="text-muted"><?php echo htmlspecialchars($user['role_label'] ?? $user['role'] ?? '-'); ?></p>
                      <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary btn-sm">Ubah Foto Profil</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-8 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Detail Profil</h4>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="font-weight-bold">Nama Lengkap</label>
                            <p class="form-control-plaintext"><?php echo htmlspecialchars($user['nama'] ?? '-'); ?></p>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="font-weight-bold">Username</label>
                            <p class="form-control-plaintext"><?php echo htmlspecialchars($user['username'] ?? '-'); ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="font-weight-bold">Email</label>
                            <p class="form-control-plaintext"><?php echo htmlspecialchars($user['email'] ?? '-'); ?></p>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="font-weight-bold">No. Telepon</label>
                            <p class="form-control-plaintext"><?php echo htmlspecialchars($user['no_telepon'] ?? '-'); ?></p>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="font-weight-bold">Alamat</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($user['alamat'] ?? '-'); ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php else: ?>
              <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">Data Tidak Ditemukan!</h4>
                <p>Profil pengguna tidak ditemukan atau telah dihapus.</p>
                <a href="index.php?controller=Profile&action=index" class="btn btn-primary">Coba Lagi</a>
              </div>
              <?php endif; ?>
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