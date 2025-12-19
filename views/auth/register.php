<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SIMONTA BENCANA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .register-container {
            display: flex;
            min-height: 100vh;
        }

        /* Left Branding Panel */
        .brand-panel {
            flex: 1;
            background: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .brand-content {
            text-align: center;
            color: white;
            z-index: 2;
            padding: 3rem;
            max-width: 500px;
        }

        .brand-logo {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            animation: float 6s ease-in-out infinite;
        }

        .brand-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 1.125rem;
            font-weight: 300;
            margin-bottom: 2rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        .role-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: center;
        }

        .role-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .role-badge:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        /* Floating Elements Animation */
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: floatRandom 20s infinite linear;
        }

        .floating-element:nth-child(1) {
            width: 80px;
            height: 80px;
            left: 10%;
            top: 20%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 120px;
            height: 120px;
            right: 15%;
            top: 60%;
            animation-delay: 3s;
        }

        .floating-element:nth-child(3) {
            width: 60px;
            height: 60px;
            left: 30%;
            bottom: 30%;
            animation-delay: 6s;
        }

        .floating-element:nth-child(4) {
            width: 100px;
            height: 100px;
            right: 25%;
            bottom: 20%;
            animation-delay: 9s;
        }

        /* Register Panel */
        .register-panel {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .register-form-container {
            width: 100%;
            max-width: 450px;
        }

        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .mobile-logo {
            display: none;
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            border-radius: 15px;
            margin: 0 auto 1.5rem;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .register-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.5rem;
        }

        .register-subtitle {
            color: #718096;
            font-size: 1rem;
            font-weight: 400;
        }

        .register-form {
            margin-top: 2rem;
        }

        .form-floating {
            margin-bottom: 1.25rem;
        }

        .form-floating > .form-control,
        .form-floating > .form-select {
            height: 3.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-floating > .form-control:focus,
        .form-floating > .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
            background: white;
        }

        .form-floating > label {
            color: #718096;
            font-weight: 500;
            padding: 0.75rem 1rem;
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-select:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label,
        .form-floating > .form-select:valid ~ label {
            color: #0d6efd;
        }

        .input-group-text {
            background: #f1f5f9;
            border: 2px solid #e2e8f0;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: #64748b;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }

        .btn-register {
            background: #0d6efd;
            border: none;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            width: 100%;
            height: 3.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-register:hover {
            background: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(13, 110, 253, 0.3);
        }

        .btn-register:disabled {
            background: #cbd5e0;
            transform: none;
            box-shadow: none;
            cursor: not-allowed;
        }

        .divider {
            text-align: center;
            margin: 2rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e2e8f0;
        }

        .divider span {
            background: white;
            padding: 0 1rem;
            color: #718096;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .login-link a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #0b5ed7;
            text-decoration: underline;
        }

        .alert {
            border-radius: 12px;
            border: none;
            font-size: 0.875rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }

        .alert-success {
            background: #f0fdf4;
            color: #16a34a;
            border-left: 4px solid #16a34a;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
            }

            .brand-panel {
                display: none;
            }

            .mobile-logo {
                display: flex;
            }

            .register-panel {
                padding: 1rem;
            }

            .brand-content {
                padding: 2rem;
            }

            .brand-title {
                font-size: 2rem;
            }

            .register-title {
                font-size: 1.5rem;
            }
        }

        /* Animations */
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes floatRandom {
            0%, 100% {
                transform: translateY(0px) translateX(0px) rotate(0deg);
                opacity: 0.1;
            }
            25% {
                transform: translateY(-30px) translateX(20px) rotate(90deg);
                opacity: 0.3;
            }
            50% {
                transform: translateY(20px) translateX(-15px) rotate(180deg);
                opacity: 0.2;
            }
            75% {
                transform: translateY(-15px) translateX(25px) rotate(270deg);
                opacity: 0.4;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Left Branding Panel -->
        <div class="brand-panel">
            <div class="floating-elements">
                <div class="floating-element"></div>
                <div class="floating-element"></div>
                <div class="floating-element"></div>
                <div class="floating-element"></div>
            </div>

            <div class="brand-content">
                <div class="brand-logo">
                    <i class="fas fa-shield-alt fa-3x"></i>
                </div>

                <h1 class="brand-title">SIMONTA BENCANA</h1>
                <p class="brand-subtitle">
                    Sistem Informasi Monitoring dan Penanganan Bencana yang terintegrasi untuk Indonesia yang lebih siap menghadapi bencana
                </p>

                <div class="role-badges">
                    <div class="role-badge">
                        <i class="fas fa-user-shield"></i>
                        <span>Admin</span>
                    </div>
                    <div class="role-badge">
                        <i class="fas fa-user-tie"></i>
                        <span>Petugas BPBD</span>
                    </div>
                    <div class="role-badge">
                        <i class="fas fa-user-check"></i>
                        <span>Operator Desa</span>
                    </div>
                    <div class="role-badge">
                        <i class="fas fa-user"></i>
                        <span>Warga</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Register Panel -->
        <div class="register-panel">
            <div class="register-form-container">
                <div class="register-header">
                    <div class="mobile-logo">
                        <i class="fas fa-shield-alt"></i>
                    </div>

                    <h2 class="register-title">Buat Akun Baru</h2>
                    <p class="register-subtitle">Bergabung dengan sistem monitoring bencana terpadu</p>
                </div>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perbaiki kesalahan berikut:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach ($errors as $field => $message): ?>
                                <li><?php echo htmlspecialchars($message); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="index.php?controller=auth&action=register" id="registerForm" class="register-form">
                    <!-- Row 1: Name and Username -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="Nama Lengkap" required
                                       value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                                <label for="name">
                                    <i class="fas fa-user me-2"></i>Nama Lengkap
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="username" name="username"
                                       placeholder="Username" required
                                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                                <label for="username">
                                    <i class="fas fa-at me-2"></i>Username
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Email and Phone -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="Email" required
                                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                                <label for="email">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="tel" class="form-control" id="phone" name="phone"
                                       placeholder="Nomor Telepon"
                                       value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                                <label for="phone">
                                    <i class="fas fa-phone me-2"></i>Nomor Telepon
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Password and Confirmation -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Password" required>
                                <label for="password">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                       placeholder="Konfirmasi Password" required>
                                <label for="password_confirmation">
                                    <i class="fas fa-lock me-2"></i>Konfirmasi Password
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div class="form-floating">
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Pilih Peran</option>
                            <option value="warga" <?php echo (isset($_POST['role']) && $_POST['role'] == 'warga') ? 'selected' : ''; ?>>Warga</option>
                            <option value="operator" <?php echo (isset($_POST['role']) && $_POST['role'] == 'operator') ? 'selected' : ''; ?>>Operator Desa</option>
                            <option value="petugas" <?php echo (isset($_POST['role']) && $_POST['role'] == 'petugas') ? 'selected' : ''; ?>>Petugas BPBD</option>
                            <option value="admin" <?php echo (isset($_POST['role']) && $_POST['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                        <label for="role">
                            <i class="fas fa-user-tag me-2"></i>Peran
                        </label>
                    </div>

                    <!-- Address -->
                    <div class="form-floating">
                        <textarea class="form-control" id="address" name="address" rows="2"
                                  placeholder="Alamat Lengkap" style="height: 80px;"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
                        <label for="address">
                            <i class="fas fa-map-marker-alt me-2"></i>Alamat Lengkap
                        </label>
                    </div>

                    <!-- Region Information -->
                    <div class="mb-4">
                        <h6 class="mb-3 text-muted">
                            <i class="fas fa-map me-2"></i>Informasi Wilayah
                        </h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="provinsi_id" name="provinsi_id">
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                    <label for="provinsi_id">Provinsi</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="kabupaten_id" name="kabupaten_id" disabled>
                                        <option value="">Pilih Kabupaten</option>
                                    </select>
                                    <label for="kabupaten_id">Kabupaten/Kota</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="kecamatan_id" name="kecamatan_id" disabled>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                    <label for="kecamatan_id">Kecamatan</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="desa_id" name="desa_id" disabled>
                                        <option value="">Pilih Desa</option>
                                    </select>
                                    <label for="desa_id">Desa/Kelurahan</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-register">
                        <i class="fas fa-user-plus"></i>
                        <span>Daftar Sekarang</span>
                    </button>
                </form>

                <div class="login-link">
                    <p class="text-muted mb-0">
                        Sudah punya akun?
                        <a href="index.php?controller=auth&action=login">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        class ModernAuthNotifier {
            constructor() {
                this.toastContainer = this.createToastContainer();
            }

            createToastContainer() {
                const container = document.createElement('div');
                container.id = 'toast-container';
                container.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 9999;
                `;
                document.body.appendChild(container);
                return container;
            }

            log(message, data = null) {
                console.log(`[MODERN REGISTER] ${message}`, data || '');
            }

            error(message, data = null) {
                console.error(`[MODERN REGISTER ERROR] ${message}`, data || '');
                this.showToast(message, 'danger');
            }

            success(message, data = null) {
                console.log(`[MODERN REGISTER SUCCESS] ${message}`, data || '');
                this.showToast(message, 'success');
            }

            warning(message, data = null) {
                console.warn(`[MODERN REGISTER WARNING] ${message}`, data || '');
                this.showToast(message, 'warning');
            }

            info(message, data = null) {
                console.info(`[MODERN REGISTER INFO] ${message}`, data || '');
                this.showToast(message, 'info');
            }

            showToast(message, type = 'info') {
                const toastId = 'toast-' + Date.now();
                const toastHtml = `
                    <div id="${toastId}" class="toast align-items-center text-white bg-${type} border-0 mb-2" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">
                                ${this.getToastIcon(type)} ${message}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                `;

                this.toastContainer.insertAdjacentHTML('beforeend', toastHtml);
                const toastElement = document.getElementById(toastId);
                const toast = new bootstrap.Toast(toastElement, { delay: 5000 });

                toastElement.addEventListener('hidden.bs.toast', () => {
                    toastElement.remove();
                });

                toast.show();
                this.log(`Toast shown: ${type} - ${message}`);
            }

            getToastIcon(type) {
                const icons = {
                    success: '<i class="fas fa-check-circle me-2"></i>',
                    danger: '<i class="fas fa-exclamation-triangle me-2"></i>',
                    warning: '<i class="fas fa-exclamation-circle me-2"></i>',
                    info: '<i class="fas fa-info-circle me-2"></i>'
                };
                return icons[type] || icons.info;
            }
        }

        class ModernRegisterHandler {
            constructor() {
                this.notifier = new ModernAuthNotifier();
                this.form = document.getElementById('registerForm');
                this.submitBtn = this.form.querySelector('button[type="submit"]');
                this.init();
            }

            init() {
                this.notifier.log('Modern register handler initialized');
                this.setupEventListeners();
                this.checkExistingMessages();

                this.notifier.log('=== BEFORE LOADING PROVINCES ===');
                this.notifier.log('Document ready state:', document.readyState);

                // Try to load provinsi after a short delay to ensure DOM is ready
                setTimeout(() => {
                    this.notifier.log('=== STARTING PROVINCES LOAD ===');
                    this.loadProvinsi();
                }, 100);

                this.notifier.log('=== MODERN REGISTER PAGE LOADED ===');
                this.notifier.log('Page URL:', window.location.href);
                this.notifier.log('User Agent:', navigator.userAgent);
                this.notifier.log('Screen Resolution:', `${screen.width}x${screen.height}`);
                this.notifier.log('Viewport Size:', `${window.innerWidth}x${window.innerHeight}`);
            }

            setupEventListeners() {
                this.form.addEventListener('submit', (e) => this.handleRegister(e));
                this.form.addEventListener('input', (e) => this.handleInput(e));
                this.form.addEventListener('focusin', (e) => this.handleFieldFocus(e));
                this.form.addEventListener('focusout', (e) => this.handleFieldBlur(e));

                document.getElementById('provinsi_id').addEventListener('change', () => this.loadKabupaten());
                document.getElementById('kabupaten_id').addEventListener('change', () => this.loadKecamatan());
                document.getElementById('kecamatan_id').addEventListener('change', () => this.loadDesa());
            }

            checkExistingMessages() {
                const errorAlert = document.querySelector('.alert-danger');
                const successAlert = document.querySelector('.alert-success');

                if (errorAlert) {
                    const errorMsg = errorAlert.textContent.trim();
                    this.notifier.error(errorMsg);
                }

                if (successAlert) {
                    const successMsg = successAlert.textContent.trim();
                    this.notifier.success(successMsg);
                }
            }

            handleInput(e) {
                const input = e.target;
                if (input.type === 'text' || input.type === 'email' || input.type === 'tel' || input.type === 'password' || input.tagName === 'TEXTAREA') {
                    this.notifier.log(`User typing in ${input.name}`, {
                        field: input.name,
                        fieldType: input.type,
                        valueLength: input.value.length,
                        hasValue: input.value.length > 0
                    });
                }

                if (input.id === 'password' || input.id === 'password_confirmation') {
                    this.validatePasswords();
                }

                if (input.id === 'email') {
                    this.validateEmail(input.value);
                }
            }

            handleFieldFocus(e) {
                const input = e.target;
                if (input.tagName === 'INPUT' || input.tagName === 'TEXTAREA' || input.tagName === 'SELECT') {
                    this.notifier.log(`Field focused: ${input.name || input.id}`, {
                        fieldType: input.type,
                        placeholder: input.placeholder,
                        required: input.required
                    });
                }
            }

            handleFieldBlur(e) {
                const input = e.target;
                if (input.tagName === 'INPUT' || input.tagName === 'TEXTAREA') {
                    this.notifier.log(`Field blurred: ${input.name || input.id}`, {
                        valueLength: input.value.length,
                        isEmpty: input.value.length === 0,
                        isValid: input.checkValidity()
                    });
                }
            }

            validateEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (email && !emailRegex.test(email)) {
                    this.notifier.warning('Format email tidak valid');
                } else if (email && emailRegex.test(email)) {
                    this.notifier.success('Email format valid');
                }
            }

            validatePasswords() {
                const password = document.getElementById('password').value;
                const passwordConfirm = document.getElementById('password_confirmation').value;

                if (passwordConfirm && password !== passwordConfirm) {
                    this.notifier.warning('Password dan konfirmasi password tidak cocok');
                } else if (passwordConfirm && password === passwordConfirm) {
                    this.notifier.success('Password cocok');
                }

                if (password.length > 0 && password.length < 8) {
                    this.notifier.warning('Password sebaiknya minimal 8 karakter untuk keamanan');
                } else if (password.length >= 8) {
                    this.notifier.success('Password strength adequate');
                }
            }

            async handleRegister(e) {
                e.preventDefault();

                const formData = new FormData(this.form);
                const registerData = Object.fromEntries(formData.entries());

                this.notifier.log('=== REGISTRATION ATTEMPT STARTED ===');
                this.notifier.log('Form data collected:', {
                    fields: Object.keys(registerData),
                    data: registerData,
                    totalFields: Object.keys(registerData).length
                });

                if (registerData.password !== registerData.password_confirmation) {
                    this.notifier.error('Password dan konfirmasi password tidak cocok!');
                    return;
                }

                this.setLoadingState(true);

                try {
                    this.notifier.log('Sending registration request to server...');
                    const response = await fetch('index.php?controller=auth&action=register', {
                        method: 'POST',
                        body: formData
                    });

                    this.notifier.log('=== REGISTRATION RESPONSE RECEIVED ===');
                    this.notifier.log('Response details:', {
                        status: response.status,
                        statusText: response.statusText,
                        url: response.url,
                        headers: Object.fromEntries(response.headers.entries()),
                        ok: response.ok,
                        redirected: response.redirected,
                        type: response.type
                    });

                    const responseText = await response.text();

                    this.notifier.log('=== REGISTRATION RESPONSE ANALYSIS ===');
                    this.notifier.log('Response analysis:', {
                        responseLength: responseText.length,
                        containsError: responseText.includes('alert-danger'),
                        containsSuccess: responseText.includes('alert-success'),
                        containsFormValidation: responseText.includes('Perbaiki kesalahan'),
                        isRedirect: response.redirected,
                        finalUrl: response.url,
                        contentType: response.headers.get('content-type')
                    });

                    let jsonData = null;
                    try {
                        jsonData = JSON.parse(responseText);
                        this.notifier.log('Response parsed as JSON:', jsonData);
                    } catch (jsonError) {
                        this.notifier.log('Response is HTML, not JSON');
                        this.notifier.log('HTML response preview:', responseText.substring(0, 200));
                    }

                    if (response.ok && !responseText.includes('alert-danger') && !responseText.includes('Perbaiki kesalahan')) {
                        this.notifier.success('Registrasi berhasil! Mengarahkan ke halaman login...');
                        this.notifier.log('=== REGISTRATION SUCCESSFUL ===');
                        this.notifier.log('Registration successful details:', {
                            redirectUrl: response.url,
                            hasJsonData: jsonData !== null,
                            responseData: jsonData,
                            responseHeaders: Object.fromEntries(response.headers.entries())
                        });

                        setTimeout(() => {
                            this.notifier.log('Redirecting to login page...');
                            window.location.href = 'index.php?controller=auth&action=login';
                        }, 2000);
                    } else {
                        this.notifier.log('=== REGISTRATION FAILED ===');
                        const errorMatch = responseText.match(/alert-danger[^>]*>([^<]+)/);
                        const validationMatch = responseText.match(/<li>([^<]+)<\/li>/g);

                        let errorMessage = 'Registrasi gagal. Periksa kembali data Anda.';
                        if (errorMatch) {
                            errorMessage = errorMatch[1].trim();
                        } else if (validationMatch) {
                            errorMessage = validationMatch.map(item => item.replace(/<[^>]*>/g, '')).join(', ');
                        }

                        this.notifier.error(errorMessage);
                        this.notifier.log('Registration failure details:', {
                            status: response.status,
                            statusText: response.statusText,
                            responseHeaders: Object.fromEntries(response.headers.entries()),
                            responseText: responseText.substring(0, 1000),
                            fullResponseLength: responseText.length,
                            jsonData: jsonData,
                            errorMessage: errorMessage
                        });
                    }
                } catch (error) {
                    this.notifier.log('=== REGISTRATION NETWORK ERROR ===');
                    this.notifier.error('Terjadi gangguan koneksi. Silakan coba lagi.');
                    this.notifier.error('Network error details:', {
                        message: error.message,
                        name: error.name,
                        stack: error.stack
                    });
                    this.notifier.log('Registration network error analysis:', {
                        errorType: error.constructor.name,
                        isNetworkError: error instanceof TypeError || error instanceof NetworkError,
                        errorMessage: error.message,
                        onlineStatus: navigator.onLine,
                        connectionType: navigator.connection ? navigator.connection.effectiveType : 'unknown'
                    });
                } finally {
                    this.setLoadingState(false);
                    this.notifier.log('=== REGISTRATION ATTEMPT COMPLETED ===');
                }
            }

            async loadProvinsi() {
                this.notifier.log('=== LOADING PROVINCES DATA ===');
                alert('loadProvinsi called!');
                try {
                    this.notifier.log('Making API request to: index.php?controller=wilayah&action=getProvinsi');

                    const response = await fetch('index.php?controller=wilayah&action=getProvinsi', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });

                    this.notifier.log('Provinces API response:', {
                        status: response.status,
                        statusText: response.statusText,
                        ok: response.ok,
                        url: response.url,
                        headers: Object.fromEntries(response.headers.entries())
                    });

                    const responseText = await response.text();
                    this.notifier.log('Raw response text:', responseText.substring(0, 500));

                    let data;
                    try {
                        data = JSON.parse(responseText);
                    } catch (jsonError) {
                        this.notifier.error('Failed to parse JSON response:', jsonError.message);
                        return;
                    }

                    this.notifier.log('Provinces data analysis:', {
                        success: data.success,
                        count: data.data ? data.data.length : 0,
                        message: data.message,
                        hasData: !!data.data,
                        dataType: typeof data.data
                    });

                    const select = document.getElementById('provinsi_id');
                    if (!select) {
                        this.notifier.error('Provinsi select element not found!');
                        return;
                    }

                    select.innerHTML = '<option value="">Pilih Provinsi</option>';

                    if (data.success && data.data && Array.isArray(data.data)) {
                        data.data.forEach((provinsi, index) => {
                            const option = document.createElement('option');
                            option.value = provinsi.id;
                            option.textContent = provinsi.nama;
                            select.appendChild(option);
                        });
                        this.notifier.success(`${data.data.length} provinsi berhasil dimuat`);
                        this.notifier.log('Provinces options created successfully:', {
                            count: data.data.length,
                            firstProvince: data.data[0],
                            lastProvince: data.data[data.data.length - 1]
                        });
                    } else {
                        this.notifier.warning('Gagal memuat data provinsi');
                        this.notifier.log('Provinces API unexpected response:', data);
                    }
                } catch (error) {
                    this.notifier.error('Gagal menghubungi server untuk data provinsi');
                    this.notifier.error('Provinces API error:', {
                        message: error.message,
                        name: error.name,
                        stack: error.stack
                    });
                }
            }

            async loadKabupaten() {
                const provinsiId = document.getElementById('provinsi_id').value;
                const select = document.getElementById('kabupaten_id');
                const kecamatanSelect = document.getElementById('kecamatan_id');
                const desaSelect = document.getElementById('desa_id');

                if (!provinsiId) {
                    select.disabled = true;
                    kecamatanSelect.disabled = true;
                    desaSelect.disabled = true;
                    return;
                }

                this.notifier.log(`=== LOADING KABUPATEN FOR PROVINCE: ${provinsiId} ===`);

                try {
                    const response = await fetch(`index.php?controller=wilayah&action=getKabupaten&id=${provinsiId}`);
                    const data = await response.json();

                    this.notifier.log('Kabupaten API response:', {
                        status: response.status,
                        success: data.success,
                        count: data.data ? data.data.length : 0
                    });

                    select.disabled = false;
                    kecamatanSelect.disabled = true;
                    desaSelect.disabled = true;
                    select.innerHTML = '<option value="">Pilih Kabupaten</option>';

                    if (data.success && data.data && Array.isArray(data.data)) {
                        data.data.forEach(kabupaten => {
                            const option = document.createElement('option');
                            option.value = kabupaten.id;
                            option.textContent = kabupaten.nama;
                            select.appendChild(option);
                        });
                        this.notifier.success(`${data.data.length} kabupaten berhasil dimuat`);
                    } else {
                        this.notifier.warning('Gagal memuat data kabupaten');
                    }
                } catch (error) {
                    this.notifier.error('Gagal menghubungi server untuk data kabupaten');
                    this.notifier.error('Kabupaten API error:', error);
                }
            }

            async loadKecamatan() {
                const kabupatenId = document.getElementById('kabupaten_id').value;
                const select = document.getElementById('kecamatan_id');
                const desaSelect = document.getElementById('desa_id');

                if (!kabupatenId) {
                    select.disabled = true;
                    desaSelect.disabled = true;
                    return;
                }

                this.notifier.log(`=== LOADING KECAMATAN FOR KABUPATEN: ${kabupatenId} ===`);

                try {
                    const response = await fetch(`index.php?controller=wilayah&action=getKecamatan&id=${kabupatenId}`);
                    const data = await response.json();

                    select.disabled = false;
                    desaSelect.disabled = true;
                    select.innerHTML = '<option value="">Pilih Kecamatan</option>';

                    if (data.success && data.data && Array.isArray(data.data)) {
                        data.data.forEach(kecamatan => {
                            const option = document.createElement('option');
                            option.value = kecamatan.id;
                            option.textContent = kecamatan.nama;
                            select.appendChild(option);
                        });
                        this.notifier.success(`${data.data.length} kecamatan berhasil dimuat`);
                    } else {
                        this.notifier.warning('Gagal memuat data kecamatan');
                    }
                } catch (error) {
                    this.notifier.error('Gagal menghubungi server untuk data kecamatan');
                    this.notifier.error('Kecamatan API error:', error);
                }
            }

            async loadDesa() {
                const kecamatanId = document.getElementById('kecamatan_id').value;
                const select = document.getElementById('desa_id');

                if (!kecamatanId) {
                    select.disabled = true;
                    return;
                }

                this.notifier.log(`=== LOADING DESA FOR KECAMATAN: ${kecamatanId} ===`);

                try {
                    const response = await fetch(`index.php?controller=wilayah&action=getDesa&id=${kecamatanId}`);
                    const data = await response.json();

                    select.disabled = false;
                    select.innerHTML = '<option value="">Pilih Desa</option>';

                    if (data.success && data.data && Array.isArray(data.data)) {
                        data.data.forEach(desa => {
                            const option = document.createElement('option');
                            option.value = desa.id;
                            option.textContent = desa.nama;
                            select.appendChild(option);
                        });
                        this.notifier.success(`${data.data.length} desa berhasil dimuat`);
                    } else {
                        this.notifier.warning('Gagal memuat data desa');
                    }
                } catch (error) {
                    this.notifier.error('Gagal menghubungi server untuk data desa');
                    this.notifier.error('Desa API error:', error);
                }
            }

            setLoadingState(loading) {
                if (loading) {
                    this.submitBtn.disabled = true;
                    this.submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mendaftar...';
                    this.notifier.info('Sedang memproses pendaftaran...');
                    this.notifier.log('Loading state activated');
                } else {
                    this.submitBtn.disabled = false;
                    this.submitBtn.innerHTML = '<i class="fas fa-user-plus"></i> <span>Daftar Sekarang</span>';
                    this.notifier.log('Loading state cleared');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const modernRegister = new ModernRegisterHandler();
            modernRegister.notifier.log('=== MODERN REGISTER PAGE FULLY LOADED ===');
        });
    </script>
</body>
</html>