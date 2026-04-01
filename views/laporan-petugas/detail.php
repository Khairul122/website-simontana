<?php include('template/header.php'); ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<?php
function laporanPetugasDetailStatusBadge($statusRaw) {
  $status = strtolower(trim((string) $statusRaw));
  if ($status === 'menunggu verifikasi' || $status === 'verifikasi' || $status === 'diverifikasi') {
    return ['Diverifikasi', 'bg-blue-50 text-blue-600 border-blue-200 fa-shield-check'];
  }
  if ($status === 'diproses' || $status === 'ditangani') {
    return ['Diproses', 'bg-indigo-50 text-indigo-600 border-indigo-200 fa-spinner fa-spin'];
  }
  if ($status === 'tindak lanjut') {
    return ['Tindak Lanjut', 'bg-amber-50 text-amber-600 border-amber-200 fa-truck-fast'];
  }
  if ($status === 'selesai') {
    return ['Selesai', 'bg-emerald-50 text-emerald-600 border-emerald-200 fa-check-double'];
  }
  if ($status === 'ditolak') {
    return ['Ditolak', 'bg-rose-50 text-rose-600 border-rose-200 fa-ban'];
  }
  if ($status === 'draft') {
    return ['Draft', 'bg-slate-100 text-slate-600 border-slate-200 fa-pen-ruler'];
  }
  return [$statusRaw ?: '-', 'bg-slate-50 text-slate-500 border-slate-200 fa-circle-info'];
}
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div>
            <div class="flex items-center gap-2 mb-2">
              <a href="index.php?controller=LaporanPetugas&action=index" class="text-sm font-bold text-slate-400 hover:text-brand-600 transition flex items-center gap-1"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            </div>
            <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-900">Surveillance Laporan BPBD</h1>
            <p class="text-sm text-slate-500 mt-1">Tinjau data komprehensif pelaporan yang diteruskan ke unit lapangan BPBD.</p>
          </div>
          <div class="shrink-0 flex gap-3">
            <a href="index.php?controller=LaporanPetugas&action=edit&id=<?php echo (int) ($laporan['id'] ?? 0); ?>" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-amber-500 text-white font-bold text-sm hover:bg-amber-600 transition shadow-sm">
              <i class="fa-solid fa-pen-to-square"></i> Perbarui Kondisi Laporan
            </a>
          </div>
        </div>

        <?php if (isset($error_message)): ?>
          <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6 flex items-start gap-4 shadow-sm">
            <div class="flex-shrink-0 text-red-500 mt-0.5"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
            <div class="flex-1">
              <h3 class="text-sm font-bold text-red-800">Ups! Sesuatu Terjadi</h3>
              <p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($error_message); ?></p>
            </div>
          </div>
        <?php endif; ?>

        <?php if (isset($laporan) && $laporan): ?>
          <?php [$label, $badge] = laporanPetugasDetailStatusBadge($laporan['status'] ?? ''); ?>
          
          <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            
            
            <div class="xl:col-span-2 flex flex-col gap-6">
              
              
              <div class="rounded-3xl bg-white border border-slate-200 shadow-card overflow-hidden">
                <div class="p-6 md:p-8">
                  <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                    <div>
                      <h2 class="font-display text-2xl font-bold text-slate-800 mb-2"><?php echo htmlspecialchars($laporan['judul_laporan'] ?? '-'); ?></h2>
                      <div class="flex flex-wrap items-center gap-3">
                         <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-bold">
                           <i class="fa-solid fa-layer-group text-[10px] text-slate-400"></i> <?php echo htmlspecialchars($laporan['kategori']['nama_kategori'] ?? '-'); ?>
                         </div>
                         <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-rose-50 text-rose-600 text-xs font-bold border border-rose-100">
                           <i class="fa-solid fa-triangle-exclamation text-[10px] text-rose-400"></i> Tingkat: <?php echo htmlspecialchars($laporan['tingkat_keparahan'] ?? '-'); ?>
                         </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="w-full h-px bg-slate-100 mb-6"></div>
                  
                  <h3 class="text-sm font-bold text-slate-800 mb-2">Penjabaran Laporan</h3>
                  <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-slate-600 leading-relaxed font-medium mb-8">
                     <?php echo nl2br(htmlspecialchars($laporan['deskripsi'] ?? 'Laporan ini tidak memiliki narasi spesifik.')); ?>
                  </div>
                  
                  
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                     
                     <div class="rounded-2xl border border-slate-100 p-4 bg-white flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 border border-slate-100 flex items-center justify-center shrink-0"><i class="fa-solid fa-user"></i></div>
                        <div>
                           <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Disampaikan Oleh</p>
                           <p class="font-bold text-slate-700"><?php echo htmlspecialchars($laporan['pelapor']['nama'] ?? '-'); ?></p>
                           <p class="text-xs font-medium text-slate-500"><i class="fa-solid fa-at mr-1"></i> <?php echo htmlspecialchars($laporan['pelapor']['email'] ?? '-'); ?></p>
                           <p class="text-xs font-medium text-slate-500 mt-0.5"><i class="fa-solid fa-mobile-screen mr-1"></i> <?php echo htmlspecialchars($laporan['pelapor']['no_telepon'] ?? '-'); ?></p>
                        </div>
                     </div>
                     
                     
                     <div class="rounded-2xl border border-slate-100 p-4 bg-white flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-red-50 text-red-500 border border-red-100 flex items-center justify-center shrink-0"><i class="fa-solid fa-map-location-dot"></i></div>
                        <div>
                           <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Alamat / Wilayah</p>
                           <p class="text-sm font-bold text-slate-700 line-clamp-2"><?php echo htmlspecialchars($laporan['alamat_laporan'] ?? ($laporan['alamat_lengkap'] ?? '-')); ?></p>
                           <p class="text-xs font-medium text-slate-500 mt-1"><?php echo htmlspecialchars($laporan['administrative_area'] ?? '-'); ?></p>
                        </div>
                     </div>
                  </div>
                  
                </div>
              </div>

              
              <div class="rounded-3xl bg-white border border-slate-200 shadow-card overflow-hidden">
                 <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                       <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center"><i class="fa-solid fa-satellite-dish"></i></div>
                       <h3 class="font-bold text-sm text-slate-800">Pemetaan Titik Pelaporan</h3>
                    </div>
                    <?php if(isset($laporan['latitude']) && isset($laporan['longitude'])): ?>
                       <div class="bg-white border border-slate-200 rounded-lg px-3 py-1 text-xs font-mono font-bold text-slate-500 shadow-sm">
                          <?php echo $laporan['latitude']; ?>, <?php echo $laporan['longitude']; ?>
                       </div>
                    <?php endif; ?>
                 </div>
                 <div class="relative w-full h-[360px] bg-slate-100">
                    <div id="map" class="absolute inset-0 z-0"></div>
                 </div>
              </div>

            </div>

            
            <div class="xl:col-span-1">
               <div class="sticky top-6 flex flex-col gap-6">
                 
                 
                 <div class="rounded-3xl bg-slate-800 text-white shadow-card overflow-hidden relative">
                   <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-[100px] -mr-10 -mt-10 pointer-events-none"></div>
                   
                   <div class="p-6 relative z-10 text-center">
                      <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-2">Penetapan Sistem</p>
                      
                      <?php 
                        $classes = explode(' ', $badge); 
                        $icon = array_pop($classes);
                        if(strpos($icon, 'fa-') === false) { $icon = 'fa-circle-info'; } else {
                           if(strpos($badge, 'fa-spin') !== false) {
                              array_pop($classes);
                              $icon = $icon . ' fa-spin';
                           }
                        }
                        
                        
                        $colorClassText = 'text-white';
                        if(strpos($badge, 'blue-50') !== false) $colorClassText = 'text-blue-400';
                        if(strpos($badge, 'indigo-50') !== false) $colorClassText = 'text-indigo-400';
                        if(strpos($badge, 'amber-50') !== false) $colorClassText = 'text-amber-400';
                        if(strpos($badge, 'emerald-50') !== false) $colorClassText = 'text-emerald-400';
                        if(strpos($badge, 'rose-50') !== false) $colorClassText = 'text-rose-400';
                      ?>
                      
                      <div class="inline-flex w-16 h-16 rounded-full bg-white/10 items-center justify-center text-3xl mb-3 <?php echo $colorClassText; ?>">
                         <i class="fa-solid <?php echo $icon; ?>"></i>
                      </div>
                      <h2 class="font-display text-2xl font-bold mb-1 <?php echo $colorClassText; ?> drop-shadow-sm"><?php echo htmlspecialchars($label); ?></h2>
                      <p class="text-xs text-slate-400 font-medium tracking-wide">Laporan Dibuat: <?php echo date('d M Y - H:i', strtotime($laporan['waktu_laporan'] ?? 'now')); ?></p>
                   </div>
                   
                   
                   <div class="p-4 bg-white/5 border-t border-white/10 flex flex-col gap-2 relative z-10">
                      <p class="text-[10px] text-center uppercase tracking-widest font-bold text-slate-400 mb-1">Aksi Cepat Petugas Lapangan</p>
                      
                      <div class="grid grid-cols-2 gap-2">
                         <form method="POST" action="index.php?controller=LaporanPetugas&action=updateToProses&id=<?php echo (int) $laporan['id']; ?>" class="quick-status-form m-0" data-confirm="Ubah status laporan menjadi Diproses?">
                           <button type="submit" class="w-full text-[11px] h-9 rounded-xl !bg-indigo-600 !text-white hover:!bg-indigo-500 font-bold border-0 shadow-none"><i class="fa-solid fa-spinner mr-1"></i> Diproses</button>
                         </form>
                         <form method="POST" action="index.php?controller=LaporanPetugas&action=updateToSelesai&id=<?php echo (int) $laporan['id']; ?>" class="quick-status-form m-0" data-confirm="Ubah status laporan menjadi Selesai?">
                           <button type="submit" class="w-full text-[11px] h-9 rounded-xl !bg-emerald-600 !text-white hover:!bg-emerald-500 font-bold border-0 shadow-none"><i class="fa-solid fa-check mr-1"></i> Selesai</button>
                         </form>
                      </div>
                      <form method="POST" action="index.php?controller=LaporanPetugas&action=updateToDitolak&id=<?php echo (int) $laporan['id']; ?>" class="quick-status-form m-0" data-confirm="Yakin membatalkan / menolak laporan ini?">
                        <button type="submit" class="w-full text-[11px] h-9 rounded-xl !bg-rose-500/20 !text-rose-100 hover:!bg-rose-500/50 hover:!text-white font-bold border-0 mt-1 transition shadow-none"><i class="fa-solid fa-ban mr-1"></i> Tolak / Tarik Laporan</button>
                      </form>
                   </div>
                 </div>

                 
                 <div class="rounded-3xl bg-white border border-slate-200 shadow-card overflow-hidden">
                   <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                     <div class="flex items-center gap-3">
                       <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center"><i class="fa-solid fa-truck-fast"></i></div>
                       <h3 class="font-bold text-sm text-slate-800">Arus Tindak Lanjut</h3>
                     </div>
                   </div>
                   
                   <div class="p-6">
                     <div class="relative border-l-2 border-slate-100 ml-3 space-y-6">
                        
                         <?php if (!empty($riwayatList) && is_array($riwayatList)): ?>
                            <?php foreach ($riwayatList as $riwayat): ?>
                               <div class="relative pl-6">
                                   <div class="absolute w-4 h-4 bg-white border-4 border-indigo-400 rounded-full -left-[-11px] top-1 z-10"></div>
                                   <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1"><?php echo date('d M Y H:i', strtotime($riwayat['waktu'] ?? ($riwayat['created_at'] ?? 'now'))); ?></p>
                                   <h4 class="text-sm font-bold text-indigo-900"><?php echo htmlspecialchars($riwayat['status'] ?? '-'); ?></h4>
                                   <?php if (!empty($riwayat['keterangan'] ?? $riwayat['catatan_verifikasi'] ?? '')): ?>
                                     <p class="text-xs text-slate-500 mt-1 bg-slate-50 border border-slate-100 p-2 rounded-lg font-medium"><?php echo htmlspecialchars($riwayat['keterangan'] ?? $riwayat['catatan_verifikasi']); ?></p>
                                   <?php endif; ?>
                               </div>
                            <?php endforeach; ?>
                         <?php else: ?>
                            <div class="relative pl-6 opacity-60">
                                <div class="absolute w-4 h-4 bg-white border-4 border-slate-200 rounded-full -left-[-11px] top-1"></div>
                                <h4 class="text-sm font-bold text-slate-400 italic">Belum ada progres lanjut</h4>
                            </div>
                        <?php endif; ?>
                     </div>
                   </div>
                 </div>
                 
                 
                 <?php if (!empty($laporan['monitoring']) && is_array($laporan['monitoring'])): ?>
                    <div class="rounded-3xl bg-white border border-slate-200 shadow-card overflow-hidden">
                      <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                          <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center"><i class="fa-solid fa-desktop"></i></div>
                          <h3 class="font-bold text-sm text-slate-800">Catatan Monitoring Desa</h3>
                        </div>
                      </div>
                      <div class="p-6">
                         <div class="relative border-l-2 border-slate-100 ml-3 space-y-6">
                            <?php foreach (array_reverse($laporan['monitoring']) as $monitor): ?>
                               <div class="relative pl-6">
                                   <div class="absolute w-4 h-4 bg-white border-4 border-emerald-400 rounded-full -left-[-11px] top-1 z-10"></div>
                                   <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1"><?php echo date('d M Y H:i', strtotime($monitor['waktu_monitoring'] ?? 'now')); ?></p>
                                   <p class="text-xs font-medium text-slate-600 mt-1"><?php echo htmlspecialchars($monitor['hasil_monitoring'] ?? '-'); ?></p>
                               </div>
                            <?php endforeach; ?>
                         </div>
                      </div>
                    </div>
                 <?php endif; ?>

               </div>
            </div>

          </div>
        <?php else: ?>
          <div class="rounded-2xl bg-amber-50 border border-amber-200 p-8 text-center max-w-2xl mx-auto mt-10 shadow-sm">
            <div class="inline-flex h-20 w-20 rounded-full bg-white text-amber-500 items-center justify-center mb-5 shadow-sm text-3xl"><i class="fa-solid fa-file-circle-xmark"></i></div>
            <h3 class="font-display font-bold text-amber-800 text-xl mb-2">Laporan Hilang atau Kosong</h3>
            <p class="text-sm font-medium text-amber-700 mb-6">Data ini mungkin telah dihapus oleh hierarki yang lebih tinggi dari pusat.</p>
            <a href="index.php?controller=LaporanPetugas&action=index" class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-amber-600 text-sm font-bold text-white hover:bg-amber-700 transition shadow-sm">
              Kembali ke Daftar Laporan
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
  document.addEventListener('DOMContentLoaded', function () {
    const mapContainer = document.getElementById('map');
    if (mapContainer && typeof L !== 'undefined') {
      const latitude = Number(<?php echo json_encode($laporan['latitude'] ?? -6.200000); ?>);
      const longitude = Number(<?php echo json_encode($laporan['longitude'] ?? 106.816666); ?>);
      const map = L.map('map').setView([latitude, longitude], 14);

      L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> contributors',
        subdomains: 'abcd',
        maxZoom: 20
      }).addTo(map);

      var customIcon = L.divIcon({
          className: 'custom-div-icon',
          html: "<div style='background-color:#0ea5e9;width:16px;height:16px;border-radius:50%;border:4px solid white;box-shadow:0 0 12px rgba(0,0,0,0.4);'></div>",
          iconSize: [24, 24],
          iconAnchor: [12, 12]
      });

      L.marker([latitude, longitude], {icon: customIcon}).addTo(map).bindPopup(
        "<div class='font-bold text-sm text-slate-800'><i class='fa-solid fa-triangle-exclamation text-rose-500 mr-1'></i> <?php echo addslashes(htmlspecialchars($laporan['judul_laporan'] ?? 'Titik Koordinat Bencana')); ?></div>"
      ).openPopup();
    }

    const quickForms = document.querySelectorAll('.quick-status-form');
    quickForms.forEach(function (form) {
      form.addEventListener('submit', function (event) {
        event.preventDefault();
        const message = form.getAttribute('data-confirm') || 'Yakin melanjutkan aksi otomatis ini?';

        if (typeof Swal !== 'undefined') {
          Swal.fire({
            icon: 'question',
            title: 'Sistem Konfirmasi',
            text: message,
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#4f46e5',
            customClass: {
               popup: 'rounded-3xl',
               confirmButton: 'rounded-xl font-bold shadow-sm',
               cancelButton: 'rounded-xl font-bold bg-slate-50 text-slate-600 border border-slate-200 hover:bg-slate-100'
            }
          }).then(function (result) {
            if (result.isConfirmed) {
              form.submit();
            }
          });
        } else {
           if(window.confirm(message)) form.submit();
        }
      });
    });
  });
</script>
