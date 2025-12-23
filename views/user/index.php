<?php 
include('template/header.php');

// Ambil server response dari session
$serverLog = $_SESSION['server_response'] ?? null;

// Hapus session setelah diambil
unset($_SESSION['server_response']);
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
              <h2>Manajemen Pengguna</h2>
              <p class="text-muted">Kelola data pengguna sistem SIMONTA BENCANA</p>
            </div>
          </div>

          <?php if ($serverLog && !$serverLog['success']): ?>
            <div class="alert alert-danger" role="alert">
              <h4 class="alert-heading">Error!</h4>
              <p><?php echo htmlspecialchars($serverLog['message'] ?? 'Terjadi kesalahan saat mengambil data'); ?></p>
              <?php if (isset($serverLog['data']) && is_array($serverLog['data']) && !empty($serverLog['data'])): ?>
                <ul class="mb-0">
                  <?php foreach ($serverLog['data'] as $error): ?>
                    <li><?php echo htmlspecialchars(is_array($error) ? json_encode($error) : $error); ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </div>
          <?php endif; ?>
          
          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Daftar Pengguna</h4>
                    <a href="index.php?controller=User&action=create" class="btn btn-primary">
                      <i class="mdi mdi-plus"></i> Tambah Pengguna
                    </a>
                  </div>
                  
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Username</th>
                          <th>Role</th>
                          <th>Email</th>
                          <th>No Telepon</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if ($serverLog && $serverLog['success'] && !empty($serverLog['data']['data'])): ?>
                          <?php $no = 1; ?>
                          <?php foreach ($serverLog['data']['data'] as $user): ?>
                            <tr>
                              <td><?php echo $no++; ?></td>
                              <td><?php echo htmlspecialchars($user['nama'] ?? '-'); ?></td>
                              <td><?php echo htmlspecialchars($user['username'] ?? '-'); ?></td>
                              <td>
                                <?php 
                                $role = $user['role'] ?? '-';
                                $badgeClass = '';
                                
                                switch(strtolower($role)) {
                                  case 'admin':
                                    $badgeClass = 'badge badge-primary';
                                    break;
                                  case 'petugasbpbd':
                                    $badgeClass = 'badge badge-warning';
                                    break;
                                  case 'operatordesa':
                                    $badgeClass = 'badge badge-info';
                                    break;
                                  case 'warga':
                                    $badgeClass = 'badge badge-secondary';
                                    break;
                                  default:
                                    $badgeClass = 'badge badge-dark';
                                }
                                ?>
                                <label class="<?php echo $badgeClass; ?>"><?php echo $role; ?></label>
                              </td>
                              <td><?php echo htmlspecialchars($user['email'] ?? '-'); ?></td>
                              <td><?php echo htmlspecialchars($user['no_telepon'] ?? '-'); ?></td>
                              <td>
                                <a href="index.php?controller=User&action=edit&id=<?php echo $user['id']; ?>" 
                                   class="btn btn-sm btn-warning btn-icon-text">
                                  <i class="mdi mdi-pencil btn-icon-prepend"></i> Edit
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-danger btn-icon-text btn-delete" 
                                        data-id="<?php echo $user['id']; ?>"
                                        data-name="<?php echo addslashes(htmlspecialchars($user['nama'] ?? 'N/A')); ?>">
                                  <i class="mdi mdi-delete btn-icon-prepend"></i> Hapus
                                </button>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="7" class="text-center">
                              <?php if ($serverLog && $serverLog['success']): ?>
                                Tidak ada data pengguna
                              <?php else: ?>
                                Tidak ada data yang dapat ditampilkan
                              <?php endif; ?>
                            </td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <?php include 'template/script.php'; ?>

  <!-- Console Log untuk debugging -->
  <script>
    console.log('Server Response:', <?php echo json_encode($serverLog); ?>);
  </script>

  <!-- Confirm Delete Function with Event Delegation -->
  <script>
    $(document).ready(function() {
      // Event delegation for delete buttons
      $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        console.log('User Management Respon: Button Clicked', id);
        
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Anda akan menghapus pengguna "${name}"`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
          }).then((result) => {
            if (result.isConfirmed) {
              // Create form and submit delete request
              const form = document.createElement('form');
              form.method = 'POST';
              form.action = `index.php?controller=User&action=delete&id=${id}`;
              document.body.appendChild(form);
              form.submit();
            }
          });
        } else {
          // Fallback to native confirm
          if (confirm(`Apakah Anda yakin ingin menghapus pengguna "${name}"?`)) {
            // Create form and submit delete request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `index.php?controller=User&action=delete&id=${id}`;
            document.body.appendChild(form);
            form.submit();
          }
        }
      });
    });
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
  </script>
</body>

</html>