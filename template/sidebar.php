<?php
$currentUser = $_SESSION['user'] ?? null;
$userRole = $currentUser['role'] ?? 'Guest';
$currentController = $_GET['controller'] ?? 'Dashboard';

function navActive($controllers, $current) {
  return in_array($current, $controllers, true) ? 'bg-brand-50 text-brand-700 border-r-4 border-brand-600 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900';
}
function navIconActive($controllers, $current) {
  return in_array($current, $controllers, true) ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600';
}
?>

<style>
  .sidebar-container {
    transition: transform 0.3s ease-in-out;
  }
  @media (max-width: 1023px) {
    .sidebar-container { transform: translateX(-100%); position: fixed; z-index: 50; }
    body.sidebar-open .sidebar-container { transform: translateX(0); }
    body.sidebar-open::after {
      content: '';
      position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(2px); z-index: 40;
    }
  }
</style>

<aside class="sidebar-container w-64 h-full bg-white border-r border-slate-200 flex flex-col shrink-0">
  
  <!-- Brand Area -->
  <div class="h-16 flex items-center gap-3 px-5 border-b border-slate-200">
    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-800 text-white font-bold text-lg shadow-inner">S</div>
    <div class="flex flex-col">
      <span class="font-display font-bold text-slate-900 tracking-tight leading-none text-xl">SIMONTANA</span>
      <span class="text-[10px] font-bold text-brand-600 tracking-widest uppercase mt-0.5">Disaster Center</span>
    </div>
  </div>

  <!-- Menu Area -->
  <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1 scrollbar-hide">
    
    <div class="px-3 mb-2 mt-2">
      <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Navigasi Utama</p>
    </div>

    <!-- Global Public Hub -->
    <a href="index.php?controller=Bmkg&action=index" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['Bmkg'], $currentController) ?>">
      <i class="fa-solid fa-cloud-bolt w-5 text-center text-lg <?= navIconActive(['Bmkg'], $currentController) ?> text-indigo-500"></i>
      <span class="text-sm font-semibold tracking-wide">Pusat Data BMKG</span>
    </a>

    <!-- Admin Roles -->
    <?php if ($userRole === 'Admin'): ?>
      
      <a href="index.php?controller=Dashboard&action=admin" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['Dashboard'], $currentController) ?>">
        <i class="fa-solid fa-chart-pie w-5 text-center text-lg <?= navIconActive(['Dashboard'], $currentController) ?>"></i>
        <span class="text-sm">Dashboard Admin</span>
      </a>

      <div class="px-3 mb-2 mt-6">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Master Data</p>
      </div>
      <a href="index.php?controller=User&action=index" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['User'], $currentController) ?>">
        <i class="fa-solid fa-users w-5 text-center text-lg <?= navIconActive(['User'], $currentController) ?>"></i>
        <span class="text-sm">Manajemen User</span>
      </a>
      <a href="index.php?controller=KategoriBencana&action=index" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['KategoriBencana'], $currentController) ?>">
        <i class="fa-solid fa-tags w-5 text-center text-lg <?= navIconActive(['KategoriBencana'], $currentController) ?>"></i>
        <span class="text-sm">Kategori Bencana</span>
      </a>
      <a href="index.php?controller=Wilayah&action=index" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['Wilayah'], $currentController) ?>">
        <i class="fa-solid fa-map-location-dot w-5 text-center text-lg <?= navIconActive(['Wilayah'], $currentController) ?>"></i>
        <span class="text-sm">Manajemen Wilayah</span>
      </a>

      <div class="px-3 mb-2 mt-6">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Operasional</p>
      </div>
      <a href="index.php?controller=LaporanAdmin&action=index" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['LaporanAdmin'], $currentController) ?>">
        <i class="fa-solid fa-clipboard-list w-5 text-center text-lg <?= navIconActive(['LaporanAdmin'], $currentController) ?>"></i>
        <span class="text-sm">Laporan Bencana</span>
      </a>
      <a href="index.php?controller=Monitoring&action=index" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['Monitoring'], $currentController) ?>">
        <i class="fa-solid fa-satellite-dish w-5 text-center text-lg <?= navIconActive(['Monitoring'], $currentController) ?>"></i>
        <span class="text-sm">Monitoring</span>
      </a>
      <a href="index.php?controller=TindakLanjut&action=index" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['TindakLanjut'], $currentController) ?>">
        <i class="fa-solid fa-truck-medical w-5 text-center text-lg <?= navIconActive(['TindakLanjut'], $currentController) ?>"></i>
        <span class="text-sm">Tindak Lanjut</span>
      </a>
      <a href="index.php?controller=RiwayatTindakan&action=index" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['RiwayatTindakan'], $currentController) ?>">
        <i class="fa-solid fa-clock-rotate-left w-5 text-center text-lg <?= navIconActive(['RiwayatTindakan'], $currentController) ?>"></i>
        <span class="text-sm">Riwayat Tindakan</span>
      </a>

    <?php elseif ($userRole === 'PetugasBPBD'): ?>
      <a href="index.php?controller=Dashboard&action=petugas" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['Dashboard'], $currentController) ?>">
        <i class="fa-solid fa-chart-pie w-5 text-center text-lg <?= navIconActive(['Dashboard'], $currentController) ?>"></i>
        <span class="text-sm">Dashboard Petugas</span>
      </a>
    <?php elseif ($userRole === 'OperatorDesa'): ?>
      <a href="index.php?controller=Dashboard&action=operator" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['Dashboard'], $currentController) ?>">
        <i class="fa-solid fa-chart-pie w-5 text-center text-lg <?= navIconActive(['Dashboard'], $currentController) ?>"></i>
        <span class="text-sm">Dashboard Operator</span>
      </a>
    <?php elseif ($userRole === 'Warga'): ?>
      <a href="index.php?controller=Dashboard&action=warga" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['Dashboard'], $currentController) ?>">
        <i class="fa-solid fa-house-chimney w-5 text-center text-lg <?= navIconActive(['Dashboard'], $currentController) ?>"></i>
        <span class="text-sm">Beranda Saya</span>
      </a>
    <?php endif; ?>

    <!-- Warga Specific -->
    <?php if ($userRole === 'Warga'): ?>
      <div class="px-3 mb-2 mt-6">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Aksi</p>
      </div>
      <a href="index.php?controller=LaporanAdmin&action=create" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['LaporanAdmin'], $currentController) ?>">
        <i class="fa-solid fa-circle-plus w-5 text-center text-lg <?= navIconActive(['LaporanAdmin'], $currentController) ?>"></i>
        <span class="text-sm">Buat Laporan Baru</span>
      </a>
      <a href="index.php?controller=LaporanAdmin&action=index" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['LaporanAdmin'], $currentController) ?>">
        <i class="fa-solid fa-list-check w-5 text-center text-lg <?= navIconActive(['LaporanAdmin'], $currentController) ?>"></i>
        <span class="text-sm">Laporan Anda</span>
      </a>
    <?php endif; ?>

    <!-- Operator/Petugas Roles Shared -->
    <?php if (in_array($userRole, ['PetugasBPBD', 'OperatorDesa'], true)): ?>
      <div class="px-3 mb-2 mt-6">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Operasional</p>
      </div>
      
      <?php if ($userRole === 'OperatorDesa'): ?>
        <a href="index.php?controller=LaporanOperator&action=index" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['LaporanOperator'], $currentController) ?>">
          <i class="fa-solid fa-clipboard-check w-5 text-center text-lg <?= navIconActive(['LaporanOperator'], $currentController) ?>"></i>
          <span class="text-sm">Verifikasi Laporan</span>
        </a>
      <?php endif; ?>

      <?php if ($userRole === 'PetugasBPBD'): ?>
        <a href="index.php?controller=LaporanAdmin&action=index" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['LaporanAdmin'], $currentController) ?>">
          <i class="fa-solid fa-clipboard-list w-5 text-center text-lg <?= navIconActive(['LaporanAdmin'], $currentController) ?>"></i>
          <span class="text-sm">Data Laporan</span>
        </a>
      <?php endif; ?>

      <a href="index.php?controller=Monitoring&action=index" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['Monitoring'], $currentController) ?>">
        <i class="fa-solid fa-satellite-dish w-5 text-center text-lg <?= navIconActive(['Monitoring'], $currentController) ?>"></i>
        <span class="text-sm">Monitoring</span>
      </a>
      <a href="index.php?controller=TindakLanjut&action=index" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['TindakLanjut'], $currentController) ?>">
        <i class="fa-solid fa-truck-medical w-5 text-center text-lg <?= navIconActive(['TindakLanjut'], $currentController) ?>"></i>
        <span class="text-sm">Tindak Lanjut</span>
      </a>
      <a href="index.php?controller=RiwayatTindakan&action=index" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all <?= navActive(['RiwayatTindakan'], $currentController) ?>">
        <i class="fa-solid fa-clock-rotate-left w-5 text-center text-lg <?= navIconActive(['RiwayatTindakan'], $currentController) ?>"></i>
        <span class="text-sm">Riwayat Tindakan</span>
      </a>
    <?php endif; ?>

  </div>
  
  <div class="p-4 border-t border-slate-200">
    <a href="index.php?controller=Auth&action=logout" class="flex items-center gap-3 w-full px-3 py-2 rounded-lg text-sm font-semibold text-slate-600 hover:bg-red-50 hover:text-red-700 transition">
      <i class="fa-solid fa-power-off text-lg"></i>
      Keluar
    </a>
  </div>
</aside>

<script>
  // Script untuk menutup sidebar jika click diluar sidebar pada mode mobile
  document.addEventListener('click', function(e) {
    if (document.body.classList.contains('sidebar-open')) {
      const sidebar = document.querySelector('.sidebar-container');
      const toggle = document.getElementById('mobileMenuBtn');
      if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
        document.body.classList.remove('sidebar-open');
      }
    }
  });
</script>
