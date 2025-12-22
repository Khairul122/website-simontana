<?php 
include('template/header.php');

// Ambil server response dari session jika sedang dalam mode edit
$serverLog = $_SESSION['server_response_edit'] ?? null;

// Hapus session setelah diambil
unset($_SESSION['server_response_edit']);
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
                <?php echo $isEdit ? 'Edit Kategori Bencana' : 'Tambah Kategori Bencana'; ?>
              </h2>
              <p class="text-muted">
                <?php echo $isEdit ? 'Edit informasi kategori bencana' : 'Tambahkan kategori bencana baru ke sistem'; ?>
              </p>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <?php if ($isEdit && isset($serverLog) && $serverLog && !$serverLog['success']): ?>
                  <div class="alert alert-danger m-3" role="alert">
                    <h4 class="alert-heading">Error!</h4>
                    <p><?php echo htmlspecialchars($serverLog['message'] ?? 'Terjadi kesalahan saat mengambil data kategori'); ?></p>
                    <?php if (isset($serverLog['data']) && is_array($serverLog['data']) && !empty($serverLog['data'])): ?>
                      <ul class="mb-0">
                        <?php foreach ($serverLog['data'] as $error): ?>
                          <li><?php echo htmlspecialchars(is_array($error) ? json_encode($error) : $error); ?></li>
                        <?php endforeach; ?>
                      </ul>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>

                <?php if ($isEdit && (!$kategori || (isset($serverLog) && $serverLog && !$serverLog['success']))): ?>
                  <div class="alert alert-warning m-3" role="alert">
                    <h4 class="alert-heading">Peringatan!</h4>
                    <p>Data kategori tidak ditemukan atau terjadi kesalahan.</p>
                    <a href="index.php?controller=KategoriBencana&action=index" class="btn btn-primary">Kembali ke Daftar</a>
                  </div>
                <?php else: ?>
                <div class="card-body">
                  <h4 class="card-title">
                    <?php echo $isEdit ? 'Edit Kategori Bencana' : 'Form Tambah Kategori Bencana'; ?>
                  </h4>

                  <form method="POST"
                        action="index.php?controller=KategoriBencana&action=<?php echo $isEdit ? 'update&id=' . $kategori['id'] : 'store'; ?>">
                    <div class="form-group">
                      <label for="nama_kategori">Nama Kategori *</label>
                      <input type="text"
                             class="form-control"
                             id="nama_kategori"
                             name="nama_kategori"
                             value="<?php echo htmlspecialchars($kategori['nama_kategori'] ?? $kategori['nama'] ?? ''); ?>"
                             required>
                      <small class="form-text text-muted">Nama kategori bencana (contoh: Banjir, Gempa Bumi)</small>
                    </div>

                    <div class="form-group">
                      <label for="deskripsi">Deskripsi</label>
                      <textarea class="form-control"
                                id="deskripsi"
                                name="deskripsi"
                                rows="4"><?php echo htmlspecialchars($kategori['deskripsi'] ?? ''); ?></textarea>
                      <small class="form-text text-muted">Deskripsi lengkap tentang jenis bencana ini</small>
                    </div>

                    <div class="form-group">
                      <label for="icon">Icon (Kode/Nama)</label>
                      <input type="text"
                             class="form-control"
                             id="icon"
                             name="icon"
                             placeholder="Contoh: water, fire, earthquake"
                             value="<?php echo htmlspecialchars($kategori['icon'] ?? ''); ?>">
                      <small class="form-text text-muted">Nama atau kode icon untuk kategori ini</small>
                    </div>

                    <div class="d-flex justify-content-between">
                      <a href="index.php?controller=KategoriBencana&action=index" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                      </a>

                      <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-content-save"></i>
                        <?php echo $isEdit ? 'Update' : 'Simpan'; ?>
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

  <!-- Console Log untuk debugging saat edit -->
  <?php if ($isEdit && $serverLog): ?>
  <script>
    console.log('Server Response (Edit):', <?php echo json_encode($serverLog); ?>);
  </script>
  <?php endif; ?>

  <!-- SweetAlert2 Toast Notification -->
  <script>
    <?php if (isset($_SESSION['toast_message'])): ?>
      const toastData = <?php echo json_encode($_SESSION['toast_message']); ?>;

      // Show toast notification
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: toastData.type,
          title: toastData.title,
          text: toastData.message,
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        });
      }

      <?php unset($_SESSION['toast_message']); ?>
    <?php endif; ?>
  </script>
</body>

</html>