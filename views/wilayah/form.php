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
                <?php echo $isEdit ? 'Edit Desa' : 'Tambah Desa'; ?>
              </h2>
              <p class="text-muted">
                <?php echo $isEdit ? 'Edit informasi desa' : 'Tambahkan desa baru ke sistem'; ?>
              </p>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <?php if ($isEdit && !$desa): ?>
                  <div class="alert alert-warning m-3" role="alert">
                    <h4 class="alert-heading">Peringatan!</h4>
                    <p>Data desa tidak ditemukan.</p>
                    <a href="index.php?controller=Wilayah&action=index" class="btn btn-primary">Kembali ke Daftar</a>
                  </div>
                <?php else: ?>
                <div class="card-body">
                  <h4 class="card-title">
                    <?php echo $isEdit ? 'Edit Desa' : 'Form Tambah Desa'; ?>
                  </h4>

                  <form method="POST"
                        action="index.php?controller=Wilayah&action=<?php echo $isEdit ? 'update' : 'store'; ?>">
                    <?php if ($isEdit): ?>
                      <input type="hidden" name="id" value="<?php echo htmlspecialchars($desa['id'] ?? ''); ?>">
                    <?php endif; ?>

                    <div class="form-group">
                      <label for="nama">Nama Desa *</label>
                      <input type="text"
                             class="form-control"
                             id="nama"
                             name="nama"
                             value="<?php echo htmlspecialchars($desa['nama'] ?? ''); ?>"
                             required>
                      <small class="form-text text-muted">Nama desa/kelurahan</small>
                    </div>

                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="provinsi_id">Pilih Provinsi *</label>
                          <select class="form-control" id="provinsi_id" required disabled>
                            <option value="">-- Pilih Provinsi --</option>
                            <?php if ($isEdit && isset($desa['provinsi'])): ?>
                              <option value="<?php echo $desa['provinsi']['id']; ?>" selected>
                                <?php echo htmlspecialchars($desa['provinsi']['nama']); ?>
                              </option>
                            <?php endif; ?>
                          </select>
                          <input type="hidden" name="id_provinsi" id="hidden_provinsi_id" value="<?php echo $desa['provinsi']['id'] ?? ''; ?>">
                          <small class="form-text text-muted">Provinsi lokasi desa (dipilih otomatis dari kecamatan)</small>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="kabupaten_id">Pilih Kabupaten/Kota *</label>
                          <select class="form-control" id="kabupaten_id" required disabled>
                            <option value="">-- Pilih Kabupaten/Kota --</option>
                            <?php if ($isEdit && isset($desa['kabupaten'])): ?>
                              <option value="<?php echo $desa['kabupaten']['id']; ?>" selected>
                                <?php echo htmlspecialchars($desa['kabupaten']['nama']); ?>
                              </option>
                            <?php endif; ?>
                          </select>
                          <input type="hidden" name="id_kabupaten" id="hidden_kabupaten_id" value="<?php echo $desa['kabupaten']['id'] ?? ''; ?>">
                          <small class="form-text text-muted">Kabupaten/kota lokasi desa (dipilih otomatis dari kecamatan)</small>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="kecamatan_id">Pilih Kecamatan *</label>
                          <select class="form-control" id="kecamatan_id" name="id_kecamatan" required>
                            <option value="">-- Pilih Kecamatan --</option>
                            <?php if ($isEdit && isset($desa['kecamatan'])): ?>
                              <option value="<?php echo $desa['kecamatan']['id']; ?>" selected>
                                <?php echo htmlspecialchars($desa['kecamatan']['nama']); ?>
                              </option>
                            <?php endif; ?>
                          </select>
                          <small class="form-text text-muted">Pilih kecamatan lokasi desa</small>
                        </div>
                      </div>
                    </div>

                    <div class="d-flex justify-content-between">
                      <a href="index.php?controller=Wilayah&action=index" class="btn btn-secondary">
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
    const currentKecamatanId = <?php echo json_encode($desa['id_kecamatan'] ?? $desa['kecamatan']['id'] ?? null); ?>;

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
        $('#kecamatan_id').empty().append('<option value="">-- Pilih Kecamatan --</option>');
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

    // Function async untuk load kecamatan berdasarkan kabupaten
    async function loadKecamatanByKabupaten(kabupatenId, selectedId = null) {
      if (!kabupatenId) {
        $('#kecamatan_id').empty().append('<option value="">-- Pilih Kecamatan --</option>');
        return;
      }

      showLoadingInSelect('#kecamatan_id', 'Memuat kecamatan...');

      try {
        const response = await $.ajax({
          url: 'index.php?controller=Wilayah&action=getKecamatanByKabupaten',
          method: 'GET',
          data: { kabupaten_id: kabupatenId },
          dataType: 'json'
        });

        if (response.success) {
          const kecamatanSelect = $('#kecamatan_id');
          kecamatanSelect.empty();
          kecamatanSelect.append('<option value="">-- Pilih Kecamatan --</option>');

          (response.data || []).forEach(function(kecamatan) {
            const isSelected = selectedId && kecamatan.id == selectedId;
            kecamatanSelect.append(`<option value="${kecamatan.id}" ${isSelected ? 'selected' : ''}>${kecamatan.nama}</option>`);
          });
        } else if (response.http_code === 401) {
          alert("Sesi habis atau tidak valid. Silakan login ulang.");
          window.location.href = 'index.php?controller=Auth&action=logout';
        } else {
          console.error('Gagal mengambil data kecamatan:', response.message);
          $('#kecamatan_id').empty().append('<option value="">-- Gagal memuat data kecamatan --</option>');
        }
      } catch (error) {
        console.error('Error loading kecamatan:', error);
        if (error.status === 401) {
          alert("Sesi habis atau tidak valid. Silakan login ulang.");
          window.location.href = 'index.php?controller=Auth&action=logout';
        } else {
          $('#kecamatan_id').empty().append('<option value="">-- Error memuat kecamatan --</option>');
          alert('Gagal memuat data kecamatan: ' + error.message);
        }
      } finally {
        hideLoadingInSelect('#kecamatan_id');
      }
    }

    // Function untuk memperbarui hidden fields dan dropdown readonly
    function updateHiddenFields(provinsiId, kabupatenId, kecamatanId) {
      $('#hidden_provinsi_id').val(provinsiId);
      $('#hidden_kabupaten_id').val(kabupatenId);

      // Update provinsi dropdown text
      if (provinsiId) {
        const provinsiText = $('#provinsi_id option[value="' + provinsiId + '"]').text();
        $('#provinsi_id').html(`<option value="${provinsiId}" selected>${provinsiText}</option>`);
      }

      // Update kabupaten dropdown text
      if (kabupatenId) {
        const kabupatenText = $('#kabupaten_id option[value="' + kabupatenId + '"]').text();
        $('#kabupaten_id').html(`<option value="${kabupatenId}" selected>${kabupatenText}</option>`);
      }
    }

    // Init Data saat page load
    $(document).ready(function() {
      if (isEditMode && currentKecamatanId) {
        // Mode edit - Muat data hierarki secara berurutan untuk pre-fill
        // Kita perlu mengambil data kecamatan untuk mendapatkan parent (kabupaten) dan parent dari parent (provinsi)
        loadKecamatanByKabupatenForEdit(currentKecamatanId);
      } else {
        // Mode create - Load provinsi saja
        loadProvinsi();
      }

      // Event handler untuk perubahan provinsi
      $('#provinsi_id').change(function() {
        const provinsiId = $(this).val();

        // Reset dropdown berikutnya
        $('#kabupaten_id').empty().append('<option value="">-- Pilih Kabupaten/Kota --</option>');
        $('#kecamatan_id').empty().append('<option value="">-- Pilih Kecamatan --</option>');

        if (provinsiId) {
          loadKabupatenByProvinsi(provinsiId);
        }
      });

      // Event handler untuk perubahan kabupaten
      $('#kabupaten_id').change(function() {
        const kabupatenId = $(this).val();

        // Reset dropdown kecamatan
        $('#kecamatan_id').empty().append('<option value="">-- Pilih Kecamatan --</option>');

        if (kabupatenId) {
          loadKecamatanByKabupaten(kabupatenId);
        }
      });

      // Form submission handler with validation
      $('form').on('submit', function(e) {
        const kecamatanId = $('#kecamatan_id').val();

        // Validate wilayah selection - hanya kecamatan yang dibutuhkan
        if (!kecamatanId) {
          e.preventDefault();
          alert('Silakan pilih kecamatan terlebih dahulu.');
          return false;
        }

        // Show confirmation before submit
        const confirmMsg = <?php echo $isEdit ? '"Apakah Anda yakin ingin memperbarui data desa ini?"' : '"Apakah Anda yakin ingin menyimpan data desa baru?"'; ?>;
        if (!confirm(confirmMsg)) {
          e.preventDefault();
          return false;
        }
      });
    });

    // Function khusus untuk mode edit - mengambil informasi hierarki dari ID desa
    async function loadKecamatanByKabupatenForEdit(desaId) {
      // Kita gunakan endpoint hierarchy untuk mendapatkan informasi lengkap
      try {
        const hierarchyResponse = await $.ajax({
          url: 'index.php?controller=Wilayah&action=getWilayahHierarchyByDesa',
          method: 'GET',
          data: { desa_id: desaId },
          dataType: 'json'
        });

        if (hierarchyResponse.success) {
          const hierarchyData = hierarchyResponse.data;
          // Data hierarki biasanya berisi informasi dari desa ke atas (kecamatan, kabupaten, provinsi)
          const provinsiId = hierarchyData.provinsi?.id || null;
          const kabupatenId = hierarchyData.kabupaten?.id || null;
          const kecamatanId = hierarchyData.kecamatan?.id || null;

          if (provinsiId && kabupatenId && kecamatanId) {
            // Muat provinsi, kabupaten, dan kecamatan
            loadProvinsi(provinsiId).then(() => {
              return loadKabupatenByProvinsi(provinsiId, kabupatenId);
            }).then(() => {
              return loadKecamatanByKabupaten(kabupatenId, kecamatanId);
            }).then(() => {
              // Update hidden fields setelah semua data dimuat
              updateHiddenFields(provinsiId, kabupatenId, kecamatanId);
            });
          }
        } else {
          // Jika endpoint hierarchy gagal, kita coba endpoint detail
          const detailResponse = await $.ajax({
            url: 'index.php?controller=Wilayah&action=getWilayahById',
            method: 'GET',
            data: { id: desaId },
            dataType: 'json'
          });

          if (detailResponse.success) {
            const desaData = detailResponse.data;
            // Dapatkan ID kecamatan dari id_parent
            const kecamatanId = desaData.id_parent;

            if (kecamatanId) {
              // Ambil detail kecamatan untuk mendapatkan parent (kabupaten)
              const kecamatanResponse = await $.ajax({
                url: 'index.php?controller=Wilayah&action=getWilayahById',
                method: 'GET',
                data: { id: kecamatanId },
                dataType: 'json'
              });

              if (kecamatanResponse.success) {
                const kecamatanData = kecamatanResponse.data;
                const kabupatenId = kecamatanData.id_parent;

                if (kabupatenId) {
                  // Ambil detail kabupaten untuk mendapatkan parent (provinsi)
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
                      // Muat provinsi, kabupaten, dan kecamatan
                      loadProvinsi(provinsiId).then(() => {
                        return loadKabupatenByProvinsi(provinsiId, kabupatenId);
                      }).then(() => {
                        return loadKecamatanByKabupaten(kabupatenId, kecamatanId);
                      }).then(() => {
                        // Update hidden fields setelah semua data dimuat
                        updateHiddenFields(provinsiId, kabupatenId, kecamatanId);
                      });
                    }
                  }
                }
              }
            }
          }
        }
      } catch (error) {
        console.error('Error loading hierarchy data for edit:', error);
        if (error.status === 401) {
          alert("Sesi habis atau tidak valid. Silakan login ulang.");
          window.location.href = 'index.php?controller=Auth&action=logout';
        } else {
          alert('Gagal memuat data hierarki wilayah: ' + error.message);
        }
      }
    }
  </script>
</body>

</html>
