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
                <?php echo $isEdit ? 'Edit Kecamatan' : 'Tambah Kecamatan'; ?>
              </h2>
              <p class="text-muted">
                <?php echo $isEdit ? 'Edit informasi kecamatan' : 'Tambahkan kecamatan baru ke sistem'; ?>
              </p>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <?php if ($isEdit && !$kecamatan): ?>
                  <div class="alert alert-warning m-3" role="alert">
                    <h4 class="alert-heading">Peringatan!</h4>
                    <p>Data kecamatan tidak ditemukan.</p>
                    <a href="index.php?controller=Wilayah&action=indexKecamatan" class="btn btn-primary">Kembali ke Daftar</a>
                  </div>
                <?php else: ?>
                <div class="card-body">
                  <h4 class="card-title">
                    <?php echo $isEdit ? 'Edit Kecamatan' : 'Form Tambah Kecamatan'; ?>
                  </h4>

                  <form method="POST"
                        action="index.php?controller=Wilayah&action=<?php echo $isEdit ? 'updateKecamatan' : 'storeKecamatan'; ?>">
                    <?php if ($isEdit): ?>
                      <input type="hidden" name="id" value="<?php echo htmlspecialchars($kecamatan['id'] ?? ''); ?>">
                    <?php endif; ?>

                    <div class="form-group">
                      <label for="nama">Nama Kecamatan *</label>
                      <input type="text"
                             class="form-control"
                             id="nama"
                             name="nama"
                             value="<?php echo htmlspecialchars($kecamatan['nama'] ?? ''); ?>"
                             required>
                      <small class="form-text text-muted">Nama kecamatan</small>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="provinsi_id">Pilih Provinsi *</label>
                          <select class="form-control" id="provinsi_id" required disabled>
                            <option value="">-- Pilih Provinsi --</option>
                            <?php if ($isEdit && isset($kecamatan['provinsi'])): ?>
                              <option value="<?php echo $kecamatan['provinsi']['id']; ?>" selected>
                                <?php echo htmlspecialchars($kecamatan['provinsi']['nama']); ?>
                              </option>
                            <?php endif; ?>
                          </select>
                          <input type="hidden" name="id_provinsi" id="hidden_provinsi_id" value="<?php echo $kecamatan['provinsi']['id'] ?? ''; ?>">
                          <small class="form-text text-muted">Provinsi lokasi kecamatan (dipilih otomatis dari kabupaten)</small>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="kabupaten_id">Pilih Kabupaten/Kota *</label>
                          <select class="form-control" id="kabupaten_id" name="id_kabupaten" required>
                            <option value="">-- Pilih Kabupaten/Kota --</option>
                            <?php if ($isEdit && isset($kecamatan['kabupaten'])): ?>
                              <option value="<?php echo $kecamatan['kabupaten']['id']; ?>" selected>
                                <?php echo htmlspecialchars($kecamatan['kabupaten']['nama']); ?>
                              </option>
                            <?php endif; ?>
                          </select>
                          <small class="form-text text-muted">Pilih kabupaten/kota lokasi kecamatan</small>
                        </div>
                      </div>
                    </div>

                    <div class="d-flex justify-content-between">
                      <a href="index.php?controller=Wilayah&action=indexKecamatan" class="btn btn-secondary">
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

  <!-- Cascading Dropdown Wilayah -->
  <script>
    // Ambil informasi apakah ini mode edit
    const isEditMode = <?php echo json_encode($isEdit ?? false); ?>;
    const currentKabupatenId = <?php echo json_encode($kecamatan['id_kabupaten'] ?? $kecamatan['kabupaten']['id'] ?? null); ?>;

    // Function untuk menampilkan loading di dropdown
    function showLoadingInSelect(selector, text = 'Memuat...') {
      const select = $(selector);
      select.empty().append(`<option value="">${text}</option>`);
      select.prop('disabled', true);
    }

    // Function untuk menyembunyikan loading di dropdown
    function hideLoadingInSelect(selector) {
      $(selector).prop('disabled', false);
    }

    // Function async untuk load provinsi
    async function loadProvinsi(selectedId = null) {
      showLoadingInSelect('#provinsi_id', 'Memuat provinsi...');

      try {
        const response = await $.ajax({
          url: 'index.php?controller=Wilayah&action=getAllProvinsi',
          method: 'GET',
          dataType: 'json'
        });

        if (response.success) {
          const provinsiSelect = $('#provinsi_id');
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
        hideLoadingInSelect('#provinsi_id');
      }
    }

    // Function async untuk load kabupaten berdasarkan provinsi
    async function loadKabupatenByProvinsi(provinsiId, selectedId = null) {
      if (!provinsiId) {
        $('#kabupaten_id').empty().append('<option value="">-- Pilih Kabupaten/Kota --</option>');
        return;
      }

      showLoadingInSelect('#kabupaten_id', 'Memuat kabupaten...');

      try {
        const response = await $.ajax({
          url: 'index.php?controller=Wilayah&action=getKabupatenByProvinsi',
          method: 'GET',
          data: { provinsi_id: provinsiId },
          dataType: 'json'
        });

        if (response.success) {
          const kabupatenSelect = $('#kabupaten_id');
          kabupatenSelect.empty();
          kabupatenSelect.append('<option value="">-- Pilih Kabupaten/Kota --</option>');

          (response.data || []).forEach(function(kabupaten) {
            const isSelected = selectedId && kabupaten.id == selectedId;
            kabupatenSelect.append(`<option value="${kabupaten.id}" ${isSelected ? 'selected' : ''}>${kabupaten.nama}</option>`);
          });
        } else if (response.http_code === 401) {
          alert("Sesi habis atau tidak valid. Silakan login ulang.");
          window.location.href = 'index.php?controller=Auth&action=logout';
        } else {
          console.error('Gagal mengambil data kabupaten:', response.message);
          $('#kabupaten_id').empty().append('<option value="">-- Gagal memuat data kabupaten --</option>');
        }
      } catch (error) {
        console.error('Error loading kabupaten:', error);
        if (error.status === 401) {
          alert("Sesi habis atau tidak valid. Silakan login ulang.");
          window.location.href = 'index.php?controller=Auth&action=logout';
        } else {
          $('#kabupaten_id').empty().append('<option value="">-- Error memuat kabupaten --</option>');
          alert('Gagal memuat data kabupaten: ' + error.message);
        }
      } finally {
        hideLoadingInSelect('#kabupaten_id');
      }
    }

    // Function untuk memperbarui hidden fields dan dropdown readonly
    function updateHiddenFields(provinsiId, kabupatenId) {
      $('#hidden_provinsi_id').val(provinsiId);
      
      // Update provinsi dropdown text
      if (provinsiId) {
        const provinsiText = $('#provinsi_id option[value="' + provinsiId + '"]').text();
        $('#provinsi_id').html(`<option value="${provinsiId}" selected>${provinsiText}</option>`);
      }
    }

    // Init Data saat page load
    $(document).ready(function() {
      if (isEditMode && currentKabupatenId) {
        // Mode edit - Muat data hierarki untuk pre-fill
        loadKabupatenAndProvinsiForEdit(currentKabupatenId);
      } else {
        // Mode create - Load provinsi saja
        loadProvinsi();
      }

      // Event handler untuk perubahan provinsi
      $('#provinsi_id').change(function() {
        const provinsiId = $(this).val();

        // Reset dropdown kabupaten
        $('#kabupaten_id').empty().append('<option value="">-- Pilih Kabupaten/Kota --</option>');

        if (provinsiId) {
          loadKabupatenByProvinsi(provinsiId);
        }
      });

      // Form submission handler with validation
      $('form').on('submit', function(e) {
        const kabupatenId = $('#kabupaten_id').val();

        // Validate wilayah selection - hanya kabupaten yang dibutuhkan
        if (!kabupatenId) {
          e.preventDefault();
          alert('Silakan pilih kabupaten terlebih dahulu.');
          return false;
        }

        // Show confirmation before submit
        const confirmMsg = <?php echo $isEdit ? '"Apakah Anda yakin ingin memperbarui data kecamatan ini?"' : '"Apakah Anda yakin ingin menyimpan data kecamatan baru?"'; ?>;
        if (!confirm(confirmMsg)) {
          e.preventDefault();
          return false;
        }
      });
    });
    
    // Function khusus untuk mode edit - mengambil informasi hierarki dari ID kecamatan
    async function loadKabupatenAndProvinsiForEdit(kabupatenId) {
      try {
        const kabupatenResponse = await $.ajax({
          url: 'index.php?controller=Wilayah&action=getWilayahById',
          method: 'GET',
          data: { id: kabupatenId },
          dataType: 'json'
        });
        
        if (kabupatenResponse.success) {
          const kabupatenData = kabupatenResponse.data;
          const provinsiId = kabupatenData.id_parent;
          
          if (provinsiId) {
            // Muat provinsi dan kabupaten
            loadProvinsi(provinsiId).then(() => {
              return loadKabupatenByProvinsi(provinsiId, kabupatenId);
            }).then(() => {
              // Update hidden fields setelah semua data dimuat
              updateHiddenFields(provinsiId, kabupatenId);
            });
          }
        }
      } catch (error) {
        console.error('Error loading kabupaten data for edit:', error);
        if (error.status === 401) {
          alert("Sesi habis atau tidak valid. Silakan login ulang.");
          window.location.href = 'index.php?controller=Auth&action=logout';
        } else {
          alert('Gagal memuat data wilayah: ' + error.message);
        }
      }
    }
  </script>
</body>

</html>