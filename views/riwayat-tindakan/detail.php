<?php include('template/header.php'); ?>

<?php
function riwayatDetailStatusBadge($statusRaw) {
  $status = strtolower(trim((string)$statusRaw));
  if ($status === 'menuju lokasi') return ['Menuju Lokasi', 'bg-blue-50 text-blue-600 border-blue-200 fa-truck-fast'];
  if ($status === 'sedang ditangani') return ['Sedang Ditangani', 'bg-amber-50 text-amber-600 border-amber-200 fa-person-digging'];
  if ($status === 'selesai') return ['Selesai', 'bg-emerald-50 text-emerald-600 border-emerald-200 fa-check'];
  if ($status === 'ditolak') return ['Ditolak', 'bg-rose-50 text-rose-600 border-rose-200 fa-ban'];
  return [$statusRaw ?: '-', 'bg-slate-50 text-slate-600 border-slate-200 fa-info-circle'];
}
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative p-4 md:p-6 lg:p-8">
      
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
          <a href="index.php?controller=RiwayatTindakan&action=index" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-brand-600 hover:bg-brand-50 transition-all shadow-sm"><i class="fa-solid fa-arrow-left"></i></a>
          <div>
            <h1 class="text-2xl md:text-3xl font-display font-bold text-slate-800">Detail Riwayat Log</h1>
            <p class="text-slate-500 mt-1">Konteks mendetail mengenai riwayat kegiatan lapangan.</p>
          </div>
        </div>
        <?php if (!empty($riwayatTindakan['id'])): ?>
        <div class="flex items-center gap-3">
           <a href="index.php?controller=RiwayatTindakan&action=edit&id=<?php echo (int)$riwayatTindakan['id']; ?>" class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:border-brand-300 hover:text-brand-600 text-slate-700 px-4 py-2 rounded-xl font-bold transition-all shadow-sm">
             <i class="fa-solid fa-pen-to-square"></i> Perbarui Data
           </a>
        </div>
        <?php endif; ?>
      </div>

      <?php if (isset($error_message)): ?>
        <div class="rounded-xl bg-rose-50 border border-rose-200 p-4 mb-6 flex items-start gap-3">
          <div class="flex-shrink-0 text-rose-500 mt-0.5"><i class="fa-solid fa-circle-exclamation text-lg"></i></div>
          <div class="text-sm text-rose-700 font-medium"><?php echo htmlspecialchars($error_message); ?></div>
        </div>
      <?php endif; ?>

      <?php if (!empty($riwayatTindakan)): ?>
        <?php [$statusLabel, $badgeWrapper] = riwayatDetailStatusBadge($riwayatTindakan['tindak_lanjut']['status'] ?? ''); ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
           <div class="lg:col-span-2 space-y-6">
              
              
              <div class="bg-white rounded-3xl border border-slate-200 shadow-card p-6 md:p-8">
                 <div class="flex flex-wrap items-center gap-3 mb-6">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 flex-shrink-0 border border-slate-200 text-slate-600 rounded-lg text-xs font-bold font-mono"><i class="fa-solid fa-hashtag text-slate-400"></i> RIW-<?php echo str_pad($riwayatTindakan['id'] ?? 0, 5, "0", STR_PAD_LEFT); ?></span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 border <?php echo $badgeWrapper; ?> rounded-lg flex-shrink-0 text-xs font-bold uppercase tracking-widest"><i class="fa-solid <?php echo explode(' ', $badgeWrapper)[3]; ?>"></i> <?php echo htmlspecialchars($statusLabel); ?></span>
                 </div>

                 <h3 class="font-bold text-lg text-slate-800 mb-4 border-b border-slate-100 pb-2 flex items-center gap-2"><i class="fa-solid fa-circle-info text-brand-500"></i> Pokok Keterangan Aksi</h3>
                 <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 mb-6">
                    <p class="text-slate-700 leading-relaxed whitespace-pre-line"><?php echo htmlspecialchars($riwayatTindakan['keterangan'] ?? '-'); ?></p>
                 </div>

                 <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl border border-slate-100 flex items-start gap-4">
                       <div class="w-10 h-10 rounded-full bg-brand-50 border border-brand-100 text-brand-600 flex items-center justify-center shrink-0"><i class="fa-solid fa-user-shield"></i></div>
                       <div>
                          <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-0.5">Petugas Penindak</p>
                          <p class="font-bold text-slate-800 leading-tight"><?php echo htmlspecialchars($riwayatTindakan['petugas_nama'] ?? $riwayatTindakan['petugas']['nama'] ?? '-'); ?></p>
                       </div>
                    </div>
                    <div class="p-4 rounded-2xl border border-slate-100 flex items-start gap-4">
                       <div class="w-10 h-10 rounded-full bg-slate-50 border border-slate-200 text-slate-500 flex items-center justify-center shrink-0"><i class="fa-solid fa-user"></i></div>
                       <div>
                          <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-0.5">Warga Pelapor</p>
                          <p class="font-bold text-slate-800 leading-tight"><?php echo htmlspecialchars($riwayatTindakan['pelapor_nama'] ?? $riwayatTindakan['tindak_lanjut']['laporan']['pelapor']['nama'] ?? '-'); ?></p>
                       </div>
                    </div>
                 </div>
              </div>

              
              <div class="bg-white rounded-3xl border border-slate-200 shadow-card p-6 md:p-8">
                 <h3 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2"><i class="fa-solid fa-link text-indigo-500"></i> Merujuk Laporan Terkait</h3>
                 
                 <div class="flex items-start gap-4 p-4 rounded-xl border border-indigo-100 bg-indigo-50/50 mb-0">
                    <div class="w-12 h-12 rounded-xl bg-white border border-indigo-100 text-indigo-600 flex items-center justify-center text-xl shrink-0"><i class="fa-solid fa-file-invoice"></i></div>
                    <div>
                       <h4 class="font-bold text-indigo-900 group-hover:text-brand-600 transition-colors cursor-pointer mb-1"><?php echo htmlspecialchars($riwayatTindakan['laporan_judul'] ?? $riwayatTindakan['tindak_lanjut']['laporan']['judul_laporan'] ?? 'Untitled Laporan'); ?></h4>
                       <p class="text-xs text-indigo-700/80 mb-2 line-clamp-2 leading-relaxed"><i class="fa-solid fa-location-dot mr-1"></i> <?php echo htmlspecialchars($riwayatTindakan['tindak_lanjut']['laporan']['alamat_lengkap'] ?? '-'); ?></p>
                       <a href="index.php?controller=LaporanAdmin&action=detail&id=<?php echo $riwayatTindakan['tindak_lanjut']['laporan_id'] ?? 0; ?>" class="inline-block text-[11px] font-bold text-white bg-indigo-600 px-3 py-1.5 rounded-lg shadow-sm hover:bg-indigo-700 transition">Buka Bukti Laporan Full &rarr;</a>
                    </div>
                 </div>
              </div>

           </div>
           
           
           <div class="col-lg-1 space-y-6">
              <div class="bg-white rounded-3xl border border-slate-200 shadow-card p-6 overflow-hidden relative">
                 <div class="absolute -right-6 -bottom-6 text-slate-50 opacity-40 pointer-events-none"><i class="fa-solid fa-clock-rotate-left text-9xl"></i></div>
                 <h3 class="font-bold text-slate-800 mb-6 relative z-10 flex items-center gap-2 border-b border-slate-100 pb-2">Informasi Metadata</h3>
                 
                 <div class="space-y-4 relative z-10">
                    <div>
                       <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-1">ID Sistem</p>
                       <p class="font-mono text-sm font-bold text-slate-700">#<?php echo (int)($riwayatTindakan['id'] ?? 0); ?></p>
                    </div>
                    <div>
                       <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-1">Waktu Tindakan / Eksekusi</p>
                       <p class="text-sm font-bold text-slate-800"><i class="fa-regular fa-calendar-check text-brand-500 mr-1.5"></i> <?php echo date('d F Y', strtotime($riwayatTindakan['waktu_tindakan'] ?? 'now')); ?></p>
                       <p class="text-xs font-mono text-slate-500 mt-1 pl-5"><?php echo date('H:i:s', strtotime($riwayatTindakan['waktu_tindakan'] ?? 'now')); ?> WIB</p>
                    </div>
                    <div>
                       <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-1">Dibuat Oleh ID Akun</p>
                       <p class="text-sm font-medium text-slate-600"><?php echo htmlspecialchars($riwayatTindakan['petugas']['id'] ?? $riwayatTindakan['petugas_id'] ?? 'System/Root'); ?></p>
                    </div>
                 </div>
              </div>
           </div>
        </div>
      <?php else: ?>
        <div class="rounded-2xl border-2 border-dashed border-slate-200 p-12 text-center text-slate-500 bg-white">
           <i class="fa-solid fa-box-open text-5xl mb-4 text-slate-300"></i>
           <h3 class="font-display font-bold text-xl text-slate-700 mb-2">Data Tidak Ditemukan</h3>
           <p class="text-sm max-w-md mx-auto mb-6">Rekaman riwayat tindakan ini sudah tidak berada di dalam sistem, mungkin dihapus secara permanen atau ada kesalahan pemanggilan.</p>
           <a href="index.php?controller=RiwayatTindakan&action=index" class="inline-flex px-5 py-2.5 rounded-xl bg-brand-50 text-brand-600 font-bold hover:bg-brand-100 transition-colors">Kembali ke Daftar Riwayat</a>
        </div>
      <?php endif; ?>

    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>
