<?php include('template/header.php'); ?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative p-4 md:p-6 lg:p-8">

      
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 md:mb-8">
        <div>
          <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-800">Prakiraan Cuaca</h1>
          <p class="text-slate-500 text-sm mt-1">Cek prakiraan cuaca komplit per daerah berdasarkan rilis data BMKG.</p>
        </div>
        <div>
          <a href="index.php?controller=Bmkg&action=index" class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:border-brand-300 hover:text-brand-600 text-slate-600 px-4 py-2.5 rounded-xl font-bold transition-all shadow-sm"><i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard Gempa</a>
        </div>
      </div>

      <?php if (isset($error_message)): ?>
        <div class="rounded-xl bg-rose-50 border border-rose-200 p-4 mb-6 flex items-start gap-3">
          <div class="flex-shrink-0 text-rose-500 mt-0.5"><i class="fa-solid fa-circle-exclamation text-lg"></i></div>
          <div class="text-sm text-rose-700 font-medium"><?php echo htmlspecialchars($error_message); ?></div>
        </div>
      <?php endif; ?>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
         
         
         <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-card p-6 md:p-8 relative overflow-hidden">
               
               <div class="absolute -right-6 -top-6 text-slate-50 opacity-50 text-9xl transform rotate-12"><i class="fa-solid fa-earth-asia"></i></div>
               
               <div class="relative z-10">
                 <div class="text-center mb-8">
                    <div class="w-16 h-16 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center text-3xl mx-auto mb-4 shadow-sm">
                       <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <h3 class="font-display font-bold text-xl text-slate-800">Pilih Wilayah</h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">Pilih hirarki administrasi sesuai standar BPS/Kemendagri untuk melihat prakiraan cuaca.</p>
                 </div>

                 <form method="GET" action="index.php" id="manualForm" class="space-y-5">
                    <input type="hidden" name="controller" value="Bmkg">
                    <input type="hidden" name="action" value="cuaca">
                    
                    <div class="space-y-4">
                       
                       <div class="space-y-1.5">
                          <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                             <i class="fa-solid fa-map text-[9px]"></i> Provinsi
                          </label>
                          <div class="relative">
                             <select class="block w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all outline-none appearance-none cursor-pointer" id="id_provinsi" name="provinsi_id" onchange="loadKabupaten()">
                                <option value="">-- Pilih Provinsi --</option>
                                <?php foreach ($provinsiList as $provinsi): ?>
                                  <option value="<?php echo htmlspecialchars($provinsi['id']); ?>"><?php echo htmlspecialchars($provinsi['nama'] ?? ''); ?></option>
                                <?php endforeach; ?>
                             </select>
                             <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                             </div>
                          </div>
                       </div>

                       
                       <div class="space-y-1.5">
                          <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                             <i class="fa-solid fa-city text-[9px]"></i> Kab / Kota
                          </label>
                          <div class="relative">
                             <select class="block w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm font-bold text-slate-700 disabled:opacity-50 disabled:cursor-not-allowed focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all outline-none appearance-none" id="id_kabupaten" name="kabupaten_id" disabled onchange="loadKecamatan()">
                                <option value="">-- Pilih Kab/Kota --</option>
                             </select>
                             <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                             </div>
                          </div>
                       </div>

                       
                       <div class="space-y-1.5">
                          <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                             <i class="fa-solid fa-building text-[9px]"></i> Kecamatan
                          </label>
                          <div class="relative">
                             <select class="block w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm font-bold text-slate-700 disabled:opacity-50 disabled:cursor-not-allowed focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all outline-none appearance-none" id="id_kecamatan" name="kecamatan_id" disabled onchange="loadDesa()">
                                <option value="">-- Pilih Kecamatan --</option>
                             </select>
                             <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                             </div>
                          </div>
                       </div>

                       
                       <div class="space-y-1.5">
                          <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                             <i class="fa-solid fa-house-user text-[9px]"></i> Kelurahan / Desa
                          </label>
                          <div class="relative">
                             <select class="block w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm font-bold text-slate-700 disabled:opacity-50 disabled:cursor-not-allowed focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all outline-none appearance-none" id="id_desa" name="wilayah_id" disabled>
                                <option value="">-- Pilih Kelurahan/Desa --</option>
                             </select>
                             <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                             </div>
                          </div>
                       </div>

                       <button type="submit" class="w-full py-4 mt-6 rounded-2xl bg-slate-900 text-white font-bold hover:bg-brand-600 transition-all shadow-xl flex items-center justify-center gap-3 group disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-slate-300" id="btnManualCari" disabled>
                          <i class="fa-solid fa-cloud-sun text-lg"></i>
                          <span>TAMPILKAN PRAKIRAAN</span>
                       </button>
                    </div>
                 </form>
                 
                 <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col items-center">
                    <div class="flex items-center gap-4 mb-3 grayscale opacity-40">
                       <img src="https://data.bmkg.go.id/pws/img/logo-bmkg.png" alt="BMKG" class="h-8">
                       <div class="h-6 w-px bg-slate-300"></div>
                       <span class="text-[10px] font-black text-slate-600 uppercase tracking-tight leading-tight">Badan Meteorologi Klimatologi<br>dan Geofisika</span>
                    </div>
                    <p class="text-[9px] text-slate-400 font-medium text-center">Data wilayah merujuk pada standar Kode Pemerintah terbaru.</p>
                 </div>
               </div>
            </div>
         </div>

         
         <div class="lg:col-span-8">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-card flex flex-col min-h-[400px]">
               <?php if (isset($cuacaData) && is_array($cuacaData)): ?>
                 
                  <div class="p-6 md:p-8 border-b border-slate-100 flex flex-col max-sm:gap-4 sm:flex-row sm:items-center justify-between">
                    <div>
                       <h2 class="font-display font-bold text-2xl text-slate-800 flex items-center gap-3"><i class="fa-solid fa-cloud-sun text-brand-500 text-3xl"></i> <?php echo htmlspecialchars($cuacaData['lokasi']['desa'] ?? '-'); ?></h2>
                       <p class="text-sm font-medium text-slate-500 mt-1"><i class="fa-solid fa-map-pin mr-1 text-slate-400"></i> <?php echo htmlspecialchars($cuacaData['lokasi']['kecamatan'] ?? '-'); ?>, <?php echo htmlspecialchars($cuacaData['lokasi']['kotkab'] ?? '-'); ?></p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl px-4 py-2 border border-slate-200">
                       <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Zona Waktu</p>
                       <p class="text-sm font-bold text-slate-700"><?php echo htmlspecialchars($cuacaData['lokasi']['timezone'] ?? 'Asia/Jakarta'); ?></p>
                    </div>
                  </div>
                  
                  <div class="p-6 md:p-8 bg-slate-50/50 flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                       <?php 
                        $allSegments = $cuacaData['data'][0]['cuaca'] ?? [];
                        $weathers = [];
                        foreach ($allSegments as $segment) {
                            if (is_array($segment)) {
                                $weathers = array_merge($weathers, $segment);
                            }
                        }
                        
                        if (!empty($weathers)): foreach ($weathers as $c): 
                       ?>
                       <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:border-brand-300 transition-colors group">
                          <p class="text-[10px] font-bold uppercase tracking-widest text-brand-600 bg-brand-50 px-2 py-1 rounded inline-block mb-3 border border-brand-100"><?php echo date('d M Y - H:i', strtotime($c['local_datetime'] ?? 'now')); ?></p>
                          
                          <div class="flex items-center gap-4 mb-4">
                             <div class="w-16 h-16 flex items-center justify-center bg-slate-50 rounded-2xl p-1 shadow-inner border border-slate-100 overflow-hidden">
                                <img src="<?php echo htmlspecialchars($c['image'] ?? ''); ?>" alt="<?php echo htmlspecialchars($c['weather_desc'] ?? ''); ?>" class="w-full h-full object-contain">
                             </div>
                             
                             <div>
                                <h3 class="font-bold text-slate-800 text-base leading-tight"><?php echo htmlspecialchars($c['weather_desc'] ?? 'Tidak Diketahui'); ?></h3>
                                <p class="text-3xl font-display font-bold text-slate-700 mt-1"><?php echo htmlspecialchars($c['t'] ?? '-'); ?>&deg;C</p>
                             </div>
                          </div>

                          <div class="grid grid-cols-2 gap-2 border-t border-slate-100 pt-3 mt-1">
                             <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-sky-50 flex items-center justify-center text-sky-500 text-[10px]"><i class="fa-solid fa-droplet"></i></div>
                                <div>
                                   <p class="text-[10px] text-slate-400 uppercase font-bold leading-none">Kelembapan</p>
                                   <p class="text-xs font-bold text-slate-700 mt-0.5"><?php echo htmlspecialchars($c['hu'] ?? '-'); ?>%</p>
                                </div>
                             </div>
                             <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-teal-50 flex items-center justify-center text-teal-500 text-[10px]"><i class="fa-solid fa-wind"></i></div>
                                <div>
                                   <p class="text-[10px] text-slate-400 uppercase font-bold leading-none">Arah Angin</p>
                                   <p class="text-xs font-bold text-slate-700 mt-0.5 text-ellipsis overflow-hidden whitespace-nowrap"><?php echo htmlspecialchars($c['wd'] ?? '-'); ?></p>
                                </div>
                             </div>
                          </div>
                          
                          <div class="flex items-center justify-between bg-slate-50 rounded-lg p-2 mt-3 border border-slate-100">
                             <span class="text-[10px] font-bold text-slate-500">Kecp. Angin</span>
                             <span class="text-xs font-bold text-slate-800"><?php echo htmlspecialchars($c['ws'] ?? '-'); ?> km/h</span>
                          </div>
                          
                       </div>
                       <?php endforeach; else: ?>
                          <div class="col-span-full py-12 text-center text-slate-400">
                             <i class="fa-regular fa-folder-open text-4xl mb-3 text-slate-300"></i>
                             <p class="font-bold">Data cuaca jam ini kosong</p>
                          </div>
                       <?php endif; ?>
                    </div>
                  </div>

               <?php else: ?>
                  <div class="flex-1 flex flex-col items-center justify-center text-center p-12 text-slate-400">
                     <div class="relative w-32 h-32 mb-4">
                        <i class="fa-solid fa-cloud-sun text-8xl text-slate-200"></i>
                        <i class="fa-solid fa-location-crosshairs absolute bottom-2 right-2 text-4xl text-brand-400 transform -rotate-12 bg-white rounded-full p-1 shadow-sm"></i>
                     </div>
                     <h3 class="font-display font-bold text-2xl text-slate-600 mb-2">Pilih Wilayah Anda</h3>
                     <p class="text-sm max-w-sm mx-auto">Gunakan hirarki menu di samping atau ketik nama lokasi untuk melihat data prakiraan cuaca resmi BMKG.</p>
                  </div>
               <?php endif; ?>
            </div>
         </div>
      </div>

    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>
