<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $title ?></title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Favicon -->
  <link rel="shortcut icon" href="assets/images/favicon.png" />

  <style>
    :root {
      /* Modern Blue Color Palette */
      --primary-color: #4F46E5;
      --primary-dark: #4338CA;
      --primary-light: #818CF8;
      --primary-50: #EEF2FF;
      --primary-100: #E0E7FF;
      --gray-50: #F9FAFB;
      --gray-100: #F3F4F6;
      --gray-200: #E5E7EB;
      --gray-300: #D1D5DB;
      --gray-400: #9CA3AF;
      --gray-500: #6B7280;
      --gray-600: #4B5563;
      --gray-700: #374151;
      --gray-800: #1F2937;
      --gray-900: #111827;
      --success: #10B981;
      --error: #EF4444;
      --warning: #F59E0B;
      --info: #3B82F6;
      --border-radius: 12px;
      --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
      --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      --transition: all 0.3s ease;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
      background-color: var(--gray-50);
      height: 100vh;
      overflow: hidden;
    }

    .login-container {
      display: flex;
      min-height: 100vh;
    }

    /* Left side - Branding */
    .login-left {
      flex: 1;
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 2rem;
      position: relative;
      overflow: hidden;
    }

    .login-left::before {
      content: '';
      position: absolute;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
      top: -50%;
      left: -50%;
    }

    .brand-content {
      text-align: center;
      z-index: 2;
      max-width: 500px;
    }

    .brand-logo {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
      background: linear-gradient(90deg, #ffffff, #e0e7ff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      text-fill-color: transparent;
    }

    .brand-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: white;
    }

    .brand-subtitle {
      font-size: 1rem;
      color: rgba(255, 255, 255, 0.8);
      margin-bottom: 2rem;
      line-height: 1.6;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
      margin-top: 2rem;
    }

    .feature-item {
      display: flex;
      align-items: flex-start;
      gap: 0.75rem;
    }

    .feature-icon {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      margin-top: 0.25rem;
    }

    .feature-text {
      color: rgba(255, 255, 255, 0.9);
      font-size: 0.9rem;
      line-height: 1.5;
    }

    /* Right side - Login Form */
    .login-right {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
      background: white;
    }

    .login-card {
      width: 100%;
      max-width: 420px;
      padding: 2.5rem;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-lg);
      background: white;
      position: relative;
      overflow: hidden;
    }

    .login-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
    }

    .logo-section {
      text-align: center;
      margin-bottom: 2rem;
    }

    .logo-section h1 {
      font-size: 2rem;
      font-weight: 700;
      color: var(--gray-800);
      margin-bottom: 0.5rem;
      letter-spacing: -0.5px;
    }

    .logo-section p {
      color: var(--gray-500);
      margin: 0;
      font-size: 0.95rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: var(--gray-700);
      font-size: 0.9rem;
    }

    .input-group {
      position: relative;
    }

    .form-control {
      width: 100%;
      padding: 0.875rem 1rem 0.875rem 3rem;
      border: 1px solid var(--gray-300);
      border-radius: 8px;
      font-size: 1rem;
      transition: var(--transition);
      background: white;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .input-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--gray-400);
      z-index: 10;
    }

    .password-toggle {
      position: absolute;
      right: 1rem;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: var(--gray-400);
      cursor: pointer;
      padding: 0.25rem;
      border-radius: 4px;
      transition: var(--transition);
    }

    .password-toggle:hover {
      color: var(--gray-600);
      background: var(--gray-100);
    }

    .btn {
      padding: 0.875rem 1rem;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      border: none;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .btn-primary {
      background-color: var(--primary-color);
      color: white;
      box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .btn-primary:hover {
      background-color: var(--primary-dark);
      transform: translateY(-1px);
      box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3), 0 2px 4px -1px rgba(79, 70, 229, 0.2);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    .auth-link {
      text-align: center;
      display: block;
      margin-top: 1.5rem;
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 500;
      font-size: 0.95rem;
      transition: var(--transition);
    }

    .auth-link:hover {
      color: var(--primary-dark);
      text-decoration: underline;
    }

    .toast-container {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
      max-width: 400px;
    }

    .custom-toast {
      background: white;
      border-radius: 8px;
      box-shadow: var(--shadow-lg);
      margin-bottom: 10px;
      padding: 1rem;
      border-left: 4px solid;
      display: flex;
      align-items: flex-start;
      gap: 0.75rem;
      animation: slideInRight 0.3s ease-out;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      min-height: 64px;
    }

    .custom-toast.hiding {
      animation: slideOutRight 0.3s ease-out;
      opacity: 0;
      transform: translateX(100%);
    }

    .custom-toast.success {
      border-left-color: var(--success);
      background-color: #F0FDF4;
    }

    .custom-toast.error {
      border-left-color: var(--error);
      background-color: #FEF2F2;
    }

    .custom-toast.warning {
      border-left-color: var(--warning);
      background-color: #FFFBEB;
    }

    .custom-toast.info {
      border-left-color: var(--info);
      background-color: #EFF6FF;
    }

    .toast-icon {
      flex-shrink: 0;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      color: white;
      font-weight: 600;
      margin-top: 2px;
    }

    .custom-toast.success .toast-icon { background: var(--success); }
    .custom-toast.error .toast-icon { background: var(--error); }
    .custom-toast.warning .toast-icon { background: var(--warning); }
    .custom-toast.info .toast-icon { background: var(--info); }

    .toast-content {
      flex: 1;
      min-width: 0;
    }

    .toast-title {
      font-weight: 600;
      font-size: 0.9rem;
      margin-bottom: 0.125rem;
      color: var(--gray-800);
    }

    .toast-message {
      font-size: 0.85rem;
      color: var(--gray-600);
      line-height: 1.4;
    }

    .toast-close {
      position: absolute;
      top: 0.75rem;
      right: 0.75rem;
      background: none;
      border: none;
      font-size: 16px;
      color: var(--gray-400);
      cursor: pointer;
      padding: 0.25rem;
      border-radius: 4px;
      transition: var(--transition);
    }

    .toast-close:hover {
      color: var(--gray-600);
      background: var(--gray-100);
    }

    .toast-progress {
      position: absolute;
      bottom: 0;
      left: 0;
      height: 3px;
      background: currentColor;
      opacity: 0.2;
      animation: progress 5s linear forwards;
    }

    @keyframes slideInRight {
      from { transform: translateX(100%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }

    @keyframes slideOutRight {
      from { transform: translateX(0); opacity: 1; }
      to { transform: translateX(100%); opacity: 0; }
    }

    @keyframes progress {
      from { width: 100%; }
      to { width: 0%; }
    }

    /* Responsive design */
    @media (max-width: 991px) {
      .login-container {
        flex-direction: column;
      }

      .login-left {
        padding: 1.5rem;
        min-height: 40vh;
      }

      .features-grid {
        grid-template-columns: 1fr;
      }

      .login-right {
        padding: 1.5rem;
      }
    }

    @media (max-width: 768px) {
      .login-card {
        max-width: 100%;
        margin: 0 1rem;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-left">
      <div class="brand-content">
        <div class="brand-logo">SIMONTA</div>
        <h2 class="brand-title">Sistem Informasi Monitoring dan Pelaporan Bencana</h2>
        <p class="brand-subtitle">Solusi komprehensif untuk pengelolaan data bencana, pelaporan real-time, dan koordinasi penanganan darurat.</p>

        <div class="features-grid">
          <div class="feature-item">
            <div class="feature-icon">
              <i class="fas fa-bolt"></i>
            </div>
            <div class="feature-text">
              Laporan Real-time
            </div>
          </div>
          <div class="feature-item">
            <div class="feature-icon">
              <i class="fas fa-sync-alt"></i>
            </div>
            <div class="feature-text">
              Update Otomatis
            </div>
          </div>
          <div class="feature-item">
            <div class="feature-icon">
              <i class="fas fa-shield-alt"></i>
            </div>
            <div class="feature-text">
              Data Terpercaya
            </div>
          </div>
          <div class="feature-item">
            <div class="feature-icon">
              <i class="fas fa-users"></i>
            </div>
            <div class="feature-text">
              Kolaborasi Tim
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="login-right">
      <div class="login-card">
        <div class="logo-section">
          <h1>Selamat Datang</h1>
          <p>Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        <form method="POST" action="index.php?controller=Auth&action=processLogin">
          <div class="form-group">
            <label for="username" class="form-label">Username atau Email</label>
            <div class="input-group">
              <span class="input-icon"><i class="fas fa-user"></i></span>
              <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username atau email" required>
            </div>
          </div>

          <div class="form-group">
            <label for="password" class="form-label">Kata Sandi</label>
            <div class="input-group">
              <span class="input-icon"><i class="fas fa-lock"></i></span>
              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan kata sandi" required>
              <button type="button" class="password-toggle" id="togglePassword">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">
            <i class="fas fa-sign-in-alt"></i>
            MASUK
          </button>

          <a href="index.php?controller=Auth&action=register" class="auth-link">
            Belum punya akun? Buat akun baru
          </a>
        </form>
      </div>
    </div>
  </div>

  <!-- Toast Container -->
  <div class="toast-container" id="toastContainer"></div>

  <script>
    // Password visibility toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
      const togglePassword = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('password');
      const eyeIcon = togglePassword.querySelector('i');

      togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Toggle eye icon
        if (type === 'password') {
          eyeIcon.classList.remove('fa-eye-slash');
          eyeIcon.classList.add('fa-eye');
        } else {
          eyeIcon.classList.remove('fa-eye');
          eyeIcon.classList.add('fa-eye-slash');
        }
      });

      // Fungsi untuk menampilkan toast notification
      function showToast(type, title, message) {
        const toastContainer = document.getElementById('toastContainer');

        const toast = document.createElement('div');
        toast.className = `custom-toast ${type}`;

        toast.innerHTML = `
          <div class="toast-icon">${type === 'success' ? '✓' : type === 'error' ? '!' : type === 'warning' ? '⚠' : 'ℹ'}</div>
          <div class="toast-content">
            <div class="toast-title">${title}</div>
            <div class="toast-message">${message}</div>
          </div>
          <button class="toast-close">&times;</button>
          <div class="toast-progress"></div>
        `;

        toastContainer.appendChild(toast);

        // Tambahkan event listener untuk tombol close
        const closeBtn = toast.querySelector('.toast-close');
        closeBtn.addEventListener('click', function() {
          toast.classList.add('hiding');
          setTimeout(() => {
            toast.remove();
          }, 300);
        });

        // Hapus toast setelah 5 detik
        setTimeout(() => {
          if (!toast.classList.contains('hiding')) {
            toast.classList.add('hiding');
            setTimeout(() => {
              toast.remove();
            }, 300);
          }
        }, 5000);

        return toast;
      }

      // Tampilkan toast jika ada dari session
      <?php if (isset($_SESSION['toast'])): ?>
      document.addEventListener('DOMContentLoaded', function() {
        const toast = showToast(
          '<?php echo addslashes($_SESSION['toast']['type']); ?>',
          '<?php echo addslashes($_SESSION['toast']['title']); ?>',
          '<?php echo addslashes($_SESSION['toast']['message']); ?>'
        );
        <?php unset($_SESSION['toast']); ?>

        // Jika redirect diperlukan setelah toast ditampilkan
        <?php if (isset($should_redirect) && $should_redirect): ?>
        setTimeout(() => {
          // Redirect ke dashboard berdasarkan role
          const role = '<?php echo $_SESSION['user_role'] ?? 'Warga'; ?>';
          let redirectUrl = 'index.php?controller=Beranda&action=index'; // Default untuk Warga

          switch(role) {
            case 'Admin':
            case 'PetugasBPBD':
            case 'OperatorDesa':
              redirectUrl = 'index.php?controller=Dashboard&action=index';
              break;
            default:
              redirectUrl = 'index.php?controller=Beranda&action=index';
              break;
          }

          window.location.href = redirectUrl;
        }, 2000); // Tunggu 2 detik agar toast terlihat sebelum redirect
        <?php endif; ?>
      });
      <?php endif; ?>

      // Jika tidak ada toast tapi redirect diperlukan
      <?php if (isset($should_redirect) && $should_redirect && !isset($_SESSION['toast'])): ?>
      document.addEventListener('DOMContentLoaded', function() {
        // Redirect ke dashboard berdasarkan role
        const role = '<?php echo $_SESSION['user_role'] ?? 'Warga'; ?>';
        let redirectUrl = 'index.php?controller=Beranda&action=index'; // Default untuk Warga

        switch(role) {
          case 'Admin':
          case 'PetugasBPBD':
          case 'OperatorDesa':
            redirectUrl = 'index.php?controller=Dashboard&action=index';
            break;
          default:
            redirectUrl = 'index.php?controller=Beranda&action=index';
            break;
        }

        window.location.href = redirectUrl;
      });
      <?php endif; ?>
    });
  </script>
</body>
</html>