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
                                 <?php if (!$isEdit): echo 'required'; ?>>
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

                    <?php if (!$isEdit): ?>
                    <div class="d-flex justify-content-between">
                      <a href="index.php?controller=User&action=index" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                      </a>

                      <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-content-save"></i>
                        <?php echo $isEdit ? 'Update' : 'Simpan'; ?>
                      </button>
                    </div>
                    <?php endif; ?>
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

  <?php endif; ?>

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

    // Cascading dropdown wilayah
    $(document).ready(function() {
        // Ambil token dari session PHP
        const token = '<?php echo $_SESSION['token'] ?? ''; ?>';

        // Function untuk load provinsi
        function loadProvinsi() {
            $.ajax({
                url: 'http://localhost:8000/api/wilayah/provinsi',
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(response) {
                    if (response.success) {
                        const provinsiSelect = $('#provinsi_id');
                        provinsiSelect.empty();
                        provinsiSelect.append('<option value="">-- Pilih Provinsi --</option>');

                        response.data.forEach(function(provinsi) {
                            provinsiSelect.append('<option value="' + provinsi.id + '">' + provinsi.nama + '</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading provinsi:', error);
                }
            });
        }

        // Load provinsi saat halaman dimuat
        loadProvinsi();

        // Event handler untuk perubahan provinsi
        $('#provinsi_id').change(function() {
            const provinsiId = $(this).val();

            // Reset dropdown berikutnya
            $('#kabupaten_id').empty().append('<option value="">-- Pilih Kabupaten/Kota --</option>');
            $('#kecamatan_id').empty().append('<option value="">-- Pilih Kecamatan --</option>');
            $('#desa_id').empty().append('<option value="">-- Pilih Desa/Kelurahan --</option>');

            if (provinsiId) {
                // Load kabupaten berdasarkan provinsi
                $.ajax({
                    url: 'http://localhost:8000/api/wilayah/kabupaten/' + provinsiId,
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    success: function(response) {
                        if (response.success) {
                            const kabupatenSelect = $('#kabupaten_id');
                            kabupatenSelect.empty();
                            kabupatenSelect.append('<option value="">-- Pilih Kabupaten/Kota --</option>');

                            response.data.forEach(function(kabupaten) {
                                kabupatenSelect.append('<option value="' + kabupaten.id + '">' + kabupaten.nama + '</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading kabupaten:', error);
                    }
                });
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
                $.ajax({
                    url: 'http://localhost:8000/api/wilayah/kecamatan/' + kabupatenId,
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    success: function(response) {
                        if (response.success) {
                            const kecamatanSelect = $('#kecamatan_id');
                            kecamatanSelect.empty();
                            kecamatanSelect.append('<option value="">-- Pilih Kecamatan --</option>');

                            response.data.forEach(function(kecamatan) {
                                kecamatanSelect.append('<option value="' + kecamatan.id + '">' + kecamatan.nama + '</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading kecamatan:', error);
                    }
                });
            }
        });

        // Event handler untuk perubahan kecamatan
        $('#kecamatan_id').change(function() {
            const kecamatanId = $(this).val();

            // Reset dropdown desa
            $('#desa_id').empty().append('<option value="">-- Pilih Desa/Kelurahan --</option>');

            if (kecamatanId) {
                // Load desa berdasarkan kecamatan
                $.ajax({
                    url: 'http://localhost:8000/api/wilayah/desa/' + kecamatanId,
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },
                    success: function(response) {
                        if (response.success) {
                            const desaSelect = $('#desa_id');
                            desaSelect.empty();
                            desaSelect.append('<option value="">-- Pilih Desa/Kelurahan --</option>');

                            response.data.forEach(function(desa) {
                                desaSelect.append('<option value="' + desa.id + '">' + desa.nama + '</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading desa:', error);
                    }
                });
            }
        });
    });
  </script>
</body>

</html>