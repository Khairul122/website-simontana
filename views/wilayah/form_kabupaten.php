<?php
include('template/header.php');

// Ambil server response jika ada
$serverLog = $_SESSION['server_response_edit'] ?? null;
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
                <?php echo $isEdit ? 'Edit Kabupaten' : 'Tambah Kabupaten'; ?>
              </h2>
              <p class="text-muted">
                <?php echo $isEdit ? 'Edit informasi kabupaten' : 'Tambahkan kabupaten baru ke sistem'; ?>
              </p>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <?php if ($isEdit && !$kabupaten): ?>
                  <div class="alert alert-warning m-3" role="alert">
                    <h4 class="alert-heading">Peringatan!</h4>
                    <p>Data kabupaten tidak ditemukan.</p>
                    <a href="index.php?controller=Wilayah&action=indexKabupaten" class="btn btn-primary">Kembali ke Daftar</a>
                  </div>
                <?php else: ?>
                <div class="card-body">
                  <h4 class="card-title">
                    <?php echo $isEdit ? 'Edit Kabupaten' : 'Form Tambah Kabupaten'; ?>
                  </h4>

                  <form method="POST"
                        action="index.php?controller=Wilayah&action=<?php echo $isEdit ? 'updateKabupaten' : 'storeKabupaten'; ?>">
                    <?php if ($isEdit): ?>
                      <input type="hidden" name="id" value="<?php echo htmlspecialchars($kabupaten['id'] ?? ''); ?>">
                    <?php endif; ?>

                    <div class="form-group">
                      <label for="nama">Nama Kabupaten *</label>
                      <input type="text"
                             class="form-control"
                             id="nama"
                             name="nama"
                             value="<?php echo htmlspecialchars($kabupaten['nama'] ?? ''); ?>"
                             required>
                      <small class="form-text text-muted">Nama kabupaten/kota</small>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="provinsi_id">Pilih Provinsi *</label>
                          <select class="form-control" id="provinsi_id" name="id_provinsi" required>
                            <option value="">-- Pilih Provinsi --</option>
                            <?php if ($isEdit && isset($kabupaten['provinsi'])): ?>
                              <option value="<?php echo $kabupaten['provinsi']['id']; ?>" selected>
                                <?php echo htmlspecialchars($kabupaten['provinsi']['nama']); ?>
                              </option>
                            <?php endif; ?>
                          </select>
                          <small class="form-text text-muted">Pilih provinsi lokasi kabupaten</small>
                        </div>
                      </div>
                    </div>

                    <div class="d-flex justify-content-between">
                      <a href="index.php?controller=Wilayah&action=indexKabupaten" class="btn btn-secondary">
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

  <!-- Load Provinsi for dropdown -->
  <script>
    // Ambil informasi apakah ini mode edit
    const isEditMode = <?php echo json_encode($isEdit ?? false); ?>;
    
    // Function async untuk load provinsi
    async function loadProvinsi(selectedId = null) {
      const provinsiSelect = $('#provinsi_id');
      provinsiSelect.empty().append('<option value="">Memuat provinsi...</option>');
      provinsiSelect.prop('disabled', true);

      try {
        const response = await $.ajax({
          url: 'index.php?controller=Wilayah&action=getAllProvinsi',
          method: 'GET',
          dataType: 'json'
        });

        if (response.success) {
          provinsiSelect.empty();
          provinsiSelect.append('<option value="">-- Pilih Provinsi --</option>');

          (response.data || []).forEach(function(provinsi) {
            const isSelected = selectedId && provinsi.id == selectedId;
            provinsiSelect.append(`<option value="${provinsi.id}" ${isSelected ? 'selected' : ''}>${provinsi.nama}</option>`);
          });
        } else if (response.http_code === 401) {
          alert("Sesi habis atau tidak valid. Silakan login ulang.");
          window.location.href = 'index.php?controller=Auth&action=logout';
        } else {
          console.error('Gagal mengambil data provinsi:', response.message);
          $('#provinsi_id').empty().append('<option value="">-- Gagal memuat data provinsi --</option>');
        }
      } catch (error) {
        console.error('Error loading provinsi:', error);
        if (error.status === 401) {
          alert("Sesi habis atau tidak valid. Silakan login ulang.");
          window.location.href = 'index.php?controller=Auth&action=logout';
        } else {
          $('#provinsi_id').empty().append('<option value="">-- Error memuat provinsi --</option>');
          alert('Gagal memuat data provinsi: ' + error.message);
        }
      } finally {
        $('#provinsi_id').prop('disabled', false);
      }
    }

    // Load provinsi saat halaman dimuat
    $(document).ready(function() {
      const selectedProvinsiId = <?php echo json_encode($kabupaten['id_provinsi'] ?? $kabupaten['provinsi']['id'] ?? null); ?>;
      loadProvinsi(selectedProvinsiId);

      // Form submission handler with validation
      $('form').on('submit', function(e) {
        const provinsiId = $('#provinsi_id').val();

        // Validate wilayah selection
        if (!provinsiId) {
          e.preventDefault();
          alert('Silakan pilih provinsi terlebih dahulu.');
          return false;
        }

        // Show confirmation before submit
        const confirmMsg = <?php echo $isEdit ? '"Apakah Anda yakin ingin memperbarui data kabupaten ini?"' : '"Apakah Anda yakin ingin menyimpan data kabupaten baru?"'; ?>;
        if (!confirm(confirmMsg)) {
          e.preventDefault();
          return false;
        }
      });
    });
  </script>
</body>

</html>