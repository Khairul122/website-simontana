<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIMONTA BENCANA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }
        .stat-card {
            transition: transform 0.3s ease;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .user-info {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-shield-alt text-danger me-2"></i>
                <strong>SIMONTA BENCANA</strong>
            </a>
            <div class="ms-auto">
                <span class="navbar-text">
                    <i class="fas fa-user-shield me-2"></i>
                    Admin: <?php echo htmlspecialchars($user['name'] ?? 'Admin'); ?>
                </span>
                <a href="index.php?controller=auth&action=logout" class="btn btn-outline-danger btn-sm ms-3">
                    <i class="fas fa-sign-out-alt me-1"></i> Keluar
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="index.php?controller=dashboard&action=admin">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php?controller=user&action=index">
                                <i class="fas fa-users me-2"></i> Kelola User
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php?controller=laporan&action=admin">
                                <i class="fas fa-list me-2"></i> Laporan Bencana
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php?controller=kategori&action=index">
                                <i class="fas fa-tags me-2"></i> Kategori Bencana
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php?controller=wilayah&action=index">
                                <i class="fas fa-map me-2"></i> Data Wilayah
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php?controller=bmkg&action=index">
                                <i class="fas fa-cloud-sun me-2"></i> Data BMKG
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="index.php?controller=auth&action=profile">
                                <i class="fas fa-user me-2"></i> Profil
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
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
                        <div class="card user-info text-white">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h4 class="card-title mb-1">Informasi Login</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>Nama:</strong> <?php echo htmlspecialchars($user['name'] ?? 'N/A'); ?>
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
                        <div class="card stat-card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="card-title"><?php echo $total_users ?? 0; ?></h4>
                                        <p class="card-text">Total Users</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="card-title"><?php echo $total_laporan ?? 0; ?></h4>
                                        <p class="card-text">Total Laporan</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="card-title"><?php echo ($laporan_stats['pending'] ?? 0); ?></h4>
                                        <p class="card-text">Pending</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="card-title"><?php echo ($laporan_stats['verified'] ?? 0); ?></h4>
                                        <p class="card-text">Verified</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-check-circle fa-2x"></i>
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
                                                <span class="badge bg-<?php echo getLaporanStatusColor($laporan['status'] ?? 'pending'); ?>">
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
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Get user data and token from PHP
        const userData = <?php echo json_encode($user); ?>;
        const apiClient = getAPIClient();
        const currentToken = apiClient ? apiClient.token : null;

        // Console logging for user info, role, and token
        console.log('=== DASHBOARD ADMIN - USER INFORMATION ===');

        console.log('[USER] Nama:', userData.name || 'N/A');
        console.log('[USER] Username:', userData.username || 'N/A');
        console.log('[USER] Email:', userData.email || 'N/A');
        console.log('[USER] Role:', userData.role || 'N/A');
        console.log('[USER] User ID (sub):', userData.sub || 'N/A');
        console.log('[USER] Phone:', userData.phone || 'N/A');
        console.log('[USER] Address:', userData.address || 'N/A');

        console.log('\n=== TOKEN INFORMATION ===');
        console.log('[TOKEN] JWT Token:', currentToken ? 'Present' : 'Not Available');

        if (currentToken) {
            console.log('[TOKEN] Token Length:', currentToken.length);
            console.log('[TOKEN] Token Header:', currentToken.substring(0, 50) + '...');

            // Parse JWT token to show payload
            try {
                const payload = JSON.parse(atob(currentToken.split('.')[1]));
                console.log('[TOKEN] Token Payload:', payload);
                console.log('[TOKEN] Issued At:', new Date(payload.iat * 1000));
                console.log('[TOKEN] Expires At:', new Date(payload.exp * 1000));
                console.log('[TOKEN] Token Valid:', new Date() < new Date(payload.exp * 1000));
            } catch (e) {
                console.log('[TOKEN] Error parsing token:', e.message);
            }
        }

        console.log('\n=== API CLIENT STATUS ===');
        console.log('[API] Client Available:', apiClient ? 'Yes' : 'No');
        console.log('[API] Base URL:', apiClient ? apiClient.baseUrl : 'N/A');
        console.log('[API] Has Token:', apiClient && apiClient.token ? 'Yes' : 'No');

        console.log('\n=== SESSION INFORMATION ===');
        console.log('[SESSION] Logged In:', <?php echo isLoggedIn() ? 'true' : 'false'; ?>);
        console.log('[SESSION] User Data:', userData);

        console.log('\n=== DASHBOARD STATISTICS ===');
        console.log('[STATS] Total Users:', <?php echo $total_users ?? 0; ?>);
        console.log('[STATS] Total Laporan:', <?php echo $total_laporan ?? 0; ?>);
        console.log('[STATS] Pending Laporan:', <?php echo ($laporan_stats['pending'] ?? 0); ?>);
        console.log('[STATS] Verified Laporan:', <?php echo ($laporan_stats['verified'] ?? 0); ?>);

        // Function to get current token for debugging
        function getCurrentToken() {
            return apiClient ? apiClient.token : null;
        }

        // Function to refresh dashboard data
        function refreshDashboard() {
            console.log('[DASHBOARD] Refreshing data...');
            location.reload();
        }

        // Log user activity
        console.log('[ACTIVITY] Dashboard loaded at:', new Date().toISOString());
        console.log('[ACTIVITY] User session active:', true);

        // Monitor token expiration
        if (currentToken) {
            try {
                const payload = JSON.parse(atob(currentToken.split('.')[1]));
                const timeUntilExpiry = (payload.exp * 1000) - Date.now();

                if (timeUntilExpiry < 300000) { // 5 minutes
                    console.warn('[TOKEN] Token expires in less than 5 minutes!');
                }

                console.log('[TOKEN] Time until expiry:', Math.floor(timeUntilExpiry / 60000), 'minutes');
            } catch (e) {
                console.error('[TOKEN] Could not monitor token expiry:', e.message);
            }
        }

        // Auto-refresh every 5 minutes
        setInterval(() => {
            console.log('[ACTIVITY] Auto-refresh check:', new Date().toISOString());
        }, 300000);
    </script>

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
</body>
</html>