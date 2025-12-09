<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMONTA BENCANA</title>

    <!-- Bootstrap 5.0.2 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #dbeafe;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1e293b;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --border-radius: 12px;
            --border-radius-lg: 16px;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        /* Toast Notification System */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
        }

        .custom-toast {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-xl);
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
            border-left-color: var(--success-color);
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        }

        .custom-toast.error {
            border-left-color: var(--danger-color);
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        }

        .custom-toast.warning {
            border-left-color: var(--warning-color);
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        }

        .custom-toast.info {
            border-left-color: var(--primary-color);
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
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

        .custom-toast.success .toast-icon {
            background: var(--success-color);
        }

        .custom-toast.error .toast-icon {
            background: var(--danger-color);
        }

        .custom-toast.warning .toast-icon {
            background: var(--warning-color);
        }

        .custom-toast.info .toast-icon {
            background: var(--primary-color);
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 4px;
            color: var(--gray-900);
        }

        .toast-message {
            font-size: 13px;
            color: var(--gray-600);
            line-height: 1.4;
        }

        .toast-close {
            position: absolute;
            top: 8px;
            right: 8px;
            background: none;
            border: none;
            font-size: 16px;
            color: var(--gray-400);
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .toast-close:hover {
            color: var(--gray-600);
            background: var(--gray-100);
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        @keyframes progress {
            from {
                width: 100%;
            }
            to {
                width: 0%;
            }
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .login-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar - Modern 2.0 Design */
        .sidebar {
            width: 50%;
            background: var(--white);
            border-right: 1px solid var(--gray-200);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .sidebar-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 2rem;
            text-align: center;
        }

        .brand-section {
            margin-bottom: 3rem;
        }

        .brand-logo {
            width: 80px;
            height: 80px;
            background: var(--primary-color);
            border-radius: var(--border-radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
        }

        .brand-logo:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-xl);
        }

        .brand-logo i {
            font-size: 2rem;
            color: var(--white);
        }

        .brand-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        .brand-subtitle {
            font-size: 1rem;
            color: var(--gray-600);
            font-weight: 500;
        }

        .features-section {
            width: 100%;
            max-width: 400px;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            text-align: left;
            padding: 1rem;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: var(--gray-50);
            transform: translateX(8px);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background: var(--primary-light);
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .feature-icon i {
            font-size: 1.25rem;
            color: var(--primary-color);
        }

        .feature-content h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }

        .feature-content p {
            font-size: 0.875rem;
            color: var(--gray-600);
            margin: 0;
            line-height: 1.5;
        }

        /* Main Content - Form Section */
        .main-content {
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: var(--white);
        }

        .form-container {
            width: 100%;
            max-width: 420px;
        }

        .form-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            font-size: 1rem;
            color: var(--gray-600);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            display: block;
        }

        .input-group {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid var(--gray-200);
            border-radius: var(--border-radius);
            font-size: 0.875rem;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            font-size: 1rem;
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
            transition: all 0.3s ease;
            z-index: 10;
        }

        .password-toggle:hover {
            color: var(--primary-color);
            background: var(--primary-light);
        }

        .form-check {
            margin-bottom: 1.5rem;
        }

        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid var(--gray-300);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            font-size: 0.875rem;
            color: var(--gray-700);
            cursor: pointer;
            user-select: none;
        }

        .btn-primary {
            width: 100%;
            padding: 0.875rem 1.5rem;
            background: var(--primary-color);
            border: none;
            border-radius: var(--border-radius);
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--white);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .form-footer {
            margin-top: 2rem;
            text-align: center;
        }

        .divider {
            position: relative;
            text-align: center;
            margin: 1.5rem 0;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--gray-200);
        }

        .divider span {
            background: var(--white);
            padding: 0 1rem;
            font-size: 0.875rem;
            color: var(--gray-500);
            position: relative;
        }

        .btn-outline {
            width: 100%;
            padding: 0.75rem 1.5rem;
            background: transparent;
            border: 2px solid var(--gray-200);
            border-radius: var(--border-radius);
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: var(--primary-light);
            transform: translateY(-1px);
        }

        /* Loading Spinner */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.15em;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .form-container {
            animation: fadeIn 0.6s ease-out;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar {
                width: 45%;
            }

            .main-content {
                width: 55%;
            }
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                min-height: auto;
                border-right: none;
                border-bottom: 1px solid var(--gray-200);
                padding: 2rem 1.5rem;
            }

            .sidebar-content {
                padding: 0;
            }

            .brand-section {
                margin-bottom: 2rem;
            }

            .features-section {
                display: none;
            }

            .main-content {
                width: 100%;
                padding: 1.5rem;
            }

            .brand-title {
                font-size: 1.5rem;
            }

            .form-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                padding: 1.5rem 1rem;
            }

            .main-content {
                padding: 1rem;
            }

            .brand-logo {
                width: 60px;
                height: 60px;
            }

            .brand-logo i {
                font-size: 1.5rem;
            }

            .brand-title {
                font-size: 1.25rem;
            }

            .form-title {
                font-size: 1.25rem;
            }
        }

        /* Modern focus states */
        .form-control:focus + .input-icon {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer">
        <?php if (isset($success)): ?>
            <div class="custom-toast success" id="initialToast">
                <div class="toast-icon">
                    <i class="fas fa-check"></i>
                </div>
                <div class="toast-content">
                    <div class="toast-title">Berhasil!</div>
                    <div class="toast-message"><?php echo htmlspecialchars($success); ?></div>
                </div>
                <button class="toast-close" onclick="hideToast('initialToast')">
                    <i class="fas fa-times"></i>
                </button>
                <div class="toast-progress"></div>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="custom-toast error" id="initialToast">
                <div class="toast-icon">
                    <i class="fas fa-exclamation"></i>
                </div>
                <div class="toast-content">
                    <div class="toast-title">Error!</div>
                    <div class="toast-message"><?php echo htmlspecialchars($error); ?></div>
                </div>
                <button class="toast-close" onclick="hideToast('initialToast')">
                    <i class="fas fa-times"></i>
                </button>
                <div class="toast-progress"></div>
            </div>
        <?php endif; ?>
    </div>

    <div class="login-container">
        <!-- Sidebar Section -->
        <div class="sidebar">
            <div class="sidebar-content">
                <div class="brand-section">
                    <div class="brand-logo">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h1 class="brand-title">SIMONTA</h1>
                    <p class="brand-subtitle">Sistem Monitoring Penanganan Bencana</p>
                </div>

                <div class="features-section">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-check"></i>
                        </div>
                        <div class="feature-content">
                            <h3>Keamanan Terjamin</h3>
                            <p>Enkripsi data berlapis dengan protokol keamanan terkini</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="feature-content">
                            <h3>Real-time Monitoring</h3>
                            <p>Pantau kondisi bencana secara aktual 24/7</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div class="feature-content">
                            <h3>Koordinasi Tim</h3>
                            <p>Sinergi efektif antar petugas dan stakeholder</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Section -->
        <div class="main-content">
            <div class="form-container">
                <div class="form-header">
                    <h2 class="form-title">Selamat Datang Kembali</h2>
                    <p class="form-subtitle">Masuk ke akun SIMONTA Anda</p>
                </div>

                <form action="index.php?controller=auth&action=login" method="POST" id="loginForm">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text"
                                   class="form-control"
                                   id="username"
                                   name="username"
                                   placeholder="Masukkan username"
                                   required
                                   autocomplete="username"
                                   value="<?php echo htmlspecialchars($_SESSION['old_data']['username'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password"
                                   class="form-control"
                                   id="password"
                                   name="password"
                                   placeholder="Masukkan password"
                                   required
                                   autocomplete="current-password">
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Ingat saya
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary" id="loginBtn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span id="loginBtnText">Masuk</span>
                        <span class="spinner-border spinner-border-sm d-none" id="loginSpinner"></span>
                    </button>
                </form>

                <div class="form-footer">
                    <div class="divider">
                        <span>atau</span>
                    </div>
                    <p>Belum punya akun?</p>
                    <a href="index.php?controller=auth&action=register" class="btn btn-outline">
                        <i class="fas fa-user-plus"></i>
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.0.2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        // Toast Management Functions
        function showToast(message, type = 'info', title = null) {
            const toastContainer = document.getElementById('toastContainer');

            // Auto-generate title based on type if not provided
            if (!title) {
                switch(type) {
                    case 'success':
                        title = 'Berhasil!';
                        break;
                    case 'error':
                        title = 'Error!';
                        break;
                    case 'warning':
                        title = 'Peringatan!';
                        break;
                    default:
                        title = 'Informasi';
                }
            }

            const toastId = 'toast-' + Date.now();

            const iconMap = {
                'success': 'fa-check',
                'error': 'fa-exclamation',
                'warning': 'fa-exclamation-triangle',
                'info': 'fa-info-circle'
            };

            const toastHtml = `
                <div class="custom-toast ${type}" id="${toastId}">
                    <div class="toast-icon">
                        <i class="fas ${iconMap[type]}"></i>
                    </div>
                    <div class="toast-content">
                        <div class="toast-title">${title}</div>
                        <div class="toast-message">${message}</div>
                    </div>
                    <button class="toast-close" onclick="hideToast('${toastId}')">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="toast-progress"></div>
                </div>
            `;

            toastContainer.insertAdjacentHTML('beforeend', toastHtml);

            // Auto-hide after 5 seconds
            setTimeout(() => {
                hideToast(toastId);
            }, 5000);
        }

        function hideToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.add('hiding');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }
        }

        // Auto-hide initial toasts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide initial toasts from PHP
            const initialToasts = document.querySelectorAll('#initialToast');
            initialToasts.forEach((toast, index) => {
                setTimeout(() => {
                    hideToast('initialToast');
                }, 5000 + (index * 100)); // Stagger auto-hide
            });

            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                eyeIcon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
            });

            // Form submission handling
            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            const loginBtnText = document.getElementById('loginBtnText');
            const loginSpinner = document.getElementById('loginSpinner');

            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();

                console.log("=== Login Form Submission Started ===");

                // Basic validation
                const username = document.getElementById('username').value.trim();
                const password = document.getElementById('password').value;

                console.log("Form data:", {
                    username: username,
                    password: password ? "***" : ""
                });

                if (!username) {
                    console.log("Validation failed: username empty");
                    showToast('Username wajib diisi', 'error');
                    return;
                }

                if (!password) {
                    console.log("Validation failed: password empty");
                    showToast('Password wajib diisi', 'error');
                    return;
                }

                if (password.length < 6) {
                    console.log("Validation failed: password too short");
                    showToast('Password minimal 6 karakter', 'error');
                    return;
                }

                console.log("Validation passed, submitting form...");

                // Show loading state
                loginBtn.disabled = true;
                loginBtnText.textContent = 'Memproses...';
                loginSpinner.classList.remove('d-none');

                console.log("Submitting form to:", this.action);
                console.log("Form method:", this.method);

                // Submit form
                this.submit();
            });

            function showAlert(message, type = 'info') {
                // Convert Bootstrap alert types to toast types
                let toastType = type;
                if (type === 'danger') {
                    toastType = 'error';
                }

                showToast(message, toastType);
            }

            // Auto-focus on username field
            document.getElementById('username').focus();

            // Prevent form resubmission on page refresh
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        });
    </script>
</body>
</html>