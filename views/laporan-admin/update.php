<?php include('template/header.php'); ?>

<?php
$selectedProvinsiId = (int)($selectedProvinsiId ?? ($_GET['provinsi_id'] ?? ($laporan['desa']['kecamatan']['kabupaten']['provinsi']['id'] ?? ($laporan['desa']['id_provinsi'] ?? 0))));
$selectedKabupatenId = (int)($selectedKabupatenId ?? ($_GET['kabupaten_id'] ?? ($laporan['desa']['kecamatan']['kabupaten']['id'] ?? ($laporan['desa']['id_kabupaten'] ?? 0))));
$selectedKecamatanId = (int)($selectedKecamatanId ?? ($_GET['kecamatan_id'] ?? ($laporan['desa']['kecamatan']['id'] ?? ($laporan['id_kecamatan'] ?? 0))));
$selectedDesaId = (int)($selectedDesaId ?? ($_GET['desa_id'] ?? ($laporan['id_desa'] ?? ($laporan['desa']['id'] ?? 0))));

$provinsiList = is_array($provinsiList ?? null) ? $provinsiList : [];
$kabupatenList = is_array($kabupatenList ?? null) ? $kabupatenList : [];
$kecamatanList = is_array($kecamatanList ?? null) ? $kecamatanList : [];
$desaList = is_array($desaList ?? null) ? $desaList : [];
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative p-4 md:p-6 lg:p-8">

      
      <nav class="flex mb-4 text-[11px] font-bold uppercase tracking-widest text-slate-500" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
          <li class="inline-flex items-center"><a href="index.php" class="hover:text-brand-600 transition-colors">Dashboard</a></li>
          <li><div class="flex items-center"><i class="fa-solid fa-chevron-right text-[8px] mx-2 opacity-50"></i><a href="index.php?controller=LaporanAdmin&action=index" class="hover:text-brand-600 transition-colors">Laporan</a></div></li>
          <li><div class="flex items-center text-slate-400"><i class="fa-solid fa-chevron-right text-[8px] mx-2 opacity-50"></i><span>Edit</span></div></li>
        </ol>
      </nav>

      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 md:mb-8">
        <div>
          <h1 class="font-display text-2xl md:text-3xl font-bold text-slate-800">Edit Laporan Bencana</h1>
          <p class="text-slate-500 text-sm mt-1">Lakukan penyuntingan jika informasi awal dirasa tidak akurat atau memerlukan pembaruan.</p>
        </div>
        <div>
          <a href="index.php?controller=LaporanAdmin&action=detail&id=<?php echo $laporan['id']; ?>" class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:border-brand-300 hover:text-brand-600 text-slate-600 px-4 py-2.5 rounded-xl font-bold transition-all shadow-sm"><i class="fa-solid fa-arrow-left"></i> Kembali ke Detail</a>
        </div>
      </div>

      <?php if (isset($error_message)): ?>
        <div class="rounded-xl bg-rose-50 border border-rose-200 p-4 mb-6 flex items-start gap-3">
          <div class="flex-shrink-0 text-rose-500 mt-0.5"><i class="fa-solid fa-circle-exclamation text-lg"></i></div>
          <div class="text-sm text-rose-700 font-medium"><?php echo htmlspecialchars($error_message); ?></div>
        </div>
      <?php endif; ?>

      <form action="index.php?controller=LaporanAdmin&action=update&id=<?php echo $laporan['id']; ?>" method="POST" enctype="multipart/form-data">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-card overflow-hidden mb-6">
          <div class="p-6 md:p-8">
            <h3 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2 border-b border-slate-100 pb-3"><i class="fa-solid fa-layer-group text-slate-400"></i> Informasi Utama & Wilayah</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              
              <div class="space-y-5">
                 <div>
                    <label for="judul_laporan" class="block text-sm font-bold text-slate-700 mb-2">Judul Referensi Laporan</label>
                    <input type="text" class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors" id="judul_laporan" name="judul_laporan" value="<?php echo htmlspecialchars($laporan['judul_laporan'] ?? $laporan['judul'] ?? ''); ?>" required>
                 </div>

                 <div class="grid grid-cols-2 gap-4">
                    <div>
                      <label for="id_provinsi" class="block text-sm font-bold text-slate-700 mb-2">Provinsi Area</label>
                      <select class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors appearance-none cursor-pointer" id="id_provinsi" name="id_provinsi" required onchange="loadKabupatenByProvinsi()">
                        <option value="">-- Provinsi --</option>
                        <?php foreach ($provinsiList as $provinsi): ?>
                          <option value="<?php echo (int)$provinsi['id']; ?>" <?php echo $selectedProvinsiId === (int)$provinsi['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($provinsi['nama'] ?? $provinsi['name'] ?? ''); ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div>
                      <label for="id_kabupaten" class="block text-sm font-bold text-slate-700 mb-2">Dati Daerah</label>
                      <select class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors appearance-none cursor-pointer" id="id_kabupaten" name="id_kabupaten" required onchange="loadKecamatanByKabupaten()">
                        <option value="">-- Kabupaten --</option>
                        <?php foreach ($kabupatenList as $kabupaten): ?>
                          <option value="<?php echo (int)$kabupaten['id']; ?>" <?php echo $selectedKabupatenId === (int)$kabupaten['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($kabupaten['nama'] ?? $kabupaten['name'] ?? ''); ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                 </div>

                 <div class="grid grid-cols-2 gap-4">
                    <div>
                      <label for="id_kecamatan" class="block text-sm font-bold text-slate-700 mb-2">Pilih Kecamatan</label>
                      <select class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors appearance-none cursor-pointer" id="id_kecamatan" name="id_kecamatan" required>
                        <option value="">-- Kecamatan --</option>
                        <?php foreach ($kecamatanList as $kecamatan): ?>
                          <option value="<?php echo (int)$kecamatan['id']; ?>" <?php echo $selectedKecamatanId === (int)$kecamatan['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($kecamatan['nama'] ?? $kecamatan['name'] ?? ''); ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div>
                      <label for="id_desa" class="block text-sm font-bold text-slate-700 mb-2">Pilih Desa/Kel</label>
                      <select class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors appearance-none cursor-pointer" id="id_desa" name="id_desa" required>
                        <option value="">-- Tentukan Desa --</option>
                        <?php foreach ($desaList as $desa): ?>
                          <option value="<?php echo (int)$desa['id']; ?>" <?php echo $selectedDesaId === (int)$desa['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($desa['nama'] ?? $desa['name'] ?? ''); ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                 </div>

                 <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Titik Koordinat Geografis (Opsional)</label>
                    <div class="flex items-center gap-3">
                       <input type="text" class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-mono focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors" id="latitude" name="latitude" value="<?php echo $laporan['latitude'] ?? ''; ?>" placeholder="Lat: -6.200000">
                       <input type="text" class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-mono focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors" id="longitude" name="longitude" value="<?php echo $laporan['longitude'] ?? ''; ?>" placeholder="Lng: 106.816666">
                    </div>
                 </div>

              </div>

              
              <div class="space-y-5">
                 
                 <div>
                    <label for="tingkat_keparahan" class="block text-sm font-bold text-slate-700 mb-2">Level Keparahan Eskalasi</label>
                    <select class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors appearance-none cursor-pointer" id="tingkat_keparahan" name="tingkat_keparahan" required>
                      <option value="">-- Tentukan Tingkat --</option>
                      <option value="Rendah" <?php echo (isset($laporan['tingkat_keparahan']) && $laporan['tingkat_keparahan'] == 'Rendah') ? 'selected' : ''; ?>>Rendah - Skala Kecil</option>
                      <option value="Sedang" <?php echo (isset($laporan['tingkat_keparahan']) && $laporan['tingkat_keparahan'] == 'Sedang') ? 'selected' : ''; ?>>Sedang - Menengah</option>
                      <option value="Tinggi" <?php echo (isset($laporan['tingkat_keparahan']) && $laporan['tingkat_keparahan'] == 'Tinggi') ? 'selected' : ''; ?>>Tinggi - Gawat Darurat</option>
                      <option value="Sangat Tinggi" <?php echo (isset($laporan['tingkat_keparahan']) && $laporan['tingkat_keparahan'] == 'Sangat Tinggi') ? 'selected' : ''; ?>>Sangat Tinggi - Kritis Nasional</option>
                    </select>
                 </div>

                 <div class="grid grid-cols-2 gap-4">
                    <div>
                      <label for="jumlah_korban" class="block text-sm font-bold text-slate-700 mb-2">Korban Terdampak</label>
                      <div class="relative">
                        <input type="number" class="block w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors" id="jumlah_korban" name="jumlah_korban" value="<?php echo $laporan['jumlah_korban'] ?? 0; ?>" min="0">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 text-xs font-bold uppercase">Jiwa</div>
                      </div>
                    </div>
                    <div>
                      <label for="jumlah_rumah_rusak" class="block text-sm font-bold text-slate-700 mb-2">Infrastruktur Rusak</label>
                      <div class="relative">
                        <input type="number" class="block w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors" id="jumlah_rumah_rusak" name="jumlah_rumah_rusak" value="<?php echo $laporan['jumlah_rumah_rusak'] ?? 0; ?>" min="0">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400 text-xs font-bold uppercase">Unit</div>
                      </div>
                    </div>
                 </div>

                 <div>
                    <label for="alamat_lengkap" class="block text-sm font-bold text-slate-700 mb-2">Patokan Jalan Lengkap</label>
                    <textarea class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors text-sm" id="alamat_lengkap" name="alamat_lengkap" rows="2" placeholder="Sebut gang, jalan, RTRW..."><?php echo htmlspecialchars($laporan['alamat_lengkap'] ?? ''); ?></textarea>
                 </div>

                 <div>
                    <label for="deskripsi" class="block text-sm font-bold text-slate-700 mb-2">Teks Kronologi Detail</label>
                    <textarea class="block w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-colors text-sm" id="deskripsi" name="deskripsi" rows="3" required placeholder="Uraikan kejadiannya..."><?php echo htmlspecialchars($laporan['deskripsi'] ?? ''); ?></textarea>
                 </div>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-card overflow-hidden mb-8">
          <div class="p-6 md:p-8">
            <h3 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2 border-b border-slate-100 pb-3"><i class="fa-regular fa-images text-slate-400"></i> Lampiran & File Bukti</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <?php for($i=1; $i<=3; $i++) { 
                 $bti = "foto_bukti_{$i}"; 
                 $btiUrl = "foto_bukti_{$i}_url";
              ?>
              <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Slot Foto Image <?php echo $i; ?></label>
                <div class="rounded-xl border-2 border-dashed border-slate-200 p-2 text-center bg-slate-50 overflow-hidden relative group">
                  <?php if (!empty($laporan[$bti])): ?>
                    <div class="w-full h-32 rounded-lg bg-cover bg-center mb-2" style="background-image: url('<?php echo htmlspecialchars($laporan[$btiUrl] ?? $laporan[$bti]); ?>');"></div>
                  <?php else: ?>
                    <div class="w-full h-32 flex flex-col items-center justify-center text-slate-400 bg-slate-100/50 rounded-lg mb-2">
                       <i class="fa-regular fa-image text-2xl mb-1"></i>
                       <span class="text-[10px] font-bold uppercase">Kosong</span>
                    </div>
                  <?php endif; ?>
                  <input type="file" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-brand-50 file:text-brand-600 hover:file:bg-brand-100 transition-colors cursor-pointer" name="<?php echo $bti; ?>" accept="image/*">
                </div>
              </div>
              <?php } ?>
            </div>

            
            <div class="mt-6 pt-6 border-t border-slate-100">
               <label class="block text-sm font-bold text-slate-700 mb-2">Klip Lampiran Video Pendek</label>
               <div class="flex flex-col md:flex-row gap-6">
                 <?php if (!empty($laporan['video_bukti'])): ?>
                   <div class="w-full md:w-64 rounded-xl overflow-hidden border border-slate-200 shadow-sm shrink-0">
                     <video class="w-full h-auto aspect-video object-cover" controls>
                       <source src="<?php echo htmlspecialchars($laporan['video_bukti_url'] ?? $laporan['video_bukti']); ?>" type="video/mp4">
                     </video>
                   </div>
                 <?php endif; ?>
                 <div class="flex-grow">
                   <div class="p-4 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50">
                     <input type="file" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border border-slate-200 file:text-sm file:font-bold file:bg-white file:text-slate-700 hover:file:bg-slate-50 hover:file:text-brand-600 transition-colors cursor-pointer" name="video_bukti" accept="video/mp4,video/x-m4v,video/*">
                     <p class="text-xs text-slate-400 mt-2 font-medium">Kosongkan kolom bila Anda tidak ingin mengubah/menambah video yang ada.</p>
                   </div>
                 </div>
               </div>
            </div>

          </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-end gap-3 pb-8">
           <a href="index.php?controller=LaporanAdmin&action=detail&id=<?php echo $laporan['id']; ?>" class="px-6 py-3 rounded-xl bg-white border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-colors text-center shadow-sm">Batal Buang Edit</a>
           <button type="submit" class="px-6 py-3 rounded-xl bg-brand-600 text-white font-bold hover:bg-brand-700 transition-colors shadow-sm focus:ring-4 focus:ring-brand-500/20 flex items-center justify-center gap-2"><i class="fa-solid fa-save"></i> Konfirmasi Perubahan Info</button>
        </div>

      </form>

    </main>
  </div>
</div>

<?php include 'template/script.php'; ?>
