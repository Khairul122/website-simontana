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
              <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight">Direktori Kabupaten/Kota</h1>
              <nav class="flex text-xs font-semibold text-slate-400 mt-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                  <li class="inline-flex items-center"><i class="fa-solid fa-map text-slate-400 mr-1.5"></i> Hub Wilayah</li>
                  <li><div class="flex items-center"><i class="fa-solid fa-chevron-right text-[10px] mx-1"></i><span class="text-slate-600">Kabupaten/Kota</span></div></li>
                </ol>
              </nav>
            </div>
          </div>
          <div class="shrink-0 flex gap-3">
             <a href="index.php?controller=Wilayah&action=createKabupaten<?php echo isset($_GET['provinsi_id']) ? '&provinsi_id=' . $_GET['provinsi_id'] : ''; ?>" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-bold text-sm hover:bg-indigo-700 hover:shadow-float transition-all shadow-sm">
              <i class="fa-solid fa-plus"></i> Kabupaten Baru
             </a>
          </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-card overflow-hidden">
          
          
          <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between bg-slate-50/50 relative overflow-hidden gap-4">
             <div class="absolute -right-6 -top-12 text-slate-200 opacity-20 pointer-events-none transform rotate-12">
               <i class="fa-solid fa-map-location-dot text-9xl"></i>
             </div>
             <div class="w-full md:w-2/3 z-10 relative">
               <form method="GET" class="w-full relative bg-white border border-slate-200 rounded-xl shadow-sm flex items-center p-1.5 focus-within:border-indigo-400 focus-within:ring focus-within:ring-indigo-200/50 transition-all">
                  <input type="hidden" name="controller" value="Wilayah">
                  <input type="hidden" name="action" value="indexKabupaten">
                  
                  <div class="flex items-center px-3 text-slate-400 font-bold border-r border-slate-100 shrink-0">
                    <i class="fa-solid fa-filter mr-2"></i> Sortir by
                  </div>
                  <select name="provinsi_id" class="w-full bg-transparent border-none text-sm font-bold text-indigo-800 outline-none pl-3 cursor-pointer appearance-none truncate" onchange="this.form.submit()">
                    <option value="">-- Bebas (Semua Provinsi) --</option>
                    <?php foreach ($provinsiList as $provinsi): ?>
                      <option value="<?php echo $provinsi['id']; ?>" <?php echo ((isset($_GET['provinsi_id']) && $_GET['provinsi_id'] == $provinsi['id']) ? 'selected' : ''); ?>>
                        <?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? ''); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <div class="px-3 text-slate-400 pointer-events-none shrink-0"><i class="fa-solid fa-chevron-down text-xs"></i></div>
               </form>
             </div>
             
             <div class="shrink-0 z-10 hidden md:block">
               <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200 shadow-sm">
                 <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Matched:</span>
                 <span class="text-base font-black text-indigo-600"><?php echo count($kabupatenList ?? []); ?></span>
               </div>
             </div>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-indigo-50/30 border-b border-indigo-100 text-[11px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap">
                  <th class="px-5 py-4 w-16 text-center">Urutan</th>
                  <th class="px-5 py-4 min-w-[200px]">Nama Kabupaten Terdaftar</th>
                  <th class="px-5 py-4 min-w-[150px]">Provinsi Akar</th>
                  <th class="px-5 py-4 text-center w-40">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-sm">
                <?php if (!empty($kabupatenList)): ?>
                  <?php $no = 1; ?>
                  <?php foreach ($kabupatenList as $kabupaten): ?>
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                      <td class="px-5 py-4 text-center font-bold text-slate-400"><?php echo $no++; ?></td>
                      <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                          <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-500 flex items-center justify-center font-bold text-xs shrink-0 border border-indigo-100">
                            <i class="fa-solid fa-map-location-dot"></i>
                          </div>
                          <div>
                            <p class="font-bold text-slate-800 mb-0.5 leading-none"><?php echo htmlspecialchars($kabupaten['nama'] ?? $kabupaten['name'] ?? ''); ?></p>
                            <p class="text-[11px] text-slate-400 font-medium">ADM2: <?php echo htmlspecialchars((string)($kabupaten['adm2'] ?? $kabupaten['id'] ?? '-')); ?></p>
                          </div>
                        </div>
                      </td>
                      <td class="px-5 py-4">
                         <?php
                          $provinsi_nama = '';
                          if (isset($kabupaten['provinsi'])) {
                              $provinsi_nama = $kabupaten['provinsi']['nama'] ?? $kabupaten['provinsi']['name'] ?? '';
                          } elseif (isset($kabupaten['id_provinsi'])) {
                              foreach ($provinsiList as $prov) {
                                  if ($prov['id'] == $kabupaten['id_provinsi']) {
                                      $provinsi_nama = $prov['nama'] ?? $prov['name'] ?? '';
                                      break;
                                  }
                              }
                          }
                        ?>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 border border-slate-200 text-slate-600 text-[10px] font-bold uppercase tracking-widest truncate max-w-[180px]">
                           <i class="fa-solid fa-link text-[8px] text-slate-400"></i> <?php echo htmlspecialchars($provinsi_nama ?: 'Terlepas'); ?>
                        </span>
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
                    <td colspan="4" class="px-5 py-16 text-center">
                      <div class="inline-flex h-16 w-16 rounded-full bg-slate-50 border border-slate-100 text-slate-300 items-center justify-center mb-4 text-3xl shadow-inner"><i class="fa-solid fa-magnifying-glass-location"></i></div>
                      <h3 class="font-display font-bold text-slate-700 text-lg mb-1">Mencari Data...</h3>
                      <p class="text-sm font-medium text-slate-500">Tidak ada kabupaten yang sesuai filter pencarian wilayah.</p>
                      <a href="index.php?controller=Wilayah&action=createKabupaten<?php echo isset($_GET['provinsi_id']) ? '&provinsi_id=' . $_GET['provinsi_id'] : ''; ?>" class="inline-flex mt-4 items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 font-bold text-sm hover:bg-slate-200 transition-colors">
                        <i class="fa-solid fa-plus"></i> Input Baru Disini
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
