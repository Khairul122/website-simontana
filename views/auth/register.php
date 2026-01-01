<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $title ?></title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Favicon -->
  <link rel="shortcut icon" href="assets/images/favicon.png" />

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            'sans': ['Inter', 'sans-serif'],
          },
          colors: {
            'primary': {
              50: '#EEF2FF',
              100: '#E0E7FF',
              200: '#C7D2FE',
              300: '#A5B4FC',
              400: '#818CF8',
              500: '#6366F1',
              600: '#4F46E5',
              700: '#4338CA',
              800: '#3730A3',
              900: '#312E81',
            }
          }
        }
      }
    }
  </script>
</head>
<body class="h-full font-sans bg-gray-50">
  <div class="h-screen w-full flex overflow-hidden">
    <!-- Image Section -->
    <div class="hidden lg:flex lg:w-1/2 xl:w-2/3 bg-cover bg-center relative" style="background-image: url('https://source.unsplash.com/random/1920x1080/?nature,disaster');">
      <!-- Gradient Overlay -->
      <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-70"></div>
      
      <!-- Branding Content -->
      <div class="relative z-10 flex flex-col justify-center items-center text-center text-white p-12 w-full">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-white to-primary-200 bg-clip-text text-transparent">
          SIMONTA BENCANA
        </h1>
        <p class="text-xl md:text-2xl font-semibold mb-6">Sistem Informasi Monitoring dan Pelaporan Bencana</p>
        <p class="text-lg text-primary-200 max-w-2xl">
          Solusi komprehensif untuk pengelolaan data bencana, pelaporan real-time, dan koordinasi penanganan darurat.
        </p>
        
        <!-- Features -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10 w-full max-w-2xl">
          <div class="flex items-start gap-3">
            <div class="bg-primary-500 bg-opacity-30 p-2 rounded-lg">
              <i class="fas fa-check-circle"></i>
            </div>
            <div class="text-left">
              <div class="font-medium">Admin</div>
              <div class="text-primary-200 text-sm">Pengelola sistem</div>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <div class="bg-primary-500 bg-opacity-30 p-2 rounded-lg">
              <i class="fas fa-check-circle"></i>
            </div>
            <div class="text-left">
              <div class="font-medium">Petugas BPBD</div>
              <div class="text-primary-200 text-sm">Pengelola bencana</div>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <div class="bg-primary-500 bg-opacity-30 p-2 rounded-lg">
              <i class="fas fa-check-circle"></i>
            </div>
            <div class="text-left">
              <div class="font-medium">Operator Desa</div>
              <div class="text-primary-200 text-sm">Pelapor lapangan</div>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <div class="bg-primary-500 bg-opacity-30 p-2 rounded-lg">
              <i class="fas fa-check-circle"></i>
            </div>
            <div class="text-left">
              <div class="font-medium">Warga</div>
              <div class="text-primary-200 text-sm">Pelapor masyarakat</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Form Section -->
    <div class="w-full lg:w-1/2 xl:w-1/3 flex items-center justify-center bg-white px-8 py-12 sm:px-12">
      <div class="w-full max-w-md">
        <div class="text-center mb-10">
          <h1 class="text-3xl font-bold text-gray-800 mb-2">Daftar Akun</h1>
          <p class="text-gray-500">Buat akun untuk mengakses sistem pelaporan bencana</p>
        </div>

        <form method="POST" action="index.php?controller=Auth&action=processRegister" class="space-y-6">
          <div class="space-y-4">
            <div>
              <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-user text-gray-400"></i>
                </div>
                <input type="text" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
              </div>
            </div>

            <div>
              <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-user-circle text-gray-400"></i>
                </div>
                <input type="text" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition" id="username" name="username" placeholder="Masukkan username" required>
              </div>
            </div>

            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-envelope text-gray-400"></i>
                </div>
                <input type="email" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition" id="email" name="email" placeholder="Masukkan email" required>
              </div>
            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-lock text-gray-400"></i>
                </div>
                <input type="password" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition" id="password" name="password" placeholder="Masukkan kata sandi" required>
              </div>
            </div>

            <div>
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-lock text-gray-400"></i>
                </div>
                <input type="password" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi kata sandi" required>
              </div>
            </div>

            <div>
              <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Peran</label>
              <select class="w-full py-3 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition" id="role" name="role" required>
                <option value="">Pilih Peran</option>
                <option value="Warga">Warga</option>
                <option value="OperatorDesa">Operator Desa</option>
                <option value="PetugasBPBD">Petugas BPBD</option>
                <option value="Admin">Admin</option>
              </select>
            </div>

            <div>
              <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-phone text-gray-400"></i>
                </div>
                <input type="text" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition" id="no_telepon" name="no_telepon" placeholder="Masukkan nomor telepon">
              </div>
            </div>

            <div>
              <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-map-marker-alt text-gray-400"></i>
                </div>
                <input type="text" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition" id="alamat" name="alamat" placeholder="Masukkan alamat lengkap">
              </div>
            </div>

            <div>
              <label for="id_desa" class="block text-sm font-medium text-gray-700 mb-1">ID Desa (opsional)</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-home text-gray-400"></i>
                </div>
                <input type="number" class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition" id="id_desa" name="id_desa" placeholder="Masukkan ID desa">
              </div>
            </div>
          </div>

          <button type="submit" class="w-full bg-gradient-to-r from-primary-600 to-primary-700 text-white py-3 px-4 rounded-lg font-medium hover:from-primary-700 hover:to-primary-800 transition-all duration-200 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
            <i class="fas fa-user-plus"></i>
            DAFTAR
          </button>

          <div class="text-center">
            <a href="index.php?controller=Auth&action=login" class="text-primary-600 hover:text-primary-800 font-medium text-sm transition">
              Sudah punya akun? Masuk di sini
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Toast Container -->
  <div class="fixed top-4 right-4 z-50 space-y-2" id="toastContainer"></div>

  <script>
    // Fungsi untuk menampilkan toast notification
    function showToast(type, title, message) {
      const toastContainer = document.getElementById('toastContainer');

      const toast = document.createElement('div');
      toast.className = `p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 ${type === 'success' ? 'bg-green-100 border-l-4 border-green-500' : type === 'error' ? 'bg-red-100 border-l-4 border-red-500' : type === 'warning' ? 'bg-yellow-100 border-l-4 border-yellow-500' : 'bg-blue-100 border-l-4 border-blue-500'}`;

      toast.innerHTML = `
        <div class="flex items-start gap-3">
          <div class="${type === 'success' ? 'text-green-500' : type === 'error' ? 'text-red-500' : type === 'warning' ? 'text-yellow-500' : 'text-blue-500'}">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'}"></i>
          </div>
          <div class="flex-1">
            <div class="font-medium ${type === 'success' ? 'text-green-800' : type === 'error' ? 'text-red-800' : type === 'warning' ? 'text-yellow-800' : 'text-blue-800'}">${title}</div>
            <div class="text-sm ${type === 'success' ? 'text-green-600' : type === 'error' ? 'text-red-600' : type === 'warning' ? 'text-yellow-600' : 'text-blue-600'}">${message}</div>
          </div>
          <button class="text-gray-500 hover:text-gray-700" onclick="this.parentElement.parentElement.remove()">&times;</button>
        </div>
      `;

      toastContainer.appendChild(toast);

      // Hapus toast setelah 5 detik
      setTimeout(() => {
        if (toast.parentNode) {
          toast.remove();
        }
      }, 5000);
    }

    // Tampilkan alert jika ada dari session
    <?php if (isset($_SESSION['toast'])): ?>
    <script>
        // Clean strings to prevent JS errors
        var title = "<?php echo addslashes($_SESSION['toast']['title'] ?? ''); ?>";
        var message = "<?php echo addslashes($_SESSION['toast']['message'] ?? ''); ?>";

        // Display native alert
        if (title && title !== 'null') {
            alert(title + "\n\n" + message);
        } else {
            alert(message);
        }
        <?php unset($_SESSION['toast']); ?>
    </script>
    <?php endif; ?>
  </script>
</body>
</html>