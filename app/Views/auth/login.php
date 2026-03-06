<!DOCTYPE html>
<?php
/** @var \CodeIgniter\View\View $this */
$settingsModel = new \App\Models\SettingsModel();
$appName = $settingsModel->getValue('app_name', 'Geotagging App');
$appLogo = $settingsModel->getValue('logo_login', '');
$headerColor = $settingsModel->getValue('header_color', '#0f172a');
?>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Access -
        <?= esc($appName)?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary: #1e3c72;
            --primary-dark: #0f172a;
            --accent: #2a5298;
            --accent-green: #27ae60;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3c72 25%, #2a5298 50%, #27ae60 75%, #1e3c72 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
            position: relative;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Animated background blobs */
        body::before,
        body::after {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            filter: blur(100px);
            z-index: -1;
            opacity: 0.1;
        }

        body::before {
            top: -200px;
            left: -200px;
            background: radial-gradient(circle, #ffffff 0%, transparent 70%);
            animation: float 20s infinite alternate;
        }

        body::after {
            bottom: -200px;
            right: -200px;
            background: radial-gradient(circle, #27ae60 0%, transparent 70%);
            animation: float 25s infinite alternate-reverse;
        }

        @keyframes float {
            from { transform: translate(0, 0); }
            to { transform: translate(100px, 100px); }
        }

        .login-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 28px;
            box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.3), inset 1px 1px 0 rgba(255, 255, 255, 0.6);
            overflow: hidden;
            width: 100%;
            max-width: 1100px;
            display: flex;
            min-height: 620px;
            margin: 20px;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .login-card:hover {
            box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.4);
            transform: translateY(-5px);
        }

        .login-sidebar {
            background: linear-gradient(135deg, #1e3c72 0%, #0f172a 50%, #2a5298 100%);
            width: 50%;
            padding: 70px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .login-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 0% 0%, rgba(255,255,255,0.1) 0%, transparent 50%),
                        radial-gradient(circle at 100% 100%, rgba(39, 174, 96, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .login-form {
            width: 50%;
            padding: 70px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            position: relative;
        }

        .login-form::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(42, 82, 152, 0.05) 0%, transparent 70%);
            z-index: 0;
        }

        .circles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            opacity: 0.15;
            pointer-events: none;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            border: 2px solid white;
        }

        .form-control {
            padding: 16px 20px;
            border-radius: 14px;
            background-color: rgba(248, 250, 252, 0.7);
            border: 1.5px solid #e2e8f0;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            color: #0f172a;
        }

        .form-control:focus {
            background-color: white;
            border-color: #2a5298;
            box-shadow: 0 0 0 5px rgba(42, 82, 152, 0.1), 0 10px 25px -5px rgba(42, 82, 152, 0.2);
            transform: translateY(-2px);
        }

        .form-control::placeholder {
            color: #cbd5e1;
            font-weight: 600;
        }

        .input-group-text {
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.8) 0%, rgba(242, 244, 246, 0.8) 100%) !important;
            border: 1.5px solid #e2e8f0;
            color: #64748b;
        }

        .btn-login {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #27ae60 100%);
            border: none;
            padding: 16px;
            border-radius: 14px;
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: white;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
            font-size: 0.9rem;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 20px 50px -10px rgba(30, 60, 114, 0.4);
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:active {
            transform: scale(0.98);
        }

        .alert {
            border-radius: 14px;
            border: none;
            backdrop-filter: blur(10px);
            animation: slideDown 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2, h3, h4, h5 {
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
        }

        .form-label {
            font-weight: 800;
            color: #475569;
            letter-spacing: 0.5px;
        }

        .text-muted {
            color: #94a3b8 !important;
        }

        @media (max-width: 768px) {
            .login-sidebar {
                display: none;
            }
            .login-form {
                width: 100%;
                padding: 50px;
            }
            .login-card {
                min-height: auto;
                border-radius: 24px;
            }
            body::before,
            body::after {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-sidebar">
            <div class="circles">
                <div class="circle" style="width: 400px; height: 400px; top: -150px; left: -150px;"></div>
                <div class="circle" style="width: 300px; height: 300px; bottom: -50px; right: -100px;"></div>
            </div>
            <div class="position-relative z-1">
                <div class="mb-4">
                    <?php if ($appLogo): ?>
                    <img src="<?= base_url($appLogo)?>" alt="Logo" style="height: 120px; width: auto; display: inline-block;">
                    <?php
else: ?>
                    <div class="rounded-4 d-flex align-items-center justify-content-center"
                        style="width: 80px; height: 80px; background: rgba(255,255,255,0.2);">
                        <i class="bi bi-shield-lock-fill fs-1 text-white"></i>
                    </div>
                    <?php
endif; ?>
                </div>
                <h2 class="fw-800 mb-2 fs-1">Command Center</h2>
                <h4 class="fw-400 opacity-75 mb-4">
                    <?= esc($appName)?>
                </h4>
                <div class="mt-5 pt-4 border-top border-white border-opacity-10">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-2 bg-white bg-opacity-10 rounded-3">
                            <i class="bi bi-fingerprint fs-5"></i>
                        </div>
                        <p class="mb-0 small fw-500 opacity-75">Secure Encrypted Authentication</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="login-form">
            <div class="mb-5">
                <h3 class="fw-800 text-dark mb-1">Administrator Login</h3>
                <p class="text-muted fw-500">Silakan masukkan kredensial untuk melanjutkan.</p>
            </div>
            <?php if (session()->getFlashdata('error')): ?>
            <div
                class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger py-3 rounded-4 small mb-4 d-flex align-items-center">
                <i class="bi bi-exclamation-octagon-fill fs-5 me-3"></i>
                <div class="fw-700">
                    <?= session()->getFlashdata('error')?>
                </div>
            </div>
            <?php
endif; ?>
            <form action="<?= base_url('auth/attemptLogin')?>" method="post">
                <div class="mb-4">
                    <label class="form-label small fw-800 text-uppercase text-muted mb-2"
                        style="font-size: 0.7rem; letter-spacing: 1px;">Username Account</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i
                                class="bi bi-person-fill text-muted"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="ID Pengguna" required
                            autofocus>
                    </div>
                </div>
                <div class="mb-5">
                    <label class="form-label small fw-800 text-uppercase text-muted mb-2"
                        style="font-size: 0.7rem; letter-spacing: 1px;">Security Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i
                                class="bi bi-lock-fill text-muted"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-login w-100 py-3 text-white shadow-lg">
                    MASUK KE SISTEM <i class="bi bi-box-arrow-in-right ms-2"></i>
                </button>
            </form>
            <div class="mt-auto pt-5 text-center">
                <a href="<?= base_url()?>"
                    class="text-decoration-none text-muted small fw-700 hover-primary d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-house-door-fill"></i> KEMBALI KE PORTAL UTAMA
                </a>
            </div>
        </div>
    </div>
</body>
</html>