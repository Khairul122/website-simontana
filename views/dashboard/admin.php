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

              <!-- User Management Statistics Cards -->
              <div class="row mb-4">
                <div class="col-12">
                  <h5 class="mb-3">Manajemen Pengguna</h5>
                </div>

                <!-- Total Users Card -->
                <div class="col-xl-3 col-md-6 mb-3">
                  <div class="card bg-success text-white">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="mb-1" id="total-users">0</h4>
                          <p class="mb-0">Total Pengguna</p>
                        </div>
                        <i class="fas fa-users fa-2x"></i>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Users by Role Card -->
                <div class="col-xl-9 col-md-6 mb-3">
                  <div class="card bg-info text-white">
                    <div class="card-body">
                      <h5 class="card-title mb-3">Pengguna per Role</h5>
                      <div class="row text-center">
                        <div class="col-3">
                          <h3 class="text-white mb-1" id="users-admin">0</h3>
                          <small>Admin</small>
                        </div>
                        <div class="col-3 border-end border-start">
                          <h3 class="text-white mb-1" id="users-petugas">0</h3>
                          <small>Petugas BPBD</small>
                        </div>
                        <div class="col-3 border-end border-start">
                          <h3 class="text-white mb-1" id="users-operator">0</h3>
                          <small>Operator Desa</small>
                        </div>
                        <div class="col-3 border-start">
                          <h3 class="text-white mb-1" id="users-warga">0</h3>
                          <small>Warga</small>
                        </div>
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

              <!-- Laporan Table Section -->
              <div class="row mb-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header bg-primary text-white">
                      <h5 class="mb-0">
                        <i class="fas fa-list-alt"></i>
                        Data Laporan Terkini
                      </h5>
                    </div>
                    <div class="card-body">
                      <!-- Filter Controls -->
                      <div class="row mb-3">
                        <div class="col-md-3">
                          <select class="form-select" id="filter-status" onchange="filterLaporan()">
                            <option value="">Semua Status</option>
                            <option value="masuk">Masuk</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                          </select>
                        </div>
                        <div class="col-md-3">
                          <select class="form-select" id="filter-kategori" onchange="filterLaporan()">
                            <option value="">Semua Kategori</option>
                            <option value="gempa">Gempa Bumi</option>
                            <option value="banjir">Banjir</option>
                            <option value="tanah-longsor">Tanah Longsor</option>
                            <option value="kebakaran">Kebakaran</option>
                            <option value="angin-topan">Angin Topan</option>
                            <option value="lainnya">Lainnya</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <input type="text" class="form-control" id="search-pelapor" placeholder="Cari nama pelapor..." onkeyup="filterLaporan()">
                        </div>
                        <div class="col-md-2">
                          <div class="btn-group w-100">
                            <button class="btn btn-outline-primary btn-sm" onclick="refreshLaporanTable()">
                              <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                            <a href="index.php?controller=laporan&action=index" class="btn btn-success btn-sm">
                              <i class="fas fa-external-link-alt"></i> All
                            </a>
                          </div>
                        </div>
                      </div>

                      <!-- Table -->
                      <div class="table-responsive">
                        <table class="table table-striped table-hover" id="laporan-table">
                          <thead class="table-dark">
                            <tr>
                              <th onclick="sortLaporan('tanggal')" style="cursor: pointer;">
                                Tanggal <i class="fas fa-sort fa-xs"></i>
                              </th>
                              <th onclick="sortLaporan('pelapor')" style="cursor: pointer;">
                                Pelapor <i class="fas fa-sort fa-xs"></i>
                              </th>
                              <th onclick="sortLaporan('kategori')" style="cursor: pointer;">
                                Kategori <i class="fas fa-sort fa-xs"></i>
                              </th>
                              <th onclick="sortLaporan('lokasi')" style="cursor: pointer;">
                                Lokasi <i class="fas fa-sort fa-xs"></i>
                              </th>
                              <th onclick="sortLaporan('status')" style="cursor: pointer;">
                                Status <i class="fas fa-sort fa-xs"></i>
                              </th>
                              <th onclick="sortLaporan('prioritas')" style="cursor: pointer;">
                                Prioritas <i class="fas fa-sort fa-xs"></i>
                              </th>
                              <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody id="laporan-table-body">
                            <tr>
                              <td colspan="7" class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                  <span class="sr-only">Loading...</span>
                                </div>
                                <p class="mt-2">Memuat data laporan...</p>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                      <!-- Pagination -->
                      <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                          <span id="pagination-info">Menampilkan 0 dari 0 data</span>
                        </div>
                        <div class="btn-group">
                          <button class="btn btn-outline-secondary btn-sm" onclick="changePage(-1)" id="prev-page">
                            <i class="fas fa-chevron-left"></i> Previous
                          </button>
                          <button class="btn btn-outline-secondary btn-sm" disabled>
                            <span id="page-info">Halaman 1</span>
                          </button>
                          <button class="btn btn-outline-secondary btn-sm" onclick="changePage(1)" id="next-page">
                            Next <i class="fas fa-chevron-right"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Tabel Laporan Detail Section -->
              <div class="row mb-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header bg-success text-white">
                      <h5 class="mb-0">
                        <i class="fas fa-table"></i>
                        Tabel Detail Laporan
                      </h5>
                    </div>
                    <div class="card-body">
                      <!-- Filter Controls -->
                      <div class="row mb-3">
                        <div class="col-md-3">
                          <select class="form-select" id="filter-status-detail" onchange="filterDetailTable()">
                            <option value="">Semua Status</option>
                            <option value="masuk">Masuk</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                          </select>
                        </div>
                        <div class="col-md-3">
                          <select class="form-select" id="filter-kategori-detail" onchange="filterDetailTable()">
                            <option value="">Semua Kategori</option>
                            <option value="gempa">Gempa Bumi</option>
                            <option value="banjir">Banjir</option>
                            <option value="tanah-longsor">Tanah Longsor</option>
                            <option value="kebakaran">Kebakaran</option>
                            <option value="angin-topan">Angin Topan</option>
                            <option value="lainnya">Lainnya</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <input type="text" class="form-control" id="search-lokasi" placeholder="Cari lokasi..." onkeyup="filterDetailTable()">
                        </div>
                        <div class="col-md-2">
                          <div class="btn-group w-100">
                            <button class="btn btn-outline-success btn-sm" onclick="refreshDetailTable()">
                              <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                            <a href="index.php?controller=laporan&action=index" class="btn btn-info btn-sm">
                              <i class="fas fa-external-link-alt"></i> All
                            </a>
                          </div>
                        </div>
                      </div>

                      <!-- Detail Table -->
                      <div class="table-responsive">
                        <table class="table table-striped table-hover" id="laporan-detail-table">
                          <thead class="table-dark">
                            <tr>
                              <th onclick="sortDetailTable('kategori')" style="cursor: pointer; white-space: nowrap;">
                                Kategori <i class="fas fa-sort fa-xs"></i>
                              </th>
                              <th onclick="sortDetailTable('tanggal')" style="cursor: pointer; white-space: nowrap;">
                                Tanggal Lapor <i class="fas fa-sort fa-xs"></i>
                              </th>
                              <th onclick="sortDetailTable('lokasi')" style="cursor: pointer;">
                                Lokasi <i class="fas fa-sort fa-xs"></i>
                              </th>
                              <th>Deskripsi</th>
                              <th>Foto</th>
                              <th onclick="sortDetailTable('status')" style="cursor: pointer; white-space: nowrap;">
                                Status Laporan <i class="fas fa-sort fa-xs"></i>
                              </th>
                              <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody id="laporan-detail-table-body">
                            <tr>
                              <td colspan="7" class="text-center">
                                <div class="spinner-border text-success" role="status">
                                  <span class="sr-only">Loading...</span>
                                </div>
                                <p class="mt-2">Memuat data detail laporan...</p>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                      <!-- Pagination -->
                      <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                          <span id="detail-pagination-info">Menampilkan 0 dari 0 data</span>
                        </div>
                        <div class="btn-group">
                          <button class="btn btn-outline-secondary btn-sm" onclick="changeDetailPage(-1)" id="detail-prev-page">
                            <i class="fas fa-chevron-left"></i> Previous
                          </button>
                          <button class="btn btn-outline-secondary btn-sm" disabled>
                            <span id="detail-page-info">Halaman 1</span>
                          </button>
                          <button class="btn btn-outline-secondary btn-sm" onclick="changeDetailPage(1)" id="detail-next-page">
                            Next <i class="fas fa-chevron-right"></i>
                          </button>
                        </div>
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

  <!-- Custom CSS for Enhanced Table -->
  <style>
    /* Enhanced Status Badges */
    .status-masuk {
      background-color: #e3f2fd;
      color: #1976d2;
      padding: 0.25rem 0.75rem;
      border-radius: 1rem;
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
    }

    .status-diproses {
      background-color: #fff3e0;
      color: #f57c00;
      padding: 0.25rem 0.75rem;
      border-radius: 1rem;
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
    }

    .status-selesai {
      background-color: #e8f5e8;
      color: #2e7d32;
      padding: 0.25rem 0.75rem;
      border-radius: 1rem;
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
    }

    /* Priority Badges */
    .priority-high {
      background-color: #ffebee;
      color: #d32f2f;
      padding: 0.25rem 0.75rem;
      border-radius: 1rem;
      font-size: 0.75rem;
      font-weight: 600;
    }

    .priority-medium {
      background-color: #fff8e1;
      color: #ffa000;
      padding: 0.25rem 0.75rem;
      border-radius: 1rem;
      font-size: 0.75rem;
      font-weight: 600;
    }

    .priority-low {
      background-color: #f5f5f5;
      color: #616161;
      padding: 0.25rem 0.75rem;
      border-radius: 1rem;
      font-size: 0.75rem;
      font-weight: 600;
    }

    /* Category Icons */
    .category-icon {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .cat-icon {
      width: 24px;
      height: 24px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 0.7rem;
      color: white;
    }

    .cat-gempa { background-color: #f44336; }
    .cat-banjir { background-color: #2196f3; }
    .cat-tanah-longsor { background-color: #4caf50; }
    .cat-kebakaran { background-color: #ff9800; }
    .cat-angin-topan { background-color: #9c27b0; }
    .cat-lainnya { background-color: #607d8b; }

    /* Enhanced Table Hover */
    #laporan-table tbody tr {
      transition: all 0.2s ease-in-out;
    }

    #laporan-table tbody tr:hover {
      background-color: #f8f9fa !important;
      transform: scale(1.01);
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Action Buttons */
    .btn-action {
      padding: 0.25rem 0.5rem;
      font-size: 0.75rem;
      margin: 0 0.125rem;
    }

    /* Loading Animation */
    .loading-overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(255, 255, 255, 0.8);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }

    /* Foto Thumbnail */
    .foto-thumbnail {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
      cursor: pointer;
      transition: transform 0.2s ease;
      border: 2px solid #e0e0e0;
    }

    .foto-thumbnail:hover {
      transform: scale(1.1);
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    /* Deskripsi Column */
    .deskripsi-cell {
      max-width: 300px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .deskripsi-cell:hover {
      white-space: normal;
      overflow: visible;
    }

    /* Enhanced Detail Table Hover */
    #laporan-detail-table tbody tr {
      transition: all 0.2s ease-in-out;
    }

    #laporan-detail-table tbody tr:hover {
      background-color: #f8f9fa !important;
      transform: scale(1.005);
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }

    /* No Image Placeholder */
    .no-image-placeholder {
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 2px dashed #e0e0e0;
      border-radius: 8px;
      background-color: #f8f9fa;
      margin: 0 auto;
    }
  </style>

  <!-- Dashboard JavaScript -->
  <script>
    let dashboardData = <?php echo json_encode($dashboardData ?? []); ?>;
    let allLaporanData = [];
    let filteredLaporanData = [];
    let currentPage = 1;
    let itemsPerPage = 10;
    let sortColumn = 'tanggal';
    let sortDirection = 'desc';

    // Detail Table Variables
    let allDetailData = [];
    let filteredDetailData = [];
    let currentDetailPage = 1;
    let detailItemsPerPage = 8;
    let detailSortColumn = 'tanggal';
    let detailSortDirection = 'desc';

    // Get API token from session storage or page data
    function getApiToken() {
      console.log('Getting API token...');

      // Try to get token from the dashboard data passed from PHP
      if (typeof dashboardData !== 'undefined' && dashboardData.api_token) {
        console.log('Found token in dashboardData:', dashboardData.api_token);
        return dashboardData.api_token;
      }

      // Try to get token from sessionStorage (try multiple keys)
      const sessionKeys = ['api_token', 'bencana_api_token'];
      for (const key of sessionKeys) {
        const sessionToken = sessionStorage.getItem(key);
        if (sessionToken) {
          console.log('Found token in sessionStorage:', key);
          return sessionToken;
        }
      }

      // Try to get token from a cookie if available
      const cookies = document.cookie.split(';');
      for (let cookie of cookies) {
        const [name, value] = cookie.trim().split('=');
        if (name === 'api_token' || name === 'bencana_api_token') {
          console.log('Found token in cookie:', name);
          return decodeURIComponent(value);
        }
      }

      console.log('No API token found in dashboardData, sessionStorage, or cookies');
      console.log('dashboardData:', typeof dashboardData !== 'undefined' ? dashboardData : 'undefined');
      console.log('sessionStorage:', sessionStorage);
      console.log('document.cookie:', document.cookie);

      return null;
    }

    document.addEventListener('DOMContentLoaded', function() {
      try {
        console.log('=== DASHBOARD ADMIN INITIALIZATION ===');
        console.log('User:', '<?php echo htmlspecialchars($user['nama']); ?>');
        console.log('Role:', '<?php echo htmlspecialchars($user['role']); ?>');

        if (typeof dashboardData !== 'undefined') {
          console.log('✓ Dashboard Data Loaded');
          console.log('Dashboard Data Keys:', Object.keys(dashboardData));
          console.log('API Token Available:', dashboardData.api_token ? 'YES' : 'NO');

          // Log individual data sections
          console.log('--- DATA SECTIONS ---');
          console.log('Dashboard Data Structure:', dashboardData);
          console.log('User Role:', dashboardData.user_role);
          console.log('Dashboard Data Keys:', dashboardData.dashboard_data ? Object.keys(dashboardData.dashboard_data) : 'No dashboard_data');

          if (dashboardData.dashboard_data) {
            console.log('BMKG Data:', dashboardData.dashboard_data.bmkg_statistics);
            console.log('Desa Data:', dashboardData.dashboard_data.desa_statistics);
            console.log('Kategori Bencana Data:', dashboardData.dashboard_data.kategori_bencana_statistics);
            console.log('Monitoring Data:', dashboardData.dashboard_data.monitoring_statistics);
            console.log('Riwayat Tindakan Data:', dashboardData.dashboard_data.riwayat_tindakan_statistics);
            console.log('Tindak Lanjut Data:', dashboardData.dashboard_data.tindak_lanjut_statistics);
            console.log('Laporan Statistics:', dashboardData.dashboard_data.laporan_statistics);
            console.log('Laporan Data Count:', dashboardData.dashboard_data.laporan_data ? dashboardData.dashboard_data.laporan_data.length : 0);
            console.log('User Statistics:', dashboardData.dashboard_data.users_statistics);
          }

          console.log('Errors:', dashboardData.errors);

          // Log API responses
          if (dashboardData.api_responses) {
            console.log('--- API RESPONSES ---');
            Object.keys(dashboardData.api_responses).forEach(key => {
              const response = dashboardData.api_responses[key];
              console.log(`${key}:`, response);
            });
          }

          if (dashboardData.api_token) {
            console.log('Token Length:', dashboardData.api_token.length);
            console.log('Token Preview:', dashboardData.api_token.substring(0, 20) + '...');
          }
        } else {
          console.error('✗ Dashboard Data NOT LOADED');
        }

        // Only update dashboard if data is available
        if (dashboardData && dashboardData.dashboard_data) {
          console.log('Updating dashboard with loaded data...');
          updateDashboard();
        } else {
          console.warn('Dashboard data or dashboard_data not available, skipping update');
        }
        setInterval(refreshDashboard, 30000);

        // Initialize laporan table
        loadLaporanTable();
        setInterval(loadLaporanTable, 60000); // Refresh laporan table every minute

        // Initialize detail table
        loadDetailTable();
        setInterval(loadDetailTable, 90000); // Refresh detail table every 90 seconds
      } catch (error) {
        console.error('Error initializing dashboard:', error);
      }
    });

    function updateDashboard() {
      console.log('=== UPDATING DASHBOARD ===');
      console.log('Dashboard Data Available:', !!dashboardData);
      console.log('Dashboard Data Structure:', dashboardData ? Object.keys(dashboardData) : 'No data');
      console.log('Dashboard Data Content:', dashboardData);

      // Update BMKG Statistics
      const bmkgTotal = dashboardData.dashboard_data?.bmkg_statistics?.total || dashboardData.dashboard_data?.bmkg_statistics?.total_alerts || calculateBMKGTotal();
      updateValue('bmkg-total', bmkgTotal);

      // Update Desa Statistics
      const desaTotal = dashboardData.dashboard_data?.desa_statistics?.total || 0;
      updateValue('desa-total', desaTotal);

      // Update Kategori Bencana Statistics
      const kategoriTotal = dashboardData.dashboard_data?.kategori_bencana_statistics?.total_categories ||
              dashboardData.dashboard_data?.kategori_bencana_statistics?.total ||
              calculateKategoriTotal();
      updateValue('kategori-total', kategoriTotal);

      // Update User Management Statistics
      const usersTotal = dashboardData.dashboard_data?.users_statistics?.total_users || 0;
      updateValue('total-users', usersTotal);

      // Update Users by Role
      const usersByRole = dashboardData.dashboard_data?.users_statistics?.users_by_role || {};
      updateValue('users-admin', usersByRole.Admin || 0);
      updateValue('users-petugas', usersByRole.PetugasBPBD || 0);
      updateValue('users-operator', usersByRole.OperatorDesa || 0);
      updateValue('users-warga', usersByRole.Warga || 0);

      // Update Monitoring Statistics
      const monitoringTotal = dashboardData.dashboard_data?.monitoring_statistics?.total ||
              dashboardData.dashboard_data?.monitoring_statistics?.total_monitoring || 0;
      updateValue('monitoring-total', monitoringTotal);

      // Update laporan statistics
      updateLaporanStatistics();

      // Update Riwayat Tindakan Statistics
      const riwayatData = dashboardData.dashboard_data?.riwayat_tindakan_statistics;
      console.log('Riwayat Tindakan Raw Data:', riwayatData);

      // Handle different possible field names from backend
      const riwayatTotal = riwayatData?.total || riwayatData?.total_actions || riwayatData?.total_riwayat || 0;
      const riwayatToday = riwayatData?.today || riwayatData?.today_actions || riwayatData?.hari_ini || 0;
      const riwayatWeek = riwayatData?.this_week || riwayatData?.minggu_ini || riwayatData?.thisWeek || 0;

      console.log('Riwayat Values:', { riwayatTotal, riwayatToday, riwayatWeek });

      // Update only if values are not null/undefined
      if (riwayatTotal !== null && riwayatTotal !== undefined) updateValue('riwayat-total', riwayatTotal);
      if (riwayatToday !== null && riwayatToday !== undefined) updateValue('riwayat-hari-ini', riwayatToday);
      if (riwayatWeek !== null && riwayatWeek !== undefined) updateValue('riwayat-minggu-ini', riwayatWeek);

      // Update Tindak Lanjut Statistics
      const tindakData = dashboardData.dashboard_data?.tindak_lanjut_statistics;
      console.log('Tindak Lanjut Raw Data:', tindakData);

      // Handle different possible field names from backend
      const tindakTotal = tindakData?.total || tindakData?.total_tindaklanjut || tindakData?.total_tindak_lanjut || 0;
      const tindakPending = tindakData?.pending || tindakData?.tindaklanjut_per_status?.direncanakan || 0;
      const tindakProses = tindakData?.in_progress || tindakData?.proses || tindakData?.tindaklanjut_per_status?.sedang_diproses || 0;
      const tindakSelesai = tindakData?.completed || tindakData?.selesai || tindakData?.tindaklanjut_per_status?.selesai || 0;

      console.log('Tindak Values:', { tindakTotal, tindakPending, tindakProses, tindakSelesai });

      // Update only if values are not null/undefined
      if (tindakTotal !== null && tindakTotal !== undefined) updateValue('tindakan-total', tindakTotal);
      if (tindakPending !== null && tindakPending !== undefined) updateValue('tindakan-pending', tindakPending);
      if (tindakProses !== null && tindakProses !== undefined) updateValue('tindakan-proses', tindakProses);
      if (tindakSelesai !== null && tindakSelesai !== undefined) updateValue('tindakan-selesai', tindakSelesai);

      console.log('Dashboard Statistics Updated:', {
        bmkg: bmkgTotal,
        desa: desaTotal,
        kategori: kategoriTotal,
        monitoring: monitoringTotal,
        riwayat: { total: riwayatTotal, today: riwayatToday, week: riwayatWeek },
        tindakLanjut: { total: tindakTotal, pending: tindakPending, proses: tindakProses, selesai: tindakSelesai },
        users: { total: usersTotal, byRole: usersByRole }
      });

      // Update time
      updateValue('last-updated', new Date().toLocaleTimeString());
    }

    function updateValue(id, value) {
      const element = document.getElementById(id);
      if (element) {
        // Convert to string if it's a number
        const displayValue = (value !== null && value !== undefined) ? String(value) : '0';
        element.textContent = displayValue;
        console.log(`Updated ${id}:`, displayValue);
      } else {
        console.warn(`Element with id '${id}' not found`);
      }
    }

    function calculateBMKGTotal() {
      if (!dashboardData.dashboard_data?.bmkg_statistics) return 0;
      return (dashboardData.dashboard_data.bmkg_statistics.total_earthquakes || 0) +
             (dashboardData.dashboard_data.bmkg_statistics.total_weather_alerts || 0) +
             (dashboardData.dashboard_data.bmkg_statistics.total_tsunami_warnings || 0);
    }

    function calculateKategoriTotal() {
      if (!dashboardData.dashboard_data?.kategori_bencana_statistics) return 0;
      return dashboardData.dashboard_data.kategori_bencana_statistics.total_kategori ||
             dashboardData.dashboard_data.kategori_bencana_statistics.total_categories ||
             dashboardData.dashboard_data.kategori_bencana_statistics.total ||
             (Array.isArray(dashboardData.dashboard_data.kategori_bencana_statistics) ? dashboardData.dashboard_data.kategori_bencana_statistics.length : 0) || 0;
    }

    function refreshDashboard() {
      const headers = { 'X-Requested-With': 'XMLHttpRequest' };

      // Add Authorization header if we have a token
      const token = getApiToken();
      if (token) {
        headers['Authorization'] = 'Bearer ' + token;
      }

      fetch('index.php?controller=dashboard&action=refreshData', {
        headers: headers
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          dashboardData = data.data;

          // Store token in sessionStorage if available
          if (data.data.api_token) {
            sessionStorage.setItem('bencana_api_token', data.data.api_token);
            console.log('Token stored in sessionStorage');
          }

          updateDashboard();
          console.log('Dashboard refreshed');
        }
      })
      .catch(error => console.error('Refresh error:', error));
    }

    function updateLaporanStatistics() {
      console.log('=== UPDATING LAPORAN STATISTICS ===');

      // Prioritaskan laporan_statistics dari API
      if (dashboardData.laporan_statistics && dashboardData.laporan_statistics.success) {
        console.log('Using laporan statistics from API:', dashboardData.laporan_statistics);
        const stats = dashboardData.laporan_statistics.data || dashboardData.laporan_statistics;

        const masuk = stats.masuk || stats.submitted || 0;
        const diproses = stats.diproses || stats.in_progress || 0;
        const selesai = stats.selesai || stats.completed || 0;

        updateValue('laporan-masuk', masuk);
        updateValue('laporan-diproses', diproses);
        updateValue('laporan-selesai', selesai);

        console.log('Laporan Statistics from API:', { masuk, diproses, selesai });
      }
      // Fallback ke data laporan yang ada
      else if (dashboardData.dashboard_data?.laporan_data) {
        console.log('Processing laporan from dashboard data:', dashboardData.dashboard_data.laporan_data);
        processLaporanData(dashboardData.dashboard_data.laporan_data);
      } else {
        console.log('No laporan data available, fetching from API...');
        fetchLaporanData();
      }
    }

    function fetchLaporanData() {
      // Use the same refreshData endpoint that already works
      const headers = {
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      };

      // Add Authorization header if we have a token
      const token = getApiToken();
      if (token) {
        headers['Authorization'] = 'Bearer ' + token;
      }

      fetch('index.php?controller=dashboard&action=refreshData', {
        method: 'GET',
        headers: headers
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
            dashboardData.dashboard_data.laporan_data = data.data.laporan;
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

    // Laporan Table Functions
    function loadLaporanTable() {
      console.log('=== LOADING LAPORAN TABLE ===');

      // First, try to use data from dashboardData (already fetched from API)
      if (dashboardData.dashboard_data?.laporan_data && dashboardData.dashboard_data.laporan_data.length > 0) {
        console.log('Using laporan data from dashboardData:', dashboardData.dashboard_data.laporan_data.length, 'records');
        allLaporanData = dashboardData.dashboard_data.laporan_data;
        filteredLaporanData = [...allLaporanData];
        renderLaporanTable();
        return;
      }

      // If no data in dashboardData, try to fetch from API endpoints
      console.log('No laporan data in dashboardData, fetching from API...');
      const endpoints = [
        'index.php?controller=laporan&action=index',
        'index.php?controller=laporan&action=list',
        'index.php?controller=laporan&action=getData'
      ];

      let currentEndpointIndex = 0;

      function tryNextEndpoint() {
        if (currentEndpointIndex >= endpoints.length) {
          console.error('All endpoints failed, using empty data');
          allLaporanData = [];
          filteredLaporanData = [];
          renderLaporanTable();
          return;
        }

        const endpoint = endpoints[currentEndpointIndex];
        console.log(`Trying endpoint: ${endpoint}`);

        const headers = {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        };

        // Add Authorization header if we have a token
        const token = getApiToken();
        if (token) {
          headers['Authorization'] = 'Bearer ' + token;
          console.log('Using token for request');
        } else {
          console.log('No token available for request');
        }

        fetch(endpoint, {
          method: 'GET',
          headers: headers
        })
        .then(response => {
          console.log(`Response status from ${endpoint}:`, response.status);
          console.log(`Response headers from ${endpoint}:`, response.headers.get('content-type'));

          if (response.ok) {
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
              return response.json();
            } else {
              console.log(`Response from ${endpoint} is not JSON, trying next endpoint...`);
              currentEndpointIndex++;
              return tryNextEndpoint();
            }
          } else {
            console.log(`Endpoint ${endpoint} returned status ${response.status}, trying next...`);
            currentEndpointIndex++;
            return tryNextEndpoint();
          }
        })
        .then(data => {
          if (!data) return; // Already handled in previous block

          console.log(`Successful response from ${endpoint}:`, data);
          console.log('Response structure:', JSON.stringify(data, null, 2));

          // Handle different response structures
          let laporanData = null;

          if (data.success && data.data) {
            // Laravel API standard format
            if (Array.isArray(data.data)) {
              laporanData = data.data;
            } else if (data.data.data && Array.isArray(data.data.data)) {
              laporanData = data.data.data;
            } else if (data.data.laporan && Array.isArray(data.data.laporan)) {
              laporanData = data.data.laporan;
            }
          } else if (data.data && Array.isArray(data.data)) {
            // Direct array response
            laporanData = data.data;
          } else if (Array.isArray(data)) {
            // Direct array without wrapper
            laporanData = data;
          } else if (data.laporan && Array.isArray(data.laporan)) {
            // Alternative structure
            laporanData = data.laporan;
          }

          console.log('Extracted laporanData:', laporanData);

          if (laporanData && laporanData.length > 0) {
            allLaporanData = laporanData.map((item, index) => {
              console.log(`Processing item ${index}:`, item);
              return {
                id: item.id || item.laporan_id || item.id_laporan || index,
                tanggal: item.tanggal_lapor || item.created_at || item.tanggal || item.createdAt,
                pelapor: item.nama_pelapor || item.pelapor || item.nama_user || item.nama_warga || item.user?.nama || item.user?.name || 'Unknown',
                kategori: item.nama_kategori || item.kategori_bencana || item.kategori || item.kategori_id || 'lainnya',
                id_kategori: item.id_kategori,
                lokasi: item.lokasi || item.alamat || 'Lokasi tidak diketahui',
                status: item.status_laporan || item.status || 'masuk',
                prioritas: item.prioritas || item.priority || 'medium',
                // Keep original data for debugging
                _original: item
              };
            });

            filteredLaporanData = [...allLaporanData];
            renderLaporanTable();
            console.log('Laporan table loaded successfully');
            console.log('Processed data:', allLaporanData);
          } else {
            console.warn('No laporan data found in API response');
            console.log('Available keys in response:', Object.keys(data));
            allLaporanData = [];
            filteredLaporanData = [];
            renderLaporanTable();
          }
        })
        .catch(error => {
          console.error(`Error with endpoint ${endpoint}:`, error);
          currentEndpointIndex++;
          tryNextEndpoint();
        });
      }

      tryNextEndpoint();
    }

    
    function renderLaporanTable() {
      const tbody = document.getElementById('laporan-table-body');
      const startIndex = (currentPage - 1) * itemsPerPage;
      const endIndex = startIndex + itemsPerPage;
      const pageData = filteredLaporanData.slice(startIndex, endIndex);

      if (pageData.length === 0) {
        tbody.innerHTML = `
          <tr>
            <td colspan="7" class="text-center text-muted">
              <i class="fas fa-inbox fa-2x mb-2"></i>
              <p>Tidak ada data laporan</p>
            </td>
          </tr>
        `;
        return;
      }

      tbody.innerHTML = pageData.map(laporan => `
        <tr>
          <td>${formatDate(laporan.tanggal)}</td>
          <td>
            <div class="d-flex align-items-center gap-2">
              <i class="fas fa-user-circle text-muted"></i>
              <span>${laporan.pelapor}</span>
            </div>
          </td>
          <td>
            <div class="category-icon">
              <span class="cat-icon cat-${laporan.kategori}">
                <i class="fas fa-${getCategoryIcon(laporan.kategori)}"></i>
              </span>
              <span>${getCategoryName(laporan.kategori)}</span>
            </div>
          </td>
          <td>
            <div class="d-flex align-items-center gap-2">
              <i class="fas fa-map-marker-alt text-muted"></i>
              <span>${laporan.lokasi}</span>
            </div>
          </td>
          <td>
            <span class="status-${laporan.status}">
              ${getStatusLabel(laporan.status)}
            </span>
          </td>
          <td>
            <span class="priority-badge priority-${laporan.prioritas}">
              ${getPriorityLabel(laporan.prioritas)}
            </span>
          </td>
          <td>
            <div class="btn-group">
              <button class="btn btn-primary btn-action" onclick="viewLaporan(${laporan.id})">
                <i class="fas fa-eye"></i>
              </button>
              <button class="btn btn-warning btn-action" onclick="editLaporan(${laporan.id})">
                <i class="fas fa-edit"></i>
              </button>
            </div>
          </td>
        </tr>
      `).join('');

      updatePagination();
    }

    function formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    }

    function getCategoryIcon(kategori) {
      const icons = {
        'gempa': 'house-damage',
        'banjir': 'water',
        'tanah-longsor': 'mountain',
        'kebakaran': 'fire',
        'angin-topan': 'wind',
        'lainnya': 'exclamation-triangle'
      };
      return icons[kategori] || 'exclamation-triangle';
    }

    function getCategoryName(kategori) {
      const names = {
        'gempa': 'Gempa Bumi',
        'banjir': 'Banjir',
        'tanah-longsor': 'Tanah Longsor',
        'kebakaran': 'Kebakaran',
        'angin-topan': 'Angin Topan',
        'lainnya': 'Lainnya'
      };
      return names[kategori] || kategori;
    }

    function getStatusLabel(status) {
      const labels = {
        'masuk': 'Masuk',
        'diproses': 'Diproses',
        'selesai': 'Selesai'
      };
      return labels[status] || status;
    }

    function getPriorityLabel(prioritas) {
      const labels = {
        'high': 'Tinggi',
        'medium': 'Sedang',
        'low': 'Rendah'
      };
      return labels[prioritas] || prioritas;
    }

    function filterLaporan() {
      const statusFilter = document.getElementById('filter-status').value;
      const kategoriFilter = document.getElementById('filter-kategori').value;
      const searchFilter = document.getElementById('search-pelapor').value.toLowerCase();

      filteredLaporanData = allLaporanData.filter(laporan => {
        const matchesStatus = !statusFilter || laporan.status === statusFilter;
        const matchesKategori = !kategoriFilter || laporan.kategori === kategoriFilter;
        const matchesSearch = !searchFilter || laporan.pelapor.toLowerCase().includes(searchFilter);

        return matchesStatus && matchesKategori && matchesSearch;
      });

      currentPage = 1;
      renderLaporanTable();
    }

    function sortLaporan(column) {
      if (sortColumn === column) {
        sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
      } else {
        sortColumn = column;
        sortDirection = 'asc';
      }

      filteredLaporanData.sort((a, b) => {
        let aVal = a[column];
        let bVal = b[column];

        if (column === 'tanggal') {
          aVal = new Date(aVal);
          bVal = new Date(bVal);
        }

        if (sortDirection === 'asc') {
          return aVal > bVal ? 1 : -1;
        } else {
          return aVal < bVal ? 1 : -1;
        }
      });

      renderLaporanTable();
    }

    function changePage(direction) {
      const maxPage = Math.ceil(filteredLaporanData.length / itemsPerPage);
      currentPage += direction;

      if (currentPage < 1) currentPage = 1;
      if (currentPage > maxPage) currentPage = maxPage;

      renderLaporanTable();
    }

    function updatePagination() {
      const totalItems = filteredLaporanData.length;
      const maxPage = Math.ceil(totalItems / itemsPerPage);
      const startItem = (currentPage - 1) * itemsPerPage + 1;
      const endItem = Math.min(currentPage * itemsPerPage, totalItems);

      document.getElementById('pagination-info').textContent =
        `Menampilkan ${totalItems > 0 ? startItem : 0}-${endItem} dari ${totalItems} data`;

      document.getElementById('page-info').textContent = `Halaman ${currentPage}`;

      document.getElementById('prev-page').disabled = currentPage === 1;
      document.getElementById('next-page').disabled = currentPage === maxPage || maxPage === 0;
    }

    function refreshLaporanTable() {
      loadLaporanTable();
    }

    function viewLaporan(id) {
      window.location.href = `index.php?controller=laporan&action=view&id=${id}`;
    }

    function editLaporan(id) {
      window.location.href = `index.php?controller=laporan&action=edit&id=${id}`;
    }

    // Detail Table Functions
    function loadDetailTable() {
      // Use same endpoint testing approach as laporan table
      const endpoints = [
        'index.php?controller=laporan&action=index',
        'index.php?controller=laporan&action=list',
        'index.php?controller=laporan&action=getData',
        'api/laporan',
        '../api/laporan'
      ];

      let currentEndpointIndex = 0;

      function tryNextDetailEndpoint() {
        if (currentEndpointIndex >= endpoints.length) {
          console.error('All detail endpoints failed');
          allDetailData = [];
          filteredDetailData = [];
          renderDetailTable();
          return;
        }

        const endpoint = endpoints[currentEndpointIndex];
        console.log(`Trying detail endpoint: ${endpoint}`);

        fetch(endpoint, {
          method: 'GET',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          }
        })
        .then(response => {
          console.log(`Detail Response status from ${endpoint}:`, response.status);
          console.log(`Detail Response headers from ${endpoint}:`, response.headers.get('content-type'));

          if (response.ok) {
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
              return response.json();
            } else {
              console.log(`Detail Response from ${endpoint} is not JSON, trying next endpoint...`);
              currentEndpointIndex++;
              return tryNextDetailEndpoint();
            }
          } else {
            console.log(`Detail Endpoint ${endpoint} returned status ${response.status}, trying next...`);
            currentEndpointIndex++;
            return tryNextDetailEndpoint();
          }
        })
        .then(data => {
          if (!data) return; // Already handled in previous block

          console.log(`Successful detail response from ${endpoint}:`, data);
          console.log('Detail Response structure:', JSON.stringify(data, null, 2));

          // Handle different response structures
          let laporanData = null;

          if (data.success && data.data) {
            // Laravel API standard format
            if (Array.isArray(data.data)) {
              laporanData = data.data;
            } else if (data.data.data && Array.isArray(data.data.data)) {
              laporanData = data.data.data;
            } else if (data.data.laporan && Array.isArray(data.data.laporan)) {
              laporanData = data.data.laporan;
            }
          } else if (data.data && Array.isArray(data.data)) {
            // Direct array response
            laporanData = data.data;
          } else if (Array.isArray(data)) {
            // Direct array without wrapper
            laporanData = data;
          } else if (data.laporan && Array.isArray(data.laporan)) {
            // Alternative structure
            laporanData = data.laporan;
          }

          console.log('Extracted detail laporanData:', laporanData);

          if (laporanData && laporanData.length > 0) {
            allDetailData = laporanData.map((item, index) => {
              console.log(`Processing detail item ${index}:`, item);
              return {
                id: item.id || item.laporan_id || item.id_laporan || index,
                kategori: item.nama_kategori || item.kategori_bencana || item.kategori || item.kategori_id || 'lainnya',
                id_kategori: item.id_kategori,
                tanggal: item.tanggal_lapor || item.created_at || item.tanggal || item.createdAt,
                lokasi: item.lokasi || item.alamat || 'Lokasi tidak diketahui',
                deskripsi: item.deskripsi || item.keterangan || item.deskripsi_laporan || 'Tidak ada deskripsi',
                foto: item.foto || item.gambar || item.attachment || item.foto_laporan || null,
                status: item.status_laporan || item.status || 'masuk',
                // Keep original data for debugging
                _original: item
              };
            });

            filteredDetailData = [...allDetailData];
            renderDetailTable();
            console.log('Detail table loaded successfully');
            console.log('Processed detail data:', allDetailData);
          } else {
            console.warn('No laporan data found in API response for detail table');
            console.log('Available keys in response:', Object.keys(data));
            allDetailData = [];
            filteredDetailData = [];
            renderDetailTable();
          }
        })
        .catch(error => {
          console.error(`Error with detail endpoint ${endpoint}:`, error);
          currentEndpointIndex++;
          tryNextDetailEndpoint();
        });
      }

      tryNextDetailEndpoint();
    }

    
    function renderDetailTable() {
      const tbody = document.getElementById('laporan-detail-table-body');
      const startIndex = (currentDetailPage - 1) * detailItemsPerPage;
      const endIndex = startIndex + detailItemsPerPage;
      const pageData = filteredDetailData.slice(startIndex, endIndex);

      if (pageData.length === 0) {
        tbody.innerHTML = `
          <tr>
            <td colspan="7" class="text-center text-muted">
              <i class="fas fa-inbox fa-2x mb-2"></i>
              <p>Tidak ada data detail laporan</p>
              <small class="text-muted">Coba refresh dashboard atau periksa endpoint /api/laporan</small>
            </td>
          </tr>
        `;
        return;
      }

      console.log('Rendering detail table with data:', pageData);

      tbody.innerHTML = pageData.map(laporan => {
        // Debug: log each item
        console.log('Rendering laporan item:', laporan);

        return `
        <tr title="ID: ${laporan.id} | Original: ${JSON.stringify(laporan._original || {}).substring(0, 100)}...">
          <td>
            <div class="category-icon">
              <span class="cat-icon cat-${laporan.kategori}">
                <i class="fas fa-${getCategoryIcon(laporan.kategori)}"></i>
              </span>
              <span>${getCategoryName(laporan.kategori)}</span>
            </div>
          </td>
          <td>${formatDate(laporan.tanggal)}</td>
          <td>
            <div class="d-flex align-items-center gap-2">
              <i class="fas fa-map-marker-alt text-muted"></i>
              <span>${laporan.lokasi}</span>
            </div>
          </td>
          <td>
            <div class="deskripsi-cell" title="${laporan.deskripsi}">
              ${laporan.deskripsi}
            </div>
          </td>
          <td>
            ${laporan.foto ?
              `<img src="${laporan.foto}" alt="Foto Laporan" class="foto-thumbnail" onclick="viewFoto('${laporan.foto}')" />` :
              `<div class="no-image-placeholder">
                <i class="fas fa-image fa-lg text-muted"></i>
              </div>`
            }
          </td>
          <td>
            <span class="status-${laporan.status}">
              ${getStatusLabel(laporan.status)}
            </span>
          </td>
          <td>
            <div class="btn-group">
              <button class="btn btn-primary btn-action" onclick="viewDetailLaporan(${laporan.id})">
                <i class="fas fa-eye"></i>
              </button>
              <button class="btn btn-success btn-action" onclick="editDetailLaporan(${laporan.id})">
                <i class="fas fa-edit"></i>
              </button>
            </div>
          </td>
        </tr>
      `;
      }).join('');

      updateDetailPagination();
    }

    function filterDetailTable() {
      const statusFilter = document.getElementById('filter-status-detail').value;
      const kategoriFilter = document.getElementById('filter-kategori-detail').value;
      const lokasiFilter = document.getElementById('search-lokasi').value.toLowerCase();

      filteredDetailData = allDetailData.filter(laporan => {
        const matchesStatus = !statusFilter || laporan.status === statusFilter;
        const matchesKategori = !kategoriFilter || laporan.kategori === kategoriFilter;
        const matchesLokasi = !lokasiFilter || laporan.lokasi.toLowerCase().includes(lokasiFilter);

        return matchesStatus && matchesKategori && matchesLokasi;
      });

      currentDetailPage = 1;
      renderDetailTable();
    }

    function sortDetailTable(column) {
      if (detailSortColumn === column) {
        detailSortDirection = detailSortDirection === 'asc' ? 'desc' : 'asc';
      } else {
        detailSortColumn = column;
        detailSortDirection = 'asc';
      }

      filteredDetailData.sort((a, b) => {
        let aVal = a[column];
        let bVal = b[column];

        if (column === 'tanggal') {
          aVal = new Date(aVal);
          bVal = new Date(bVal);
        }

        if (detailSortDirection === 'asc') {
          return aVal > bVal ? 1 : -1;
        } else {
          return aVal < bVal ? 1 : -1;
        }
      });

      renderDetailTable();
    }

    function changeDetailPage(direction) {
      const maxPage = Math.ceil(filteredDetailData.length / detailItemsPerPage);
      currentDetailPage += direction;

      if (currentDetailPage < 1) currentDetailPage = 1;
      if (currentDetailPage > maxPage) currentDetailPage = maxPage;

      renderDetailTable();
    }

    function updateDetailPagination() {
      const totalItems = filteredDetailData.length;
      const maxPage = Math.ceil(totalItems / detailItemsPerPage);
      const startItem = (currentDetailPage - 1) * detailItemsPerPage + 1;
      const endItem = Math.min(currentDetailPage * detailItemsPerPage, totalItems);

      document.getElementById('detail-pagination-info').textContent =
        `Menampilkan ${totalItems > 0 ? startItem : 0}-${endItem} dari ${totalItems} data`;

      document.getElementById('detail-page-info').textContent = `Halaman ${currentDetailPage}`;

      document.getElementById('detail-prev-page').disabled = currentDetailPage === 1;
      document.getElementById('detail-next-page').disabled = currentDetailPage === maxPage || maxPage === 0;
    }

    function refreshDetailTable() {
      loadDetailTable();
    }

    function viewFoto(fotoUrl) {
      // Open image in modal or new window
      window.open(fotoUrl, '_blank', 'width=800,height=600');
    }

    function viewDetailLaporan(id) {
      window.location.href = `index.php?controller=laporan&action=view&id=${id}`;
    }

    function editDetailLaporan(id) {
      window.location.href = `index.php?controller=laporan&action=edit&id=${id}`;
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