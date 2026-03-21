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
              <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight">Direktori Kecamatan</h1>
              <nav class="flex text-xs font-semibold text-slate-400 mt-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                  <li class="inline-flex items-center"><i class="fa-solid fa-map text-slate-400 mr-1.5"></i> Hub Wilayah</li>
                  <li><div class="flex items-center"><i class="fa-solid fa-chevron-right text-[10px] mx-1"></i><span class="text-slate-600">Kecamatan</span></div></li>
                </ol>
              </nav>
            </div>
          </div>
          <div class="shrink-0 flex gap-3">
             <a href="index.php?controller=Wilayah&action=createKecamatan<?php echo isset($_GET['kabupaten_id']) ? '&kabupaten_id=' . $_GET['kabupaten_id'] : ''; ?>" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-sm hover:bg-emerald-700 hover:shadow-float transition-all shadow-sm">
              <i class="fa-solid fa-plus"></i> Kecamatan Baru
             </a>
          </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-card overflow-hidden">
          
          
          <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between bg-slate-50/50 relative overflow-hidden gap-4">
             <div class="absolute -right-6 -top-12 text-slate-200 opacity-20 pointer-events-none transform rotate-12">
               <i class="fa-solid fa-draw-polygon text-9xl"></i>
             </div>
             
             <div class="w-full md:w-3/4 z-10 relative flex flex-col md:flex-row gap-3">
               
               <form method="GET" class="flex-1 relative bg-white border border-slate-200 rounded-xl shadow-sm flex items-center p-1.5 focus-within:border-emerald-400 focus-within:ring focus-within:ring-emerald-200/50 transition-all">
                  <input type="hidden" name="controller" value="Wilayah">
                  <input type="hidden" name="action" value="indexKecamatan">
                  
                  <div class="flex items-center px-3 text-slate-400 font-bold border-r border-slate-100 shrink-0">
                    <i class="fa-solid fa-filter mr-2"></i> Provinsi
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

               
               <form method="GET" class="flex-1 relative bg-white border border-slate-200 rounded-xl shadow-sm flex items-center p-1.5 focus-within:border-emerald-400 focus-within:ring focus-within:ring-emerald-200/50 transition-all">
                  <input type="hidden" name="controller" value="Wilayah">
                  <input type="hidden" name="action" value="indexKecamatan">
                  <input type="hidden" name="provinsi_id" value="<?php echo htmlspecialchars($_GET['provinsi_id'] ?? ''); ?>">
                  
                  <div class="flex items-center px-3 text-slate-400 font-bold border-r border-slate-100 shrink-0">
                    <i class="fa-solid fa-filter mr-2"></i> Kabupaten
                  </div>
                  <select name="kabupaten_id" class="w-full bg-transparent border-none text-sm font-bold text-emerald-800 outline-none pl-3 cursor-pointer appearance-none truncate" onchange="this.form.submit()">
                    <option value="">-- Semua --</option>
                    <?php foreach ($kabupatenList as $kabupaten): ?>
                      <option value="<?php echo $kabupaten['id']; ?>" <?php echo ((isset($_GET['kabupaten_id']) && $_GET['kabupaten_id'] == $kabupaten['id']) ? 'selected' : ''); ?>>
                        <?php echo htmlspecialchars($kabupaten['nama'] ?? $kabupaten['name'] ?? ''); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <div class="px-3 text-slate-400 pointer-events-none shrink-0"><i class="fa-solid fa-chevron-down text-xs"></i></div>
               </form>
             </div>
             
             <div class="shrink-0 z-10 hidden md:block">
               <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-emerald-200 shadow-sm border-l-4 border-l-emerald-500">
                 <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Matched:</span>
                 <span class="text-base font-black text-emerald-600"><?php echo count($kecamatanList ?? []); ?></span>
               </div>
             </div>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-emerald-50/30 border-b border-emerald-100 text-[11px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap">
                  <th class="px-5 py-4 w-16 text-center">Urutan</th>
                  <th class="px-5 py-4 min-w-[200px]">Nama Kecamatan</th>
                  <th class="px-5 py-4 min-w-[150px]">Rantai Wilayah Hierarchy</th>
                  <th class="px-5 py-4 text-center w-36">Kontrol Data</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 text-sm">
                <?php if (!empty($kecamatanList)): ?>
                  <?php $no = 1; ?>
                  <?php foreach ($kecamatanList as $kecamatan): ?>
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                      <td class="px-5 py-4 text-center font-bold text-slate-400"><?php echo $no++; ?></td>
                      <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                          <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-500 flex items-center justify-center font-bold text-xs shrink-0 border border-emerald-100">
                            <i class="fa-solid fa-draw-polygon"></i>
                          </div>
                          <div>
                            <p class="font-bold text-slate-800 mb-0.5 leading-none"><?php echo htmlspecialchars($kecamatan['nama'] ?? $kecamatan['name'] ?? ''); ?></p>
                            <p class="text-[11px] text-slate-400 font-medium">Level 3 Directory</p>
                          </div>
                        </div>
                      </td>
                      <td class="px-5 py-4">
                         <?php
                          $kabupaten_nama = '';
                          $provinsi_nama = '';

                          if (isset($kecamatan['kabupaten'])) {
                              $kabupaten_nama = $kecamatan['kabupaten']['nama'] ?? $kecamatan['kabupaten']['name'] ?? '';
                              $provinsi_nama = $kecamatan['kabupaten']['provinsi']['nama'] ?? $kecamatan['kabupaten']['provinsi']['name'] ?? '';
                          } elseif (isset($kecamatan['id_kabupaten'])) {
                              foreach ($kabupatenList as $kab) {
                                  if ($kab['id'] == $kecamatan['id_kabupaten']) {
                                      $kabupaten_nama = $kab['nama'] ?? $kab['name'] ?? '';
                                      if(isset($kab['provinsi'])) {
                                        $provinsi_nama = $kab['provinsi']['nama'] ?? $kab['provinsi']['name'] ?? '';
                                      } else {
                                        foreach ($provinsiList as $prov) {
                                          if ($prov['id'] == $kab['id_provinsi']) {
                                              $provinsi_nama = $prov['nama'] ?? $prov['name'] ?? '';
                                              break;
                                          }
                                        }
                                      }
                                      break;
                                  }
                              }
                          }
                        ?>
                        <div class="flex flex-col gap-1.5">
                          <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 border border-slate-200 text-slate-600 text-[10px] font-bold uppercase tracking-widest truncate w-fit max-w-[200px]">
                             <i class="fa-solid fa-map-location-dot text-[8px] text-indigo-400"></i> <?php echo htmlspecialchars($kabupaten_nama ?: 'Terlepas'); ?>
                          </span>
                          <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-transparent text-slate-400 text-[10px] font-bold uppercase tracking-widest truncate w-fit max-w-[200px]">
                             <i class="fa-solid fa-link text-[8px]"></i> <?php echo htmlspecialchars($provinsi_nama ?: 'Terlepas'); ?>
                          </span>
                        </div>
                      </td>
                      <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-1.5">
                          <a href="index.php?controller=Wilayah&action=editKecamatan&id=<?php echo $kecamatan['id']; ?>&kabupaten_id=<?php echo $_GET['kabupaten_id'] ?? ''; ?>" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-700 transition" title="Edit Data">
                            <i class="fa-solid fa-pen text-sm"></i>
                          </a>
                          <form method="POST" action="index.php?controller=Wilayah&action=deleteKecamatan&id=<?php echo $kecamatan['id']; ?>" class="inline-block m-0 delete-wilayah-form" data-label="kecamatan">
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
                      <p class="text-sm font-medium text-slate-500">Tidak ada kecamatan yang sesuai saringan wilayah.</p>
                      <a href="index.php?controller=Wilayah&action=createKecamatan<?php echo isset($_GET['kabupaten_id']) ? '&kabupaten_id=' . $_GET['kabupaten_id'] : ''; ?>" class="inline-flex mt-4 items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 font-bold text-sm hover:bg-slate-200 transition-colors">
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
        text: 'Ini akan berakibat fatal ke sub-wilayah (desa) jika dihapus.',
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
      if (window.confirm(`Apakah Anda yakin ingin menghapus referensi ${label} ini?\n\nPERINGATAN: Memungkinkan terjadinya data corrupt pada level bawahnya!`)) {
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
