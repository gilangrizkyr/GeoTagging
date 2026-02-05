<?php /** @var \CodeIgniter\View\View $this */?>
<?php $this->extend('layouts/admin')?>

<?php $this->section('title')?>
Registrasi Personel Baru
<?php $this->endSection()?>

<?php $this->section('styles')?>
<style>
    .password-toggle {
        cursor: pointer;
        transition: all 0.2s;
    }

    .password-toggle:hover {
        color: var(--primary) !important;
    }

    .validation-badge {
        font-size: 0.7rem;
        font-weight: 700;
        display: none;
        margin-top: 0.5rem;
    }
</style>
<?php $this->endSection()?>

<?php $this->section('content')?>
<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-8">

        <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger border-0 shadow-sm rounded-4 p-3 mb-4">
            <div class="fw-800 small text-uppercase mb-2"><i class="bi bi-shield-exclamation me-2"></i> Validasi Gagal:
            </div>
            <ul class="mb-0 small fw-600">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li>
                    <?= $error?>
                </li>
                <?php
    endforeach ?>
            </ul>
        </div>
        <?php
endif; ?>

        <div class="card card-premium overflow-hidden">
            <div class="card-header bg-white py-4 px-4 border-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 bg-light rounded-4 text-primary">
                        <i class="bi bi-person-plus-fill fs-3"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-800 text-dark">Registrasi Akun Personel</h5>
                        <p class="text-muted small mb-0 fw-500">Tambahkan otoritas baru untuk akses sistem intelijen
                            spasial.</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4 p-lg-5 pt-2">
                <form action="<?= base_url('admin/users/store')?>" method="post" id="userForm">

                    <div class="mb-4">
                        <label class="form-label fw-700 small mb-2 text-muted text-uppercase"
                            style="letter-spacing: 0.5px;">Username Otoritas <span class="text-danger">*</span></label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-person-badge text-muted"></i></span>
                            <input type="text" name="username" class="form-control fw-600 border-start-0 ps-0"
                                placeholder="Contoh: GilangRizky" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-700 small mb-2 text-muted text-uppercase"
                                style="letter-spacing: 0.5px;">Kata Sandi <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light border-end-0"><i
                                        class="bi bi-shield-lock text-muted"></i></span>
                                <input type="password" name="password" id="password"
                                    class="form-control fw-600 border-start-0 border-end-0 ps-0"
                                    placeholder="Minimal 8 karakter" required>
                                <span class="input-group-text bg-light border-start-0 password-toggle"
                                    onclick="togglePassword('password', this)">
                                    <i class="bi bi-eye-fill text-muted"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-700 small mb-2 text-muted text-uppercase"
                                style="letter-spacing: 0.5px;">Konfirmasi Sandi <span
                                    class="text-danger">*</span></label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light border-end-0"><i
                                        class="bi bi-shield-check text-muted"></i></span>
                                <input type="password" name="password_conf" id="password_conf"
                                    class="form-control fw-600 border-start-0 border-end-0 ps-0"
                                    placeholder="Ulangi sandi" required>
                                <span class="input-group-text bg-light border-start-0 password-toggle"
                                    onclick="togglePassword('password_conf', this)">
                                    <i class="bi bi-eye-fill text-muted"></i>
                                </span>
                            </div>
                            <div id="match-status" class="validation-badge"></div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-700 small mb-2 text-muted text-uppercase"
                            style="letter-spacing: 0.5px;">Security Clearance (Role) <span
                                class="text-danger">*</span></label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check card-premium p-3 border h-100" style="cursor: pointer;">
                                    <input class="form-check-input ms-0 me-3" type="radio" name="role"
                                        id="role-operator" value="operator" checked>
                                    <label class="form-check-label fw-800 text-dark" for="role-operator">
                                        OPERATOR
                                        <div class="fw-500 small text-muted mt-1 opacity-75">Akses operasional harian.
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check card-premium p-3 border h-100" style="cursor: pointer;">
                                    <input class="form-check-input ms-0 me-3" type="radio" name="role" id="role-admin"
                                        value="admin">
                                    <label class="form-check-label fw-800 text-dark" for="role-admin">
                                        ADMINISTRATOR
                                        <div class="fw-500 small text-muted mt-1 opacity-75">Otoritas penuh sistem.
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-top d-flex gap-2">
                        <button type="submit" id="btn-submit"
                            class="btn btn-primary px-5 py-3 fw-800 rounded-3 shadow-lg flex-grow-1">
                            <i class="bi bi-check-all me-2"></i> AKTIFKAN AKUN PERSONEL
                        </button>
                        <a href="<?= base_url('admin/users')?>"
                            class="btn btn-light px-4 py-3 fw-700 rounded-3 border text-muted">CANCEL</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection()?>

<?php $this->section('scripts')?>
<script>
    function togglePassword(inputId, el) {
        const input = document.getElementById(inputId);
        const icon = el.querySelector('i');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
        } else {
            input.type = "password";
            icon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
        }
    }

    const password = document.getElementById('password');
    const confirm = document.getElementById('password_conf');
    const status = document.getElementById('match-status');
    const btn = document.getElementById('btn-submit');

    function validatePassword() {
        if (!confirm.value) {
            status.style.display = 'none';
            btn.disabled = false;
            return;
        }

        status.style.display = 'block';
        if (password.value === confirm.value) {
            status.textContent = '✓ Password Cocok';
            status.className = 'validation-badge text-success';
            btn.disabled = false;
        } else {
            status.textContent = '✕ Password Belum Sama';
            status.className = 'validation-badge text-danger';
            btn.disabled = true;
        }
    }

    password.addEventListener('input', validatePassword);
    confirm.addEventListener('input', validatePassword);

    document.getElementById('userForm').addEventListener('submit', function (e) {
        if (password.value !== confirm.value) {
            e.preventDefault();
            alert('Password tidak cocok satu sama lain.');
        }
    });
</script>
<?php $this->endSection()?>