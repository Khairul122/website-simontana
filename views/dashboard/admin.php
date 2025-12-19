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
              <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard Admin</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                  <div class="btn-group me-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                  </div>
                  <button type="button" class="btn btn-sm btn-primary" onclick="refreshDashboard()">
                    <i class="fas fa-sync-alt me-1"></i> Refresh
                  </button>
                </div>
              </div>

              <!-- User Info Card -->
              <div class="row mb-4">
                <div class="col-12">
                  <div class="card bg-gradient-danger text-white">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-md-8">
                          <h4 class="card-title mb-1">Informasi Login</h4>
                          <div class="row">
                            <div class="col-md-4">
                              <strong>Nama:</strong> <?php echo htmlspecialchars($user['name'] ?? 'Admin'); ?>
                            </div>
                            <div class="col-md-4">
                              <strong>Username:</strong> <?php echo htmlspecialchars($user['username'] ?? 'N/A'); ?>
                            </div>
                            <div class="col-md-4">
                              <strong>Role:</strong> <?php echo htmlspecialchars($user['role'] ?? 'N/A'); ?>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4 text-end">
                          <small class="d-block">User ID: <?php echo htmlspecialchars($user['sub'] ?? 'N/A'); ?></small>
                          <small class="d-block">Login Time: <?php echo date('d M Y H:i:s'); ?></small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Statistics Cards -->
              <div class="row mb-4">
                <div class="col-md-3 mb-3">
                  <div class="card stat-card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="card-title"><?php echo $total_users ?? 0; ?></h4>
                          <p class="card-text">Total Users</p>
                        </div>
                        <div class="align-self-center">
                          <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 mb-3">
                  <div class="card stat-card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="card-title"><?php echo $total_laporan ?? 0; ?></h4>
                          <p class="card-text">Total Laporan</p>
                        </div>
                        <div class="align-self-center">
                          <i class="fas fa-exclamation-triangle fa-2x text-success"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 mb-3">
                  <div class="card stat-card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="card-title"><?php echo ($laporan_stats['pending'] ?? 0); ?></h4>
                          <p class="card-text">Pending</p>
                        </div>
                        <div class="align-self-center">
                          <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 mb-3">
                  <div class="card stat-card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="card-title"><?php echo ($laporan_stats['verified'] ?? 0); ?></h4>
                          <p class="card-text">Verified</p>
                        </div>
                        <div class="align-self-center">
                          <i class="fas fa-check-circle fa-2x text-info"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Recent Activities -->
              <div class="row">
                <div class="col-md-6 mb-4">
                  <h4><i class="fas fa-users me-2"></i>Recent Users</h4>
                  <div class="card">
                    <div class="card-body">
                      <?php if (!empty($recent_users)): ?>
                        <div class="list-group list-group-flush">
                          <?php foreach (array_slice($recent_users, 0, 5) as $recentUser): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                              <div>
                                <h6 class="mb-1"><?php echo htmlspecialchars($recentUser['name'] ?? 'User'); ?></h6>
                                <small class="text-muted"><?php echo htmlspecialchars($recentUser['role'] ?? 'user'); ?></small>
                              </div>
                              <small class="text-muted">
                                <?php echo date('d M H:i', strtotime($recentUser['created_at'] ?? 'now')); ?>
                              </small>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      <?php else: ?>
                        <p class="text-muted">No recent users</p>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4">
                  <h4><i class="fas fa-exclamation-triangle me-2"></i>Recent Reports</h4>
                  <div class="card">
                    <div class="card-body">
                      <?php if (!empty($recent_laporan)): ?>
                        <div class="list-group list-group-flush">
                          <?php foreach (array_slice($recent_laporan, 0, 5) as $laporan): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                              <div>
                                <h6 class="mb-1"><?php echo htmlspecialchars($laporan['judul'] ?? 'Report'); ?></h6>
                                <small class="text-muted"><?php echo htmlspecialchars($laporan['alamat'] ?? 'Location'); ?></small>
                              </div>
                              <span class="badge bg-<?php echo getLaporanStatusColor($laporan['status'] ?? 'pending'); ?> badge-pill">
                                <?php echo ucfirst($laporan['status'] ?? 'Pending'); ?>
                              </span>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      <?php else: ?>
                        <p class="text-muted">No recent reports</p>
                      <?php endif; ?>
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

  <script>
    // Function to refresh dashboard data
    function refreshDashboard() {
      console.log('[DASHBOARD] Refreshing data...');
      location.reload();
    }

    <?php
    function getLaporanStatusColor($status) {
        $colors = [
            'pending' => 'warning',
            'verified' => 'info',
            'proses' => 'primary',
            'selesai' => 'success',
            'ditolak' => 'danger'
        ];
        return $colors[$status] ?? 'secondary';
    }
    ?>
  </script>
</body>

</html>