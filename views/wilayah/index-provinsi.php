<?php include('template/header.php'); ?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div class="flex items-center gap-4">
            <a href="index.php?controller=Wilayah&action=index" class="flex items-center justify-center h-10 w-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-brand-600 hover:bg-brand-50 hover:border-brand-200 transition-all shadow-sm">
              <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
              <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight">Direktori Provinsi</h1>
              <nav class="flex text-xs font-semibold text-slate-400 mt-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                  <li class="inline-flex items-center"><i class="fa-solid fa-map text-slate-400 mr-1.5"></i> Hub Wilayah</li>
                  <li><div class="flex items-center"><i class="fa-solid fa-chevron-right text-[10px] mx-1"></i><span class="text-slate-600">Provinsi</span></div></li>
                </ol>
              </nav>
            </div>
          </div>
          <div class="shrink-0 flex gap-3">
            <a href="index.php?controller=Wilayah&action=createProvinsi" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-600 text-white font-bold text-sm hover:bg-brand-700 hover:shadow-float transition-all shadow-sm">
              <i class="fa-solid fa-plus"></i> Provinsi Baru
            </a>
          </div>
        </div>

        
        <div class="rounded-2xl border border-slate-200 bg-white shadow-card overflow-hidden">
          <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between bg-white relative overflow-hidden gap-4">
             <div class="absolute -right-10 -top-10 text-slate-50 opacity-10 pointer-events-none transform -rotate-12">
               <i class="fa-solid fa-map text-9xl"></i>
             </div>
             <div>
                <h2 class="font-bold text-slate-800 text-base mb-1">Daftar Wilayah Tingkat Provinsi</h2>
                <p class="text-sm font-medium text-slate-500">Akar utama dari seluruh cabang wilayah kabupaten, kecamatan, dan desa / posko.</p>
             </div>
             <div class="shrink-0">
               <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 border border-slate-200">
                 <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Entri:</span>
                 <span class="text-base font-black text-brand-600"><?php echo count($provinsiList ?? []); ?></span>
               </div>
             </div>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap">
                  <th class="px-5 py-4 w-16 text-center">Urutan</th>
                  <th class="px-5 py-4 min-w-[200px]">Nama Provinsi Terdaftar</th>
                  <th class="px-5 py-4 text-center w-40">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-sm">
                <?php if (!empty($provinsiList)): ?>
                  <?php $no = 1; ?>
                  <?php foreach ($provinsiList as $provinsi): ?>
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                      <td class="px-5 py-4 text-center font-bold text-slate-400"><?php echo $no++; ?></td>
                      <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                          <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-xs shrink-0">
                            <i class="fa-solid fa-map"></i>
                          </div>
                          <div>
                            <p class="font-bold text-slate-800 mb-0.5 leading-none"><?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? ''); ?></p>
                            <p class="text-[11px] text-slate-400 font-medium">ADM1: <?php echo htmlspecialchars((string)($provinsi['adm1'] ?? $provinsi['id'] ?? '-')); ?></p>
                          </div>
                        </div>
                      </td>
                      <td class="px-5 py-4 text-center">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold border border-slate-200">
                          <i class="fa-solid fa-lock"></i> Read Only
                        </span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="3" class="px-5 py-16 text-center">
                      <div class="inline-flex h-16 w-16 rounded-full bg-slate-50 border border-slate-100 text-slate-300 items-center justify-center mb-4 text-3xl shadow-inner"><i class="fa-solid fa-map-location-dot"></i></div>
                      <h3 class="font-display font-bold text-slate-700 text-lg mb-1">Database Kosong</h3>
                      <p class="text-sm font-medium text-slate-500">Silakan input data wilayah provinsi terlebih dahulu.</p>
                      <a href="index.php?controller=Wilayah&action=createProvinsi" class="inline-flex mt-4 items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 font-bold text-sm hover:bg-slate-200 transition-colors">
                        <i class="fa-solid fa-plus"></i> Input Baru
                      </a>
                    </td>
                  </tr>
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

<script>
  const urlParams = new URLSearchParams(window.location.search);
  if(urlParams.has('success') && typeof Swal !== 'undefined') {
      Swal.fire({icon: 'success', title: 'Berhasil', text: urlParams.get('success'), toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true});
  }
  if(urlParams.has('error') && typeof Swal !== 'undefined') {
      Swal.fire({icon: 'error', title: 'Error', text: urlParams.get('error'), toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true});
  }
</script>
