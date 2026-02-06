<!DOCTYPE html>
<?php
/** @var \CodeIgniter\View\View $this */
$settingsModel = new \App\Models\SettingsModel();
$appName = $settingsModel->getValue('app_name', 'Geotagging App');
$appLogo = $settingsModel->getValue('app_logo', '');
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
            --primary: #0f172a;
            --primary-dark: #020617;
            --accent: #3b82f6;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f1f5f9;
            background-image:
                radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.05) 0, transparent 50%),
                radial-gradient(at 100% 100%, rgba(59, 130, 246, 0.05) 0, transparent 50%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 1000px;
            display: flex;
            min-height: 600px;
            margin: 20px;
        }
        .login-sidebar {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            width: 50%;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .login-form {
            width: 50%;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
        }
        .circles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            opacity: 0.1;
            pointer-events: none;
        }
        .circle {
            position: absolute;
            border-radius: 50%;
            border: 2px solid white;
        }
        .form-control {
            padding: 14px 18px;
            border-radius: 12px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            background-color: white;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        .btn-login {
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(15, 23, 42, 0.4);
            opacity: 0.95;
        }
        @media (max-width: 768px) {
            .login-sidebar {
                display: none;
            }
            .login-form {
                width: 100%;
                padding: 40px;
            }
            .login-card {
                min-height: auto;
                border-radius: 20px;
            }
        }
        h2,
        h3,
        h4,
        h5 {
            font-family: 'Outfit', sans-serif;
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
                    <div class="d-inline-block bg-white rounded-4 p-3 shadow-lg">
                        <img src="<?= base_url($appLogo)?>" alt="Logo" style="height: 60px; width: auto;">
                    </div>
                    <?php
else: ?>
                    <div class="bg-white rounded-4 d-flex align-items-center justify-content-center shadow-lg"
                        style="width: 80px; height: 80px;">
                        <i class="bi bi-shield-lock-fill fs-1 text-primary"></i>
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