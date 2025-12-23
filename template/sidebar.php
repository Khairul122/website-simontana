<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="index.php?controller=dashboard&action=admin">
        <i class="mdi mdi-speedometer menu-icon"></i>
        <span class="menu-title">Dashboard Admin</span>
      </a>
    </li>

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
            <a class="nav-link" href="index.php?controller=Wilayah&action=index">Daftar Desa</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Desa Management -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#desa-menu" aria-expanded="false" aria-controls="desa-menu">
        <i class="mdi mdi-home-map-marker menu-icon"></i>
        <span class="menu-title">Manajemen Desa</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="desa-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=desa&action=index">Daftar Desa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=desa&action=form">Tambah Desa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=desa&action=statistics">Statistik Desa</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Kategori Bencana -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#kategori-menu" aria-expanded="false" aria-controls="kategori-menu">
        <i class="mdi mdi-alert-circle-outline menu-icon"></i>
        <span class="menu-title">Kategori Bencana</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="kategori-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=kategori&action=index">Daftar Kategori</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=kategori&action=form">Tambah Kategori</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=kategori&action=statistics">Statistik Kategori</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Laporan Management -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#laporan-menu" aria-expanded="false" aria-controls="laporan-menu">
        <i class="mdi mdi-file-document menu-icon"></i>
        <span class="menu-title">Manajemen Laporan</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="laporan-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=laporan&action=index">Daftar Laporan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=laporan&action=form">Buat Laporan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=laporan&action=statistics">Statistik Laporan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=laporan&action=map">Peta Laporan</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Monitoring -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#monitoring-menu" aria-expanded="false" aria-controls="monitoring-menu">
        <i class="mdi mdi-eye menu-icon"></i>
        <span class="menu-title">Monitoring</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="monitoring-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=monitoring&action=index">Daftar Monitoring</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=monitoring&action=form">Tambah Monitoring</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=monitoring&action=statistics">Statistik Monitoring</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=monitoring&action=realtime">Monitoring Real-time</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Tindak Lanjut -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#tindak-menu" aria-expanded="false" aria-controls="tindak-menu">
        <i class="mdi mdi-hammer menu-icon"></i>
        <span class="menu-title">Tindak Lanjut</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="tindak-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=tindakLanjut&action=index">Daftar Tindakan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=tindakLanjut&action=form">Buat Tindakan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=tindakLanjut&action=statistics">Statistik Tindakan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=tindakLanjut&action=timeline">Timeline Tindakan</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Riwayat Tindakan -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#riwayat-menu" aria-expanded="false" aria-controls="riwayat-menu">
        <i class="mdi mdi-history menu-icon"></i>
        <span class="menu-title">Riwayat Tindakan</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="riwayat-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=riwayat&action=index">Daftar Riwayat</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=riwayat&action=form">Tambah Riwayat</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=riwayat&action=statistics">Statistik Riwayat</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=riwayat&action=report">Laporan Riwayat</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- BMKG Integration -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#bmkg-menu" aria-expanded="false" aria-controls="bmkg-menu">
        <i class="mdi mdi-earthquake menu-icon"></i>
        <span class="menu-title">BMKG Integration</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="bmkg-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=bmkg&action=index">Dashboard BMKG</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=bmkg&action=earthquake">Info Gempa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=bmkg&action=weather">Info Cuaca</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=bmkg&action=tsunami">Peringatan Tsunami</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=bmkg&action=settings">Pengaturan BMKG</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Reports & Analytics -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#reports-menu" aria-expanded="false" aria-controls="reports-menu">
        <i class="mdi mdi-chart-line menu-icon"></i>
        <span class="menu-title">Laporan & Analitik</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="reports-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=report&action=dashboard">Dashboard Laporan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=report&action=bencana">Laporan Bencana</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=report&action=kegiatan">Laporan Kegiatan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=report&action=export">Export Data</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=report&action=analytics">Analitik Lanjutan</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Settings -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#settings-menu" aria-expanded="false" aria-controls="settings-menu">
        <i class="mdi mdi-settings menu-icon"></i>
        <span class="menu-title">Pengaturan</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="settings-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=settings&action=profile">Profile Pengguna</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=settings&action=system">Pengaturan Sistem</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=settings&action=notification">Notifikasi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=settings&action=backup">Backup & Restore</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=settings&action=logs">Log Sistem</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Help & Support -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#help-menu" aria-expanded="false" aria-controls="help-menu">
        <i class="mdi mdi-help-circle menu-icon"></i>
        <span class="menu-title">Bantuan</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="help-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=help&action=documentation">Dokumentasi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=help&action=tutorial">Tutorial</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=help&action=faq">FAQ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=help&action=contact">Kontak Support</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Logout -->
    <li class="nav-item">
      <a class="nav-link" href="index.php?controller=auth&action=logout">
        <i class="mdi mdi-logout menu-icon"></i>
        <span class="menu-title">Keluar</span>
      </a>
    </li>

  </ul>
</nav>