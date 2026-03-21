<?php
$nama = isset($_SESSION['user']['nama']) ? $_SESSION['user']['nama'] : (isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : (isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : (isset($_SESSION['username']) ? $_SESSION['username'] : 'Pengguna')));
$email = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : (isset($_SESSION['email']) ? $_SESSION['email'] : 'email@example.com');
$role = isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : (isset($_SESSION['role']) ? $_SESSION['role'] : 'masyarakat');
$roleLabel = [
  'Admin' => 'Admin',
  'PetugasBPBD' => 'Petugas BPBD',
  'OperatorDesa' => 'Operator Desa',
  'Warga' => 'Warga'
][$role] ?? ucfirst((string)$role);
$initial = strtoupper(substr((string)$nama, 0, 1));
?>

<header class="glass-nav sticky top-0 z-40 w-full flex-none transition-colors duration-500 lg:z-50 border-b border-slate-200">
  <div class="max-w-full mx-auto">
    <div class="py-3 px-4 lg:px-8 mx-4 lg:mx-0 flex items-center justify-between">
      
      <!-- Mobile menu button & Brand -->
      <div class="flex items-center gap-4">
        <button id="mobileMenuBtn" class="lg:hidden text-slate-500 hover:text-slate-700 focus:outline-none">
          <i class="fa-solid fa-bars text-xl"></i>
        </button>
        <div class="flex items-center gap-2 lg:hidden">
          <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-700 text-white font-bold text-sm">S</div>
          <span class="font-display font-bold text-slate-900 tracking-tight">SIMONTANA</span>
        </div>
      </div>

      <!-- Right controls -->
      <div class="flex items-center gap-4">
        
        <div class="hidden md:flex items-center gap-2 rounded-full border border-brand-200 bg-brand-50 px-3 py-1">
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-600"></span>
          </span>
          <span class="text-xs font-bold text-brand-700 tracking-wide uppercase"><?php echo htmlspecialchars($roleLabel); ?></span>
        </div>

        <!-- User Profile Dropdown -->
        <div class="relative" id="userDropdownWrapper">
          <button id="userDropdownBtn" class="flex items-center gap-2 rounded-full border border-slate-200 bg-white p-1 pr-3 hover:bg-slate-50 transition-colors focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-1">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-800 text-white font-bold text-sm">
              <?php echo htmlspecialchars($initial); ?>
            </div>
            <span class="text-sm font-semibold text-slate-700 hidden sm:block"><?php echo htmlspecialchars(explode(' ', $nama)[0]); ?></span>
            <i class="fa-solid fa-chevron-down text-xs text-slate-400 ml-1"></i>
          </button>

          <!-- Dropdown Menu -->
          <div id="userDropdownMenu" class="hidden absolute right-0 mt-2 w-56 origin-top-right rounded-xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden animate-fade-in">
            <div class="border-b border-slate-100 p-4">
              <p class="text-sm font-bold text-slate-900"><?php echo htmlspecialchars($nama); ?></p>
              <p class="text-xs text-slate-500 truncate"><?php echo htmlspecialchars($email); ?></p>
            </div>
            <div class="p-2">
              <a href="index.php?controller=Profile&action=index" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-700 transition">
                <i class="fa-regular fa-user"></i>
                Kelola Profil
              </a>
              <a href="index.php?controller=Auth&action=logout" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-red-600 hover:bg-red-50 transition mt-1">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                Keluar Aplikasi
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</header>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const userBtn = document.getElementById('userDropdownBtn');
    const userMenu = document.getElementById('userDropdownMenu');
    
    if(userBtn && userMenu) {
      userBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        userMenu.classList.toggle('hidden');
      });
      document.addEventListener('click', () => {
        if(!userMenu.classList.contains('hidden')) {
          userMenu.classList.add('hidden');
        }
      });
    }

    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    if(mobileMenuBtn) {
      mobileMenuBtn.addEventListener('click', () => {
        document.body.classList.toggle('sidebar-open');
      });
    }
  });
</script>
