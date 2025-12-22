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
              <h2>Manajemen Kategori Bencana</h2>
              <p class="text-muted">Kelola kategori bencana untuk sistem pelaporan</p>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Daftar Kategori Bencana</h4>
                    <a href="index.php?controller=KategoriBencana&action=create" class="btn btn-primary">
                      <i class="mdi mdi-plus"></i> Tambah Kategori
                    </a>
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

                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Kategori</th>
                          <th>Deskripsi</th>
                          <th>Icon</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if ($serverLog && $serverLog['success'] && !empty($serverLog['data']['data'])): ?>
                          <?php $no = 1; ?>
                          <?php foreach ($serverLog['data']['data'] as $kategori): ?>
                            <tr>
                              <td><?php echo $no++; ?></td>
                              <td><?php echo htmlspecialchars($kategori['nama_kategori'] ?? $kategori['nama'] ?? '-'); ?></td>
                              <td><?php echo htmlspecialchars($kategori['deskripsi'] ?? '-'); ?></td>
                              <td>
                                <?php if (!empty($kategori['icon'])): ?>
                                  <span class="badge badge-info"><?php echo htmlspecialchars($kategori['icon']); ?></span>
                                <?php else: ?>
                                  <span class="badge badge-secondary">-</span>
                                <?php endif; ?>
                              </td>
                              <td>
                                <a href="index.php?controller=KategoriBencana&action=edit&id=<?php echo $kategori['id']; ?>"
                                   class="btn btn-sm btn-warning btn-icon-text">
                                  <i class="mdi mdi-pencil btn-icon-prepend"></i> Edit
                                </a>
                                <button type="button"
                                        class="btn btn-sm btn-danger btn-icon-text btn-delete"
                                        data-id="<?php echo $kategori['id']; ?>"
                                        data-name="<?php echo addslashes(htmlspecialchars($kategori['nama_kategori'] ?? $kategori['nama'] ?? 'N/A')); ?>">
                                  <i class="mdi mdi-delete btn-icon-prepend"></i> Hapus
                                </button>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="5" class="text-center">
                              <?php if ($serverLog && $serverLog['success']): ?>
                                Tidak ada data kategori bencana
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

  <!-- Confirm Delete Function with Event Delegation -->
  <script>
    $(document).ready(function() {
      // Event delegation for delete buttons
      $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');

        console.log('Kategori Bencana Respon: Button Clicked', id);

        if (typeof Swal !== 'undefined') {
          Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Anda akan menghapus kategori "${name}"`,
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
              form.action = `index.php?controller=KategoriBencana&action=delete&id=${id}`;
              document.body.appendChild(form);
              form.submit();
            }
          });
        } else {
          // Fallback to native confirm
          if (confirm(`Apakah Anda yakin ingin menghapus kategori "${name}"?`)) {
            // Create form and submit delete request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `index.php?controller=KategoriBencana&action=delete&id=${id}`;
            document.body.appendChild(form);
            form.submit();
          }
        }
      });
    });
  </script>
</body>

</html>