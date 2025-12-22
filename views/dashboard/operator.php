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
              <h2>Selamat Datang, Operator Desa</h2>
              <p class="text-muted">Ini adalah dashboard khusus untuk operator desa</p>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <p class="card-title">Laporan Diverifikasi</p>
                    <div class="text-success">
                      <i class="mdi mdi-arrow-up-bold"></i>
                    </div>
                  </div>
                  <h4 class="font-weight-bold">18</h4>
                  <div class="progress progress-md">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 75%"></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <p class="card-title">Laporan Ditolak</p>
                    <div class="text-info">
                      <i class="mdi mdi-arrow-up-bold"></i>
                    </div>
                  </div>
                  <h4 class="font-weight-bold">3</h4>
                  <div class="progress progress-md">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 30%"></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <p class="card-title">Laporan Baru</p>
                    <div class="text-primary">
                      <i class="mdi mdi-arrow-up-bold"></i>
                    </div>
                  </div>
                  <h4 class="font-weight-bold">7</h4>
                  <div class="progress progress-md">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 40%"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Statistik Verifikasi Minggu Ini</h4>
                  <canvas id="barChart"></canvas>
                </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Laporan Berdasarkan Jenis</h4>
                  <canvas id="doughnutChart"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Laporan yang Perlu Diverifikasi</h4>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nama Pelapor</th>
                          <th>Jenis Bencana</th>
                          <th>Lokasi</th>
                          <th>Status</th>
                          <th>Tanggal Lapor</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>201</td>
                          <td>John Doe</td>
                          <td>Banjir</td>
                          <td>Jl. Merdeka No. 123</td>
                          <td><label class="badge badge-warning">Baru</label></td>
                          <td>2025-06-15</td>
                          <td>
                            <button class="btn btn-sm btn-success">Verifikasi</button>
                            <button class="btn btn-sm btn-danger">Tolak</button>
                          </td>
                        </tr>
                        <tr>
                          <td>202</td>
                          <td>Jane Smith</td>
                          <td>Angin Puting Beliung</td>
                          <td>Jl. Sudirman No. 45</td>
                          <td><label class="badge badge-warning">Baru</label></td>
                          <td>2025-06-14</td>
                          <td>
                            <button class="btn btn-sm btn-success">Verifikasi</button>
                            <button class="btn btn-sm btn-danger">Tolak</button>
                          </td>
                        </tr>
                        <tr>
                          <td>203</td>
                          <td>Bob Johnson</td>
                          <td>Tanah Longsor</td>
                          <td>Jl. Gatot Subroto No. 78</td>
                          <td><label class="badge badge-warning">Baru</label></td>
                          <td>2025-06-13</td>
                          <td>
                            <button class="btn btn-sm btn-success">Verifikasi</button>
                            <button class="btn btn-sm btn-danger">Tolak</button>
                          </td>
                        </tr>
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

  <!-- Toast Container -->
  <div class="toast-container" id="toastContainer"></div>

  <?php include 'template/script.php'; ?>

  <!-- Scripts tambahan untuk dashboard -->
  <script src="assets/vendors/chart.js/Chart.min.js"></script>
  <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="assets/js/dataTables.select.min.js"></script>
  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/Chart.roundedBarCharts.js"></script>

  <script>
    // Fungsi untuk menampilkan toast notification
    function showToast(type, title, message) {
      const toastContainer = document.getElementById('toastContainer');

      const toast = document.createElement('div');
      toast.className = `custom-toast ${type}`;

      toast.innerHTML = `
        <div class="toast-icon">${type === 'success' ? '✓' : '!'}</div>
        <div class="toast-content">
          <div class="toast-title">${title}</div>
          <div class="toast-message">${message}</div>
        </div>
        <button class="toast-close">&times;</button>
        <div class="toast-progress"></div>
      `;

      toastContainer.appendChild(toast);

      // Tambahkan event listener untuk tombol close
      const closeBtn = toast.querySelector('.toast-close');
      closeBtn.addEventListener('click', function() {
        toast.classList.add('hiding');
        setTimeout(() => {
          toast.remove();
        }, 300);
      });

      // Hapus toast setelah 5 detik
      setTimeout(() => {
        if (!toast.classList.contains('hiding')) {
          toast.classList.add('hiding');
          setTimeout(() => {
            toast.remove();
          }, 300);
        }
      }, 5000);
    }

    // Tampilkan toast jika ada dari session
    <?php if (isset($_SESSION['toast'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
      showToast(
        '<?php echo addslashes($_SESSION['toast']['type']); ?>',
        '<?php echo addslashes($_SESSION['toast']['title']); ?>',
        '<?php echo addslashes($_SESSION['toast']['message']); ?>'
      );
      <?php unset($_SESSION['toast']); ?>
    });
    <?php endif; ?>
  </script>
</body>

</html>