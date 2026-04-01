<?php include('template/header.php'); ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div>
            <div class="flex items-center gap-2 mb-2">
              <a href="index.php?controller=LaporanOperator&action=index" class="text-sm font-bold text-slate-400 hover:text-brand-600 transition flex items-center gap-1"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            </div>
            <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-900">Rincian Laporan Masuk</h1>
            <p class="text-sm text-slate-500 mt-1">Detail pelaporan yang dikirim oleh warga di sekitar wilayah desa Anda.</p>
          </div>
        </div>

        <?php if (isset($error_message)): ?>
          <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6 flex items-start gap-4 shadow-sm">
            <div class="flex-shrink-0 text-red-500 mt-0.5"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
            <div class="flex-1">
              <h3 class="text-sm font-bold text-red-800">Peringatan Sistem</h3>
              <p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($error_message); ?></p>
            </div>
          </div>
        <?php endif; ?>

        <?php if (!empty($report)): ?>
          
          <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            
            
            <div class="xl:col-span-2 flex flex-col gap-6">
              
              
              <div class="rounded-3xl bg-white border border-slate-200 shadow-card overflow-hidden">
                <div class="p-6 md:p-8">
                  <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-6">
                    <div>
                      <h2 class="font-display text-2xl font-bold text-slate-800 mb-2"><?php echo htmlspecialchars($report['judul_laporan'] ?? '-'); ?></h2>
                      <div class="flex flex-wrap items-center gap-3">
                         <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-bold">
                           <i class="fa-solid fa-layer-group text-[10px] text-slate-400"></i> <?php echo htmlspecialchars($report['kategori']['nama_kategori'] ?? '-'); ?>
                         </div>
                         <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-bold">
                           <i class="fa-solid fa-fire-flame-curved text-[10px] text-orange-400"></i> Tingkat: <?php echo htmlspecialchars($report['tingkat_keparahan'] ?? '-'); ?>
                         </div>
                      </div>
                    </div>
                    
                    <div class="shrink-0 flex gap-2">
                        <?php if (in_array(strtolower($report['status'] ?? ''), ['menunggu verifikasi', 'diverifikasi', 'sedang diproses'])): ?>
                          <a href="index.php?controller=LaporanOperator&action=edit-status&id=<?php echo $report['id']; ?>" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 text-white font-bold text-sm hover:bg-amber-600 transition shadow-sm">
                            <i class="fa-solid fa-pen-to-square"></i> Perbarui Status
                          </a>
                        <?php endif; ?>
                    </div>
                  </div>
                  
                  <div class="w-full h-px bg-slate-100 mb-6"></div>
                  
                  <h3 class="text-sm font-bold text-slate-800 mb-2">Deskripsi Kronologis</h3>
                  <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-slate-600 leading-relaxed font-medium mb-8">
                     <?php echo nl2br(htmlspecialchars($report['deskripsi'] ?? 'Laporan ini tidak memiliki deskripsi spesifik.')); ?>
                  </div>
                  
                  
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                     <div class="rounded-2xl border border-slate-100 p-4 bg-white shadow-sm flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center text-lg shrink-0"><i class="fa-solid fa-user-shield"></i></div>
                        <div>
                           <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 mt-0.5">Dilaporkan Oleh</p>
                           <p class="font-bold text-slate-800"><?php echo htmlspecialchars($report['pelapor']['nama'] ?? '-'); ?></p>
                           <p class="text-xs font-medium text-slate-500 mt-0.5"><i class="fa-solid fa-phone mr-1"></i> <?php echo htmlspecialchars($report['pelapor']['no_telepon'] ?? 'Tidak ada HP'); ?></p>
                        </div>
                     </div>
                     <div class="rounded-2xl border border-slate-100 p-4 bg-white shadow-sm flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-violet-50 text-violet-500 flex items-center justify-center text-lg shrink-0"><i class="fa-solid fa-map-location"></i></div>
                        <div>
                           <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 mt-0.5">Wilayah Administrasi</p>
                           <p class="font-bold text-slate-800">Desa <?php echo htmlspecialchars($report['desa']['nama'] ?? '-'); ?></p>
                           <p class="text-xs font-medium text-slate-500 mt-1 line-clamp-2"><?php echo htmlspecialchars($report['alamat_laporan'] ?? ($report['alamat_lengkap'] ?? '-')); ?></p>
                        </div>
                     </div>
                  </div>
                </div>
              </div>

              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                
                <div class="rounded-3xl bg-white border border-slate-200 shadow-card overflow-hidden flex flex-col">
                  <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                     <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center"><i class="fa-solid fa-map-pin"></i></div>
                     <h3 class="font-bold text-sm text-slate-800">Peta Titik Kejadian</h3>
                  </div>
                  <div class="relative flex-1 min-h-[250px] bg-slate-100">
                    <?php if (isset($report['latitude']) && isset($report['longitude']) && !empty($report['latitude']) && !empty($report['longitude'])): ?>
                      <div id="map" class="absolute inset-0 z-0"></div>
                      <div class="absolute bottom-3 left-3 right-3 z-[1000]">
                         <div class="backdrop-blur-md bg-white/80 border border-white/50 p-2.5 rounded-xl shadow-lg flex items-center justify-center gap-2 text-xs font-bold text-slate-700">
                           <i class="fa-solid fa-crosshairs text-slate-400"></i> <?php echo $report['latitude']; ?>, <?php echo $report['longitude']; ?>
                         </div>
                      </div>
                    <?php else: ?>
                      <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-400">
                        <i class="fa-solid fa-map-location-dot text-4xl mb-3 text-slate-300"></i>
                        <span class="text-sm font-bold">Titik Koordinat Tidak Ditemukan</span>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>

                
                <div class="rounded-3xl bg-white border border-slate-200 shadow-card overflow-hidden flex flex-col">
                  <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                     <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center"><i class="fa-solid fa-camera-retro"></i></div>
                     <h3 class="font-bold text-sm text-slate-800">Bukti Visual</h3>
                  </div>
                  <div class="p-5 flex-1 flex flex-col items-center justify-center">
                    <?php if (!empty($report['foto_bukti_1'])): ?>
                      <div class="rounded-2xl border-4 border-slate-100 overflow-hidden shadow-sm relative group w-full max-w-[240px]">
                         <img src="<?php echo htmlspecialchars($report['foto_bukti_1']); ?>" class="w-full h-auto object-cover aspect-square" alt="Foto Bukti">
                         <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                            <a href="<?php echo htmlspecialchars($report['foto_bukti_1']); ?>" target="_blank" class="px-4 py-2 rounded-lg bg-white text-slate-800 font-bold text-xs shadow-sm"><i class="fa-solid fa-expand mr-1.5"></i> Perbesar visual</a>
                         </div>
                      </div>
                    <?php else: ?>
                      <div class="w-full h-40 flex flex-col items-center justify-center bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl text-slate-400">
                        <i class="fa-solid fa-image text-4xl mb-3 text-slate-300"></i>
                        <span class="text-sm font-bold">Tidak ada foto dilampirkan</span>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>

              </div>

            </div>

            
            <div class="xl:col-span-1">
               <div class="sticky top-6 flex flex-col gap-6">
                 
                 
                 <div class="rounded-3xl bg-slate-800 border-none shadow-card overflow-hidden text-white relative">
                   <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-full -mr-10 -mt-10"></div>
                   <div class="p-6 relative z-10 text-center">
                      <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-2">Status Saat Ini</p>
                      
                      <?php
                        $statusText = $report['status'] ?? 'Draft';
                        $iconStatus = 'fa-circle-info';
                        $colorStatus = 'text-white';
                        
                        switch (strtolower($statusText)) {
                          case 'draft': $iconStatus = 'fa-pen-ruler'; break;
                          case 'menunggu verifikasi': $iconStatus = 'fa-hourglass-half'; $colorStatus = 'text-amber-400'; break;
                          case 'diverifikasi': $iconStatus = 'fa-shield-check'; $colorStatus = 'text-blue-400'; break;
                          case 'sedang diproses': $iconStatus = 'fa-spinner fa-spin'; $colorStatus = 'text-indigo-400'; break;
                          case 'selesai': $iconStatus = 'fa-check-double'; $colorStatus = 'text-emerald-400'; break;
                          case 'ditolak': $iconStatus = 'fa-ban'; $colorStatus = 'text-rose-400'; break;
                        }
                      ?>
                      
                      <div class="inline-flex w-16 h-16 rounded-full bg-white/10 items-center justify-center text-3xl mb-3 <?php echo $colorStatus; ?>">
                         <i class="fa-solid <?php echo $iconStatus; ?>"></i>
                      </div>
                      <h2 class="font-display text-2xl font-bold mb-1 <?php echo $colorStatus; ?> drop-shadow-sm"><?php echo htmlspecialchars($statusText); ?></h2>
                      <p class="text-xs text-slate-400 font-medium">Diperbarui: <?php echo date('d M Y - H:i', strtotime($report['updated_at'] ?? $report['waktu_laporan'] ?? '')); ?></p>
                   </div>
                   <?php if (strtolower($statusText) === 'menunggu verifikasi'): ?>
                     <div class="p-4 bg-white/5 border-t border-white/10 text-center">
                        <a href="index.php?controller=LaporanOperator&action=edit-status&id=<?php echo $report['id']; ?>" class="inline-flex w-full items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-brand-600 text-white font-bold text-sm hover:bg-brand-500 transition shadow-lg">
                          <i class="fa-solid fa-list-check"></i> Lakukan Verifikasi Data
                        </a>
                     </div>
                   <?php endif; ?>
                 </div>

                 
                 <div class="rounded-3xl bg-white border border-slate-200 shadow-card overflow-hidden">
                   <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                     <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center"><i class="fa-solid fa-clock-rotate-left"></i></div>
                     <h3 class="font-bold text-sm text-slate-800">Riwayat Penanganan</h3>
                   </div>
                   <div class="p-6">
                     <div class="relative border-l-2 border-slate-100 ml-3 space-y-6">
                        
                         <?php if (!empty($riwayatList) && is_array($riwayatList)): ?>
                           <?php foreach ($riwayatList as $riwayat): ?>
                             <div class="relative pl-6">
                                 <div class="absolute w-4 h-4 bg-white border-4 border-amber-400 rounded-full -left-[-11px] top-1 z-10 shadow-[0_0_0_3px_white]"></div>
                                 <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1"><?php echo date('d M Y H:i', strtotime($riwayat['waktu'] ?? ($riwayat['created_at'] ?? 'now'))); ?></p>
                                 <h4 class="text-sm font-bold text-slate-800"><?php echo htmlspecialchars($riwayat['status'] ?? '-'); ?></h4>
                                 <?php if (!empty($riwayat['keterangan'] ?? $riwayat['catatan_verifikasi'] ?? '')): ?>
                                   <p class="text-xs text-slate-600 mt-1 p-2 bg-amber-50 rounded-lg border border-amber-100 font-medium"><?php echo htmlspecialchars($riwayat['keterangan'] ?? $riwayat['catatan_verifikasi']); ?></p>
                                 <?php endif; ?>
                             </div>
                           <?php endforeach; ?>
                        <?php else: ?>
                            <div class="relative pl-6 opacity-60">
                                <div class="absolute w-4 h-4 bg-white border-4 border-slate-200 rounded-full -left-[-11px] top-1"></div>
                                <h4 class="text-sm font-bold text-slate-400 italic">Belum ada riwayat pergerakan</h4>
                            </div>
                        <?php endif; ?>

                     </div>
                   </div>
                 </div>

               </div>
            </div>
            
          </div>
          
        <?php else: ?>
          <div class="rounded-2xl bg-amber-50 border border-amber-200 p-8 text-center max-w-2xl mx-auto mt-10 shadow-sm">
            <div class="inline-flex h-20 w-20 rounded-full bg-white text-amber-500 items-center justify-center mb-5 shadow-sm text-3xl"><i class="fa-solid fa-file-circle-xmark"></i></div>
            <h3 class="font-display font-bold text-amber-800 text-xl mb-2">Laporan Tidak Ditemukan</h3>
            <p class="text-sm font-medium text-amber-700 mb-6">Data rincian laporan yang Anda cari tidak tersedia di pangkalan data.</p>
            <a href="index.php?controller=LaporanOperator&action=index" class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-amber-600 text-sm font-bold text-white hover:bg-amber-700 transition shadow-sm">
              <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar
            </a>
          </div>
        <?php endif; ?>

      </div>
    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
  <?php if (isset($report['latitude']) && isset($report['longitude']) && !empty($report['latitude']) && !empty($report['longitude'])): ?>
    var map = L.map('map').setView([<?php echo $report['latitude']; ?>, <?php echo $report['longitude']; ?>], 15);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 20
    }).addTo(map);

    var customIcon = L.divIcon({
        className: 'custom-div-icon',
        html: "<div style='background-color:#ef4444;width:14px;height:14px;border-radius:50%;border:3px solid white;box-shadow:0 0 10px rgba(0,0,0,0.5);'></div>",
        iconSize: [20, 20],
        iconAnchor: [10, 10]
    });

    var marker = L.marker([<?php echo $report['latitude']; ?>, <?php echo $report['longitude']; ?>], {icon: customIcon}).addTo(map);
    marker.bindPopup("<div class='font-bold text-sm text-slate-800'><?php echo addslashes(htmlspecialchars($report['judul_laporan'] ?? 'Titik Bencana')); ?></div>").openPopup();
  <?php endif; ?>
</script>
