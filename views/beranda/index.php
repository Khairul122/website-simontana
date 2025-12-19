<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - SIMONTA BENCANA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
        }
        .card {
            transition: transform 0.3s ease;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .stat-card {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
        }
        .alert-card {
            border-left: 4px solid #ff6b6b;
        }
        .navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-shield-alt text-danger me-2"></i>
                <strong>SIMONTA BENCANA</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?controller=beranda">
                            <i class="fas fa-home me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=beranda&action=buatLaporan">
                            <i class="fas fa-plus-circle me-1"></i> Buat Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=beranda&action=laporanSaya">
                            <i class="fas fa-list me-1"></i> Laporan Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=beranda&action=informasi">
                            <i class="fas fa-info-circle me-1"></i> Informasi
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>
                            <?php echo htmlspecialchars($user['username'] ?? 'User'); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?controller=beranda&action=profil">
                                <i class="fas fa-user me-2"></i> Profil Saya
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="index.php?controller=auth&action=logout">
                                <i class="fas fa-sign-out-alt me-2"></i> Keluar
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Selamat Datang, <?php echo htmlspecialchars($user['name'] ?? 'Warga'); ?>!</h1>
                    <p class="lead mb-4">Sistem Informasi Monitoring dan Penanganan Bencana untuk melaporkan dan memantau kondisi bencana di wilayah Anda.</p>
                    <div class="d-flex gap-3">
                        <a href="index.php?controller=beranda&action=buatLaporan" class="btn btn-light btn-lg">
                            <i class="fas fa-exclamation-triangle me-2"></i> Laporkan Bencana
                        </a>
                        <a href="index.php?controller=beranda&action=informasi" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-info-circle me-2"></i> Informasi BMKG
                        </a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="card stat-card text-center">
                                <div class="card-body">
                                    <h3 class="card-title"><?php echo $user_stats['total_laporan']; ?></h3>
                                    <p class="card-text">Total Laporan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card stat-card text-center">
                                <div class="card-body">
                                    <h3 class="card-title"><?php echo $user_stats['verified_laporan']; ?></h3>
                                    <p class="card-text">Terverifikasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <?php if (!empty($bmkg_alerts)): ?>
            <div class="row mb-4">
                <div class="col-12">
                    <h4 class="mb-3"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Peringatan Dini</h4>
                    <div class="row">
                        <?php foreach (array_slice($bmkg_alerts, 0, 3) as $alert): ?>
                            <div class="col-md-4 mb-3">
                                <div class="card alert-card">
                                    <div class="card-body">
                                        <h6 class="card-title text-warning">
                                            <i class="fas fa-bell me-2"></i>
                                            <?php echo htmlspecialchars($alert['title'] ?? 'Peringatan Cuaca'); ?>
                                        </h6>
                                        <p class="card-text small"><?php echo htmlspecialchars($alert['description'] ?? substr($alert['summary'] ?? '', 0, 100)); ?></p>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <?php echo date('d M Y H:i', strtotime($alert['issued'] ?? 'now')); ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-8">
                <h4 class="mb-3"><i class="fas fa-list-alt me-2"></i>Laporan Terbaru</h4>
                <?php if (!empty($recent_laporan)): ?>
                    <div class="row">
                        <?php foreach ($recent_laporan as $laporan): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-title"><?php echo htmlspecialchars($laporan['judul'] ?? 'Laporan Bencana'); ?></h6>
                                            <span class="badge bg-<?php echo getStatusBadgeColor($laporan['status'] ?? 'pending'); ?>">
                                                <?php echo ucfirst($laporan['status'] ?? 'Pending'); ?>
                                            </span>
                                        </div>
                                        <p class="card-text small"><?php echo htmlspecialchars(substr($laporan['deskripsi'] ?? '', 0, 150)); ?>...</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                <?php echo htmlspecialchars($laporan['alamat'] ?? 'Lokasi tidak diketahui'); ?>
                                            </small>
                                            <small class="text-muted">
                                                <?php echo date('d M H:i', strtotime($laporan['created_at'] ?? 'now')); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5>Belum Ada Laporan</h5>
                            <p class="text-muted">Belum ada laporan bencana yang tercatat. Jadilah yang pertama melaporkan!</p>
                            <a href="index.php?controller=beranda&action=buatLaporan" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>Buat Laporan
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <h4 class="mb-3"><i class="fas fa-tachometer-alt me-2"></i>Quick Actions</h4>
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title"><i class="fas fa-plus-circle text-primary me-2"></i>Buat Laporan Baru</h6>
                        <p class="card-text small">Laporkan kejadian bencana di sekitar Anda</p>
                        <a href="index.php?controller=beranda&action=buatLaporan" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-plus me-1"></i> Buat Laporan
                        </a>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title"><i class="fas fa-list text-success me-2"></i>Laporan Saya</h6>
                        <p class="card-text small">Lihat daftar laporan yang telah Anda buat</p>
                        <a href="index.php?controller=beranda&action=laporanSaya" class="btn btn-success btn-sm w-100">
                            <i class="fas fa-eye me-1"></i> Lihat Laporan
                        </a>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title"><i class="fas fa-info-circle text-info me-2"></i>Informasi BMKG</h6>
                        <p class="card-text small">Dapatkan informasi cuaca dan peringatan dini</p>
                        <a href="index.php?controller=beranda&action=informasi" class="btn btn-info btn-sm w-100">
                            <i class="fas fa-cloud-sun me-1"></i> Informasi Cuaca
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title"><i class="fas fa-user text-warning me-2"></i>Pengaturan</h6>
                        <p class="card-text small">Kelola profil dan pengaturan akun Anda</p>
                        <a href="index.php?controller=auth&action=profile" class="btn btn-warning btn-sm w-100">
                            <i class="fas fa-cog me-1"></i> Profil Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('[BERANDA] Beranda page loaded');

            const user = <?php echo json_encode($user); ?>;
            console.log('[BERANDA] Current user:', user);

            const stats = <?php echo json_encode($user_stats); ?>;
            console.log('[BERANDA] User stats:', stats);

            const laporanCount = <?php echo count($recent_laporan); ?>;
            const alertCount = <?php echo count($bmkg_alerts); ?>;

            console.log(`[BERANDA] Data loaded: ${laporanCount} laporan, ${alertCount} alerts`);
        });
    </script>
</body>
</html>

