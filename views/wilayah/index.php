<?php include('template/header.php'); ?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div>
            <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-900 leading-tight">Manajemen Geospasial & Wilayah</h1>
            <p class="text-sm text-slate-500 mt-1">Strukturisasi hierarki region untuk pemetaan dan batasan area akun.</p>
          </div>
        </div>

        <!-- Navigation Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
          
          <!-- Provinsi -->
          <div class="group rounded-3xl bg-white border border-slate-200 shadow-sm hover:shadow-card hover:border-brand-200 transition-all duration-300 flex flex-col overflow-hidden relative">
            <div class="absolute top-0 right-0 p-4 opacity-5 pointer-events-none transition-transform group-hover:scale-110 duration-500">
              <i class="fa-solid fa-map text-8xl"></i>
            </div>
            <div class="p-6 flex-1 flex flex-col relative z-10">
              <div class="w-14 h-14 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center text-2xl mb-5 group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300 shadow-sm border border-brand-100 group-hover:border-brand-600">
                <i class="fa-solid fa-map"></i>
              </div>
              <h3 class="font-display text-xl font-bold text-slate-800 mb-2">Level Provinsi</h3>
              <p class="text-sm text-slate-500 leading-relaxed mb-6">Kelola daftar provinsi sebagai akar pohon wilayah hierarkis pelaporan.</p>
              
              <div class="mt-auto flex flex-col gap-2">
                <a href="index.php?controller=Wilayah&action=indexProvinsi" class="flex items-center justify-center w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-bold text-slate-700 hover:bg-slate-100 transition-colors">
                  Lihat Semua
                </a>
                <a href="index.php?controller=Wilayah&action=createProvinsi" class="flex items-center justify-center w-full px-4 py-2.5 rounded-xl bg-brand-600 text-sm font-bold text-white hover:bg-brand-700 hover:shadow-float transition-all shadow-sm">
                  <i class="fa-solid fa-plus mr-1"></i> Input Provinsi
                </a>
              </div>
            </div>
          </div>

          <!-- Kabupaten -->
          <div class="group rounded-3xl bg-white border border-slate-200 shadow-sm hover:shadow-card hover:border-indigo-200 transition-all duration-300 flex flex-col overflow-hidden relative">
            <div class="absolute top-0 right-0 p-4 opacity-5 pointer-events-none transition-transform group-hover:scale-110 duration-500">
              <i class="fa-solid fa-map-location-dot text-8xl"></i>
            </div>
            <div class="p-6 flex-1 flex flex-col relative z-10">
              <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl mb-5 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300 shadow-sm border border-indigo-100 group-hover:border-indigo-600">
                <i class="fa-solid fa-map-location-dot"></i>
              </div>
              <h3 class="font-display text-xl font-bold text-slate-800 mb-2">Kabupaten / Kota</h3>
              <p class="text-sm text-slate-500 leading-relaxed mb-6">Pemetaan administratif level 2 untuk pembatasan pelaporan sektoral regional.</p>
              
              <div class="mt-auto flex flex-col gap-2">
                <a href="index.php?controller=Wilayah&action=indexKabupaten" class="flex items-center justify-center w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-bold text-slate-700 hover:bg-slate-100 transition-colors">
                  Lihat Semua
                </a>
                <a href="index.php?controller=Wilayah&action=createKabupaten" class="flex items-center justify-center w-full px-4 py-2.5 rounded-xl bg-indigo-600 text-sm font-bold text-white hover:bg-indigo-700 hover:shadow-float transition-all shadow-sm">
                  <i class="fa-solid fa-plus mr-1"></i> Input Kabupaten
                </a>
              </div>
            </div>
          </div>

          <!-- Kecamatan -->
          <div class="group rounded-3xl bg-white border border-slate-200 shadow-sm hover:shadow-card hover:border-emerald-200 transition-all duration-300 flex flex-col overflow-hidden relative">
            <div class="absolute top-0 right-0 p-4 opacity-5 pointer-events-none transition-transform group-hover:scale-110 duration-500">
              <i class="fa-solid fa-draw-polygon text-8xl"></i>
            </div>
            <div class="p-6 flex-1 flex flex-col relative z-10">
              <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-5 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300 shadow-sm border border-emerald-100 group-hover:border-emerald-600">
                <i class="fa-solid fa-draw-polygon"></i>
              </div>
              <h3 class="font-display text-xl font-bold text-slate-800 mb-2">Kecamatan</h3>
              <p class="text-sm text-slate-500 leading-relaxed mb-6">Pengelolaan rayon distilasi tingkat kecamatan dari sebuah kabupaten terdaftar.</p>
              
              <div class="mt-auto flex flex-col gap-2">
                <a href="index.php?controller=Wilayah&action=indexKecamatan" class="flex items-center justify-center w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-bold text-slate-700 hover:bg-slate-100 transition-colors">
                  Lihat Semua
                </a>
                <a href="index.php?controller=Wilayah&action=createKecamatan" class="flex items-center justify-center w-full px-4 py-2.5 rounded-xl bg-emerald-600 text-sm font-bold text-white hover:bg-emerald-700 hover:shadow-float transition-all shadow-sm">
                  <i class="fa-solid fa-plus mr-1"></i> Input Kecamatan
                </a>
              </div>
            </div>
          </div>

          <!-- Desa -->
          <div class="group rounded-3xl bg-white border border-slate-200 shadow-sm hover:shadow-card hover:border-amber-200 transition-all duration-300 flex flex-col overflow-hidden relative">
            <div class="absolute top-0 right-0 p-4 opacity-5 pointer-events-none transition-transform group-hover:scale-110 duration-500">
              <i class="fa-solid fa-house-flag text-8xl"></i>
            </div>
            <div class="p-6 flex-1 flex flex-col relative z-10">
              <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl mb-5 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300 shadow-sm border border-amber-100 group-hover:border-amber-600">
                <i class="fa-solid fa-house-flag"></i>
              </div>
              <h3 class="font-display text-xl font-bold text-slate-800 mb-2">Kelurahan / Desa</h3>
              <p class="text-sm text-slate-500 leading-relaxed mb-6">Level titik pangkal yang menentukan domisili laporan dan cakupan posko warga.</p>
              
              <div class="mt-auto flex flex-col gap-2">
                <a href="index.php?controller=Wilayah&action=indexDesa" class="flex items-center justify-center w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-bold text-slate-700 hover:bg-slate-100 transition-colors">
                  Lihat Semua
                </a>
                <a href="index.php?controller=Wilayah&action=createDesa" class="flex items-center justify-center w-full px-4 py-2.5 rounded-xl bg-amber-600 text-sm font-bold text-white hover:bg-amber-700 hover:shadow-float transition-all shadow-sm">
                  <i class="fa-solid fa-plus mr-1"></i> Input Desa Sektoral
                </a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>
