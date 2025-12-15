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
              <!-- Statistics Cards -->
              <div class="row mb-4">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                  <div class="card card-statistics bg-gradient-info text-white">
                    <div class="card-body">
                      <div class="clearfix">
                        <div class="float-left">
                          <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div class="float-right">
                          <p class="card-text text-white">Total Users</p>
                          <div class="fluid-container">
                            <h3 class="font-weight-bold text-white"><?php echo $statistics['total_users'] ?? 0; ?></h3>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                  <div class="card card-statistics bg-gradient-success text-white">
                    <div class="card-body">
                      <div class="clearfix">
                        <div class="float-left">
                          <i class="fas fa-user-shield fa-2x"></i>
                        </div>
                        <div class="float-right">
                          <p class="card-text text-white">Admin</p>
                          <div class="fluid-container">
                            <h3 class="font-weight-bold text-white"><?php echo $statistics['users_by_role']['Admin'] ?? 0; ?></h3>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                  <div class="card card-statistics bg-gradient-warning text-white">
                    <div class="card-body">
                      <div class="clearfix">
                        <div class="float-left">
                          <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                        <div class="float-right">
                          <p class="card-text text-white">Petugas BPBD</p>
                          <div class="fluid-container">
                            <h3 class="font-weight-bold text-white"><?php echo $statistics['users_by_role']['PetugasBPBD'] ?? 0; ?></h3>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                  <div class="card card-statistics bg-gradient-primary text-white">
                    <div class="card-body">
                      <div class="clearfix">
                        <div class="float-left">
                          <i class="fas fa-user-cog fa-2x"></i>
                        </div>
                        <div class="float-right">
                          <p class="card-text text-white">Operator Desa</p>
                          <div class="fluid-container">
                            <h3 class="font-weight-bold text-white"><?php echo $statistics['users_by_role']['OperatorDesa'] ?? 0; ?></h3>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

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
                  <h3>Manajemen User</h3>
                  <span>Kelola data pengguna sistem</span>
                </div>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php?controller=dashboard&action=admin">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Management</li>
                  </ol>
                </nav>
              </div>

              <!-- User Management Card -->
              <div class="card">
                <div class="card-body">
                  <!-- Header with Actions -->
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                      <h4 class="card-title mb-0">Daftar User</h4>
                      <p class="text-muted mb-0">Total <?php echo $pagination['total'] ?? 0; ?> user terdaftar</p>
                    </div>
                    <div>
                      <button type="button" class="btn btn-primary" onclick="window.location.href='index.php?controller=user&action=form'">
                        <i class="fas fa-plus"></i> Tambah User
                      </button>
                    </div>
                  </div>

                  <!-- Filters -->
                  <div class="row mb-3">
                    <div class="col-md-3">
                      <input type="text" class="form-control" placeholder="Cari user..." id="searchInput" value="<?php echo htmlspecialchars($filters['search'] ?? ''); ?>">
                    </div>
                    <div class="col-md-2">
                      <select class="form-control" id="roleFilter">
                        <option value="">Semua Role</option>
                        <option value="Admin" <?php echo (isset($filters['role']) && $filters['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="PetugasBPBD" <?php echo (isset($filters['role']) && $filters['role'] == 'PetugasBPBD') ? 'selected' : ''; ?>>Petugas BPBD</option>
                        <option value="OperatorDesa" <?php echo (isset($filters['role']) && $filters['role'] == 'OperatorDesa') ? 'selected' : ''; ?>>Operator Desa</option>
                        <option value="Warga" <?php echo (isset($filters['role']) && $filters['role'] == 'Warga') ? 'selected' : ''; ?>>Warga</option>
                      </select>
                    </div>
                    <div class="col-md-2">
                      <select class="form-control" id="desaFilter">
                        <option value="">Semua Desa</option>
                        <?php foreach ($villages as $village): ?>
                          <option value="<?php echo $village['id_desa']; ?>" <?php echo (isset($filters['id_desa']) && $filters['id_desa'] == $village['id_desa']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($village['nama_desa']); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-md-2">
                      <select class="form-control" id="perPageFilter">
                        <option value="10" <?php echo (isset($filters['per_page']) && $filters['per_page'] == 10) ? 'selected' : ''; ?>>10 / halaman</option>
                        <option value="25" <?php echo (isset($filters['per_page']) && $filters['per_page'] == 25) ? 'selected' : ''; ?>>25 / halaman</option>
                        <option value="50" <?php echo (isset($filters['per_page']) && $filters['per_page'] == 50) ? 'selected' : ''; ?>>50 / halaman</option>
                        <option value="100" <?php echo (isset($filters['per_page']) && $filters['per_page'] == 100) ? 'selected' : ''; ?>>100 / halaman</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary" id="filterBtn">
                          <i class="fas fa-filter"></i> Filter
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="resetBtn">
                          <i class="fas fa-undo"></i> Reset
                        </button>
                      </div>
                    </div>
                  </div>

                  <!-- Users Table -->
                  <div class="table-responsive">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Role</th>
                          <th>No. Telepon</th>
                          <th>Desa</th>
                          <th>Created At</th>
                          <th class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (empty($users)): ?>
                          <tr>
                            <td colspan="9" class="text-center">Tidak ada data user</td>
                          </tr>
                        <?php else: ?>
                          <?php $no = $pagination['from']; ?>
                          <?php foreach ($users as $user): ?>
                            <tr>
                              <td><?php echo $no++; ?></td>
                              <td><?php echo htmlspecialchars($user['nama']); ?></td>
                              <td><?php echo htmlspecialchars($user['username']); ?></td>
                              <td><?php echo htmlspecialchars($user['email']); ?></td>
                              <td>
                                <?php
                                $roleClass = '';
                                switch ($user['role']) {
                                  case 'Admin': $roleClass = 'badge-danger'; break;
                                  case 'PetugasBPBD': $roleClass = 'badge-warning'; break;
                                  case 'OperatorDesa': $roleClass = 'badge-info'; break;
                                  case 'Warga': $roleClass = 'badge-success'; break;
                                }
                                ?>
                                <span class="badge <?php echo $roleClass; ?>">
                                  <?php echo htmlspecialchars($user['role']); ?>
                                </span>
                              </td>
                              <td><?php echo htmlspecialchars($user['no_telepon'] ?? '-'); ?></td>
                              <td><?php echo htmlspecialchars($user['desa']['nama_desa'] ?? '-'); ?></td>
                              <td><?php echo date('d M Y, H:i', strtotime($user['created_at'])); ?></td>
                              <td class="text-center">
                                <div class="btn-group" role="group">
                                  <button type="button" class="btn btn-sm btn-info" onclick="viewUser(<?php echo $user['id']; ?>)">
                                    <i class="fas fa-eye"></i>
                                  </button>
                                  <button type="button" class="btn btn-sm btn-warning" onclick="editUser(<?php echo $user['id']; ?>)">
                                    <i class="fas fa-edit"></i>
                                  </button>
                                  <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser(<?php echo $user['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                </div>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>

                  <!-- Pagination -->
                  <?php if (($pagination['total'] ?? 0) > 0): ?>
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="text-muted">
                        Menampilkan <?php echo $pagination['from'] ?? 0; ?> - <?php echo $pagination['to'] ?? 0; ?> dari <?php echo $pagination['total'] ?? 0; ?> data
                      </div>
                      <nav>
                        <ul class="pagination mb-0">
                          <?php
                          $currentPage = $pagination['current_page'] ?? 1;
                          $lastPage = $pagination['last_page'] ?? 1;
                          $queryString = $_SERVER['QUERY_STRING'];
                          parse_str($queryString, $queryParams);
                          unset($queryParams['page']);
                          $newQueryString = http_build_query($queryParams);
                          ?>

                          <!-- Previous Page -->
                          <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                              <a class="page-link" href="index.php?controller=user&action=index&page=<?php echo $currentPage - 1; ?><?php echo $newQueryString ? '&' . $newQueryString : ''; ?>">
                                <i class="fas fa-chevron-left"></i>
                              </a>
                            </li>
                          <?php else: ?>
                            <li class="page-item disabled">
                              <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                            </li>
                          <?php endif; ?>

                          <!-- Page Numbers -->
                          <?php
                          $startPage = max(1, $currentPage - 2);
                          $endPage = min($lastPage, $currentPage + 2);

                          for ($i = $startPage; $i <= $endPage; $i++):
                          ?>
                            <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                              <a class="page-link" href="index.php?controller=user&action=index&page=<?php echo $i; ?><?php echo $newQueryString ? '&' . $newQueryString : ''; ?>">
                                <?php echo $i; ?>
                              </a>
                            </li>
                          <?php endfor; ?>

                          <!-- Next Page -->
                          <?php if ($currentPage < $lastPage): ?>
                            <li class="page-item">
                              <a class="page-link" href="index.php?controller=user&action=index&page=<?php echo $currentPage + 1; ?><?php echo $newQueryString ? '&' . $newQueryString : ''; ?>">
                                <i class="fas fa-chevron-right"></i>
                              </a>
                            </li>
                          <?php else: ?>
                            <li class="page-item disabled">
                              <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                            </li>
                          <?php endif; ?>
                        </ul>
                      </nav>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include 'template/script.php'; ?>

  <!-- User Details Modal -->
  <div class="modal fade" id="userDetailModal" tabindex="-1" role="dialog" aria-labelledby="userDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="userDetailModalLabel">Detail User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="userDetailContent">
            <!-- Content will be loaded via AJAX -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yakin ingin menghapus user ini?</p>
          <p class="text-warning"><small>Tindakan ini tidak dapat dibatalkan!</small></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      // Filter functionality
      $('#filterBtn').click(function() {
        const search = $('#searchInput').val();
        const role = $('#roleFilter').val();
        const desa = $('#desaFilter').val();
        const perPage = $('#perPageFilter').val();

        let url = 'index.php?controller=user&action=index';
        const params = [];

        if (search) params.push('search=' + encodeURIComponent(search));
        if (role) params.push('role=' + encodeURIComponent(role));
        if (desa) params.push('id_desa=' + encodeURIComponent(desa));
        if (perPage) params.push('per_page=' + encodeURIComponent(perPage));

        if (params.length > 0) url += '&' + params.join('&');

        window.location.href = url;
      });

      // Reset functionality
      $('#resetBtn').click(function() {
        window.location.href = 'index.php?controller=user&action=index';
      });

      // Enter key search
      $('#searchInput').keypress(function(e) {
        if (e.which === 13) {
          $('#filterBtn').click();
        }
      });
    });

    // View user details
    function viewUser(id) {
      $.ajax({
        url: 'index.php?controller=user&action=show&id=' + id,
        type: 'GET',
        success: function(response) {
          const data = JSON.parse(response);
          if (data.success) {
            const user = data.data;
            let html = `
              <div class="row">
                <div class="col-md-6">
                  <table class="table table-borderless">
                    <tr>
                      <td><strong>Nama</strong></td>
                      <td>${user.nama}</td>
                    </tr>
                    <tr>
                      <td><strong>Username</strong></td>
                      <td>${user.username}</td>
                    </tr>
                    <tr>
                      <td><strong>Email</strong></td>
                      <td>${user.email}</td>
                    </tr>
                    <tr>
                      <td><strong>Role</strong></td>
                      <td><span class="badge badge-info">${user.role}</span></td>
                    </tr>
                  </table>
                </div>
                <div class="col-md-6">
                  <table class="table table-borderless">
                    <tr>
                      <td><strong>No. Telepon</strong></td>
                      <td>${user.no_telepon || '-'}</td>
                    </tr>
                    <tr>
                      <td><strong>Alamat</strong></td>
                      <td>${user.alamat || '-'}</td>
                    </tr>
                    <tr>
                      <td><strong>Desa</strong></td>
                      <td>${user.desa ? user.desa.nama_desa : '-'}</td>
                    </tr>
                    <tr>
                      <td><strong>Created At</strong></td>
                      <td>${new Date(user.created_at).toLocaleString('id-ID')}</td>
                    </tr>
                  </table>
                </div>
              </div>
            `;
            $('#userDetailContent').html(html);
            $('#userDetailModal').modal('show');
          } else {
            alert('Gagal memuat detail user');
          }
        },
        error: function() {
          alert('Terjadi kesalahan saat memuat detail user');
        }
      });
    }

    // Edit user
    function editUser(id) {
      window.location.href = 'index.php?controller=user&action=form&id=' + id;
    }

    // Delete user
    function deleteUser(id) {
      $('#confirmDeleteBtn').data('id', id);
      $('#deleteModal').modal('show');
    }

    // Confirm delete
    $('#confirmDeleteBtn').click(function() {
      const id = $(this).data('id');
      window.location.href = 'index.php?controller=user&action=delete&id=' + id;
    });
  </script>
</body>

</html>