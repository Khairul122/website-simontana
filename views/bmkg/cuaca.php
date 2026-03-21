<?php include('template/header.php'); ?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative p-4 md:p-6 lg:p-8">

      <!-- Header -->
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 md:mb-8">
        <div>
          <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-800">Prakiraan Cuaca Wilayah</h1>
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
         
         <!-- Form Pencarian Wilayah -->
         <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-card p-6 relative overflow-hidden">
               <div class="absolute -right-4 -bottom-4 text-slate-50 opacity-50 text-8xl"><i class="fa-solid fa-magnifying-glass-location"></i></div>
               <h3 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2 border-b border-slate-100 pb-3 relative z-10"><i class="fa-solid fa-map-location-dot text-indigo-500"></i> Cari Lokasi Wilayah</h3>
               
               <form method="GET" action="index.php" class="space-y-4 relative z-10">
                  <input type="hidden" name="controller" value="Bmkg">
                  <input type="hidden" name="action" value="cuaca">
                  
                  <div>
                    <label for="id_provinsi" class="block text-sm font-bold text-slate-700 mb-2">Provinsi</label>
                    <select class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors appearance-none cursor-pointer" id="id_provinsi" name="provinsi_id" required onchange="loadKabupatenByProvinsi()">
                      <option value="">-- Pilih Provinsi --</option>
                      <?php foreach ($provinsiList as $provinsi): ?>
                        <option value="<?php echo (int)$provinsi['id']; ?>"><?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? ''); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div>
                    <label for="id_kabupaten" class="block text-sm font-bold text-slate-700 mb-2">Kabupaten / Kota</label>
                    <select class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors appearance-none cursor-pointer disabled:opacity-50" id="id_kabupaten" name="wilayah_id" required disabled>
                      <option value="">-- Pilih Kab/Kota --</option>
                    </select>
                    <p class="text-xs text-slate-400 mt-1">*Pilih dari daftar Kabupaten/Kota yang tersedia.</p>
                  </div>

                  <div class="pt-4">
                     <button type="submit" class="w-full py-3 rounded-xl bg-brand-600 text-white font-bold shadow-sm hover:bg-brand-700 transition-colors flex justify-center items-center gap-2" id="btnCari" disabled>
                        <i class="fa-solid fa-search"></i> Lihat Cuaca
                     </button>
                  </div>
               </form>
            </div>
         </div>

         <!-- Hasil Prakiraan Cuaca -->
         <div class="lg:col-span-8">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-card flex flex-col min-h-[400px]">
               <?php if (isset($cuacaData) && is_array($cuacaData)): ?>
                 
                 <div class="p-6 md:p-8 border-b border-slate-100 flex flex-col max-sm:gap-4 sm:flex-row sm:items-center justify-between">
                    <div>
                       <h2 class="font-display font-bold text-2xl text-slate-800 flex items-center gap-3"><i class="fa-solid fa-cloud-sun text-brand-500 text-3xl"></i> <?php echo htmlspecialchars($cuacaData['wilayah'] ?? '-'); ?></h2>
                       <p class="text-sm font-medium text-slate-500 mt-1"><i class="fa-solid fa-map-pin mr-1 text-slate-400"></i> Provinsi <?php echo htmlspecialchars($cuacaData['provinsi'] ?? '-'); ?> (Zona <?php echo htmlspecialchars($cuacaData['timezone'] ?? 'WIB'); ?>)</p>
                    </div>
                 </div>
                 
                 <div class="p-6 md:p-8 bg-slate-50/50 flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                       <?php if (!empty($cuacaData['cuaca'])): foreach ($cuacaData['cuaca'] as $c): ?>
                       <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:border-brand-300 transition-colors group">
                          <p class="text-[10px] font-bold uppercase tracking-widest text-brand-600 bg-brand-50 px-2 py-1 rounded inline-block mb-3 border border-brand-100"><?php echo date('d M Y - H:i', strtotime($c['jam'] ?? 'now')); ?></p>
                          
                          <div class="flex items-center gap-4 mb-4">
                             <?php if (!empty($c['icon'])): ?>
                               <img src="<?php echo htmlspecialchars($c['icon']); ?>" alt="Icon Cuaca" class="w-14 h-14 object-contain filter group-hover:scale-110 transition-transform">
                             <?php else: ?>
                               <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-2xl"><i class="fa-solid fa-cloud"></i></div>
                             <?php endif; ?>
                             
                             <div>
                                <h3 class="font-bold text-slate-800 text-base leading-tight"><?php echo htmlspecialchars($c['cuaca'] ?? 'Tidak Diketahui'); ?></h3>
                                <p class="text-3xl font-display font-bold text-slate-700 mt-1"><?php echo htmlspecialchars($c['suhu'] ?? '-'); ?>&deg;C</p>
                             </div>
                          </div>

                          <div class="grid grid-cols-2 gap-2 border-t border-slate-100 pt-3 mt-1">
                             <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-sky-50 flex items-center justify-center text-sky-500 text-[10px]"><i class="fa-solid fa-droplet"></i></div>
                                <div>
                                   <p class="text-[10px] text-slate-400 uppercase font-bold leading-none">Kelembapan</p>
                                   <p class="text-xs font-bold text-slate-700 mt-0.5"><?php echo htmlspecialchars($c['kelembapan'] ?? '-'); ?>%</p>
                                </div>
                             </div>
                             <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-teal-50 flex items-center justify-center text-teal-500 text-[10px]"><i class="fa-solid fa-wind"></i></div>
                                <div>
                                   <p class="text-[10px] text-slate-400 uppercase font-bold leading-none">Arah Angin</p>
                                   <p class="text-xs font-bold text-slate-700 mt-0.5"><?php echo htmlspecialchars($c['angin_arah'] ?? '-'); ?></p>
                                </div>
                             </div>
                          </div>
                          
                          <div class="flex items-center justify-between bg-slate-50 rounded-lg p-2 mt-3 border border-slate-100">
                             <span class="text-[10px] font-bold text-slate-500">Kecp. Angin</span>
                             <span class="text-xs font-bold text-slate-800"><?php echo htmlspecialchars($c['angin_kecepatan'] ?? '-'); ?> km/h</span>
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
                       <i class="fa-solid fa-magnifying-glass absolute bottom-2 right-2 text-4xl text-brand-400 transform -rotate-12 bg-white rounded-full p-1 shadow-sm"></i>
                    </div>
                    <h3 class="font-display font-bold text-2xl text-slate-600 mb-2">Tentukan Lokasi Anda</h3>
                    <p class="text-sm max-w-sm mx-auto">Silakan pilih Provinsi dan Kabupaten lewat formulir di sisi kiri untuk mengambil data prakiraan cuaca dari BMKG secara komprehensif.</p>
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
async function fetchWilayahOptions(url, selectId) {
    const selectEl = document.getElementById(selectId);
    selectEl.innerHTML = '<option value="">Memuat data...</option>';
    selectEl.disabled = true;

    try {
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        
        selectEl.innerHTML = '<option value="">-- Silakan Pilih --</option>';
        if (data.success && data.data && data.data.length > 0) {
            data.data.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.id;
                opt.textContent = item.nama;
                selectEl.appendChild(opt);
            });
            selectEl.disabled = false;
        } else {
            selectEl.innerHTML = '<option value="">Tidak ada data kawasan</option>';
        }
    } catch (error) {
        selectEl.innerHTML = '<option value="">Gagal mengambil data</option>';
    }
}

function loadKabupatenByProvinsi() {
    const provId = document.getElementById('id_provinsi').value;
    const btnCari = document.getElementById('btnCari');
    btnCari.disabled = true;
    if (provId) {
        // Asumsi API route untuk AJAX (menggunakan file route yang sama spt biasa jika ada)
        fetchWilayahOptions(`index.php?controller=Wilayah&action=apiGetByProvinsi&provinsi_id=${provId}`, 'id_kabupaten');
    } else {
        const kabSelect = document.getElementById('id_kabupaten');
        kabSelect.innerHTML = '<option value="">-- Pilih Kab/Kota --</option>';
        kabSelect.disabled = true;
    }
}

document.getElementById('id_kabupaten').addEventListener('change', function() {
    document.getElementById('btnCari').disabled = !this.value;
});
</script>
