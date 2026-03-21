<?php include('template/header.php'); ?>

<?php
$desaList = is_array($desaList ?? null) ? $desaList : [];
?>

<div class="flex h-screen overflow-hidden bg-slate-50">
  <?php include 'template/sidebar.php'; ?>
  
  <div class="flex-1 flex flex-col overflow-hidden">
    <?php include 'template/navbar.php'; ?>
    
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 relative">
      <div class="p-4 md:p-6 lg:p-8 w-full">

        
        <div class="flex items-center gap-4 mb-6">
          <a href="index.php?controller=LaporanAdmin&action=index" class="flex items-center justify-center h-10 w-10 rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-brand-600 hover:bg-brand-50 hover:border-brand-200 transition-all shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
          </a>
          <div>
            <h1 class="font-display text-2xl font-bold text-slate-900 leading-tight">Formulir Laporan Kejadian</h1>
            <p class="text-sm text-slate-500">Catat dan infokan rincian kejadian darurat kebencanaan secara mendetail.</p>
          </div>
        </div>

        <?php if (isset($error_message)): ?>
          <div class="rounded-xl bg-red-50 border border-red-200 p-4 mb-6 flex items-start gap-4">
            <div class="flex-shrink-0 text-red-500 mt-0.5"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
            <div class="flex-1">
              <h3 class="text-sm font-bold text-red-800">Gagal Menyimpan Laporan</h3>
              <p class="text-sm text-red-600 mt-1"><?php echo htmlspecialchars($error_message); ?></p>
            </div>
          </div>
        <?php endif; ?>

        <form action="index.php?controller=LaporanAdmin&action=store" method="POST" enctype="multipart/form-data">
          <div class="flex flex-col xl:flex-row gap-6">
            
            
            <div class="flex-1 space-y-6">
              
              
              <div class="rounded-2xl bg-white border border-slate-200 p-6 md:p-8 shadow-card overflow-hidden relative">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-brand-500"></div>
                
                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 pb-3 flex items-center gap-2">
                  <i class="fa-solid fa-file-lines text-slate-300"></i> IDENTITAS KEJADIAN
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                  <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Judul Laporan Singkat <span class="text-red-500">*</span></label>
                    <input type="text" name="judul_laporan" required placeholder="Contoh: Banjir Bandang di Desa Mekar Jaya" class="w-full rounded-xl border border-slate-300 bg-white py-3 px-4 text-sm outline-none transition-all focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 hover:border-slate-400 shadow-sm">
                  </div>
                  <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tingkat Darurat <span class="text-red-500">*</span></label>
                    <div class="relative">
                      <select name="tingkat_keparahan" required class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-4 pr-10 text-sm font-semibold text-slate-700 outline-none transition-all focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 hover:border-slate-400 shadow-sm appearance-none">
                        <option value="">Pilih Tingkat</option>
                        <option value="Rendah">🔴 Rendah</option>
                        <option value="Sedang">🟠 Sedang</option>
                        <option value="Tinggi">🟡 Tinggi</option>
                        <option value="Sangat Tinggi">🚨 Sangat Tinggi</option>
                      </select>
                      <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    </div>
                  </div>
                </div>

                <div>
                  <label class="block text-sm font-bold text-slate-700 mb-2">Kronologi / Deskripsi Kejadian <span class="text-red-500">*</span></label>
                  <textarea name="deskripsi" rows="5" required placeholder="Ceritakan secara kronologis kapan kejadian dimulai, penyebab, curah hujan, dan detail lainnya..." class="w-full rounded-xl border border-slate-300 bg-white py-3 px-4 text-sm outline-none transition-all focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 hover:border-slate-400 shadow-sm resize-none"></textarea>
                </div>
              </div>

              
              <div class="rounded-2xl bg-white border border-slate-200 p-6 md:p-8 shadow-card overflow-hidden relative">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-amber-500"></div>

                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 pb-3 flex items-center gap-2">
                  <i class="fa-solid fa-location-crosshairs text-slate-300"></i> LOKASI & DETAIL DAMPAK
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                  <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Desa Kejadian <span class="text-red-500">*</span></label>
                    <div class="relative">
                      <select name="id_desa" required class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-10 text-sm font-semibold outline-none transition-all focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 hover:border-slate-400 shadow-sm appearance-none">
                        <option value="">Pilih Administrasi Desa</option>
                        <?php if (!empty($desaList)): ?>
                          <?php foreach ($desaList as $desa): 
                            $desaId = (int)($desa['id'] ?? 0);
                            $desaNama = $desa['nama'] ?? $desa['name'] ?? 'Desa';
                            if ($desaId > 0):
                          ?>
                            <option value="<?php echo $desaId; ?>"><?php echo htmlspecialchars($desaNama); ?></option>
                          <?php endif; endforeach; ?>
                        <?php else: ?>
                          <option value="" disabled>Data desa belum tersedia</option>
                        <?php endif; ?>
                      </select>
                      <i class="fa-solid fa-map-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                      <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    </div>
                  </div>

                  <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Estimasi Korban Jiwa</label>
                    <div class="relative">
                      <i class="fa-solid fa-users absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                      <input type="number" name="jumlah_korban" min="0" value="0" class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm font-bold outline-none transition-all focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 hover:border-slate-400 shadow-sm text-amber-900">
                    </div>
                  </div>

                  <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Rumah Terdampak</label>
                    <div class="relative">
                      <i class="fa-solid fa-house-crack absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                      <input type="number" name="jumlah_rumah_rusak" min="0" value="0" class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm font-bold outline-none transition-all focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 hover:border-slate-400 shadow-sm text-amber-900">
                    </div>
                  </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                  <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Koordinat X (Latitude)</label>
                    <input type="text" name="latitude" placeholder="Contoh: -6.200000" class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 px-4 text-sm font-mono outline-none transition-all focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 hover:border-slate-400 shadow-sm focus:bg-white text-slate-600">
                  </div>
                  <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Koordinat Y (Longitude)</label>
                    <input type="text" name="longitude" placeholder="Contoh: 106.816666" class="w-full rounded-xl border border-slate-300 bg-slate-50 py-3 px-4 text-sm font-mono outline-none transition-all focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 hover:border-slate-400 shadow-sm focus:bg-white text-slate-600">
                  </div>
                </div>

                <div>
                  <label class="block text-sm font-bold text-slate-700 mb-2">Detail Alamat Lingkungan / RT RW</label>
                  <textarea name="alamat_lengkap" rows="3" placeholder="Sebutkan patokan jalan, nama gang, nomor RT / RW dengan jelas agar mudah ditemukan..." class="w-full rounded-xl border border-slate-300 bg-white py-3 px-4 text-sm outline-none transition-all focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 hover:border-slate-400 shadow-sm resize-none"></textarea>
                </div>
              </div>

              
              <div class="rounded-2xl bg-white border border-slate-200 p-6 md:p-8 shadow-card overflow-hidden relative">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-500"></div>

                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 pb-3 flex items-center gap-2">
                  <i class="fa-solid fa-camera text-slate-300"></i> DOKUMENTASI & LAMPIRAN
                </h2>
                
                <p class="text-sm text-slate-500 mb-6 bg-indigo-50 border border-indigo-100 p-3 rounded-xl flex items-center gap-3">
                  <i class="fa-solid fa-info-circle text-indigo-500 text-lg shrink-0"></i>
                  Unggah bukti kuat berupa foto JPG/PNG dan maksimal 1 video pendukung kejadian untuk validasi otomatis tingkat urgensi.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <?php for($i=1; $i<=3; $i++): ?>
                  <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Lampiran Foto <?php echo $i; ?> <?php echo $i===1? '<span class="text-slate-400 font-normal">(Opsional yang diutamakan)</span>':''; ?></label>
                    <div class="relative flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 hover:border-indigo-400 transition-all group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl mb-2 text-slate-400 group-hover:text-indigo-500 transition-colors"></i>
                                <p class="text-xs text-slate-500"><span class="font-bold text-indigo-600">Klik untuk unggah</span> file foto</p>
                            </div>
                            <input type="file" name="foto_bukti_<?php echo $i; ?>" accept="image/*" class="hidden" onchange="previewPath(this)" />
                        </label>
                    </div>
                    <p class="text-[10px] font-semibold text-indigo-600 mt-1.5 hidden file-name-display truncate"></p>
                  </div>
                  <?php endfor; ?>

                  <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Lampiran Video Ekstra</label>
                    <div class="relative flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 hover:border-indigo-400 transition-all group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fa-solid fa-video text-3xl mb-2 text-slate-400 group-hover:text-indigo-500 transition-colors"></i>
                                <p class="text-xs text-slate-500"><span class="font-bold text-indigo-600">Klik untuk unggah</span> file MP4/MOV</p>
                            </div>
                            <input type="file" name="video_bukti" accept="video/*" class="hidden" onchange="previewPath(this)" />
                        </label>
                    </div>
                    <p class="text-[10px] font-semibold text-indigo-600 mt-1.5 hidden file-name-display truncate"></p>
                  </div>
                </div>
              </div>
            </div>

            
            <div class="xl:w-80 shrink-0">
              <div class="sticky top-24 rounded-2xl bg-brand-50 border border-brand-200 p-6 shadow-sidebar">
                
                <div class="flex items-center gap-3 mb-5 border-b border-brand-200/50 pb-4">
                  <div class="w-10 h-10 rounded-full bg-brand-600 text-white flex items-center justify-center font-bold">
                    <i class="fa-regular fa-lightbulb"></i>
                  </div>
                  <div>
                    <h3 class="font-bold text-brand-900">Asisten Pelaporan</h3>
                    <p class="text-xs text-brand-700 font-medium">Ceklist standar BPBD</p>
                  </div>
                </div>

                <ul class="space-y-4 mb-8">
                  <li class="flex items-start gap-3 text-sm text-brand-800">
                    <i class="fa-solid fa-circle-check text-brand-500 mt-0.5"></i>
                    <div>
                      <strong class="block mb-0.5 text-brand-900">Validasi Identitas</strong>
                      <span class="text-xs text-brand-700 leading-tight">Pastikan judul dan tingkat kedaruratan diisi rasional dan logis.</span>
                    </div>
                  </li>
                  <li class="flex items-start gap-3 text-sm text-brand-800">
                    <i class="fa-solid fa-circle-check text-brand-500 mt-0.5"></i>
                    <div>
                      <strong class="block mb-0.5 text-brand-900">Lokasi Presisi</strong>
                      <span class="text-xs text-brand-700 leading-tight">Pemilihan desa yang akurat membantu operator melempar tugas ke Tim Rescue terdekat.</span>
                    </div>
                  </li>
                  <li class="flex items-start gap-3 text-sm text-brand-800">
                    <i class="fa-solid fa-camera text-brand-500 mt-0.5"></i>
                    <div>
                      <strong class="block mb-0.5 text-brand-900">Bukti Mayor</strong>
                      <span class="text-xs text-brand-700 leading-tight">Foto kondisi lapangan menghindari kesalahan asesmen (hoax).</span>
                    </div>
                  </li>
                </ul>

                <button type="submit" class="w-full flex items-center justify-center gap-2 rounded-xl bg-brand-700 border border-transparent px-5 py-3.5 text-sm font-bold text-white hover:bg-brand-800 hover:shadow-float transition-all active:scale-95 mb-3 shadow-md">
                  <i class="fa-solid fa-paper-plane text-brand-200"></i> Simpan Data Laporan
                </button>
                <a href="index.php?controller=LaporanAdmin&action=index" class="w-full flex items-center justify-center gap-2 rounded-xl bg-white border border-brand-200 px-5 py-3 text-sm font-bold text-brand-700 hover:bg-brand-100 transition-all">
                  Batalkan & Kembali
                </a>

              </div>
            </div>

          </div>
        </form>

      </div>
    </main>
  </div>
</div>

<script>
  function previewPath(input) {
    const display = input.parentElement.parentElement.parentElement.querySelector('.file-name-display');
    if (input.files && input.files[0]) {
      display.textContent = 'Terpilih: ' + input.files[0].name;
      display.classList.remove('hidden');
      input.parentElement.classList.add('border-indigo-400', 'bg-indigo-50/50');
    } else {
      display.textContent = '';
      display.classList.add('hidden');
      input.parentElement.classList.remove('border-indigo-400', 'bg-indigo-50/50');
    }
  }
</script>

<?php include 'template/script.php'; ?>
