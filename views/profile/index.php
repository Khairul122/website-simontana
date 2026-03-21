<?php include('template/header.php'); ?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div>
            <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-900">Profil Pengguna</h1>
            <p class="text-sm text-slate-500 mt-1">Identitas akun dan pengamanan profil akses SIMONTANA Anda.</p>
          </div>
          <div class="shrink-0 flex gap-3">
            <button onclick="window.location.reload();" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 hover:text-brand-600 transition-all shadow-sm">
              <i class="fa-solid fa-rotate-right"></i> Muat Ulang
            </button>
          </div>
        </div>

        <?php if (isset($error_message)): ?>
          <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6 flex items-start gap-4 shadow-sm">
            <div class="flex-shrink-0 text-red-500 mt-0.5"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
            <div class="flex-1">
              <h3 class="text-sm font-bold text-red-800">Perhatian</h3>
              <p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($error_message); ?></p>
            </div>
          </div>
        <?php endif; ?>

        <?php if (!empty($user)): ?>
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            
            <div class="lg:col-span-4 xl:col-span-3">
              <div class="rounded-3xl bg-white border border-slate-200 shadow-card overflow-hidden sticky top-6">
                
                <div class="h-32 bg-gradient-to-br from-brand-600 to-indigo-700 relative overflow-hidden">
                   <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
                </div>
                
                <div class="px-6 pb-6 pt-0 relative flex flex-col items-center text-center mt--12">
                  
                  <div class="w-24 h-24 rounded-full bg-white p-1.5 shadow-md relative z-10 -mt-12 mb-4 border border-slate-100">
                    <div class="w-full h-full rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-3xl font-black font-display uppercase">
                      <?php echo strtoupper(substr($user['nama'] ?? 'U', 0, 1)); ?>
                    </div>
                  </div>
                  
                  <h3 class="font-display text-xl font-bold text-slate-800 mb-1"><?php echo htmlspecialchars($user['nama'] ?? '-'); ?></h3>
                  
                  <?php 
                    $roleLabel = $user['role_label'] ?? $user['role'] ?? '-';
                    $badgeClass = 'bg-slate-100 text-slate-600 border-slate-200';
                    $roleCheck = strtolower($roleLabel);
                    if (strpos($roleCheck, 'admin') !== false) {
                        $badgeClass = 'bg-rose-50 text-rose-600 border-rose-200';
                    } elseif (strpos($roleCheck, 'petugas') !== false || strpos($roleCheck, 'operator') !== false) {
                        $badgeClass = 'bg-blue-50 text-blue-600 border-blue-200';
                    } elseif (strpos($roleCheck, 'warga') !== false) {
                        $badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                    }
                  ?>
                  <div class="inline-block px-3 py-1 rounded-full border <?php echo $badgeClass; ?> text-xs font-bold uppercase tracking-wider mb-5">
                    <?php echo htmlspecialchars($roleLabel); ?>
                  </div>
                  
                  <div class="w-full h-px bg-slate-100 mb-5"></div>
                  
                  <div class="w-full text-left space-y-4 text-sm">
                    <div class="flex items-center gap-3">
                      <div class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 border border-slate-100 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-at"></i>
                      </div>
                      <div class="overflow-hidden">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Username Akses</p>
                        <p class="font-semibold text-slate-700 truncate"><?php echo htmlspecialchars($user['username'] ?? '-'); ?></p>
                      </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                      <div class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 border border-slate-100 flex items-center justify-center shrink-0">
                         <i class="fa-regular fa-clock"></i>
                      </div>
                      <div class="overflow-hidden">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Waktu Login</p>
                        <p class="font-medium text-slate-600 truncate"><?php echo date('d M Y - H:i'); ?></p>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>

            
            <div class="lg:col-span-8 xl:col-span-9">
              <div class="rounded-3xl bg-white border border-slate-200 shadow-card overflow-hidden">
                <div class="p-6 md:p-8 border-b border-slate-100 bg-slate-50/50">
                  <h3 class="font-bold text-lg text-slate-800">Informasi Pribadi</h3>
                  <p class="text-sm font-medium text-slate-500 mt-1">Detail identitas Anda yang terdaftar pada sistem pangkalan data pelaporan.</p>
                </div>
                
                <div class="p-6 md:p-8">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    
                    <div>
                      <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 flex items-center gap-2">
                        <i class="fa-solid fa-id-card text-slate-300"></i> Nama Tertulis Lengkap
                      </p>
                      <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                        <p class="font-bold text-slate-800"><?php echo htmlspecialchars($user['nama'] ?? '-'); ?></p>
                      </div>
                    </div>
                    
                    
                    <div>
                      <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 flex items-center gap-2">
                        <i class="fa-solid fa-fingerprint text-slate-300"></i> Nama Pengguna (Username)
                      </p>
                      <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                        <p class="font-bold text-slate-800"><?php echo htmlspecialchars($user['username'] ?? '-'); ?></p>
                      </div>
                    </div>
                    
                    
                    <div>
                      <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-slate-300"></i> Alamat Email Valid
                      </p>
                      <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 flex items-center justify-between">
                        <p class="font-bold text-slate-800"><?php echo htmlspecialchars($user['email'] ?? 'Belum distel'); ?></p>
                        <?php if(!empty($user['email'])): ?>
                           <i class="fa-solid fa-circle-check text-emerald-500" title="Terverifikasi"></i>
                        <?php endif; ?>
                      </div>
                    </div>
                    
                    
                    <div>
                      <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 flex items-center gap-2">
                        <i class="fa-solid fa-phone text-slate-300"></i> Nomor Telepon / HP
                      </p>
                      <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                        <p class="font-bold text-slate-800"><?php echo htmlspecialchars($user['no_telepon'] ?? 'Belum distel'); ?></p>
                      </div>
                    </div>
                    
                    
                    <div class="md:col-span-2">
                      <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5 flex items-center gap-2">
                        <i class="fa-solid fa-map-location-dot text-slate-300"></i> Alamat Domisili Aktif
                      </p>
                      <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                        <p class="font-bold text-slate-800 leading-relaxed"><?php echo nl2br(htmlspecialchars($user['alamat'] ?? 'Alamat belum dilengkapi di profil ini.')); ?></p>
                      </div>
                    </div>

                  </div>
                  
                  <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between bg-white rounded-2xl p-4 shadow-[0_0_15px_rgba(0,0,0,0.02)]">
                    <div class="flex items-center gap-3">
                       <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                         <i class="fa-solid fa-shield-halved"></i>
                       </div>
                       <div>
                         <p class="text-sm font-bold text-slate-700">Privasi & Keamanan</p>
                         <p class="text-xs text-slate-500">Hubungi Admin jika Anda perlu mereset sandi Anda.</p>
                       </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            
          </div>
        <?php else: ?>
          <div class="rounded-2xl bg-amber-50 border border-amber-200 p-8 text-center max-w-2xl mx-auto mt-10 shadow-sm">
            <div class="inline-flex h-20 w-20 rounded-full bg-white text-amber-500 items-center justify-center mb-5 shadow-sm text-3xl"><i class="fa-regular fa-face-frown-open"></i></div>
            <h3 class="font-display font-bold text-amber-800 text-xl mb-2">Data Profil Tidak Ditemukan</h3>
            <p class="text-sm font-medium text-amber-700 mb-6">Sistem gagal menarik informasi pengguna yang sedang login. Sesi mungkin sudah habis.</p>
            <a href="index.php?controller=Profile&action=index" class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-amber-600 text-sm font-bold text-white hover:bg-amber-700 hover:shadow-float transition-all shadow-sm">
              <i class="fa-solid fa-rotate-right mr-2"></i> Muat Ulang Halaman
            </a>
          </div>
        <?php endif; ?>

      </div>
    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>
