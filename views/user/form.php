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
                <?php echo $isEdit ? 'Edit Pengguna' : 'Tambah Pengguna'; ?>
              </h2>
              <p class="text-muted">
                <?php echo $isEdit ? 'Edit informasi pengguna' : 'Tambahkan pengguna baru ke sistem'; ?>
              </p>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <?php if ($isEdit && isset($serverLog) && $serverLog && !$serverLog['success']): ?>
                  <div class="alert alert-danger m-3" role="alert">
                    <h4 class="alert-heading">Error!</h4>
                    <p><?php echo htmlspecialchars($serverLog['message'] ?? 'Terjadi kesalahan saat mengambil data pengguna'); ?></p>
                    <?php if (isset($serverLog['data']) && is_array($serverLog['data']) && !empty($serverLog['data'])): ?>
                      <ul class="mb-0">
                        <?php foreach ($serverLog['data'] as $error): ?>
                          <li><?php echo htmlspecialchars(is_array($error) ? json_encode($error) : $error); ?></li>
                        <?php endforeach; ?>
                      </ul>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>

                <?php if ($isEdit && (!$user || (isset($serverLog) && $serverLog && !$serverLog['success']))): ?>
                  <div class="alert alert-warning m-3" role="alert">
                    <h4 class="alert-heading">Peringatan!</h4>
                    <p>Data pengguna tidak ditemukan atau terjadi kesalahan.</p>
                    <a href="index.php?controller=User&action=index" class="btn btn-primary">Kembali ke Daftar</a>
                  </div>
                <?php else: ?>
                <div class="card-body">
                  <h4 class="card-title">
                    <?php echo $isEdit ? 'Edit Pengguna' : 'Form Tambah Pengguna'; ?>
                  </h4>

                  <form method="POST"
                        action="index.php?controller=User&action=<?php echo $isEdit ? 'update&id=' . $user['id'] : 'store'; ?>">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="nama">Nama *</label>
                          <input type="text"
                                 class="form-control"
                                 id="nama"
                                 name="nama"
                                 value="<?php echo htmlspecialchars($user['nama'] ?? ''); ?>"
                                 required>
                          <small class="form-text text-muted">Nama lengkap pengguna</small>
                        </div>

                        <div class="form-group">
                          <label for="username">Username *</label>
                          <input type="text"
                                 class="form-control"
                                 id="username"
                                 name="username"
                                 value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>"
                                 required>
                          <small class="form-text text-muted">Username unik untuk login</small>
                        </div>

                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email"
                                 class="form-control"
                                 id="email"
                                 name="email"
                                 value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                          <small class="form-text text-muted">Alamat email pengguna</small>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="no_telepon">No Telepon</label>
                          <input type="text"
                                 class="form-control"
                                 id="no_telepon"
                                 name="no_telepon"
                                 value="<?php echo htmlspecialchars($user['no_telepon'] ?? ''); ?>">
                          <small class="form-text text-muted">Nomor telepon pengguna</small>
                        </div>

                        <div class="form-group">
                          <label for="role">Role *</label>
                          <select class="form-control" id="role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="Admin"
                                    <?php echo (isset($user['role']) && $user['role'] === 'Admin') ? 'selected' : ''; ?>>
                              Admin
                            </option>
                            <option value="PetugasBPBD"
                                    <?php echo (isset($user['role']) && $user['role'] === 'PetugasBPBD') ? 'selected' : ''; ?>>
                              Petugas BPBD
                            </option>
                            <option value="OperatorDesa"
                                    <?php echo (isset($user['role']) && $user['role'] === 'OperatorDesa') ? 'selected' : ''; ?>>
                              Operator Desa
                            </option>
                            <option value="Warga"
                                    <?php echo (isset($user['role']) && $user['role'] === 'Warga') ? 'selected' : ''; ?>>
                              Warga
                            </option>
                          </select>
                          <small class="form-text text-muted">Hak akses pengguna dalam sistem</small>
                        </div>

                        <div class="form-group">
                          <label for="password">
                            <?php echo $isEdit ? 'Password (Kosongkan jika tidak ingin mengganti)' : 'Password *'; ?>
                          </label>
                          <input type="password"
                                 class="form-control"
                                 id="password"
                                 name="password"
                                 <?php if (!$isEdit) { echo 'required'; } ?>>
                          <?php if ($isEdit): ?>
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti password</small>
                          <?php else: ?>
                            <small class="form-text text-muted">Password minimal 6 karakter</small>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="alamat">Alamat</label>
                      <textarea class="form-control"
                                id="alamat"
                                name="alamat"
                                rows="3"><?php echo htmlspecialchars($user['alamat'] ?? ''); ?></textarea>
                      <small class="form-text text-muted">Alamat lengkap pengguna</small>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="provinsi_id">Pilih Provinsi</label>
                          <select class="form-control" id="provinsi_id" name="id_provinsi">
                            <option value="">-- Pilih Provinsi --</option>
                            <?php if ($isEdit && isset($user['desa']['kecamatan']['kabupaten']['provinsi'])): ?>
                              <option value="<?php echo $user['desa']['kecamatan']['kabupaten']['provinsi']['id']; ?>" selected>
                                <?php echo htmlspecialchars($user['desa']['kecamatan']['kabupaten']['provinsi']['nama']); ?>
                              </option>
                            <?php endif; ?>
                          </select>
                          <small class="form-text text-muted">Pilih provinsi tempat tinggal pengguna</small>
                        </div>

                        <div class="form-group">
                          <label for="kabupaten_id">Pilih Kabupaten/Kota</label>
                          <select class="form-control" id="kabupaten_id" name="id_kabupaten">
                            <option value="">-- Pilih Kabupaten/Kota --</option>
                            <?php if ($isEdit && isset($user['desa']['kecamatan']['kabupaten'])): ?>
                              <option value="<?php echo $user['desa']['kecamatan']['kabupaten']['id']; ?>" selected>
                                <?php echo htmlspecialchars($user['desa']['kecamatan']['kabupaten']['nama']); ?>
                              </option>
                            <?php endif; ?>
                          </select>
                          <small class="form-text text-muted">Pilih kabupaten/kota tempat tinggal pengguna</small>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="kecamatan_id">Pilih Kecamatan</label>
                          <select class="form-control" id="kecamatan_id" name="id_kecamatan">
                            <option value="">-- Pilih Kecamatan --</option>
                            <?php if ($isEdit && isset($user['desa']['kecamatan'])): ?>
                              <option value="<?php echo $user['desa']['kecamatan']['id']; ?>" selected>
                                <?php echo htmlspecialchars($user['desa']['kecamatan']['nama']); ?>
                              </option>
                            <?php endif; ?>
                          </select>
                          <small class="form-text text-muted">Pilih kecamatan tempat tinggal pengguna</small>
                        </div>

                        <div class="form-group">
                          <label for="desa_id">Pilih Desa/Kelurahan *</label>
                          <select class="form-control" id="desa_id" name="id_desa" required>
                            <option value="">-- Pilih Desa/Kelurahan --</option>
                            <?php if ($isEdit && isset($user['desa'])): ?>
                              <option value="<?php echo $user['desa']['id']; ?>" selected>
                                <?php echo htmlspecialchars($user['desa']['nama']); ?>
                              </option>
                            <?php endif; ?>
                          </select>
                          <small class="form-text text-muted">Pilih desa/kelurahan tempat tinggal pengguna (wajib)</small>
                        </div>
                      </div>
                    </div>

                    <div class="d-flex justify-content-between">
                      <a href="index.php?controller=User&action=index" class="btn btn-secondary">
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

  <!-- Server Response Toast Notifications -->
  <script>
    // Show toast for server responses
    function showServerResponseToast(icon, title, message) {
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: icon,
          title: title,
          text: message,
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
      } else {
        // Fallback to native alert if Swal is not available
        alert(`${title}: ${message}`);
      }
    }

    // Handle success responses
    <?php if (isset($_GET['success'])): ?>
      showServerResponseToast('success', 'Berhasil', '<?php echo htmlspecialchars(urldecode($_GET['success'])); ?>');
    <?php endif; ?>

    // Handle error responses
    <?php if (isset($_GET['error'])): ?>
      showServerResponseToast('error', 'Gagal', '<?php echo htmlspecialchars(urldecode($_GET['error'])); ?>');
    <?php endif; ?>

    // Cascading dropdown wilayah (PROXY PATTERN - Using local controller as proxy)
    $(document).ready(function() {
        // Ambil informasi apakah ini mode edit
        const isEditMode = <?php echo json_encode($isEdit ?? false); ?>;
        const currentDesaId = <?php echo json_encode($user['id_desa'] ?? null); ?>;

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
                    // Handle unauthorized error
                    alert("Sesi habis atau tidak valid. Silakan login ulang.");
                    window.location.href = 'index.php?controller=Auth&action=logout';
                } else {
                    console.error('Gagal mengambil data provinsi:', response.message);
                    $('#provinsi_id').empty().append('<option value="">-- Gagal memuat data provinsi --</option>');
                }
            } catch (error) {
                console.error('Error loading provinsi:', error);
                if (error.status === 401) {
                    // Handle unauthorized error
                    alert("Sesi habis atau tidak valid. Silakan login ulang.");
                    window.location.href = 'index.php?controller=Auth&action=logout';
                } else {
                    $('#provinsi_id').empty().append('<option value="">-- Error memuat provinsi --</option>');
                    showServerResponseToast('error', 'Error', 'Gagal memuat data provinsi: ' + error.message);
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
                    // Handle unauthorized error
                    alert("Sesi habis atau tidak valid. Silakan login ulang.");
                    window.location.href = 'index.php?controller=Auth&action=logout';
                } else {
                    console.error('Gagal mengambil data kabupaten:', response.message);
                    $('#kabupaten_id').empty().append('<option value="">-- Gagal memuat data kabupaten --</option>');
                }
            } catch (error) {
                console.error('Error loading kabupaten:', error);
                if (error.status === 401) {
                    // Handle unauthorized error
                    alert("Sesi habis atau tidak valid. Silakan login ulang.");
                    window.location.href = 'index.php?controller=Auth&action=logout';
                } else {
                    $('#kabupaten_id').empty().append('<option value="">-- Error memuat kabupaten --</option>');
                    showServerResponseToast('error', 'Error', 'Gagal memuat data kabupaten: ' + error.message);
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
                    // Handle unauthorized error
                    alert("Sesi habis atau tidak valid. Silakan login ulang.");
                    window.location.href = 'index.php?controller=Auth&action=logout';
                } else {
                    console.error('Gagal mengambil data kecamatan:', response.message);
                    $('#kecamatan_id').empty().append('<option value="">-- Gagal memuat data kecamatan --</option>');
                }
            } catch (error) {
                console.error('Error loading kecamatan:', error);
                if (error.status === 401) {
                    // Handle unauthorized error
                    alert("Sesi habis atau tidak valid. Silakan login ulang.");
                    window.location.href = 'index.php?controller=Auth&action=logout';
                } else {
                    $('#kecamatan_id').empty().append('<option value="">-- Error memuat kecamatan --</option>');
                    showServerResponseToast('error', 'Error', 'Gagal memuat data kecamatan: ' + error.message);
                }
            } finally {
                hideLoadingInSelect('#kecamatan_id');
            }
        }

        // Function async untuk load desa berdasarkan kecamatan
        async function loadDesaByKecamatan(kecamatanId, selectedId = null) {
            if (!kecamatanId) {
                $('#desa_id').empty().append('<option value="">-- Pilih Desa/Kelurahan --</option>');
                return;
            }

            showLoadingInSelect('#desa_id', 'Memuat desa...');

            try {
                const response = await $.ajax({
                    url: 'index.php?controller=Wilayah&action=getDesaByKecamatan',
                    method: 'GET',
                    data: { kecamatan_id: kecamatanId },
                    dataType: 'json'
                });

                if (response.success) {
                    const desaSelect = $('#desa_id');
                    desaSelect.empty();
                    desaSelect.append('<option value="">-- Pilih Desa/Kelurahan --</option>');

                    (response.data || []).forEach(function(desa) {
                        const isSelected = selectedId && desa.id == selectedId;
                        desaSelect.append(`<option value="${desa.id}" ${isSelected ? 'selected' : ''}>${desa.nama}</option>`);
                    });
                } else if (response.http_code === 401) {
                    // Handle unauthorized error
                    alert("Sesi habis atau tidak valid. Silakan login ulang.");
                    window.location.href = 'index.php?controller=Auth&action=logout';
                } else {
                    console.error('Gagal mengambil data desa:', response.message);
                    $('#desa_id').empty().append('<option value="">-- Gagal memuat data desa --</option>');
                }
            } catch (error) {
                console.error('Error loading desa:', error);
                if (error.status === 401) {
                    // Handle unauthorized error
                    alert("Sesi habis atau tidak valid. Silakan login ulang.");
                    window.location.href = 'index.php?controller=Auth&action=logout';
                } else {
                    $('#desa_id').empty().append('<option value="">-- Error memuat desa --</option>');
                    showServerResponseToast('error', 'Error', 'Gagal memuat data desa: ' + error.message);
                }
            } finally {
                hideLoadingInSelect('#desa_id');
            }
        }

        // Function async untuk memuat data wilayah lengkap saat edit mode
        async function loadWilayahForEdit(desaId) {
            if (!desaId) return;

            try {
                // Ambil detail hierarki wilayah
                const detailResponse = await $.ajax({
                    url: 'index.php?controller=Wilayah&action=getWilayahDetailByDesa',
                    method: 'GET',
                    data: { desa_id: desaId },
                    dataType: 'json'
                });

                if (detailResponse.http_code === 401) {
                    // Handle unauthorized error
                    alert("Sesi habis atau tidak valid. Silakan login ulang.");
                    window.location.href = 'index.php?controller=Auth&action=logout';
                    return;
                }

                if (!detailResponse.success || !detailResponse.data) {
                    throw new Error(detailResponse.message || 'Data wilayah tidak ditemukan');
                }

                const desa = detailResponse.data;
                const kecamatan = detailResponse.data.kecamatan;
                const kabupaten = detailResponse.data.kecamatan?.kabupaten;
                const provinsi = detailResponse.data.kecamatan?.kabupaten?.provinsi;

                // Load provinsi dan tunggu selesai
                await loadProvinsi(provinsi?.id);
                $('#provinsi_id').val(provinsi?.id);

                // Load kabupaten berdasarkan provinsi dan tunggu selesai
                await loadKabupatenByProvinsi(provinsi?.id, kabupaten?.id);
                $('#kabupaten_id').val(kabupaten?.id);

                // Load kecamatan berdasarkan kabupaten dan tunggu selesai
                await loadKecamatanByKabupaten(kabupaten?.id, kecamatan?.id);
                $('#kecamatan_id').val(kecamatan?.id);

                // Load desa berdasarkan kecamatan dan set value
                await loadDesaByKecamatan(kecamatan?.id, desa?.id);
                $('#desa_id').val(desa?.id);

            } catch (error) {
                console.error('Error loading wilayah hierarchy for edit mode:', error);
                if (error.status === 401 || (error.responseJSON && error.responseJSON.http_code === 401)) {
                    // Handle unauthorized error
                    alert("Sesi habis atau tidak valid. Silakan login ulang.");
                    window.location.href = 'index.php?controller=Auth&action=logout';
                } else {
                    showServerResponseToast('error', 'Gagal', 'Gagal mengambil data wilayah: ' + error.message);
                    // Redirect ke halaman index
                    setTimeout(() => {
                        window.location.href = 'index.php?controller=User&action=index';
                    }, 2000);
                }
            }
        }

        // Init Edit Data - Jika mode edit, muat hirarki wilayah secara berurutan
        if (isEditMode && currentDesaId) {
            loadWilayahForEdit(currentDesaId);
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
            $('#desa_id').empty().append('<option value="">-- Pilih Desa/Kelurahan --</option>');

            if (provinsiId) {
                // Load kabupaten berdasarkan provinsi
                loadKabupatenByProvinsi(provinsiId);
            }
        });

        // Event handler untuk perubahan kabupaten
        $('#kabupaten_id').change(function() {
            const kabupatenId = $(this).val();

            // Reset dropdown berikutnya
            $('#kecamatan_id').empty().append('<option value="">-- Pilih Kecamatan --</option>');
            $('#desa_id').empty().append('<option value="">-- Pilih Desa/Kelurahan --</option>');

            if (kabupatenId) {
                // Load kecamatan berdasarkan kabupaten
                loadKecamatanByKabupaten(kabupatenId);
            }
        });

        // Event handler untuk perubahan kecamatan
        $('#kecamatan_id').change(function() {
            const kecamatanId = $(this).val();

            // Reset dropdown desa
            $('#desa_id').empty().append('<option value="">-- Pilih Desa/Kelurahan --</option>');

            if (kecamatanId) {
                // Load desa berdasarkan kecamatan
                loadDesaByKecamatan(kecamatanId);
            }
        });

        // Form submission handler with validation and notifications
        $('form').on('submit', function(e) {
            const provinsiId = $('#provinsi_id').val();
            const kabupatenId = $('#kabupaten_id').val();
            const kecamatanId = $('#kecamatan_id').val();
            const desaId = $('#desa_id').val();

            // Validate wilayah selection
            if (!provinsiId || !kabupatenId || !kecamatanId || !desaId) {
                e.preventDefault();
                showServerResponseToast('warning', 'Peringatan', 'Silakan lengkapi semua pilihan wilayah terlebih dahulu.');
                return false;
            }

            // Show loading or confirmation before submit
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: <?php echo $isEdit ? '"Apakah Anda yakin ingin memperbarui data pengguna ini?"' : '"Apakah Anda yakin ingin menyimpan data pengguna baru?"'; ?>,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, <?php echo $isEdit ? 'Perbarui' : 'Simpan'; ?>',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (!result.isConfirmed) {
                        e.preventDefault();
                    }
                });
            }
        });
    });
  </script>
</body>

</html>