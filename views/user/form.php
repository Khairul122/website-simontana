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
              <!-- Alert Messages -->
              <?php if (!empty($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?php echo $success_message; ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <?php endif; ?>

              <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?php echo $error_message; ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <?php endif; ?>

              <!-- Page Header -->
              <div class="page-header">
                <div class="page-title">
                  <h3><?php echo $is_edit ? 'Edit User' : 'Tambah User'; ?></h3>
                  <span><?php echo $is_edit ? 'Ubah data user yang ada' : 'Tambahkan user baru ke sistem'; ?></span>
                </div>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php?controller=dashboard&action=admin">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="index.php?controller=user&action=index">User Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $is_edit ? 'Edit User' : 'Tambah User'; ?></li>
                  </ol>
                </nav>
              </div>

              <!-- User Form Card -->
              <div class="card">
                <div class="card-body">
                  <form method="POST" action="index.php?controller=user&action=<?php echo $is_edit ? 'update&id=' . $user['id'] : 'store'; ?>" id="userForm">
                    <div class="row">
                      <!-- Left Column -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="nama" name="nama" required
                                 value="<?php echo htmlspecialchars($old_input['nama'] ?? ($user['nama'] ?? '')); ?>"
                                 placeholder="Masukkan nama lengkap">
                          <small class="form-text text-muted">Nama lengkap user</small>
                        </div>

                        <div class="form-group">
                          <label for="username">Username <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="username" name="username" required
                                 value="<?php echo htmlspecialchars($old_input['username'] ?? ($user['username'] ?? '')); ?>"
                                 placeholder="Masukkan username"
                                 <?php echo $is_edit ? 'readonly' : ''; ?>>
                          <small class="form-text text-muted">
                            <?php echo $is_edit ? 'Username tidak dapat diubah' : 'Username untuk login'; ?>
                          </small>
                        </div>

                        <div class="form-group">
                          <label for="email">Email <span class="text-danger">*</span></label>
                          <input type="email" class="form-control" id="email" name="email" required
                                 value="<?php echo htmlspecialchars($old_input['email'] ?? ($user['email'] ?? '')); ?>"
                                 placeholder="email@example.com">
                          <small class="form-text text-muted">Email aktif user</small>
                        </div>

                        <div class="form-group">
                          <label for="role">Role <span class="text-danger">*</span></label>
                          <select class="form-control" id="role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="Admin" <?php echo (isset($old_input['role']) && $old_input['role'] == 'Admin') || ($user['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="PetugasBPBD" <?php echo (isset($old_input['role']) && $old_input['role'] == 'PetugasBPBD') || ($user['role'] == 'PetugasBPBD') ? 'selected' : ''; ?>>Petugas BPBD</option>
                            <option value="OperatorDesa" <?php echo (isset($old_input['role']) && $old_input['role'] == 'OperatorDesa') || ($user['role'] == 'OperatorDesa') ? 'selected' : ''; ?>>Operator Desa</option>
                            <option value="Warga" <?php echo (isset($old_input['role']) && $old_input['role'] == 'Warga') || ($user['role'] == 'Warga') ? 'selected' : ''; ?>>Warga</option>
                          </select>
                          <small class="form-text text-muted">Hak akses user dalam sistem</small>
                        </div>

                        <div class="form-group">
                          <label for="password">
                            Password <?php echo $is_edit ? '' : '<span class="text-danger">*</span>'; ?>
                          </label>
                          <input type="password" class="form-control" id="password" name="password"
                                 <?php echo $is_edit ? '' : 'required'; ?>
                                 placeholder="<?php echo $is_edit ? 'Kosongkan jika tidak ingin mengubah password' : 'Masukkan password'; ?>">
                          <small class="form-text text-muted">
                            <?php echo $is_edit ? 'Minimal 6 karakter. Kosongkan jika tidak ingin mengubah password' : 'Minimal 6 karakter'; ?>
                          </small>
                        </div>
                      </div>

                      <!-- Right Column -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="no_telepon">No. Telepon</label>
                          <input type="text" class="form-control" id="no_telepon" name="no_telepon"
                                 value="<?php echo htmlspecialchars($old_input['no_telepon'] ?? ($user['no_telepon'] ?? '')); ?>"
                                 placeholder="08123456789">
                          <small class="form-text text-muted">Nomor telepon yang dapat dihubungi</small>
                        </div>

                        <div class="form-group">
                          <label for="id_desa">Desa</label>
                          <select class="form-control" id="id_desa" name="id_desa">
                            <option value="">Pilih Desa</option>
                            <?php foreach ($villages as $village): ?>
                              <option value="<?php echo $village['id_desa']; ?>"
                                      <?php echo (isset($old_input['id_desa']) && $old_input['id_desa'] == $village['id_desa']) || ($user['id_desa'] == $village['id_desa']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($village['nama_desa']); ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <small class="form-text text-muted">Desa asal user (opsional)</small>
                        </div>

                        <div class="form-group">
                          <label for="alamat">Alamat</label>
                          <textarea class="form-control" id="alamat" name="alamat" rows="3"
                                    placeholder="Masukkan alamat lengkap"><?php echo htmlspecialchars($old_input['alamat'] ?? ($user['alamat'] ?? '')); ?></textarea>
                          <small class="form-text text-muted">Alamat lengkap user</small>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div id="passwordStrength" class="mb-3" style="display: none;">
                          <label>Kekuatan Password:</label>
                          <div class="progress" style="height: 5px;">
                            <div class="progress-bar" id="passwordStrengthBar" role="progressbar" style="width: 0%"></div>
                          </div>
                          <small class="form-text text-muted" id="passwordStrengthText"></small>
                        </div>
                      </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="row mt-4">
                      <div class="col-12">
                        <div class="btn-group">
                          <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save"></i> <?php echo $is_edit ? 'Update User' : 'Simpan User'; ?>
                          </button>
                          <a href="index.php?controller=user&action=index" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                          </a>
                        </div>
                      </div>
                    </div>
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

  <script>
    $(document).ready(function() {
      // Password strength checker
      $('#password').on('input', function() {
        const password = $(this).val();

        if (password.length === 0) {
          $('#passwordStrength').hide();
          return;
        }

        $('#passwordStrength').show();

        let strength = 0;
        let feedback = '';

        // Check password strength
        if (password.length >= 6) strength += 25;
        if (password.length >= 10) strength += 25;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 25;
        if (/[0-9]/.test(password)) strength += 12.5;
        if (/[^a-zA-Z0-9]/.test(password)) strength += 12.5;

        // Update progress bar
        const strengthBar = $('#passwordStrengthBar');
        strengthBar.removeClass('bg-danger bg-warning bg-info bg-success');

        if (strength <= 25) {
          strengthBar.addClass('bg-danger').css('width', '25%');
          feedback = 'Lemah - Tambahkan huruf besar, angka, dan simbol';
        } else if (strength <= 50) {
          strengthBar.addClass('bg-warning').css('width', '50%');
          feedback = 'Sedang - Tambahkan angka dan simbol';
        } else if (strength <= 75) {
          strengthBar.addClass('bg-info').css('width', '75%');
          feedback = 'Kuat - Tambahkan simbol untuk lebih baik';
        } else {
          strengthBar.addClass('bg-success').css('width', '100%');
          feedback = 'Sangat Kuat - Password aman!';
        }

        $('#passwordStrengthText').text(feedback);
      });

      // Form validation
      $('#userForm').on('submit', function(e) {
        e.preventDefault();

        // Basic validation
        const nama = $('#nama').val().trim();
        const username = $('#username').val().trim();
        const email = $('#email').val().trim();
        const role = $('#role').val();
        const password = $('#password').val();

        if (!nama) {
          alert('Nama lengkap harus diisi!');
          $('#nama').focus();
          return false;
        }

        if (!username) {
          alert('Username harus diisi!');
          $('#username').focus();
          return false;
        }

        if (!email) {
          alert('Email harus diisi!');
          $('#email').focus();
          return false;
        }

        if (!validateEmail(email)) {
          alert('Format email tidak valid!');
          $('#email').focus();
          return false;
        }

        if (!role) {
          alert('Role harus dipilih!');
          $('#role').focus();
          return false;
        }

        <?php if (!$is_edit): ?>
        if (!password) {
          alert('Password harus diisi!');
          $('#password').focus();
          return false;
        }
        <?php endif; ?>

        if (password && password.length < 6) {
          alert('Password minimal 6 karakter!');
          $('#password').focus();
          return false;
        }

        // Check if password and confirm password match
        <?php if (!$is_edit): ?>
        const confirmPassword = $('#confirmPassword').val();
        if (password !== confirmPassword) {
          alert('Password dan konfirmasi password tidak cocok!');
          $('#confirmPassword').focus();
          return false;
        }
        <?php endif; ?>

        // Validate phone number if provided
        const noTelepon = $('#no_telepon').val().trim();
        if (noTelepon && !/^[0-9+-]+$/.test(noTelepon)) {
          alert('Nomor telepon hanya boleh mengandung angka, +, dan -!');
          $('#no_telepon').focus();
          return false;
        }

        // Show loading
        const submitBtn = $('#submitBtn');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...').prop('disabled', true);

        // Submit form
        this.submit();
      });

      // Email validation function
      function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
      }

      // Auto-hide password strength when form is submitted
      $('#userForm').on('submit', function() {
        <?php if ($is_edit): ?>
        // Clear password if it's empty (edit mode)
        if (!$('#password').val()) {
          $('#password').attr('name', '');
        }
        <?php endif; ?>
      });
    });
  </script>
</body>

</html>