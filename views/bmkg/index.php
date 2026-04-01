<?php
$metaDescription = 'Pusat informasi BMKG di SIMONTANA: gempa terbaru, daftar gempa dirasakan, peringatan dini cuaca, dan status kesiapsiagaan bencana.';
$metaKeywords = 'bmkg, gempa terbaru, gempa dirasakan, peringatan dini cuaca, simontana';
$schemaBreadcrumbs = [
  ['name' => 'Beranda', 'url' => 'index.php?controller=Dashboard&action=warga'],
  ['name' => 'BMKG', 'url' => 'index.php?controller=Bmkg&action=index'],
];
include('template/header.php');
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative p-4 md:p-6 lg:p-8">

      
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
          <h1 class="text-2xl md:text-3xl font-display font-bold text-slate-800">Pusat Informasi BMKG Terkini</h1>
          <p class="text-slate-500 mt-1">Pantau rilis resmi gempa bumi dan peringatan tsunami dari Badan Meteorologi, Klimatologi, dan Geofisika.</p>
        </div>
        <div class="flex gap-2">
            <a href="index.php?controller=Bmkg&action=index" class="px-4 py-2 rounded-xl bg-brand-600 text-white font-bold shadow-sm hover:bg-brand-700 transition-colors flex items-center gap-2"><i class="fa-solid fa-rotate"></i> Refresh Data BMKG</a>
            <a href="index.php?controller=Bmkg&action=cuaca" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 font-bold shadow-sm hover:text-brand-600 hover:border-brand-200 transition-colors flex items-center gap-2"><i class="fa-solid fa-cloud-sun-rain"></i> Prakiraan Cuaca</a>
            <?php if (isset($currentUser['role']) && in_array($currentUser['role'], ['Admin', 'PetugasBPBD'])): ?>
            <a href="index.php?controller=Bmkg&action=cache" class="px-4 py-2 rounded-xl bg-slate-800 text-white font-bold shadow-sm hover:bg-slate-700 transition-colors flex items-center gap-2"><i class="fa-solid fa-server"></i> Kelola Cache API</a>
            <?php endif; ?>
        </div>
      </div>

      
      <?php if (!empty($peringatanTsunami) && isset($peringatanTsunami['status']) && strtolower($peringatanTsunami['status']) !== 'tidak ada peringatan'): ?>
        <div class="rounded-2xl border border-red-300 bg-red-100 p-6 mb-8 shadow-sm flex gap-4 animate-pulse">
          <div class="w-12 h-12 rounded-xl bg-red-600 text-white flex items-center justify-center shrink-0 text-xl shadow-lg"><i class="fa-solid fa-water"></i></div>
          <div>
            <h2 class="text-lg font-bold text-red-800 mb-1">PERINGATAN DINI TSUNAMI</h2>
            <p class="text-sm font-medium text-red-700"><?php echo htmlspecialchars($peringatanTsunami['keterangan'] ?? 'Terdeteksi potensi tsunami. Harap waspada dan ikuti arahan resmi.'); ?></p>
          </div>
        </div>
      <?php else: ?>
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4 mb-8 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 text-sm"><i class="fa-solid fa-circle-check"></i></div>
            <p class="text-xs font-bold text-emerald-700 uppercase tracking-wide">Status Tsunami: Tidak ada peringatan tsunami aktif saat ini.</p>
        </div>
      <?php endif; ?>

      
      <?php if (!empty($peringatanDiniCuaca['alerts'])): ?>
        <div class="bg-white rounded-3xl border border-amber-200 shadow-card p-6 md:p-8 mb-8 relative overflow-hidden">
           <h2 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2"><i class="fa-solid fa-cloud-bolt text-amber-500"></i> Peringatan Dini Cuaca Nasional (Nowcast)</h2>
           <div class="space-y-4 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
             <?php foreach ($peringatanDiniCuaca['alerts'] as $alert): ?>
             <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
                <div class="flex items-start gap-4">
                   <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center shrink-0 border border-amber-200 text-lg shadow-inner"><i class="fa-solid fa-triangle-exclamation"></i></div>
                   <div class="flex-1">
                     <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                        <h3 class="text-sm md:text-base font-bold text-amber-900"><?php echo htmlspecialchars($alert['title'] ?? ''); ?></h3>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-amber-700 bg-amber-200/50 px-2 py-1 rounded border border-amber-300 self-start sm:self-auto"><?php echo date('d M Y H:i', strtotime($alert['pubDate'] ?? 'now')); ?></span>
                     </div>
                     <p class="text-xs md:text-sm font-medium text-amber-800 leading-relaxed max-w-4xl"><?php echo htmlspecialchars($alert['description'] ?? ''); ?></p>
                     <?php if (!empty($alert['link'])): ?>
                     <div class="mt-3">
                         <a href="<?php echo htmlspecialchars($alert['link']); ?>" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-700 hover:text-amber-900 bg-amber-100 hover:bg-amber-200 transition-colors px-3 py-1.5 rounded-lg border border-amber-200"><i class="fa-solid fa-arrow-up-right-from-square"></i> Rilis BMGK Resmi</a>
                     </div>
                     <?php endif; ?>
                   </div>
                </div>
             </div>
             <?php endforeach; ?>
           </div>
        </div>
      <?php endif; ?>

      
      <?php if (!empty($summary['gempa_terbaru'])): $gt = $summary['gempa_terbaru']; ?>
        <div class="bg-white rounded-3xl border border-slate-200 shadow-card p-6 md:p-8 mb-8 relative overflow-hidden">
           <div class="absolute right-0 top-0 w-64 h-full bg-slate-50/50 skew-x-12 -mr-16 border-l border-slate-100 pointer-events-none"></div>
           
           <h2 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2"><i class="fa-solid fa-bullseye text-rose-500"></i> Event Gempa Terkini (Paling Baru)</h2>
           
           <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 relative z-10">
              <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                 <div class="flex items-center gap-3 mb-6">
                    <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-2xl font-bold shadow-sm border border-rose-200"><?php echo htmlspecialchars($gt['Magnitude'] ?? '-'); ?></div>
                    <div>
                       <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Magnitudo Gempa</p>
                       <p class="text-slate-800 font-bold"><?php echo htmlspecialchars($gt['Tanggal'] ?? '-'); ?> - <?php echo htmlspecialchars($gt['Jam'] ?? '-'); ?></p>
                    </div>
                 </div>

                 <div class="space-y-4">
                    <div class="flex items-start gap-3">
                       <i class="fa-solid fa-location-dot mt-1 text-slate-400 w-5 text-center"></i>
                       <div>
                          <p class="text-xs uppercase font-bold text-slate-500 mb-0.5">Pusat Lokasi</p>
                          <p class="text-sm font-bold text-slate-800"><?php echo htmlspecialchars($gt['Wilayah'] ?? '-'); ?></p>
                          <p class="text-xs text-slate-500 mt-1 font-mono"><?php echo htmlspecialchars($gt['Coordinates'] ?? '-'); ?></p>
                       </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-200">
                       <div>
                          <p class="text-[10px] uppercase font-bold text-slate-500 mb-1">Kedalaman</p>
                          <p class="text-sm font-bold text-slate-800 flex items-center gap-1.5"><i class="fa-solid fa-arrow-down-long text-blue-500"></i> <?php echo htmlspecialchars($gt['Kedalaman'] ?? '-'); ?></p>
                       </div>
                       <div>
                          <p class="text-[10px] uppercase font-bold text-slate-500 mb-1">Potensi Tsunami</p>
                          <p class="text-[11px] font-bold py-1 px-2 rounded <?php echo (strpos(strtolower($gt['Potensi'] ?? ''), 'tidak') !== false) ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-red-50 text-red-600 border border-red-200'; ?> inline-block uppercase tracking-wide">
                             <?php echo htmlspecialchars($gt['Potensi'] ?? '-'); ?>
                          </p>
                       </div>
                    </div>
                 </div>
              </div>

              
              <div class="rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center h-64 lg:h-auto min-h-[250px]">
                 <?php if (!empty($gt['Shakemap'])): 
                    $shakemapUrl = (strpos($gt['Shakemap'], 'http') === 0) 
                       ? $gt['Shakemap'] 
                       : "https://data.bmkg.go.id/DataMKG/TEWS/" . $gt['Shakemap'];
                 ?>
                    <img src="<?php echo $shakemapUrl; ?>" alt="Peta Guncangan BMKG" class="w-full h-full object-cover shadow-sm hover:scale-105 transition-transform duration-500 cursor-zoom-in" onclick="window.open(this.src, '_blank')">
                 <?php else: ?>
                    <div class="text-center text-slate-400">
                       <i class="fa-solid fa-map text-4xl mb-2 opacity-50"></i>
                       <p class="font-bold text-sm">Peta Shakemap Tidak Tersedia</p>
                    </div>
                 <?php endif; ?>
              </div>
           </div>
        </div>
      <?php endif; ?>

      
      <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
        
        
        <div class="bg-white rounded-3xl border border-slate-200 shadow-card flex flex-col overflow-hidden">
           <div class="p-6 border-b border-slate-100 flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center text-lg"><i class="fa-solid fa-triangle-exclamation"></i></div>
              <h2 class="font-bold text-slate-800">Daftar Gempa M &ge; 5.0</h2>
           </div>
           <div class="p-0 overflow-y-auto w-full h-[400px]">
              <table class="w-full text-left text-sm border-collapse">
                 <thead class="sticky top-0 bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase font-bold tracking-widest z-10 shadow-sm">
                    <tr><th class="px-5 py-3">Waktu & Titik Koordinat</th><th class="px-5 py-3">Info Terpusat</th><th class="px-5 py-3 text-center w-20">Mag</th></tr>
                 </thead>
                 <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($gempaTerkini)): foreach($gempaTerkini as $kini): ?>
                    <tr class="hover:bg-slate-50 transition">
                       <td class="px-5 py-4">
                          <p class="font-bold text-slate-700"><?php echo htmlspecialchars($kini['Tanggal'] ?? ''); ?> <span class="text-xs font-normal text-slate-500"><?php echo htmlspecialchars($kini['Jam'] ?? ''); ?></span></p>
                          <p class="text-[11px] font-mono text-slate-500 mt-1"><?php echo htmlspecialchars($kini['Coordinates'] ?? '-'); ?></p>
                       </td>
                       <td class="px-5 py-4">
                          <p class="font-bold text-slate-800 leading-tight mb-1 text-xs"><?php echo htmlspecialchars($kini['Wilayah'] ?? '-'); ?></p>
                          <p class="text-[10px] uppercase font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded border border-amber-100 inline-block">Kedalaman: <?php echo htmlspecialchars($kini['Kedalaman'] ?? '-'); ?></p>
                       </td>
                       <td class="px-5 py-4 text-center">
                          <div class="w-10 h-10 mx-auto rounded-full bg-slate-100 text-slate-700 font-bold border border-slate-200 flex items-center justify-center shadow-inner"><?php echo htmlspecialchars($kini['Magnitude'] ?? '-'); ?></div>
                       </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="3" class="p-8 text-center text-slate-400 font-medium font-sm"><i class="fa-solid fa-bed text-2xl mb-2"></i><br>Tidak ada data gempa > M5.0.</td></tr>
                    <?php endif; ?>
                 </tbody>
              </table>
           </div>
        </div>

        
        <div class="bg-white rounded-3xl border border-slate-200 shadow-card flex flex-col overflow-hidden">
           <div class="p-6 border-b border-slate-100 flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-lg"><i class="fa-solid fa-house-chimney-crack"></i></div>
              <h2 class="font-bold text-slate-800">Daftar Gempa Dirasakan Warga</h2>
           </div>
           <div class="p-0 overflow-y-auto w-full h-[400px]">
              <table class="w-full text-left text-sm border-collapse">
                 <thead class="sticky top-0 bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase font-bold tracking-widest z-10 shadow-sm">
                    <tr><th class="px-5 py-3">Waktu & Magnitudo</th><th class="px-5 py-3">Wilayah</th><th class="px-5 py-3">Skala Dirasakan (MMI)</th></tr>
                 </thead>
                 <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($gempaDirasakan)): foreach($gempaDirasakan as $rasa): ?>
                    <tr class="hover:bg-slate-50 transition">
                       <td class="px-5 py-4 whitespace-nowrap">
                          <p class="font-bold text-slate-700"><?php echo htmlspecialchars($rasa['Tanggal'] ?? ''); ?></p>
                          <p class="text-xs text-slate-500 mb-1"><?php echo htmlspecialchars($rasa['Jam'] ?? ''); ?></p>
                          <span class="text-xs font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded border border-brand-200">M <?php echo htmlspecialchars($rasa['Magnitude'] ?? '-'); ?></span>
                       </td>
                       <td class="px-5 py-4">
                          <p class="font-bold text-slate-800 text-xs leading-relaxed"><?php echo htmlspecialchars($rasa['Wilayah'] ?? '-'); ?></p>
                          <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase">Kdlmn: <?php echo htmlspecialchars($rasa['Kedalaman'] ?? '-'); ?></p>
                       </td>
                       <td class="px-5 py-4">
                          <p class="text-xs font-medium text-slate-600 bg-slate-50 border border-slate-200 p-2 rounded-lg break-words leading-relaxed">
                             <i class="fa-solid fa-users text-indigo-400 mr-1"></i> <?php echo htmlspecialchars($rasa['Dirasakan'] ?? '-'); ?>
                          </p>
                       </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="3" class="p-8 text-center text-slate-400 font-medium font-sm"><i class="fa-solid fa-mug-hot text-2xl mb-2"></i><br>Tidak ada data gempa dirasakan saat ini.</td></tr>
                    <?php endif; ?>
                 </tbody>
              </table>
           </div>
        </div>

      </div>

    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>