<script>
// --- Hierarchical Manual Search Script ---
async function fetchWilayahOptions(url, selectId, nextSelectIds = []) {
    const selectEl = document.getElementById(selectId);
    if (!selectEl) return;

    selectEl.innerHTML = '<option value="">Memuat...</option>';
    selectEl.disabled = true;

    // Reset and disable subsequent dropdowns
    nextSelectIds.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.innerHTML = `<option value="">-- Pilih --</option>`;
            el.disabled = true;
        }
    });

    // Disable submit button during load
    const btnCari = document.getElementById('btnManualCari');
    if (btnCari) btnCari.disabled = true;

    try {
        const response = await fetch(url);
        const data = await response.json();
        
        const label = selectId.split('_')[1];
        const labelDisplay = label.charAt(0).toUpperCase() + label.slice(1);
        selectEl.innerHTML = `<option value="">-- Pilih ${labelDisplay} --</option>`;
        
        if (data.success && data.data && data.data.length > 0) {
            data.data.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.id; 
                opt.textContent = item.nama;
                selectEl.appendChild(opt);
            });
            selectEl.disabled = false;
        } else {
            selectEl.innerHTML = '<option value="">Data tidak tersedia</option>';
        }
    } catch (error) {
        selectEl.innerHTML = '<option value="">Gagal memuat data</option>';
    }
}

