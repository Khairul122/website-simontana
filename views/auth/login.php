<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="assets/vendors/feather/feather.css" />
  <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css" />
  <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css" />
  <link rel="stylesheet" href="assets/vendors/typicons/typicons.css" />
  <link rel="stylesheet" href="assets/vendors/simple-line-icons/css/simple-line-icons.css" />
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css" />
  <link rel="stylesheet" href="assets/css/vertical-layout-light/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css" />
  <link rel="stylesheet" type="text/css" href="assets/js/select.dataTables.min.css" />
  <link rel="shortcut icon" href="assets/images/favicon.png" />
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
    }

    .login-container {
      display: flex;
      min-height: 100vh;
    }

    .login-left {
      flex: 1;
      background-color: #4051b5;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 2rem;
      position: relative;
      overflow: hidden;
    }

    .login-right {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
      background-color: white;
    }

    .login-card {
      width: 100%;
      max-width: 400px;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .logo-section {
      text-align: center;
      margin-bottom: 2rem;
    }

    .logo-section h1 {
      font-size: 2rem;
      margin-bottom: 0.5rem;
      color: #4051b5;
    }

    .logo-section p {
      color: #6c757d;
      margin: 0;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: #495057;
    }

    .form-control {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid #ced4da;
      border-radius: 5px;
      font-size: 1rem;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
      border-color: #4051b5;
      box-shadow: 0 0 0 0.2rem rgba(64, 81, 181, 0.25);
      outline: 0;
    }

    .input-group {
      position: relative;
    }

    .input-group-text {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      background: transparent;
      border: none;
      color: #6c757d;
      z-index: 10;
    }

    .input-with-icon {
      padding-left: 3rem;
    }

    .btn {
      padding: 0.75rem 1rem;
      border-radius: 5px;
      font-size: 1rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-primary {
      background-color: #4051b5;
      border: none;
      color: white;
      width: 100%;
    }

    .btn-primary:hover {
      background-color: #34418c;
    }

    .auth-link {
      text-align: center;
      display: block;
      margin-top: 1rem;
      color: #4051b5;
      text-decoration: none;
    }

    .auth-link:hover {
      text-decoration: underline;
    }

    .features {
      text-align: center;
      margin-top: 2rem;
    }

    .features h4 {
      color: white;
      margin-bottom: 1rem;
    }

    .features ul {
      list-style: none;
      padding: 0;
    }

    .features li {
      padding: 0.5rem 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .features i {
      margin-right: 0.5rem;
      color: #4ade80;
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
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      margin-bottom: 10px;
      padding: 16px;
      border-left: 4px solid;
      display: flex;
      align-items: flex-start;
      gap: 12px;
      animation: slideInRight 0.3s ease-out;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .custom-toast.hiding {
      animation: slideOutRight 0.3s ease-out;
      opacity: 0;
      transform: translateX(100%);
    }

    .custom-toast.success {
      border-left-color: #10b981;
      background-color: #f0fdf4;
    }

    .custom-toast.error {
      border-left-color: #ef4444;
      background-color: #fef2f2;
    }

    .custom-toast.warning {
      border-left-color: #f59e0b;
      background-color: #fffbeb;
    }

    .custom-toast.info {
      border-left-color: #3b82f6;
      background-color: #eff6ff;
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
    }

    .custom-toast.success .toast-icon { background: #10b981; }
    .custom-toast.error .toast-icon { background: #ef4444; }
    .custom-toast.warning .toast-icon { background: #f59e0b; }
    .custom-toast.info .toast-icon { background: #3b82f6; }

    .toast-content {
      flex: 1;
    }

    .toast-title {
      font-weight: 600;
      font-size: 14px;
      margin-bottom: 4px;
      color: #1f2937;
    }

    .toast-message {
      font-size: 13px;
      color: #64748b;
      line-height: 1.4;
    }

    .toast-close {
      position: absolute;
      top: 8px;
      right: 8px;
      background: none;
      border: none;
      font-size: 16px;
      color: #9ca3af;
      cursor: pointer;
      padding: 4px;
      border-radius: 4px;
      transition: all 0.2s;
    }

    .toast-close:hover {
      color: #64748b;
      background: #e5e7eb;
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

    @media (max-width: 991px) {
      .login-container {
        flex-direction: column;
      }

      .login-left {
        padding: 1rem;
      }

      .login-right {
        padding: 1rem;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-left">
      <div class="text-center">
        <h2 class="mb-4">SIMONTA BENCANA</h2>
        <p class="mb-5">Sistem Informasi Monitoring dan Pelaporan Bencana</p>
        <div class="features">
          <h4>Alur Pelaporan</h4>
          <ul class="text-left">
            <li><i class="fas fa-check-circle"></i> Melapor</li>
            <li><i class="fas fa-check-circle"></i> Verifikasi</li>
            <li><i class="fas fa-check-circle"></i> Penanganan</li>
            <li><i class="fas fa-check-circle"></i> Penyelesaian</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="login-right">
      <div class="login-card">
        <div class="logo-section">
          <h1>SIMONTA</h1>
          <p>Sistem Informasi Monitoring dan Pelaporan Bencana</p>
        </div>

        <form method="POST" action="index.php?controller=Auth&action=processLogin">
          <div class="form-group">
            <label for="username" class="form-label">Username atau Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-user"></i></span>
              <input type="text" class="form-control input-with-icon" id="username" name="username" placeholder="Masukkan username atau email" required>
            </div>
          </div>

          <div class="form-group">
            <label for="password" class="form-label">Kata Sandi</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
              <input type="password" class="form-control input-with-icon" id="password" name="password" placeholder="Masukkan kata sandi" required>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">MASUK</button>

          <a href="index.php?controller=Auth&action=register" class="auth-link">Buat akun baru</a>
        </form>
      </div>
    </div>
  </div>

  <!-- Toast Container -->
  <div class="toast-container" id="toastContainer"></div>

  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/template.js"></script>
  <script src="assets/js/settings.js"></script>
  <script src="assets/js/todolist.js"></script>

  <script>
    // Fungsi untuk menampilkan toast notification
    function showToast(type, title, message) {
      const toastContainer = document.getElementById('toastContainer');

      const toast = document.createElement('div');
      toast.className = `custom-toast ${type}`;

      toast.innerHTML = `
        <div class="toast-icon">${type === 'success' ? '✓' : '!'}</div>
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
  </script>
</body>
</html>