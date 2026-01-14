<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Edit User
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit User: <?= esc($user['fullname']) ?></h5>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul>
                        <?php foreach(session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('updateuser/'.$user['user_id']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Fullname</label>
                        <input type="text" name="fullname" class="form-control" value="<?= esc($user['fullname']) ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" value="<?= esc($user['username']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep existing">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
                                <option value="staff" <?= $user['role']=='staff'?'selected':'' ?>>Staff</option>
                                <option value="encoder" <?= $user['role']=='encoder'?'selected':'' ?>>Encoder</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" <?= $user['status']=='active'?'selected':'' ?>>Active</option>
                                <option value="inactive" <?= $user['status']=='inactive'?'selected':'' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Office</label>
                        <select name="office_id" class="form-select" required>
                            <?php foreach($offices as $o): ?>
                                <option value="<?= $o['office_id'] ?>" <?= $o['office_id']==$user['office_id']?'selected':'' ?>>
                                    <?= esc($o['office_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?= base_url('users') ?>" class="btn btn-secondary me-md-2">Back to List</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill"></i> Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>