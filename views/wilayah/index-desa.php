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
              <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight">Direktori Desa & Kelurahan</h1>
              <nav class="flex text-xs font-semibold text-slate-400 mt-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                  <li class="inline-flex items-center"><i class="fa-solid fa-map text-slate-400 mr-1.5"></i> Hub Wilayah</li>
                  <li><div class="flex items-center"><i class="fa-solid fa-chevron-right text-[10px] mx-1"></i><span class="text-slate-600">Desa/Kel</span></div></li>
                </ol>
              </nav>
            </div>
          </div>
          <div class="shrink-0 flex gap-3">
             <a href="index.php?controller=Wilayah&action=createDesa<?php echo isset($_GET['kecamatan_id']) ? '&kecamatan_id=' . $_GET['kecamatan_id'] : ''; ?>" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-amber-600 text-white font-bold text-sm hover:bg-amber-700 hover:shadow-float transition-all shadow-sm">
              <i class="fa-solid fa-plus"></i> Kelurahan/Desa Baru
             </a>
          </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-card overflow-hidden">
          
          
          <div class="p-5 border-b border-slate-100 flex flex-col xl:flex-row xl:items-center justify-between bg-slate-50/50 relative overflow-hidden gap-4">
             <div class="absolute -right-6 -top-12 text-slate-200 opacity-20 pointer-events-none transform rotate-12">
               <i class="fa-solid fa-house-flag text-9xl"></i>
             </div>
             
             <div class="w-full xl:w-4/5 z-10 relative flex flex-col md:flex-row gap-3">
               
               <form method="GET" class="flex-1 relative bg-white border border-slate-200 rounded-xl shadow-sm flex items-center p-1.5 focus-within:border-amber-400 focus-within:ring focus-within:ring-amber-200/50 transition-all">
                  <input type="hidden" name="controller" value="Wilayah">
                  <input type="hidden" name="action" value="indexDesa">
                  
                  <div class="flex items-center px-3 text-slate-400 font-bold border-r border-slate-100 shrink-0">
                    <i class="fa-solid fa-filter mr-2"></i> Prov
                  </div>
                  <select name="provinsi_id" class="w-full bg-transparent border-none text-sm font-bold text-slate-700 outline-none pl-3 cursor-pointer appearance-none truncate" onchange="this.form.submit()">
                    <option value="">-- Semua --</option>
                    <?php foreach ($provinsiList as $provinsi): ?>
                      <option value="<?php echo $provinsi['id']; ?>" <?php echo ((isset($_GET['provinsi_id']) && $_GET['provinsi_id'] == $provinsi['id']) ? 'selected' : ''); ?>>
                        <?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? ''); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <div class="px-3 text-slate-400 pointer-events-none shrink-0"><i class="fa-solid fa-chevron-down text-xs"></i></div>
               </form>

               <form method="GET" class="flex-1 relative bg-white border border-slate-200 rounded-xl shadow-sm flex items-center p-1.5 focus-within:border-amber-400 focus-within:ring focus-within:ring-amber-200/50 transition-all">
                  <input type="hidden" name="controller" value="Wilayah">
                  <input type="hidden" name="action" value="indexDesa">
                  <input type="hidden" name="provinsi_id" value="<?php echo htmlspecialchars($_GET['provinsi_id'] ?? ''); ?>">
                  
                  <div class="flex items-center px-3 text-slate-400 font-bold border-r border-slate-100 shrink-0">
                    <i class="fa-solid fa-filter mr-2"></i> Kab
                  </div>
                  <select name="kabupaten_id" class="w-full bg-transparent border-none text-sm font-bold text-slate-700 outline-none pl-3 cursor-pointer appearance-none truncate" onchange="this.form.submit()">
                    <option value="">-- Semua --</option>
                    <?php foreach ($kabupatenList as $kabupaten): ?>
                      <option value="<?php echo $kabupaten['id']; ?>" <?php echo ((isset($_GET['kabupaten_id']) && $_GET['kabupaten_id'] == $kabupaten['id']) ? 'selected' : ''); ?>>
                        <?php echo htmlspecialchars($kabupaten['nama'] ?? $kabupaten['name'] ?? ''); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <div class="px-3 text-slate-400 pointer-events-none shrink-0"><i class="fa-solid fa-chevron-down text-xs"></i></div>
               </form>

               <form method="GET" class="flex-1 relative bg-white border border-slate-200 rounded-xl shadow-sm flex items-center p-1.5 focus-within:border-amber-400 focus-within:ring focus-within:ring-amber-200/50 transition-all">
                  <input type="hidden" name="controller" value="Wilayah">
                  <input type="hidden" name="action" value="indexDesa">
                  <input type="hidden" name="provinsi_id" value="<?php echo htmlspecialchars($_GET['provinsi_id'] ?? ''); ?>">
                  <input type="hidden" name="kabupaten_id" value="<?php echo htmlspecialchars($_GET['kabupaten_id'] ?? ''); ?>">
                  
                  <div class="flex items-center px-3 text-slate-400 font-bold border-r border-slate-100 shrink-0">
                    <i class="fa-solid fa-filter mr-2"></i> Kec
                  </div>
                  <select name="kecamatan_id" class="w-full bg-transparent border-none text-sm font-bold text-amber-800 outline-none pl-3 cursor-pointer appearance-none truncate" onchange="this.form.submit()">
                    <option value="">-- Semua --</option>
                    <?php foreach ($kecamatanList as $kecamatan): ?>
                      <option value="<?php echo $kecamatan['id']; ?>" <?php echo ((isset($_GET['kecamatan_id']) && $_GET['kecamatan_id'] == $kecamatan['id']) ? 'selected' : ''); ?>>
                        <?php echo htmlspecialchars($kecamatan['nama'] ?? $kecamatan['name'] ?? ''); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <div class="px-3 text-slate-400 pointer-events-none shrink-0"><i class="fa-solid fa-chevron-down text-xs"></i></div>
               </form>
             </div>
             
             <div class="shrink-0 z-10 hidden xl:block">
               <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-amber-200 shadow-sm border-l-4 border-l-amber-500">
                 <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Matched:</span>
                 <span class="text-base font-black text-amber-600"><?php echo count($desaList ?? []); ?></span>
               </div>
             </div>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-amber-50/30 border-b border-amber-100 text-[11px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap">
                  <th class="px-5 py-4 w-16 text-center">No</th>
                  <th class="px-5 py-4 min-w-[200px]">Nama Kel / Desa</th>
                  <th class="px-5 py-4 min-w-[300px]">Rantai Wilayah Hierarchy</th>
                  <th class="px-5 py-4 text-center w-36">Kontrol Data</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-sm">
                <?php if (!empty($desaList)): ?>
                  <?php $no = 1; ?>
                  <?php foreach ($desaList as $desa): ?>
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                      <td class="px-5 py-4 text-center font-bold text-slate-400"><?php echo $no++; ?></td>
                      <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                          <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center font-bold text-xs shrink-0 border border-amber-100">
                            <i class="fa-solid fa-house-flag"></i>
                          </div>
                          <div>
                            <p class="font-bold text-slate-800 mb-0.5 leading-none"><?php echo htmlspecialchars($desa['nama'] ?? $desa['name'] ?? ''); ?></p>
                            <p class="text-[11px] text-slate-400 font-medium">Level 4 Leaf Directory</p>
                          </div>
                        </div>
                      </td>
                      <td class="px-5 py-4">
                         <?php
                          $kecamatan_nama = '';
                          $kabupaten_nama = '';
                          $provinsi_nama = '';
                          
                          if (isset($desa['kecamatan'])) {
                              $kecamatan_nama = $desa['kecamatan']['nama'] ?? $desa['kecamatan']['name'] ?? '';
                              if (isset($desa['kecamatan']['kabupaten'])) {
                                $kabupaten_nama = $desa['kecamatan']['kabupaten']['nama'] ?? $desa['kecamatan']['kabupaten']['name'] ?? '';
                                if(isset($desa['kecamatan']['kabupaten']['provinsi'])){
                                  $provinsi_nama = $desa['kecamatan']['kabupaten']['provinsi']['nama'] ?? $desa['kecamatan']['kabupaten']['provinsi']['name'] ?? '';
                                }
                              }
                          } elseif (isset($desa['id_kecamatan'])) {
                             foreach ($kecamatanList as $kec) {
                                  if ($kec['id'] == $desa['id_kecamatan']) {
                                      $kecamatan_nama = $kec['nama'] ?? $kec['name'] ?? '';
                                      if (isset($kec['kabupaten'])) {
                                          $kabupaten_nama = $kec['kabupaten']['nama'] ?? $kec['kabupaten']['name'] ?? '';
                                          $provinsi_nama = $kec['kabupaten']['provinsi']['nama'] ?? $kec['kabupaten']['provinsi']['name'] ?? '';
                                      } else {
                                        
                                      }
                                      break;
                                  }
                              }
                          }
                        ?>
                        <div class="flex flex-row flex-wrap items-center justify-start gap-1">
                          <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-transparent border border-slate-200 text-slate-500 text-[10px] font-bold uppercase tracking-widest truncate w-fit">
                             <i class="fa-solid fa-draw-polygon text-[8px] text-emerald-500"></i> <?php echo htmlspecialchars($kecamatan_nama ?: 'Terlepas'); ?>
                          </span>
                          <span class="inline-flex items-center justify-center text-[10px] text-slate-300"><i class="fa-solid fa-chevron-right"></i></span>
                          <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-transparent text-slate-500 text-[10px] font-bold uppercase tracking-widest truncate w-fit">
                             <i class="fa-solid fa-map-location-dot text-[8px]"></i> <?php echo htmlspecialchars($kabupaten_nama ?: '?'); ?>
                          </span>
                           <span class="inline-flex items-center justify-center text-[10px] text-slate-300"><i class="fa-solid fa-chevron-right"></i></span>
                          <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-transparent text-slate-400 text-[10px] font-bold uppercase tracking-widest truncate w-fit">
                             <i class="fa-solid fa-map text-[8px]"></i> <?php echo htmlspecialchars($provinsi_nama ?: '?'); ?>
                          </span>
                        </div>
                      </td>
                      <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-1.5">
                          <a href="index.php?controller=Wilayah&action=editDesa&id=<?php echo $desa['id']; ?>&kecamatan_id=<?php echo $_GET['kecamatan_id'] ?? ''; ?>" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-700 transition" title="Edit Data">
                            <i class="fa-solid fa-pen text-sm"></i>
                          </a>
                          <form method="POST" action="index.php?controller=Wilayah&action=deleteDesa&id=<?php echo $desa['id']; ?>" class="inline-block m-0 delete-wilayah-form" data-label="desa">
                            <button type="submit" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition" title="Hapus Permanen">
                              <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="4" class="px-5 py-16 text-center">
                      <div class="inline-flex h-16 w-16 rounded-full bg-slate-50 border border-slate-100 text-slate-300 items-center justify-center mb-4 text-3xl shadow-inner"><i class="fa-solid fa-magnifying-glass-location"></i></div>
                      <h3 class="font-display font-bold text-slate-700 text-lg mb-1">Mencari Data...</h3>
                      <p class="text-sm font-medium text-slate-500">Tidak ada list Desa yang sesuai saringan wilayah.</p>
                      <a href="index.php?controller=Wilayah&action=createDesa<?php echo isset($_GET['kecamatan_id']) ? '&kecamatan_id=' . $_GET['kecamatan_id'] : ''; ?>" class="inline-flex mt-4 items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 font-bold text-sm hover:bg-slate-200 transition-colors">
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
  document.addEventListener('submit', function (event) {
    const form = event.target.closest('.delete-wilayah-form');
    if (!form) return;
    event.preventDefault();

    const label = form.getAttribute('data-label') || 'Wilayah';
    
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        title: `Hapus Referensi ${label}?`,
        text: 'Anda akan menghapus node ujung dari rantai wilayah.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#e2e8f0',
        confirmButtonText: 'Tetap Hapus',
        cancelButtonText: 'Batalkan',
        customClass: {
          popup: 'rounded-2xl',
          confirmButton: 'rounded-xl px-5 py-2.5 font-bold shadow-sm',
          cancelButton: 'rounded-xl px-5 py-2.5 font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50'
        }
      }).then(function (result) {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    } else {
      if (window.confirm(`Apakah Anda yakin ingin menghapus referensi ${label} ini?`)) {
        form.submit();
      }
    }
  });

  const urlParams = new URLSearchParams(window.location.search);
  if(urlParams.has('success') && typeof Swal !== 'undefined') {
      Swal.fire({icon: 'success', title: 'Berhasil', text: urlParams.get('success'), toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true});
  }
  if(urlParams.has('error') && typeof Swal !== 'undefined') {
      Swal.fire({icon: 'error', title: 'Error', text: urlParams.get('error'), toast: true, position: 'top-end', showConfirmButton: false, timer: 5000, timerProgressBar: true});
  }
</script>
