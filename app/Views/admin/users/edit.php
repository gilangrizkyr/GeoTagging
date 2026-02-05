<?php /** @var \CodeIgniter\View\View $this */?>
<?php /** @var \CodeIgniter\View\View $this */?>
<?php $this->extend('layouts/admin')?>

<?php $this->section('content')?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <h3>Edit User</h3>

        <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
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

        <div class="card mt-3">
            <div class="card-body">
                <form action="<?= base_url('admin/users/update/' . $user['id'])?>" method="post">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?= esc($user['username'])?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <label>Password (Biarkan kosong jika tidak diganti)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-select" required>
                            <option value="operator" <?= $user['role'] == 'operator' ? 'selected' : '' ?>>Operator</option>
                            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="<?= base_url('admin/users')?>" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection()?>