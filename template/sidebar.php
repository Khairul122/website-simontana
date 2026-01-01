<?php
// Ambil role dari session user
$currentUser = null;
if (isset($_SESSION['user'])) {
  $currentUser = $_SESSION['user'];
}
$userRole = $currentUser['role'] ?? 'Guest';
?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <!-- Dashboard - berbeda berdasarkan role -->
    <?php if ($userRole === 'Admin'): ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=dashboard&action=admin">
          <i class="mdi mdi-speedometer menu-icon"></i>
          <span class="menu-title">Dashboard Admin</span>
        </a>
      </li>
    <?php elseif ($userRole === 'PetugasBPBD'): ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=dashboard&action=petugas">
          <i class="mdi mdi-speedometer menu-icon"></i>
          <span class="menu-title">Dashboard Petugas</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=LaporanPetugas&action=index">
          <i class="mdi mdi-speedometer menu-icon"></i>
          <span class="menu-title">Laporan Bencana</span>
        </a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="index.php?controller=TindakLanjut&action=index">
          <i class="mdi mdi-speedometer menu-icon"></i>
          <span class="menu-title">Tindak Lanjut</span>
        </a>
      </li>
    <?php elseif ($userRole === 'OperatorDesa'): ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=dashboard&action=operator">
          <i class="mdi mdi-speedometer menu-icon"></i>
          <span class="menu-title">Dashboard Operator</span>
        </a>
      </li>
    <?php elseif ($userRole === 'Warga'): ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=Beranda&action=index">
          <i class="mdi mdi-speedometer menu-icon"></i>
          <span class="menu-title">Dashboard Warga</span>
        </a>
      </li>
    <?php endif; ?>

    <!-- Menu untuk Admin -->
    <?php if ($userRole === 'Admin'): ?>
      <!-- User Management -->
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=KategoriBencana&action=index">
          <i class="mdi mdi-account-group menu-icon"></i>
          <span class="menu-title">Manajemen Kategori Bencana</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=User&action=index">
          <i class="mdi mdi-account-group menu-icon"></i>
          <span class="menu-title">Manajemen User</span>
        </a>
      </li>

      <!-- Wilayah Management -->
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#wilayah-menu" aria-expanded="false" aria-controls="wilayah-menu">
          <i class="mdi mdi-map menu-icon"></i>
          <span class="menu-title">Manajemen Wilayah</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="wilayah-menu">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="index.php?controller=Wilayah&action=indexProvinsi">Daftar Provinsi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?controller=Wilayah&action=indexKabupaten">Daftar Kabupaten</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?controller=Wilayah&action=indexKecamatan">Daftar Kecamatan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?controller=Wilayah&action=indexDesa">Daftar Desa</a>
            </li>
          </ul>
        </div>
      </li>
    <?php endif; ?>

    <!-- Menu untuk Admin dan PetugasBPBD -->
    <?php if ($userRole === 'Admin' || $userRole === 'PetugasBPBD'): ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=LaporanAdmin&action=index">
          <i class="mdi mdi-clipboard-text menu-icon"></i>
          <span class="menu-title">Laporan Bencana</span>
        </a>
      </li>
    <?php endif; ?>

    <!-- Menu untuk OperatorDesa -->
    <?php if ($userRole === 'OperatorDesa'): ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=LaporanOperator&action=index">
          <i class="mdi mdi-plus-circle menu-icon"></i>
          <span class="menu-title">Laporan Operator</span>
        </a>
      </li>

    <?php endif; ?>

    <!-- Menu untuk Warga -->
    <?php if ($userRole === 'Warga'): ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=LaporanAdmin&action=index">
          <i class="mdi mdi-clipboard-text menu-icon"></i>
          <span class="menu-title">Lihat Laporan</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=LaporanAdmin&action=create">
          <i class="mdi mdi-plus-circle menu-icon"></i>
          <span class="menu-title">Buat Laporan</span>
        </a>
      </li>
    <?php endif; ?>

    <!-- Logout - tersedia untuk semua role -->
    <li class="nav-item">
      <a class="nav-link" href="index.php?controller=auth&action=logout">
        <i class="mdi mdi-logout menu-icon"></i>
        <span class="menu-title">Keluar</span>
      </a>
    </li>

  </ul>
</nav>