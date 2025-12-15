<?php include('template/header.php'); ?>

<body class="with-welcome-text">
  <div class="container-scroller">
    <?php include 'template/navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include 'template/setting_panel.php'; ?>
      <?php include 'template/sidebar.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">

          <!-- Dashboard Content -->
          <div class="row">
            <div class="col-sm-12">

              <!-- Page Header -->
              <div class="page-header">
                <h3 class="page-title">Dashboard Admin</h3>
                <p class="text-muted">Selamat datang, <strong><?php echo htmlspecialchars($user['nama']); ?></strong></p>
              </div>

              <!-- Statistics Cards -->
              <div class="row mb-4">
                <!-- BMKG Card -->
                <div class="col-xl-3 col-md-6 mb-3">
                  <div class="card bg-primary text-white">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="mb-1" id="bmkg-total">0</h4>
                          <p class="mb-0">BMKG Alerts</p>
                        </div>
                        <i class="fas fa-cloud-sun fa-2x"></i>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Desa Card -->
                <div class="col-xl-3 col-md-6 mb-3">
                  <div class="card bg-success text-white">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="mb-1" id="desa-total">0</h4>
                          <p class="mb-0">Total Desa</p>
                        </div>
                        <i class="fas fa-map-marked-alt fa-2x"></i>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Kategori Card -->
                <div class="col-xl-3 col-md-6 mb-3">
                  <div class="card bg-info text-white">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="mb-1" id="kategori-total">0</h4>
                          <p class="mb-0">Kategori</p>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Monitoring Card -->
                <div class="col-xl-3 col-md-6 mb-3">
                  <div class="card bg-warning text-white">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="mb-1" id="monitoring-total">0</h4>
                          <p class="mb-0">Monitoring</p>
                        </div>
                        <i class="fas fa-search-location fa-2x"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Laporan Statistics Cards -->
              <div class="row mb-4">
                <div class="col-12">
                  <h5 class="mb-3">Statistik Laporan</h5>
                </div>

                <!-- Laporan Masuk Card -->
                <div class="col-xl-4 col-md-6 mb-3">
                  <div class="card bg-secondary text-white">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="mb-1" id="laporan-masuk">0</h4>
                          <p class="mb-0">Laporan Masuk</p>
                        </div>
                        <i class="fas fa-inbox fa-2x"></i>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Laporan Diproses Card -->
                <div class="col-xl-4 col-md-6 mb-3">
                  <div class="card bg-info text-white">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="mb-1" id="laporan-diproses">0</h4>
                          <p class="mb-0">Laporan Diproses</p>
                        </div>
                        <i class="fas fa-spinner fa-2x"></i>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Laporan Selesai Card -->
                <div class="col-xl-4 col-md-6 mb-3">
                  <div class="card bg-success text-white">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="mb-1" id="laporan-selesai">0</h4>
                          <p class="mb-0">Laporan Selesai</p>
                        </div>
                        <i class="fas fa-check-circle fa-2x"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Detail Statistics -->
              <div class="row mb-4">
                <!-- Riwayat Tindakan -->
                <div class="col-lg-4 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Riwayat Tindakan</h5>
                      <div class="row text-center">
                        <div class="col-4">
                          <h3 class="text-primary" id="riwayat-total">0</h3>
                          <small>Total</small>
                        </div>
                        <div class="col-4">
                          <h3 class="text-success" id="riwayat-hari-ini">0</h3>
                          <small>Hari Ini</small>
                        </div>
                        <div class="col-4">
                          <h3 class="text-warning" id="riwayat-minggu-ini">0</h3>
                          <small>Minggu Ini</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Tindak Lanjut -->
                <div class="col-lg-4 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Tindak Lanjut</h5>
                      <div class="row text-center">
                        <div class="col-3">
                          <h3 class="text-primary" id="tindakan-total">0</h3>
                          <small>Total</small>
                        </div>
                        <div class="col-3">
                          <h3 class="text-warning" id="tindakan-pending">0</h3>
                          <small>Pending</small>
                        </div>
                        <div class="col-3">
                          <h3 class="text-info" id="tindakan-proses">0</h3>
                          <small>Proses</small>
                        </div>
                        <div class="col-3">
                          <h3 class="text-success" id="tindakan-selesai">0</h3>
                          <small>Selesai</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- System Status -->
                <div class="col-lg-4 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Status Sistem</h5>
                      <div class="text-center">
                        <i class="fas fa-server fa-3x text-success mb-2"></i>
                        <p class="mb-1">API Status: <span class="badge bg-success">Online</span></p>
                        <small class="text-muted">Update: <span id="last-updated"><?php echo date('H:i:s'); ?></span></small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Actions -->
              <div class="row mb-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Quick Actions</h5>
                      <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-sm" onclick="refreshDashboard()">
                          <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                        <button class="btn btn-info btn-sm" onclick="toggleDebug()">
                          <i class="fas fa-code"></i> Debug
                        </button>
                        <a href="index.php?controller=laporan&action=index" class="btn btn-success btn-sm">
                          <i class="fas fa-list"></i> Laporan
                        </a>
                        <a href="index.php?controller=auth&action=logout" class="btn btn-danger btn-sm">
                          <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Debug Section (Hidden) -->
              <div class="row" id="debug-section" style="display: none;">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header bg-dark text-white">
                      <h6 class="mb-0">Debug Information</h6>
                    </div>
                    <div class="card-body">
                      <div id="debug-content">
                        <p>Loading debug information...</p>
                      </div>
                    </div>
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

  <!-- Dashboard JavaScript -->
  <script>
    let dashboardData = <?php echo json_encode($dashboardData ?? []); ?>;

    document.addEventListener('DOMContentLoaded', function() {
      console.log('Dashboard Admin loaded');
      console.log('User:', '<?php echo htmlspecialchars($user['nama']); ?>');
      console.log('Dashboard Data:', dashboardData);

      updateDashboard();
      setInterval(refreshDashboard, 30000);
    });

    function updateDashboard() {
      // Update main cards
      updateValue('bmkg-total', calculateBMKGTotal());
      updateValue('desa-total', dashboardData.desa?.total_desa || dashboardData.desa?.total || 0);
      updateValue('kategori-total', calculateKategoriTotal());
      updateValue('monitoring-total', dashboardData.monitoring?.total_monitoring || 0);

      // Update laporan statistics
      updateLaporanStatistics();

      // Update details
      updateValue('riwayat-total', dashboardData.riwayat_tindakan?.total_riwayat || 0);
      updateValue('riwayat-hari-ini', dashboardData.riwayat_tindakan?.today_actions || 0);
      updateValue('riwayat-minggu-ini', dashboardData.riwayat_tindakan?.this_week || 0);

      updateValue('tindakan-total', dashboardData.tindak_lanjut?.total_tindaklanjut || 0);
      updateValue('tindakan-pending', dashboardData.tindak_lanjut?.tindaklanjut_per_status?.direncanakan || 0);
      updateValue('tindakan-proses', dashboardData.tindak_lanjut?.tindaklanjut_per_status?.sedang_diproses || 0);
      updateValue('tindakan-selesai', dashboardData.tindak_lanjut?.tindaklanjut_per_status?.selesai || 0);

      // Update time
      updateValue('last-updated', new Date().toLocaleTimeString());
    }

    function updateValue(id, value) {
      const element = document.getElementById(id);
      if (element) element.textContent = value;
    }

    function calculateBMKGTotal() {
      if (!dashboardData.bmkg) return 0;
      return (dashboardData.bmkg.total_earthquakes || 0) +
             (dashboardData.bmkg.total_weather_alerts || 0) +
             (dashboardData.bmkg.total_tsunami_warnings || 0);
    }

    function calculateKategoriTotal() {
      if (!dashboardData.kategori_bencana) return 0;
      return dashboardData.kategori_bencana.total_kategori ||
             dashboardData.kategori_bencana.total_categories ||
             dashboardData.kategori_bencana.total ||
             (Array.isArray(dashboardData.kategori_bencana) ? dashboardData.kategori_bencana.length : 0) || 0;
    }

    function refreshDashboard() {
      fetch('index.php?controller=dashboard&action=refreshData', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          dashboardData = data.data;
          updateDashboard();
          console.log('Dashboard refreshed');
        }
      })
      .catch(error => console.error('Refresh error:', error));
    }

    function updateLaporanStatistics() {
      // Jika sudah ada data laporan di dashboardData, gunakan itu
      if (dashboardData.laporan) {
        processLaporanData(dashboardData.laporan);
      } else {
        // Jika tidak ada, fetch dari endpoint /api/laporan
        fetchLaporanData();
      }
    }

    function fetchLaporanData() {
      // Use the same refreshData endpoint that already works
      fetch('index.php?controller=dashboard&action=refreshData', {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        }
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        console.log('Laporan data from refresh:', data);
        if (data.success && data.data) {
          // Check if laporan data exists in the refreshed data
          if (data.data.laporan) {
            dashboardData.laporan = data.data.laporan;
            processLaporanData(data.data.laporan);
          } else {
            // Try to get laporan from the main dashboard data structure
            console.log('Laporan data not found in refresh response');
            setDefaultLaporanValues();
          }
        } else {
          setDefaultLaporanValues();
        }
      })
      .catch(error => {
        console.error('Error fetching laporan data:', error);
        setDefaultLaporanValues();
      });
    }

    function setDefaultLaporanValues() {
      console.log('Setting default laporan values');
      updateValue('laporan-masuk', '0');
      updateValue('laporan-diproses', '0');
      updateValue('laporan-selesai', '0');
    }

    function processLaporanData(laporanData) {
      let masuk = 0;
      let diproses = 0;
      let selesai = 0;

      // Handle different data formats
      if (Array.isArray(laporanData)) {
        // If laporanData is an array of laporan objects
        laporanData.forEach(laporan => {
          const status = (laporan.status_laporan || '').toLowerCase();
          if (status === 'masuk' || status === 'submitted' || status === 'baru') {
            masuk++;
          } else if (status === 'diproses' || status === 'in_progress' || status === 'processing') {
            diproses++;
          } else if (status === 'selesai' || status === 'completed' || status === 'finished') {
            selesai++;
          }
        });
      } else if (laporanData.data && Array.isArray(laporanData.data)) {
        // If laporanData has a data property containing array
        laporanData.data.forEach(laporan => {
          const status = (laporan.status_laporan || '').toLowerCase();
          if (status === 'masuk' || status === 'submitted' || status === 'baru') {
            masuk++;
          } else if (status === 'diproses' || status === 'in_progress' || status === 'processing') {
            diproses++;
          } else if (status === 'selesai' || status === 'completed' || status === 'finished') {
            selesai++;
          }
        });
      } else if (laporanData.total_laporan !== undefined) {
        // If laporanData already has statistics
        masuk = laporanData.masuk || laporanData.submitted || 0;
        diproses = laporanData.diproses || laporanData.in_progress || 0;
        selesai = laporanData.selesai || laporanData.completed || 0;
      }

      // Update UI
      updateValue('laporan-masuk', masuk);
      updateValue('laporan-diproses', diproses);
      updateValue('laporan-selesai', selesai);

      console.log('Laporan Statistics - Masuk:', masuk, 'Diproses:', diproses, 'Selesai:', selesai);
    }

    function toggleDebug() {
      const debugSection = document.getElementById('debug-section');
      const debugContent = document.getElementById('debug-content');

      if (debugSection.style.display === 'none') {
        debugSection.style.display = 'block';
        debugContent.innerHTML = `
          <h6>API Status:</h6>
          <ul class="list-unstyled">
            <li>BMKG: ${dashboardData.bmkg ? '<span class="text-success">✓</span>' : '<span class="text-danger">✗</span>'}</li>
            <li>Desa: ${dashboardData.desa ? '<span class="text-success">✓</span>' : '<span class="text-danger">✗</span>'}</li>
            <li>Kategori: ${dashboardData.kategori_bencana ? '<span class="text-success">✓</span>' : '<span class="text-danger">✗</span>'}</li>
            <li>Monitoring: ${dashboardData.monitoring ? '<span class="text-success">✓</span>' : '<span class="text-danger">✗</span>'}</li>
            <li>Riwayat: ${dashboardData.riwayat_tindakan ? '<span class="text-success">✓</span>' : '<span class="text-danger">✗</span>'}</li>
            <li>Tindakan: ${dashboardData.tindak_lanjut ? '<span class="text-success">✓</span>' : '<span class="text-danger">✗</span>'}</li>
            <li>Laporan: ${dashboardData.laporan ? '<span class="text-success">✓</span>' : '<span class="text-warning">Loading...</span>'}</li>
          </ul>
          <div class="mt-3">
            <h6>Current Values:</h6>
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted">Main Cards:</small>
                <ul class="list-unstyled small">
                  <li>BMKG: ${document.getElementById('bmkg-total')?.textContent || '0'}</li>
                  <li>Desa: ${document.getElementById('desa-total')?.textContent || '0'}</li>
                  <li>Kategori: ${document.getElementById('kategori-total')?.textContent || '0'}</li>
                  <li>Monitoring: ${document.getElementById('monitoring-total')?.textContent || '0'}</li>
                </ul>
              </div>
              <div class="col-md-6">
                <small class="text-muted">Laporan Statistics:</small>
                <ul class="list-unstyled small">
                  <li>Masuk: ${document.getElementById('laporan-masuk')?.textContent || '0'}</li>
                  <li>Diproses: ${document.getElementById('laporan-diproses')?.textContent || '0'}</li>
                  <li>Selesai: ${document.getElementById('laporan-selesai')?.textContent || '0'}</li>
                </ul>
              </div>
            </div>
          </div>
          <div class="mt-3">
            <small class="text-muted">Open Developer Console (F12) for detailed logs</small>
          </div>
        `;
      } else {
        debugSection.style.display = 'none';
      }
    }
  </script>
</body>

</html>