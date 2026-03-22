<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
  <title><?= $title ?? 'Registrasi Akun - SIMONTA Bencana' ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="shortcut icon" href="assets/images/favicon.png" />
  
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
            display: ['Outfit', 'sans-serif']
          },
          colors: {
            brand: {
              50: '#fff7ed', 100: '#ffedd5', 200: '#fed7aa', 300: '#fdba74',
              400: '#fb923c', 500: '#f97316', 600: '#ea580c', 700: '#c2410c',
              800: '#9a3412', 900: '#7c2d12', 950: '#431407',
            }
          },
          animation: {
            'blob': 'blob 10s infinite',
            'slide-up': 'slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
            'fade-in': 'fadeIn 1s ease-out forwards',
            'toast-in': 'toastIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards'
          },
          keyframes: {
            blob: {
              '0%': { transform: 'translate(0px, 0px) scale(1)' },
              '33%': { transform: 'translate(40px, -60px) scale(1.1)' },
              '66%': { transform: 'translate(-30px, 30px) scale(0.9)' },
              '100%': { transform: 'translate(0px, 0px) scale(1)' }
            },
            slideUp: {
              '0%': { opacity: '0', transform: 'translateY(30px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' }
            },
            fadeIn: {
              '0%': { opacity: '0' },
              '100%': { opacity: '1' }
            },
            toastIn: {
              '0%': { opacity: '0', transform: 'translateX(100px)' },
              '100%': { opacity: '1', transform: 'translateX(0)' }
            }
          }
        }
      }
    }
  </script>
  <style>
    .glass-effect {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.5);
    }
    .dark-glass {
      background: rgba(15, 23, 42, 0.5);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    /* Scrollbar minimal untuk form kiri yang panjang */
    .custom-scrollbar::-webkit-scrollbar {
      width: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
      background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
      background-color: rgba(203, 213, 225, 0.5);
      border-radius: 10px;
    }
  </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased h-screen overflow-hidden selection:bg-brand-500 selection:text-white">
  <?php $desaList = is_array($desaList ?? null) ? $desaList : []; ?>

  <div class="flex h-full w-full">
    
    <!-- Kolom Kiri: Form Registrasi -->
    <div class="relative flex w-full flex-col lg:w-7/12 xl:w-1/2 h-full overflow-y-auto custom-scrollbar bg-slate-50/50">
      
      <!-- Dekorasi Background -->
      <div class="absolute inset-0 overflow-hidden pointer-events-none z-0 fixed">
        <div class="absolute -left-20 top-0 h-[500px] w-[500px] rounded-full bg-brand-200/30 mix-blend-multiply blur-[80px] animate-blob"></div>
        <div class="absolute right-0 top-[20%] h-96 w-96 rounded-full bg-blue-200/30 mix-blend-multiply blur-[80px] animate-blob" style="animation-delay: 2s;"></div>
      </div>

      <!-- Container Konten -->
      <div class="relative z-10 flex flex-col justify-start px-4 py-8 sm:px-10 md:px-16 lg:px-12 xl:px-20 min-h-full">
        
        <div class="w-full max-w-2xl mx-auto animate-slide-up">
          
          <!-- Tombol Kembali untuk Mobile -->
          <div class="mb-6 lg:hidden">
            <a href="index.php?controller=Auth&action=login" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-brand-600 transition-colors">
              <i class="fa-solid fa-arrow-left"></i> Kembali ke Login
            </a>
          </div>

          <!-- Header Registrasi -->
          <div class="mb-8 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-5">
            <div class="inline-flex items-center justify-center p-4 rounded-3xl bg-gradient-to-br from-brand-500 to-brand-700 shadow-xl shadow-brand-500/30 text-white transform hover:scale-105 transition-transform flex-shrink-0">
              <i class="fa-solid fa-users-viewfinder text-3xl"></i>
            </div>
            <div>
              <h1 class="font-display text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 mb-2">Daftar Akun Baru</h1>
              <p class="text-sm sm:text-base text-slate-500">Bergabunglah dengan SIMONTA untuk berperan aktif dalam respon dan koordinasi bencana secara terpadu.</p>
            </div>
          </div>

          <?php if (isset($error_message)): ?>
            <div class="mb-6 rounded-2xl border-l-4 border-rose-500 bg-rose-50 p-4 shadow-sm animate-fade-in flex items-start gap-3">
              <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg mt-0.5"></i>
              <div class="text-sm text-rose-800 font-medium"><?php echo htmlspecialchars($error_message); ?></div>
            </div>
          <?php endif; ?>

          <!-- Card Form Utama -->
          <div class="glass-effect rounded-[2rem] p-6 sm:p-10 shadow-xl shadow-slate-200/40 border-slate-200/50">
            <form method="POST" action="index.php?controller=Auth&action=processRegister" class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
              
              <!-- Bagian 1: Data Dasar -->
              <div class="sm:col-span-2 border-b border-slate-200/80 pb-3 mb-1 mt-0">
                <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800"><i class="fa-regular fa-id-card text-brand-500"></i> Informasi Pribadi</h3>
              </div>

              <div class="sm:col-span-2">
                <label for="nama" class="mb-2 block text-sm font-bold text-slate-700">Nama Lengkap</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-pen"></i>
                  </div>
                  <input id="nama" name="nama" type="text" required 
                    class="block w-full rounded-2xl border border-slate-200 bg-white/80 py-3 pl-10 pr-4 text-slate-900 shadow-sm focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 sm:text-sm transition-all" 
                    placeholder="Contoh: Budi Santoso">
                </div>
              </div>

              <div>
                <label for="username" class="mb-2 block text-sm font-bold text-slate-700">Username</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-regular fa-user"></i>
                  </div>
                  <input id="username" name="username" type="text" required 
                    class="block w-full rounded-2xl border border-slate-200 bg-white/80 py-3 pl-10 pr-4 text-slate-900 shadow-sm focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 sm:text-sm transition-all" 
                    placeholder="Buat username unik">
                </div>
              </div>

              <div>
                <label for="email" class="mb-2 block text-sm font-bold text-slate-700">Email Utama</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-regular fa-envelope"></i>
                  </div>
                  <input id="email" name="email" type="email" required 
                    class="block w-full rounded-2xl border border-slate-200 bg-white/80 py-3 pl-10 pr-4 text-slate-900 shadow-sm focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 sm:text-sm transition-all" 
                    placeholder="budi@email.com">
                </div>
              </div>

              <div>
                <label for="no_telepon" class="mb-2 block text-sm font-bold text-slate-700">Nomor Telepon <span class="text-xs font-normal text-slate-400">(WA)</span></label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-phone"></i>
                  </div>
                  <input id="no_telepon" name="no_telepon" type="text" 
                    class="block w-full rounded-2xl border border-slate-200 bg-white/80 py-3 pl-10 pr-4 text-slate-900 shadow-sm focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 sm:text-sm transition-all" 
                    placeholder="08123456789">
                </div>
              </div>
              
              <div>
                <label for="role" class="mb-2 block text-sm font-bold text-slate-700">Peran Akun</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-user-gear"></i>
                  </div>
                  <select id="role" name="role" required 
                    class="block w-full appearance-none rounded-2xl border border-slate-200 bg-white/80 py-3 pl-10 pr-10 text-slate-900 shadow-sm focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 sm:text-sm transition-all cursor-pointer font-medium">
                    <option value="" disabled selected>Pilih Peran Sistem</option>
                    <option value="Warga">Warga Biasa</option>
                    <option value="OperatorDesa">Operator Desa</option>
                    <option value="PetugasBPBD">Petugas BPBD</option>
                    <option value="Admin">Administrator</option>
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-500">
                    <i class="fa-solid fa-caret-down"></i>
                  </div>
                </div>
              </div>

              <!-- Bagian 2: Wilayah -->
              <div class="sm:col-span-2 border-b border-slate-200/80 pb-3 mb-1 mt-4">
                <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800"><i class="fa-solid fa-map-location-dot text-brand-500"></i> Cakupan Wilayah</h3>
              </div>

              <div>
                <label for="provinsi_id" class="mb-2 block text-sm font-bold text-slate-700">Provinsi</label>
                <div class="relative">
                  <select id="provinsi_id" name="id_provinsi" 
                    class="block w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-4 pr-10 text-slate-900 shadow-sm focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 sm:text-sm transition-all cursor-pointer">
                    <option value="">Memuat data...</option>
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-500"><i class="fa-solid fa-caret-down"></i></div>
                </div>
              </div>

              <div>
                <label for="kabupaten_id" class="mb-2 block text-sm font-bold text-slate-700">Kabupaten/Kota</label>
                <div class="relative">
                  <select id="kabupaten_id" name="id_kabupaten" 
                    class="block w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-4 pr-10 text-slate-900 shadow-sm focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 sm:text-sm transition-all cursor-pointer">
                    <option value="">Pilih Provinsi Dahulu</option>
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-500"><i class="fa-solid fa-caret-down"></i></div>
                </div>
              </div>

              <div>
                <label for="kecamatan_id" class="mb-2 block text-sm font-bold text-slate-700">Kecamatan</label>
                <div class="relative">
                  <select id="kecamatan_id" name="id_kecamatan" 
                    class="block w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-4 pr-10 text-slate-900 shadow-sm focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 sm:text-sm transition-all cursor-pointer">
                    <option value="">Pilih Kabupaten Dahulu</option>
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-500"><i class="fa-solid fa-caret-down"></i></div>
                </div>
              </div>

              <div>
                <label for="id_desa" class="mb-2 block text-sm font-bold text-slate-700">Desa/Kelurahan</label>
                <div class="relative">
                  <select id="id_desa" name="id_desa" 
                    class="block w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-4 pr-10 text-slate-900 shadow-sm focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 sm:text-sm transition-all cursor-pointer">
                    <option value="">Pilih Kecamatan Dahulu</option>
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-500"><i class="fa-solid fa-caret-down"></i></div>
                </div>
              </div>

              <div class="sm:col-span-2">
                <label for="alamat" class="mb-2 block text-sm font-bold text-slate-700">Alamat Lengkap (Opsional)</label>
                <textarea id="alamat" name="alamat" rows="2" 
                  class="block w-full rounded-2xl border border-slate-200 bg-white/80 py-3 px-4 text-slate-900 shadow-sm focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 sm:text-sm transition-all resize-none" 
                  placeholder="Detail alamat domisili atau posko..."></textarea>
              </div>

              <!-- Bagian 3: Keamanan -->
              <div class="sm:col-span-2 border-b border-slate-200/80 pb-3 mb-1 mt-4">
                <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800"><i class="fa-solid fa-lock text-brand-500"></i> Kata Sandi (Keamanan)</h3>
              </div>

              <div>
                <label for="password" class="mb-2 block text-sm font-bold text-slate-700">Kata Sandi Baru</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-key"></i>
                  </div>
                  <input id="password" name="password" type="password" required 
                    class="block w-full rounded-2xl border border-slate-200 bg-white/80 py-3 pl-10 pr-4 text-slate-900 shadow-sm focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 sm:text-sm transition-all" 
                    placeholder="Minimal 6 karakter">
                </div>
              </div>

              <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-bold text-slate-700">Ulangi Kata Sandi</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-check-double"></i>
                  </div>
                  <input id="password_confirmation" name="password_confirmation" type="password" required 
                    class="block w-full rounded-2xl border border-slate-200 bg-white/80 py-3 pl-10 pr-4 text-slate-900 shadow-sm focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 sm:text-sm transition-all" 
                    placeholder="Pastikan sama persis">
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="sm:col-span-2 mt-4 pt-4 border-t border-slate-200/50 flex flex-col items-center justify-between gap-6 sm:flex-row-reverse">
                <button type="submit" 
                  class="group relative flex w-full sm:w-auto justify-center items-center gap-2 rounded-2xl bg-brand-600 px-8 py-3.5 text-base font-bold text-white shadow-lg shadow-brand-500/30 transition-all hover:bg-brand-500 hover:shadow-brand-500/40 focus:outline-none focus:ring-4 focus:ring-brand-500/30 active:scale-[0.98] overflow-hidden">
                  <span class="absolute inset-0 -translate-x-full bg-white/20 transition-transform duration-500 ease-out group-hover:translate-x-0"></span>
                  <span class="relative">Daftarkan Akun</span>
                  <i class="fa-solid fa-paper-plane relative group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform"></i>
                </button>
                
                <div class="text-sm font-medium text-slate-600 text-center sm:text-left">
                  Sudah punya akun?
                  <a href="index.php?controller=Auth&action=login" class="font-bold text-brand-600 hover:text-brand-800 transition-colors ml-1 hover:underline underline-offset-4">Masuk di sini</a>
                </div>
              </div>
            </form>
          </div>
          
          <div class="mt-8 text-center text-xs font-medium text-slate-400 pb-10">
            &copy; 2024 SIMONTA Bencana. All Rights Reserved.
          </div>

        </div>
      </div>
    </div>

    <!-- Kolom Kanan: Visual Cover (Tersembunyi di Mobile/Tablet kecil) -->
    <div class="hidden lg:flex lg:w-5/12 xl:w-1/2 relative bg-slate-900 group overflow-hidden">
      <!-- Background Image -->
      <img src="https://images.unsplash.com/photo-1541888086425-d81bb192a063?auto=format&fit=crop&q=80&w=1600" 
           alt="Pusat Komando Bencana" class="absolute inset-0 h-full w-full object-cover opacity-50 mix-blend-overlay group-hover:scale-105 transition-transform duration-[15s] ease-out grayscale-[20%]">
      
      <!-- Gradient Overlay -->
      <div class="absolute inset-0 bg-gradient-to-t from-slate-900/95 via-slate-900/60 to-transparent"></div>
      <div class="absolute inset-0 bg-brand-900/10 mix-blend-color"></div>

      <!-- Konten Teks di Kanan -->
      <div class="absolute bottom-0 left-0 right-0 p-12 xl:p-16 z-10 animate-slide-up" style="animation-delay: 0.3s">
        
        <div class="mb-10 lg:pr-10">
          <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs font-bold uppercase tracking-widest backdrop-blur-md text-white shadow-lg">
            <span class="h-2 w-2 rounded-full bg-brand-500 shadow-[0_0_10px_#f97316]"></span>
            Komando & Koordinasi
          </div>
          <h2 class="font-display text-4xl xl:text-5xl font-bold text-white mt-6 mb-4 leading-tight">Membangun Ketahanan. <br/> Menyebarkan Harapan.</h2>
          <p class="text-slate-300 leading-relaxed text-lg max-w-lg">
            Platform komprehensif untuk mendata, memetakan, dan memitigasi dampak bencana secara digital sebelum terlambat.
          </p>
        </div>

        <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
           <div class="dark-glass rounded-2xl p-5 hover:bg-slate-800/60 transition-colors">
             <div class="h-10 w-10 rounded-xl bg-brand-500/20 text-brand-400 flex items-center justify-center text-lg mb-3">
               <i class="fa-solid fa-lock"></i>
             </div>
             <h4 class="text-white font-bold mb-1">Aman & Terverifikasi</h4>
             <p class="text-xs text-slate-400">Sistem registrasi yang tervalidasi berbasis peran.</p>
           </div>
           
           <div class="dark-glass rounded-2xl p-5 hover:bg-slate-800/60 transition-colors">
             <div class="h-10 w-10 rounded-xl bg-brand-500/20 text-brand-400 flex items-center justify-center text-lg mb-3">
               <i class="fa-solid fa-map-location-dot"></i>
             </div>
             <h4 class="text-white font-bold mb-1">Berbasis Satuan Wilayah</h4>
             <p class="text-xs text-slate-400">Sinkronisasi langsung dengan data wilayah administratif terkini.</p>
           </div>
        </div>

      </div>
    </div>
    
  </div>

  <!-- Toast Container -->
  <div class="fixed right-0 top-6 z-50 flex w-full max-w-sm flex-col gap-3 px-4 sm:right-6 sm:pl-0" id="toastContainer"></div>

  <script>
    (function () {
      function setOptions(select, items, placeholder) {
        if (!select) return;
        select.innerHTML = '';
        const first = document.createElement('option');
        first.value = '';
        first.textContent = placeholder;
        first.disabled = true;
        first.selected = true;
        select.appendChild(first);

        (items || []).forEach(function (item) {
          const id = String(item.id || '');
          if (!id) return;
          const option = document.createElement('option');
          option.value = id;
          option.textContent = String(item.nama || item.name || '-');
          select.appendChild(option);
        });
      }

      async function fetchWilayah(url, params) {
        const query = new URLSearchParams(params || {}).toString();
        const finalUrl = query ? (url + '&' + query) : url;
        try {
          const response = await fetch(finalUrl, { credentials: 'same-origin' });
          if (!response.ok) throw new Error('Jaringan bermasalah');
          return await response.json();
        } catch (error) {
          console.error("Fetch error:", error);
          return { success: false, data: [] };
        }
      }

      const provinsi = document.getElementById('provinsi_id');
      const kabupaten = document.getElementById('kabupaten_id');
      const kecamatan = document.getElementById('kecamatan_id');
      const desa = document.getElementById('id_desa');
      
      if (!provinsi || !kabupaten || !kecamatan || !desa) return;

      async function loadProvinsi() {
        setOptions(provinsi, [], 'Memuat provinsi...');
        const result = await fetchWilayah('index.php?controller=Auth&action=getAllProvinsi');
        setOptions(provinsi, result.success ? result.data : [], 'Pilih Provinsi (Wajib)');
      }

      async function loadKabupaten(provinsiId) {
        if (!provinsiId) {
          setOptions(kabupaten, [], 'Pilih Provinsi Dahulu');
          setOptions(kecamatan, [], 'Pilih Kabupaten Dahulu');
          setOptions(desa, [], 'Pilih Kecamatan Dahulu');
          return;
        }
        setOptions(kabupaten, [], 'Memuat kabupaten...');
        const result = await fetchWilayah('index.php?controller=Auth&action=getKabupatenByProvinsi', { id: provinsiId });
        setOptions(kabupaten, result.success ? result.data : [], 'Pilih Kabupaten / Kota');
        setOptions(kecamatan, [], 'Pilih Kabupaten Dahulu');
        setOptions(desa, [], 'Pilih Kecamatan Dahulu');
      }

      async function loadKecamatan(kabupatenId) {
        if (!kabupatenId) {
          setOptions(kecamatan, [], 'Pilih Kabupaten Dahulu');
          setOptions(desa, [], 'Pilih Kecamatan Dahulu');
          return;
        }
        setOptions(kecamatan, [], 'Memuat kecamatan...');
        const result = await fetchWilayah('index.php?controller=Auth&action=getKecamatanByKabupaten', { id: kabupatenId });
        setOptions(kecamatan, result.success ? result.data : [], 'Pilih Kecamatan');
        setOptions(desa, [], 'Pilih Kecamatan Dahulu');
      }

      async function loadDesa(kecamatanId) {
        if (!kecamatanId) {
          setOptions(desa, [], 'Pilih Kecamatan Dahulu');
          return;
        }
        setOptions(desa, [], 'Memuat desa...');
        const result = await fetchWilayah('index.php?controller=Auth&action=getDesaByKecamatan', { id: kecamatanId });
        setOptions(desa, result.success ? result.data : [], 'Pilih Desa / Kelurahan');
      }

      provinsi.addEventListener('change', function () {
        loadKabupaten(this.value);
      });

      kabupaten.addEventListener('change', function () {
        loadKecamatan(this.value);
      });

      kecamatan.addEventListener('change', function () {
        loadDesa(this.value);
      });

      // Init Load
      loadProvinsi();
    })();

    function showToast(type, title, message) {
      const toastContainer = document.getElementById('toastContainer');
      if (!toastContainer) return;

      const styleMap = {
        success: 'border-emerald-500 bg-emerald-50 text-emerald-800 shadow-emerald-500/20',
        error: 'border-rose-500 bg-rose-50 text-rose-800 shadow-rose-500/20',
        warning: 'border-amber-500 bg-amber-50 text-amber-800 shadow-amber-500/20',
        info: 'border-blue-500 bg-blue-50 text-blue-800 shadow-blue-500/20'
      };
      const iconMap = {
        success: 'fa-circle-check text-emerald-500',
        error: 'fa-circle-xmark text-rose-500',
        warning: 'fa-triangle-exclamation text-amber-500',
        info: 'fa-circle-info text-blue-500'
      };
      const key = styleMap[type] ? type : 'info';

      const toast = document.createElement('div');
      toast.className = `glass-effect animate-toast-in overflow-hidden rounded-2xl border-l-4 p-4 shadow-xl ${styleMap[key]} transform transition-all`;
      toast.innerHTML = `
        <div class="flex items-start gap-4">
          <span class="mt-0.5 text-xl"><i class="fa-solid ${iconMap[key]}"></i></span>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-bold truncate">${title}</p>
            <p class="text-sm mt-0.5 opacity-90 leading-relaxed">${message}</p>
          </div>
          <button type="button" class="ml-4 shrink-0 text-current opacity-50 hover:opacity-100 focus:outline-none transition-opacity" aria-label="Tutup">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
      `;

      const closeButton = toast.querySelector('button');
      if (closeButton) {
        closeButton.addEventListener('click', function () {
          toast.style.transform = 'translateX(100px)';
          toast.style.opacity = '0';
          setTimeout(() => toast.remove(), 300);
        });
      }

      toastContainer.appendChild(toast);
      setTimeout(() => {
        if (toast.parentNode) {
          toast.style.transform = 'translateX(100px)';
          toast.style.opacity = '0';
          setTimeout(() => toast.remove(), 300);
        }
      }, 5000);
    }

    <?php if (isset($_SESSION['toast'])): ?>
    <?php
      $toastType = addslashes($_SESSION['toast']['type'] ?? 'info');
      $toastTitle = addslashes($_SESSION['toast']['title'] ?? 'Informasi');
      $toastMessage = addslashes($_SESSION['toast']['message'] ?? '');
      unset($_SESSION['toast']);
    ?>
    showToast('<?php echo $toastType; ?>', '<?php echo $toastTitle; ?>', '<?php echo $toastMessage; ?>');
    <?php endif; ?>
  </script>
</body>
</html>
