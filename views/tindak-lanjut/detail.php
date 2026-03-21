<?php include('template/header.php'); ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<?php
function tindakStatusTheme($statusRaw) {
  $status = strtolower(trim((string)$statusRaw));
  if ($status === 'menuju lokasi') return ['Menuju Lokasi', 'bg-rose-50 text-rose-700 border-rose-200', 'fa-truck-fast'];
  if ($status === 'sedang ditangani') return ['Sedang Ditangani', 'bg-amber-50 text-amber-700 border-amber-200', 'fa-person-digging'];
  if ($status === 'selesai') return ['Selesai', 'bg-emerald-50 text-emerald-700 border-emerald-200', 'fa-check-double'];
  if ($status === 'ditolak') return ['Dibatalkan', 'bg-slate-100 text-slate-500 border-slate-200', 'fa-xmark'];
  return [$statusRaw ?: '-', 'bg-slate-100 text-slate-700 border-slate-200', 'fa-circle-info'];
}
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div class="flex items-center gap-4">
            <a href="index.php?controller=TindakLanjut&action=index" class="flex items-center justify-center h-10 w-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-brand-600 hover:bg-brand-50 hover:border-brand-200 transition-all shadow-sm">
              <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
              <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight">Detail Operasi <span class="text-slate-400">#<?php echo (int)($tindakLanjut['id_tindaklanjut'] ?? 0); ?></span></h1>
              <p class="text-sm text-slate-500">Tinjau rekam jejak, foto, dan lokasi dari proses tanggap darurat.</p>
            </div>
          </div>
          <div class="shrink-0 flex gap-2">
            <?php if (!empty($tindakLanjut['id_tindaklanjut'])): ?>
              <a href="index.php?controller=TindakLanjut&action=edit&id=<?php echo (int)$tindakLanjut['id_tindaklanjut']; ?>" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-sm hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm">
                <i class="fa-solid fa-pen"></i> Update Info
              </a>
            <?php endif; ?>
          </div>
        </div>

        <?php if (isset($error_message)): ?>
          <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6 flex items-start gap-4">
            <div class="flex-shrink-0 text-red-500 mt-0.5"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
            <div class="flex-1">
              <h3 class="text-sm font-bold text-red-800">Gagal Memuat Data</h3>
              <p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($error_message); ?></p>
            </div>
          </div>
        <?php endif; ?>

        <?php if (isset($tindakLanjut) && $tindakLanjut): ?>
          <?php [$statusLabel, $badgeClass, $iconClass] = tindakStatusTheme($tindakLanjut['status'] ?? ''); ?>
          
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
              
              
              <div class="rounded-2xl bg-white border border-slate-200 shadow-card overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                  <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-truck-medical text-slate-400"></i> Rekam Jejak Lapangan
                  </h3>
                  <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-bold tracking-widest uppercase <?php echo $badgeClass; ?>">
                    <i class="fa-solid <?php echo $iconClass; ?>"></i> <?php echo htmlspecialchars($statusLabel); ?>
                  </span>
                </div>
                <div class="p-6">
                  
                  <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 mb-6 flex flex-wrap gap-x-8 gap-y-3">
                    <div>
                      <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-0.5">Asal Laporan</span>
                      <strong class="text-brand-600"><?php echo htmlspecialchars($tindakLanjut['laporan_judul'] ?? $tindakLanjut['laporan']['judul_laporan'] ?? '-'); ?></strong>
                    </div>
                    <div>
                      <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-0.5">Petugas PIC / Regu</span>
                      <strong class="text-indigo-600"><i class="fa-solid fa-users text-indigo-300 mr-1"></i> <?php echo htmlspecialchars($tindakLanjut['petugas_nama'] ?? $tindakLanjut['petugas']['nama'] ?? '-'); ?></strong>
                    </div>
                  </div>

                  
                  <div class="space-y-4">
                    <div>
                      <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Waktu Update Status</p>
                      <p class="font-semibold text-slate-600"><i class="fa-regular fa-clock mr-1.5 text-slate-400"></i> <?php echo date('d M Y, H:i', strtotime($tindakLanjut['tanggal_tanggapan'] ?? 'now')); ?></p>
                    </div>
                    
                    <div class="pt-2">
                      <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Catatan Operasi / Keterangan Tim</p>
                      <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 text-slate-700 leading-relaxed whitespace-pre-wrap font-medium"><?php echo htmlspecialchars($tindakLanjut['keterangan'] ?? 'Tanpa catatan tertulis.'); ?></div>
                    </div>
                  </div>
                </div>
              </div>

              
              <div class="rounded-2xl bg-white border border-slate-200 shadow-card overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                  <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-camera-retro text-slate-400"></i> Dokumentasi Referensi Laporan Awal
                  </h3>
                </div>
                <div class="p-6">
                  
                  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <?php for($i=1; $i<=3; $i++): ?>
                      <?php 
                        $fotoKey = 'foto_bukti_' . $i;
                        $fotoUrlKey = 'foto_bukti_' . $i . '_url';
                        $fotoSrc = $tindakLanjut['laporan'][$fotoUrlKey] ?? $tindakLanjut['laporan'][$fotoKey] ?? null;
                      ?>
                      <?php if (!empty($fotoSrc)): ?>
                        <div class="group relative aspect-[4/3] rounded-xl overflow-hidden cursor-pointer shadow-sm border border-slate-200" onclick="openFullscreen('<?php echo htmlspecialchars($fotoSrc); ?>')">
                          <img src="<?php echo htmlspecialchars($fotoSrc); ?>" alt="Bukti <?php echo $i; ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                          <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <i class="fa-solid fa-expand text-white text-2xl"></i>
                          </div>
                        </div>
                      <?php else: ?>
                        <div class="aspect-[4/3] rounded-xl bg-slate-50 border border-slate-200 border-dashed flex flex-col items-center justify-center text-slate-400">
                          <i class="fa-regular fa-image mb-2 text-2xl"></i>
                          <span class="text-xs font-medium">Foto <?php echo $i; ?> tidak ada</span>
                        </div>
                      <?php endif; ?>
                    <?php endfor; ?>
                  </div>

                  <?php $videoSrc = $tindakLanjut['laporan']['video_bukti_url'] ?? $tindakLanjut['laporan']['video_bukti'] ?? null; ?>
                  <?php if (!empty($videoSrc)): ?>
                    <div class="rounded-xl overflow-hidden border border-slate-200 shadow-sm bg-black aspect-video max-w-xl">
                      <video width="100%" height="auto" controls class="w-full h-full object-contain">
                        <source src="<?php echo htmlspecialchars($videoSrc); ?>" type="video/mp4">
                        Browser tidak mendukung elemen video.
                      </video>
                    </div>
                  <?php endif; ?>

                </div>
              </div>

            </div>

            
            <div class="lg:col-span-1 space-y-6">
              
              
              <div class="rounded-2xl bg-white border border-slate-200 shadow-card overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                  <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-map-location-dot text-slate-400"></i> Peta Insiden
                  </h3>
                </div>
                
                <div class="w-full h-[320px] relative z-0">
                  <div id="map" class="w-full h-full bg-slate-100"></div>
                </div>

                <div class="p-5 bg-slate-50/50">
                  <div class="mb-3">
                    <p class="text-xs font-semibold text-slate-600 leading-relaxed"><i class="fa-solid fa-location-dot text-brand-500 mr-1.5"></i> <?php echo htmlspecialchars($tindakLanjut['laporan']['alamat_lengkap'] ?? '-'); ?></p>
                  </div>
                  <div class="grid grid-cols-2 gap-2 pt-3 border-t border-slate-200 text-sm">
                    <div>
                      <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Latitude</p>
                      <p class="font-mono text-slate-700 text-xs"><?php echo htmlspecialchars((string)($tindakLanjut['laporan']['latitude'] ?? '-')); ?></p>
                    </div>
                    <div>
                      <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Longitude</p>
                      <p class="font-mono text-slate-700 text-xs"><?php echo htmlspecialchars((string)($tindakLanjut['laporan']['longitude'] ?? '-')); ?></p>
                    </div>
                  </div>
                </div>
              </div>

              
              <div class="rounded-2xl bg-white border border-slate-200 shadow-card p-5">
                <h3 class="font-bold text-slate-800 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                  <i class="fa-solid fa-link text-slate-400 text-sm"></i> Tautan Navigasi
                </h3>
                
                <div class="flex flex-col gap-2">
                  <a href="index.php?controller=LaporanAdmin&action=detail&id=<?php echo (int)($tindakLanjut['laporan_id'] ?? 0); ?>" class="flex items-center gap-3 w-full p-3 rounded-xl border border-indigo-200 bg-indigo-50 hover:bg-indigo-100 transition-colors group">
                    <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-indigo-500 group-hover:scale-110 transition-transform"><i class="fa-solid fa-file-invoice"></i></div>
                    <div class="text-left">
                      <p class="text-sm font-bold text-indigo-900">Lihat Laporan Awal</p>
                      <p class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">Detail Pelapor & Kronologi</p>
                    </div>
                  </a>
                  
                  <a href="index.php?controller=TindakLanjut&action=index" class="w-full flex items-center justify-center p-3 rounded-xl bg-slate-100 text-sm font-bold text-slate-600 hover:bg-slate-200 transition-colors mt-2">
                    Kembali ke Daftar
                  </a>
                </div>
              </div>

            </div>

          </div>
        <?php else: ?>
          <div class="rounded-2xl border border-amber-200 bg-amber-50 p-8 text-center flex flex-col items-center">
            <div class="inline-flex h-16 w-16 rounded-full bg-white text-amber-500 items-center justify-center mb-4 text-3xl shadow-sm"><i class="fa-solid fa-file-circle-question"></i></div>
            <h3 class="font-bold text-amber-800 text-lg mb-2">Data Tidak Ditemukan</h3>
            <p class="text-amber-700 max-w-sm mb-6">Data operasi ini mungkin telah dibatalkan atau dihapus dari sistem.</p>
            <a href="index.php?controller=TindakLanjut&action=index" class="inline-flex items-center gap-2 rounded-xl bg-amber-600 px-6 py-2.5 text-sm font-bold text-white hover:bg-amber-700 transition">
              Kembali ke Daftar
            </a>
          </div>
        <?php endif; ?>

      </div>
    </main>
  </div>
