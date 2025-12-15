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
                <h3 class="page-title">Dashboard Petugas BPBD</h3>
                <p class="text-muted">Selamat datang, <strong><?php echo htmlspecialchars($user['nama']); ?></strong></p>
                <p class="text-muted">Petugas BPBD</p>
              </div>

              <!-- Statistics Cards -->
              <div class="row mb-4">
                <!-- Laporan Aktif Card -->
                <div class="col-xl-3 col-md-6 mb-3">
                  <div class="card bg-primary text-white">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="mb-1" id="laporan-aktif">0</h4>
                          <p class="mb-0">Laporan Aktif</p>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Monitoring Lapangan Card -->
                <div class="col-xl-3 col-md-6 mb-3">
                  <div class="card bg-success text-white">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="mb-1" id="monitoring-lapangan">0</h4>
                          <p class="mb-0">Monitoring Lapangan</p>
                        </div>
                        <i class="fas fa-search-location fa-2x"></i>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Tindak Lanjut Card -->
                <div class="col-xl-3 col-md-6 mb-3">
                  <div class="card bg-warning text-white">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="mb-1" id="tindak-lanjut-aktif">0</h4>
                          <p class="mb-0">Tindak Lanjut</p>
                        </div>
                        <i class="fas fa-tasks fa-2x"></i>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Evakuasi Berlangsung Card -->
                <div class="col-xl-3 col-md-6 mb-3">
                  <div class="card bg-info text-white">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="mb-1" id="evakuasi-berlangsung">0</h4>
                          <p class="mb-0">Evakuasi Berlangsung</p>
                        </div>
                        <i class="fas fa-people-carry fa-2x"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Priority Actions Section -->
              <div class="row mb-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header bg-danger text-white">
                      <h5 class="mb-0">
                        <i class="fas fa-exclamation-circle"></i> Prioritas Tinggi - Membutuhkan Tindakan Segera
                      </h5>
                    </div>
                    <div class="card-body">
                      <div id="priority-actions">
                        <div class="text-center">
                          <div class="spinner-border text-danger" role="status">
                            <span class="sr-only">Loading...</span>
                          </div>
                          <p class="mt-2">Memuat laporan prioritas tinggi...</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Recent Activities & Reports -->
              <div class="row mb-4">
                <!-- Recent Monitoring -->
                <div class="col-lg-6 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title mb-3">Monitoring Terkini</h5>
                      <div class="table-responsive">
                        <table class="table table-striped table-sm">
                          <thead>
                            <tr>
                              <th>Lokasi</th>
                              <th>Jenis</th>
                              <th>Status</th>
                              <th>Petugas</th>
                            </tr>
                          </thead>
                          <tbody id="recent-monitoring">
                            <tr>
                              <td colspan="4" class="text-center">Loading data...</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Recent Follow-ups -->
                <div class="col-lg-6 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title mb-3">Tindak Lanjut Aktif</h5>
                      <div class="table-responsive">
                        <table class="table table-striped table-sm">
                          <thead>
                            <tr>
                              <th>Laporan</th>
                              <th>Jenis</th>
                              <th>Prioritas</th>
                              <th>Petugas</th>
                            </tr>
                          </thead>
                          <tbody id="recent-followups">
                            <tr>
                              <td colspan="4" class="text-center">Loading data...</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Quick Actions & Resources -->
              <div class="row mb-4">
                <div class="col-lg-4 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title mb-3">Quick Actions</h5>
                      <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-sm" onclick="refreshDashboard()">
                          <i class="fas fa-sync-alt"></i> Refresh Dashboard
                        </button>
                        <a href="index.php?controller=laporan&action=index" class="btn btn-warning btn-sm">
                          <i class="fas fa-list"></i> Lihat Semua Laporan
                        </a>
                        <a href="index.php?controller=tindak&action=buat" class="btn btn-success btn-sm">
                          <i class="fas fa-plus"></i> Buat Tindak Lanjut
                        </a>
                        <a href="index.php?controller=monitoring&action=lapangan" class="btn btn-info btn-sm">
                          <i class="fas fa-map"></i> Monitoring Lapangan
                        </a>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Resource Status -->
                <div class="col-lg-4 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title mb-3">Status Sumber Daya</h5>
                      <div class="row text-center">
                        <div class="col-6 border-end">
                          <h3 class="text-primary mb-1" id="petugas-tersedia">12</h3>
                          <small>Petugas Tersedia</small>
                        </div>
                        <div class="col-6">
                          <h3 class="text-success mb-1" id="kendaraan-aktif">8</h3>
                          <small>Kendaraan Aktif</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- System Status -->
                <div class="col-lg-4 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title mb-3">System Status</h5>
                      <div class="text-center">
                        <i class="fas fa-satellite-dish fa-3x text-success mb-2"></i>
                        <p class="mb-1"> komunikasi: <span class="badge bg-success">Normal</span></p>
                        <small class="text-muted">Update: <span id="system-time"><?php echo date('H:i:s'); ?></span></small>
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
    let lastRefreshTime = '<?php echo date('Y-m-d H:i:s'); ?>';

    document.addEventListener('DOMContentLoaded', function() {
      console.log('Petugas BPBD Dashboard loaded');
      console.log('User:', '<?php echo htmlspecialchars($user['nama']); ?>');
      console.log('Role: Petugas BPBD');

      updateDashboard();
      setInterval(refreshDashboard, 30000);
      loadPriorityActions();
      setInterval(loadPriorityActions, 15000); // Refresh priority every 15 seconds
    });

    function updateDashboard() {
      // Update statistics
      updateValue('laporan-aktif', calculateActiveReports());
      updateValue('monitoring-lapangan', dashboardData.monitoring?.total_monitoring || 0);
      updateValue('tindak-lanjut-aktif', dashboardData.tindak_lanjut?.total_tindaklanjut || 0);
      updateValue('evakuasi-berlangsung', 2); // Default 2 evakuasi aktif

      // Update resources
      updateValue('petugas-tersedia', 12); // Static for demo
      updateValue('kendaraan-aktif', 8); // Static for demo

      // Update time
      updateValue('system-time', new Date().toLocaleTimeString());

      console.log('Petugas BPBD Dashboard updated');
    }

    function calculateActiveReports() {
      let total = 0;
      if (dashboardData.laporan) {
        if (Array.isArray(dashboardData.laporan.data)) {
          total = dashboardData.laporan.data.length;
        } else if (dashboardData.laporan.data && Array.isArray(dashboardData.laporan.data.data)) {
          total = dashboardData.laporan.data.data.length;
        }
      }
      return total;
    }

    function updateValue(id, value) {
      const element = document.getElementById(id);
      if (element) element.textContent = value;
    }

    function loadPriorityActions() {
      fetch('index.php?controller=dashboard&action=refreshData', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success && data.data) {
          displayPriorityActions(data.data);
        } else {
          displayNoPriorityActions();
        }
      })
      .catch(error => {
        console.error('Error loading priority actions:', error);
        displayNoPriorityActions();
      });
    }

    function displayPriorityActions(data) {
      const actionsContainer = document.getElementById('priority-actions');
      let actionsHtml = '';

      // Simulate priority actions based on data
      const highPriorityReports = calculateHighPriorityReports(data);

      if (highPriorityReports > 0) {
        actionsHtml = `
          <div class="alert alert-danger" role="alert">
            <h5><i class="fas fa-exclamation-circle"></i> ${highPriorityReports} Laporan Prioritas Tinggi</h5>
            <p class="mb-2">Laporan yang membutuhkan penanganan segera:</p>
            <div class="d-grid gap-2">
              <button class="btn btn-danger btn-sm" onclick="viewHighPriorityReports()">
                <i class="fas fa-eye"></i> Lihat Laporan
              </button>
              <button class="btn btn-warning btn-sm" onclick="deployTeam()">
                <i class="fas fa-users"></i> Deploy Tim
              </button>
            </div>
          </div>
        `;
      } else {
        actionsHtml = `
          <div class="alert alert-success" role="alert">
            <i class="fas fa-check-circle"></i>
            <strong>Tidak ada laporan prioritas tinggi saat ini.</strong>
          </div>
        `;
      }

      actionsContainer.innerHTML = actionsHtml;
    }

    function displayNoPriorityActions() {
      const actionsContainer = document.getElementById('priority-actions');
      actionsContainer.innerHTML = `
        <div class="alert alert-secondary" role="alert">
          <i class="fas fa-info-circle"></i>
          <strong>Tidak dapat memuat data prioritas.</strong>
        </div>
      `;
    }

    function calculateHighPriorityReports(data) {
      // Simulate high priority calculation
      // In real implementation, this would filter based on actual report data
      if (data.laporan && data.laporan.data) {
        return Math.min(3, Math.floor(Math.random() * 5)); // Simulate 0-3 high priority reports
      }
      return 0;
    }

    function viewHighPriorityReports() {
      // Navigate to reports with high priority filter
      window.location.href = 'index.php?controller=laporan&action=index&filter=priority-high';
    }

    function deployTeam() {
      alert('Fitur deploy tim akan segera tersedia');
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
          console.log('Petugas BPBD Dashboard refreshed');
        }
      })
      .catch(error => console.error('Refresh error:', error));
    }

    function toggleDebug() {
      const debugSection = document.getElementById('debug-section');
      const debugContent = document.getElementById('debug-content');

      if (debugSection.style.display === 'none') {
        debugSection.style.display = 'block';
        debugContent.innerHTML = `
          <h6>API Status:</h6>
          <ul class="list-unstyled">
            <li>Laporan: ${dashboardData.laporan ? '<span class="text-success">✓</span>' : '<span class="text-danger">✗</span>'}</li>
            <li>Monitoring: ${dashboardData.monitoring ? '<span class="text-success">✓</span>' : '<span class="text-danger">✗</span>'}</li>
            <li>Tindak Lanjut: ${dashboardData.tindak_lanjut ? '<span class="text-success">✓</span>' : '<span class="text-danger">✗</span>'}</li>
            <li>BMKG: ${dashboardData.bmkg ? '<span class="text-success">✓</span>' : '<span class="text-danger">✗</span>'}</li>
          </ul>
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