function loadKabupaten() {
    const provEl = document.getElementById('id_provinsi');
    if (provEl && provEl.value) {
        fetchWilayahOptions(`index.php?controller=Bmkg&action=getCuacaKabupatenByProvinsi&id=${encodeURIComponent(provEl.value)}`, 'id_kabupaten', ['id_kecamatan', 'id_desa']);
    }
}

function loadKecamatan() {
    const kabEl = document.getElementById('id_kabupaten');
    if (kabEl && kabEl.value) {
        fetchWilayahOptions(`index.php?controller=Bmkg&action=getCuacaKecamatanByKabupaten&id=${encodeURIComponent(kabEl.value)}`, 'id_kecamatan', ['id_desa']);
    }
}

function loadDesa() {
    const kecEl = document.getElementById('id_kecamatan');
    if (kecEl && kecEl.value) {
        fetchWilayahOptions(`index.php?controller=Bmkg&action=getCuacaDesaByKecamatan&id=${encodeURIComponent(kecEl.value)}`, 'id_desa');
    }
}

// Enable/disable submit button based on Desa selection
document.addEventListener('DOMContentLoaded', function() {
    const desaEl = document.getElementById('id_desa');
    const btnCari = document.getElementById('btnManualCari');
    
    if (desaEl && btnCari) {
        desaEl.addEventListener('change', function() {
            btnCari.disabled = !this.value;
            if (this.value) {
                btnCari.classList.remove('bg-slate-300');
                btnCari.classList.add('bg-slate-900');
            } else {
                btnCari.classList.add('bg-slate-300');
                btnCari.classList.remove('bg-slate-900');
            }
        });
    }
});
</script>
