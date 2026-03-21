<?php include('template/header.php'); ?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative p-4 md:p-6 lg:p-8">

      
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 md:mb-8">
        <div>
          <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-800">Manajemen Cache Data BMKG</h1>
          <p class="text-slate-500 text-sm mt-1">Konfigurasi file sementara untuk mempercepat respon data dan menghindari API Limit.</p>
        </div>
        <div>
          <a href="index.php?controller=Bmkg&action=index" class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:border-brand-300 hover:text-brand-600 text-slate-600 px-4 py-2.5 rounded-xl font-bold transition-all shadow-sm"><i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard Gempa</a>
        </div>
      </div>

      <?php if (isset($_SESSION['flash_success'])): ?>
        <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4 mb-6 flex items-start gap-3">
          <div class="flex-shrink-0 text-emerald-500 mt-0.5"><i class="fa-solid fa-circle-check text-lg"></i></div>
          <div class="text-sm text-emerald-700 font-bold"><?php echo htmlspecialchars($_SESSION['flash_success']); ?></div>
        </div>
        <?php unset($_SESSION['flash_success']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['flash_error'])): ?>
        <div class="rounded-xl bg-rose-50 border border-rose-200 p-4 mb-6 flex items-start gap-3">
          <div class="flex-shrink-0 text-rose-500 mt-0.5"><i class="fa-solid fa-circle-xmark text-lg"></i></div>
          <div class="text-sm text-rose-700 font-bold"><?php echo htmlspecialchars($_SESSION['flash_error']); ?></div>
        </div>
        <?php unset($_SESSION['flash_error']); ?>
      <?php endif; ?>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
         <div class="bg-white rounded-3xl border border-slate-200 shadow-card overflow-hidden">
            <div class="p-6 md:p-8 border-b border-slate-100">
               <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2 mb-2"><i class="fa-solid fa-server text-brand-500"></i> Status Cache Saat Ini</h3>
               <p class="text-sm text-slate-500">Diagnosis keberadaan *file caching* API Data BMKG di dalam sistem lokal.</p>
            </div>
            <div class="p-6 md:p-8">
               <?php if (isset($cacheStatus)): ?>
                  <div class="mb-6">
                     <p class="text-xs uppercase font-bold text-slate-400 mb-1 tracking-widest">Driver Cache Penyimpanan</p>
                     <p class="text-sm font-mono font-bold bg-slate-50 border border-slate-200 px-3 py-1.5 rounded inline-block text-slate-700"><i class="fa-solid fa-hard-drive mr-1"></i> <?php echo htmlspecialchars($cacheStatus['driver'] ?? 'File System'); ?></p>
                  </div>

                  <p class="text-xs uppercase font-bold text-slate-400 mb-2 tracking-widest">Ketersediaan File Cache Endpoint</p>
                  <ul class="space-y-3">
                     <?php if (isset($cacheStatus['cached_keys'])): foreach ($cacheStatus['cached_keys'] as $key => $status): ?>
                     <li class="flex items-center justify-between p-3 rounded-xl border <?php echo $status ? 'border-emerald-100 bg-emerald-50/50' : 'border-rose-100 bg-rose-50/50'; ?>">
                        <div class="flex items-center gap-2">
                           <i class="fa-solid <?php echo $status ? 'fa-check text-emerald-500' : 'fa-xmark text-rose-500'; ?> w-4 text-center"></i>
                           <span class="text-sm font-mono font-bold <?php echo $status ? 'text-emerald-800' : 'text-rose-800'; ?>"><?php echo htmlspecialchars($key); ?></span>
                        </div>
                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded <?php echo $status ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'; ?> tracking-widest"><?php echo $status ? 'Hit Tersedia' : 'Miss/Kosong'; ?></span>
                     </li>
                     <?php endforeach; else: ?>
                     <li class="p-4 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 text-sm font-bold text-center">Data Key Cache Tidak Muncul Dari Respon API</li>
                     <?php endif; ?>
                  </ul>
               <?php else: ?>
                  <div class="p-6 rounded-2xl border-2 border-dashed border-rose-200 bg-rose-50 text-rose-600 text-center">
                     <i class="fa-solid fa-bug text-3xl mb-2 opacity-50"></i>
                     <p class="text-sm font-bold">Gagal menghubungkan ke infrastruktur status Cache API.</p>
                  </div>
               <?php endif; ?>
            </div>
         </div>

         <div class="space-y-6">
            <div class="bg-amber-50 rounded-3xl border border-amber-200 p-6 shadow-sm">
               <h3 class="font-bold text-amber-800 text-lg mb-4 flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation"></i> Zona Berbahaya - Purge Data</h3>
               <p class="text-amber-700 text-sm mb-6 leading-relaxed">Menghapus cache secara *Force Refresh* berarti setiap request selanjutnya akan secara langsung melakukan panggilan (cURL) ke server eksternal BMKG.<br><br>Hanya lakukan proses *clearing/purge* bila dirasa **Peringatan Tsunami macet/telat terupdate** atau **kondisi bencana mendesak**. Jangan mempurgasi sistem ini dalam intensitas hitungan menit untuk menghindari Rate Limiting Block IP Server.</p>
               
               <form method="POST" action="index.php?controller=Bmkg&action=clearCache" onsubmit="return confirm('Peringatan: Purgasi akan meningkatkan beban server secara drastis saat request cuaca/gempa massal terjadi. Anda yakin?')">
                  <button type="submit" class="w-full py-4 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-center shadow transition-colors flex justify-center items-center gap-2">
                     <i class="fa-solid fa-dumpster-fire"></i> Lakukan Clear All Cache BMKG Sekarang
                  </button>
               </form>
            </div>
         </div>
      </div>

    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>
