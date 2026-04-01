<?php include('template/header.php'); ?>


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<?php
  $status = $laporan['status'] ?? '';
  $badgeTheme = 'bg-slate-100 text-slate-700 border-slate-200';
  $statusIcon = 'fa-spinner';
  $statusBgHeader = 'bg-slate-50 border-slate-200';
  $statusColorPulse = 'bg-slate-400';
  
  if ($status === 'Menunggu Verifikasi') { 
    $badgeTheme = 'bg-red-50 text-red-700 border-red-200'; 
    $statusIcon = 'fa-clock'; 
    $statusBgHeader = 'bg-red-50 border-red-200';
    $statusColorPulse = 'bg-red-500';
  }
  if ($status === 'Diproses' || $status === 'Ditangani') { 
    $badgeTheme = 'bg-amber-50 text-amber-700 border-amber-200'; 
    $statusIcon = 'fa-helmet-safety'; 
    $statusBgHeader = 'bg-amber-50 border-amber-200';
    $statusColorPulse = 'bg-amber-500';
  }
  if ($status === 'Selesai') { 
    $badgeTheme = 'bg-emerald-50 text-emerald-700 border-emerald-200'; 
    $statusIcon = 'fa-check-double'; 
    $statusBgHeader = 'bg-emerald-50 border-emerald-200';
    $statusColorPulse = 'bg-emerald-500';
  }
  if ($status === 'Ditolak') { 
    $badgeTheme = 'bg-slate-100 text-slate-500 border-slate-200'; 
    $statusIcon = 'fa-xmark'; 
    $statusBgHeader = 'bg-slate-100 border-slate-200';
    $statusColorPulse = 'bg-slate-400';
  }

  $tingkat = $laporan['tingkat_keparahan'] ?? $laporan['tingkat_kedaruratan'] ?? '';
  $tingkatClass = 'text-slate-700';
  if ($tingkat === 'Rendah') { $tingkatClass = 'text-emerald-600'; }
  if ($tingkat === 'Sedang') { $tingkatClass = 'text-amber-600'; }
  if ($tingkat === 'Tinggi') { $tingkatClass = 'text-orange-600'; }
  if ($tingkat === 'Sangat Tinggi' || $tingkat === 'Kritis') { $tingkatClass = 'text-red-600 font-bold'; }
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div class="flex items-center gap-4">
            <a href="index.php?controller=LaporanAdmin&action=index" class="flex items-center justify-center h-10 w-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-brand-600 hover:bg-brand-50 hover:border-brand-200 transition-all shadow-sm">
              <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
              <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight">Detail Kejadian <span class="text-slate-400">#<?php echo htmlspecialchars($laporan['id']); ?></span></h1>
              <p class="text-sm text-slate-500">Tinjau informasi lengkap, lokasi, dan bukti lapangan.</p>
            </div>
          </div>
          <div class="shrink-0 flex gap-3"></div>
        </div>

        
        <div class="rounded-2xl border <?php echo $statusBgHeader; ?> p-4 md:p-6 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-sm relative overflow-hidden">
          <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/40 rounded-full blur-2xl"></div>
          <div class="relative z-10 flex items-center gap-4">
            <div class="relative flex h-4 w-4 shrink-0">
              <?php if($status !== 'Selesai' && $status !== 'Ditolak'): ?>
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full <?php echo $statusColorPulse; ?> opacity-75"></span>
              <?php endif; ?>
              <span class="relative inline-flex rounded-full h-4 w-4 <?php echo $statusColorPulse; ?>"></span>
            </div>
            <div>
              <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-0.5">Status Penanganan Saat Ini</p>
              <h2 class="text-xl font-bold text-slate-800"><?php echo htmlspecialchars($status); ?></h2>
            </div>
          </div>
          
          <div class="relative z-10 flex flex-wrap gap-x-6 gap-y-2 text-sm">
            <div><span class="text-slate-500 font-medium mr-1">Dilaporkan:</span> <strong class="text-slate-700"><?php echo date('d M Y, H:i', strtotime($laporan['waktu_laporan'] ?? $laporan['created_at'] ?? 'now')); ?></strong></div>
            <div><span class="text-slate-500 font-medium mr-1">Oleh:</span> <strong class="text-slate-700"><i class="fa-solid fa-user-circle text-slate-400 mr-1"></i> <?php echo htmlspecialchars($laporan['pelapor']['nama'] ?? $laporan['user']['nama'] ?? '-'); ?></strong></div>
          </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
          
          
          <div class="xl:col-span-2 space-y-6">
            
            
            <div class="rounded-2xl bg-white border border-slate-200 shadow-card overflow-hidden">
              <div class="p-6 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                  <i class="fa-solid fa-file-lines text-slate-400"></i> Informasi Kejadian
                </h3>
              </div>
              <div class="p-6">
                <h2 class="font-display text-2xl font-bold text-slate-900 mb-4"><?php echo htmlspecialchars($laporan['judul_laporan'] ?? $laporan['judul'] ?? $laporan['name'] ?? '-'); ?></h2>
                
                <div class="rounded-xl bg-slate-50 border border-slate-100 p-5 mb-6">
                  <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Kronologi / Deskripsi Laporan</p>
                  <p class="text-slate-700 leading-relaxed whitespace-pre-wrap"><?php echo htmlspecialchars($laporan['deskripsi'] ?? 'Tidak ada deskripsi rinci.'); ?></p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                  <div class="rounded-xl bg-white border border-slate-200 p-4">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tingkat Darurat</p>
                    <p class="font-bold <?php echo $tingkatClass; ?>"><?php echo htmlspecialchars($tingkat ?: '-'); ?></p>
                  </div>
                  <div class="rounded-xl bg-white border border-slate-200 p-4">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Telp Pelapor</p>
                    <p class="font-bold text-slate-700"><?php echo htmlspecialchars($laporan['pelapor']['no_telepon'] ?? $laporan['user']['no_telepon'] ?? '-'); ?></p>
                  </div>
                  <div class="rounded-xl bg-white border border-slate-200 p-4">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Estimasi Korban</p>
                    <p class="font-bold text-slate-700"><?php echo (int)($laporan['jumlah_korban'] ?? 0); ?> Jiwa</p>
                  </div>
                  <div class="rounded-xl bg-white border border-slate-200 p-4">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Dampak Bangunan</p>
                    <p class="font-bold text-slate-700"><?php echo (int)($laporan['jumlah_rumah_rusak'] ?? 0); ?> Unit</p>
                  </div>
                </div>
              </div>
            </div>

            
            <div class="rounded-2xl bg-white border border-slate-200 shadow-card overflow-hidden">
              <div class="p-6 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                  <i class="fa-solid fa-camera text-slate-400"></i> Bukti Dokumentasi Lapangan
                </h3>
              </div>
              <div class="p-6">
                
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Lampiran Foto</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                  
                  <?php for($i=1; $i<=3; $i++): ?>
                    <?php 
                      $fotoKey = 'foto_bukti_' . $i;
                      $fotoUrlKey = 'foto_bukti_' . $i . '_url';
                      $fotoSrc = $laporan[$fotoUrlKey] ?? $laporan[$fotoKey] ?? null;
                    ?>
                    <?php if (!empty($fotoSrc)): ?>
                      <div class="group relative aspect-[4/3] rounded-xl overflow-hidden cursor-pointer shadow-sm border border-slate-200" onclick="openFullscreen('<?php echo htmlspecialchars($fotoSrc); ?>', 'image')">
                        <img src="<?php echo htmlspecialchars($fotoSrc); ?>" alt="Bukti <?php echo $i; ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                          <i class="fa-solid fa-expand text-white text-2xl"></i>
                        </div>
                      </div>
                    <?php else: ?>
                      <div class="aspect-[4/3] rounded-xl bg-slate-50 border border-slate-200 border-dashed flex flex-col items-center justify-center text-slate-400">
                        <i class="fa-regular fa-image mb-2 text-2xl"></i>
                        <span class="text-xs font-medium">Foto <?php echo $i; ?> kosong</span>
                      </div>
                    <?php endif; ?>
                  <?php endfor; ?>
                  
                </div>

                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Lampiran Video</h4>
                <?php 
                  $videoSrc = $laporan['video_bukti_url'] ?? $laporan['video_bukti'] ?? null;
                ?>
                <?php if (!empty($videoSrc)): ?>
                  <div class="rounded-xl overflow-hidden border border-slate-200 shadow-sm bg-black aspect-video max-w-xl">
                    <video width="100%" height="auto" controls class="w-full h-full object-contain">
                      <source src="<?php echo htmlspecialchars($videoSrc); ?>" type="video/mp4">
                      Browser Anda tidak mendukung elemen video.
                    </video>
                  </div>
                <?php else: ?>
                  <div class="h-32 rounded-xl bg-slate-50 border border-slate-200 border-dashed flex flex-col items-center justify-center text-slate-400">
                    <i class="fa-solid fa-video-slash mb-2 text-2xl"></i>
                    <span class="text-xs font-medium">Tidak ada video lampiran.</span>
                  </div>
                <?php endif; ?>

              </div>
            </div>

          </div>

          
          <div class="xl:col-span-1 space-y-6">
            
            <div class="rounded-2xl bg-white border border-slate-200 shadow-card overflow-hidden">
              <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                  <i class="fa-solid fa-map-location-dot text-slate-400"></i> Peta Lokasi
                </h3>
              </div>
              
              
              <div class="w-full h-[400px] relative z-0">
                <div id="map" class="w-full h-full bg-slate-100"></div>
              </div>

              <div class="p-6 bg-slate-50/50">
                <div class="mb-4">
                  <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1.5">Alamat Detail Titik Terdampak</p>
                  <p class="text-sm font-semibold text-slate-700 leading-relaxed"><i class="fa-solid fa-location-dot text-brand-500 mr-1.5"></i> <?php echo htmlspecialchars($laporan['alamat_laporan'] ?? ($laporan['alamat_lengkap'] ?? 'Alamat tidak ditulis rinci.')); ?></p>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-200 text-sm">
                  <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Latitude</p>
                    <p class="font-mono text-slate-700"><?php echo htmlspecialchars($laporan['latitude'] ?? '-'); ?></p>
                  </div>
                  <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Longitude</p>
                    <p class="font-mono text-slate-700"><?php echo htmlspecialchars($laporan['longitude'] ?? '-'); ?></p>
                  </div>
                </div>
              </div>
            </div>

            <div class="rounded-2xl bg-white border border-slate-200 shadow-card overflow-hidden">
              <div class="p-6 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                  <i class="fa-solid fa-clock-rotate-left text-slate-400"></i> Riwayat Status Laporan
                </h3>
              </div>
              <div class="p-6">
                <?php if (!empty($riwayatList) && is_array($riwayatList)): ?>
                  <div class="relative border-l-2 border-slate-100 ml-3 space-y-5">
                    <?php foreach ($riwayatList as $riwayat): ?>
                      <div class="relative pl-6">
                        <div class="absolute w-4 h-4 bg-white border-4 border-brand-300 rounded-full -left-[-11px] top-1 z-10"></div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1"><?php echo date('d M Y H:i', strtotime($riwayat['waktu'] ?? ($riwayat['created_at'] ?? 'now'))); ?></p>
                        <h4 class="text-sm font-bold text-slate-800"><?php echo htmlspecialchars($riwayat['status'] ?? '-'); ?></h4>
                        <?php if (!empty($riwayat['keterangan'] ?? $riwayat['catatan_verifikasi'] ?? '')): ?>
                          <p class="text-xs text-slate-600 mt-1 p-2 bg-slate-50 rounded-lg border border-slate-100"><?php echo htmlspecialchars($riwayat['keterangan'] ?? $riwayat['catatan_verifikasi']); ?></p>
                        <?php endif; ?>
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php else: ?>
                  <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-4 text-sm text-slate-500">Riwayat status belum tersedia.</div>
                <?php endif; ?>
              </div>
            </div>

          </div>

        </div>
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

  function openFullscreen(src, type) {
    if(type === 'image') {
      document.getElementById('modalImage').src = src;
      document.getElementById('modalImage').classList.remove('hidden');
      document.getElementById('mediaModal').classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeFullscreen() {
    document.getElementById('mediaModal').classList.add('hidden');
    document.getElementById('modalImage').classList.add('hidden');
    document.body.style.overflow = 'auto';
  }

  document.addEventListener("DOMContentLoaded", function() {

      var latRaw = "<?php echo $laporan['latitude'] ?? ''; ?>";
      var lngRaw = "<?php echo $laporan['longitude'] ?? ''; ?>";
      var latitude = parseFloat(latRaw);
      var longitude = parseFloat(lngRaw);

      if (!isNaN(latitude) && !isNaN(longitude) && latRaw !== '' && lngRaw !== '') {
          var map = L.map('map').setView([latitude, longitude], 15);

          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
              attribution: '© OpenStreetMap contributors',
              maxZoom: 19
          }).addTo(map);

          var marker = L.marker([latitude, longitude]).addTo(map);
          marker.bindPopup("<div class='font-sans font-bold text-sm mb-1 text-slate-800'>Titik Kejadian Darurat</div><div class='font-mono text-xs text-slate-500'>" + latitude + ", " + longitude + "</div>").openPopup();
          
          setTimeout(function() { map.invalidateSize(); }, 200);
      } else {
          document.getElementById('map').innerHTML = '<div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-100"><i class="fa-solid fa-map-location-dot text-4xl mb-3 opacity-50"></i><p class="font-medium text-sm">Koordinat peta tidak valid</p></div>';
      }
  });

  document.addEventListener('keydown', function(event){
    if(event.key === "Escape"){
      closeFullscreen();
    }
  });
</script>
