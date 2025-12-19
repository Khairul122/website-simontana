<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMONTA BENCANA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .login-container {
            display: flex;
            height: 100vh;
            position: relative;
        }

        /* Left Panel - Branding */
        .brand-panel {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 20s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .brand-content {
            text-align: center;
            z-index: 2;
            max-width: 400px;
        }

        .brand-logo {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .brand-logo i {
            font-size: 3rem;
            color: white;
        }

        .brand-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            letter-spacing: -0.025em;
        }

        .brand-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .brand-features {
            text-align: left;
            margin-top: 3rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .feature-item i {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.1rem;
        }

        /* Right Panel - Login Form */
        .login-panel {
            flex: 1;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .login-header {
            padding: 3rem 3rem 1rem;
            text-align: center;
        }

        .login-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        .login-header p {
            color: #6b7280;
            font-size: 1rem;
            margin: 0;
        }

        .login-form-container {
            flex: 1;
            padding: 0 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-floating > label {
            color: #9ca3af;
            padding: 1rem 0.75rem;
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            color: #667eea;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 1rem 0.75rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            height: auto;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-login:disabled {
            opacity: 0.7;
            transform: none;
            box-shadow: none;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: #9ca3af;
            font-size: 0.875rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            padding: 0 1rem;
        }

        .role-badges {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .role-badge {
            background: #f3f4f6;
            color: #374151;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .role-badge i {
            font-size: 0.75rem;
        }

        .register-link {
            text-align: center;
            margin-top: 2rem;
            color: #6b7280;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #764ba2;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .brand-panel {
                display: none;
            }

            .login-panel {
                flex: 1;
            }

            .login-header {
                padding: 2rem 1.5rem 1rem;
            }

            .login-form-container {
                padding: 0 1.5rem 2rem;
            }
        }

        /* Toast Container */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            border-radius: 12px;
            border: none;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="row g-0">
            <div class="col-md-7">
                <div class="login-form">
                    <div class="text-center mb-4">
                        <i class="fas fa-shield-alt fa-3x text-danger mb-3"></i>
                        <h2 class="fw-bold text-dark">Selamat Datang</h2>
                        <p class="text-muted">Masuk ke akun SIMONTA BENCANA Anda</p>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php echo htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($success)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo htmlspecialchars($success); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="index.php?controller=auth&action=login">
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold">Username</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" class="form-control" id="username" name="username"
                                       placeholder="Masukkan username" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Masukkan password" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-login btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i> Masuk
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="index.php?controller=auth&action=register" class="text-decoration-none">
                                Belum punya akun? <strong>Daftar sekarang</strong>
                            </a>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <h6 class="text-muted mb-3">Akses Berdasarkan Peran</h6>
                        <div class="row">
                            <div class="col-6 col-md-3 mb-2">
                                <div class="text-center">
                                    <i class="fas fa-user-shield fa-2x text-primary mb-2"></i>
                                    <div class="small">Admin</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-2">
                                <div class="text-center">
                                    <i class="fas fa-user-tie fa-2x text-success mb-2"></i>
                                    <div class="small">Petugas BPBD</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-2">
                                <div class="text-center">
                                    <i class="fas fa-user-check fa-2x text-warning mb-2"></i>
                                    <div class="small">Operator Desa</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-2">
                                <div class="text-center">
                                    <i class="fas fa-user fa-2x text-info mb-2"></i>
                                    <div class="small">Warga</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="logo-section d-flex flex-column justify-content-center h-100">
                    <i class="fas fa-hand-holding-medical fa-4x text-danger mb-3"></i>
                    <h1>SIMONTA BENCANA</h1>
                    <p>Sistem Informasi Monitoring dan Penanganan Bencana</p>
                    <hr class="my-3">
                    <p class="small">
                        <strong>Fitur Utama:</strong><br>
                        " Pelaporan Bencana Real-time<br>
                        " Pemantauan Status Bencana<br>
                        " Koordinasi Tim Penanggulangan<br>
                        " Integrasi BMKG<br>
                        " Sistem Multi-Role
                    </p>
                    <div class="mt-auto">
                        <a href="#" class="text-muted text-decoration-none small">
                            <i class="fas fa-question-circle me-1"></i> Bantuan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        class AuthNotifier {
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
                console.log(`[AUTH] ${message}`, data || '');
            }

            error(message, data = null) {
                console.error(`[AUTH ERROR] ${message}`, data || '');
                this.showToast(message, 'danger');
            }

            success(message, data = null) {
                console.log(`[AUTH SUCCESS] ${message}`, data || '');
                this.showToast(message, 'success');
            }

            warning(message, data = null) {
                console.warn(`[AUTH WARNING] ${message}`, data || '');
                this.showToast(message, 'warning');
            }

            info(message, data = null) {
                console.info(`[AUTH INFO] ${message}`, data || '');
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

        class AuthHandler {
            constructor() {
                this.notifier = new AuthNotifier();
                this.form = document.querySelector('form');
                this.submitBtn = this.form.querySelector('button[type="submit"]');
                this.init();
            }

            init() {
                this.notifier.log('Auth handler initialized');
                this.setupEventListeners();
                this.checkExistingMessages();
            }

            setupEventListeners() {
                this.form.addEventListener('submit', (e) => this.handleLogin(e));
                this.form.addEventListener('input', (e) => this.handleInput(e));
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
                if (input.type === 'text' || input.type === 'password') {
                    this.notifier.log(`User typing in ${input.name}`, {
                        field: input.name,
                        valueLength: input.value.length
                    });
                }
            }

            async handleLogin(e) {
                e.preventDefault();

                const formData = new FormData(this.form);
                const loginData = {
                    username: formData.get('username'),
                    password: formData.get('password')
                };

                this.notifier.log('Login attempt started', loginData);
                this.setLoadingState(true);

                try {
                    const response = await fetch('index.php?controller=auth&action=login', {
                        method: 'POST',
                        body: formData
                    });

                    this.notifier.log('Login response received', {
                        status: response.status,
                        statusText: response.statusText,
                        url: response.url,
                        headers: Object.fromEntries(response.headers.entries()),
                        ok: response.ok,
                        redirected: response.redirected
                    });

                    const responseText = await response.text();

                    this.notifier.log('API Response Details', {
                        responseLength: responseText.length,
                        containsError: responseText.includes('alert-danger'),
                        containsSuccess: responseText.includes('alert-success') || responseText.includes('dashboard'),
                        isRedirect: response.redirected,
                        finalUrl: response.url
                    });

                    // Try to parse as JSON if possible
                    let jsonData = null;
                    try {
                        jsonData = JSON.parse(responseText);
                        this.notifier.log('API Response JSON', jsonData);
                    } catch (jsonError) {
                        this.notifier.log('Response is not JSON, treating as HTML');
                    }

                    if (response.ok && !responseText.includes('alert-danger')) {
                        this.notifier.success('Login berhasil! Mengarahkan ke dashboard...');
                        this.notifier.log('Login successful', {
                            redirectUrl: response.url,
                            hasJsonData: jsonData !== null,
                            jsonData: jsonData
                        });

                        setTimeout(() => {
                            window.location.href = response.url || 'index.php';
                        }, 1500);
                    } else {
                        const errorMatch = responseText.match(/alert-danger[^>]*>([^<]+)/);
                        const errorMessage = errorMatch ? errorMatch[1].trim() : 'Login gagal. Periksa kembali username dan password.';

                        this.notifier.error(errorMessage);
                        this.notifier.log('Login failed', {
                            status: response.status,
                            statusText: response.statusText,
                            responseHeaders: Object.fromEntries(response.headers.entries()),
                            responseText: responseText.substring(0, 500),
                            fullResponseLength: responseText.length,
                            jsonData: jsonData
                        });
                    }
                } catch (error) {
                    this.notifier.error('Terjadi gangguan koneksi. Silakan coba lagi.');
                    this.notifier.error('Network error', {
                        message: error.message,
                        name: error.name,
                        stack: error.stack
                    });
                    this.notifier.log('Network error details', {
                        errorType: error.constructor.name,
                        isNetworkError: error instanceof TypeError || error instanceof NetworkError,
                        errorMessage: error.message
                    });
                } finally {
                    this.setLoadingState(false);
                }
            }

            setLoadingState(loading) {
                if (loading) {
                    this.submitBtn.disabled = true;
                    this.submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
                    this.notifier.info('Sedang memproses login...');
                } else {
                    this.submitBtn.disabled = false;
                    this.submitBtn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i> Masuk';
                    this.notifier.log('Loading state cleared');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            new AuthHandler();
        });
    </script>
</body>
</html>