</div>


<div id="mediaModal" class="fixed inset-0 z-[100] hidden bg-black/90 backdrop-blur-sm flex items-center justify-center p-4">
  <button onclick="closeFullscreen()" class="absolute top-6 right-6 w-12 h-12 rounded-full bg-white/10 text-white flex items-center justify-center hover:bg-white/20 transition backdrop-blur-md">
    <i class="fa-solid fa-xmark text-xl"></i>
  </button>
  <div class="max-w-6xl w-full max-h-[90vh] flex items-center justify-center">
    <img id="modalImage" src="" class="hidden max-h-[90vh] max-w-full rounded-lg shadow-2xl object-contain">
  </div>
</div>

<?php include 'template/script.php'; ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

  function openFullscreen(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('modalImage').classList.remove('hidden');
    document.getElementById('mediaModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }

  function closeFullscreen() {
    document.getElementById('mediaModal').classList.add('hidden');
    document.getElementById('modalImage').classList.add('hidden');
    document.body.style.overflow = 'auto';
  }

  document.addEventListener('keydown', function(event){
    if(event.key === "Escape"){
      closeFullscreen();
    }
  });

  document.addEventListener('DOMContentLoaded', function () {
    const mapElement = document.getElementById('map');
    if (!mapElement || typeof L === 'undefined') return;

    var latRaw = "<?php echo (string)($tindakLanjut['laporan']['latitude'] ?? ''); ?>";
    var lngRaw = "<?php echo (string)($tindakLanjut['laporan']['longitude'] ?? ''); ?>";

    const latitude = Number(latRaw) || -6.2;
    const longitude = Number(lngRaw) || 106.816666;

    const map = L.map('map').setView([latitude, longitude], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap',
      maxZoom: 19
    }).addTo(map);

    if(latRaw && lngRaw) {
      L.marker([latitude, longitude]).addTo(map).bindPopup(
        '<div class="font-sans font-bold text-sm mb-1 text-slate-800">Sasaran Operasi</div><div class="font-mono text-xs text-slate-500">' + latitude + ', ' + longitude + '</div>'
      ).openPopup();
      
      setTimeout(function() { map.invalidateSize(); }, 200);
    } else {
      document.getElementById('map').innerHTML = '<div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-100"><i class="fa-solid fa-map-location-dot text-4xl mb-3 opacity-50"></i><p class="font-medium text-sm">Koordinat tidak tersedia</p></div>';
    }
  });
</script>
