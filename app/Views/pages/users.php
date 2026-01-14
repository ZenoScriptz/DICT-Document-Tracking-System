<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Manage Users
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Manage Users</h4>
        <a href="<?= base_url('adduser') ?>" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Add New User</a>
    </div>
    <div class="card-body">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Fullname</th>
                        <th scope="col">Username</th>
                        <th scope="col">Role</th>
                        <th scope="col">Office</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($user)): foreach ($user as $u): ?>
                        <tr>
                            <td><?= esc($u['user_id']) ?></td>
                            <td><?= esc($u['fullname']) ?></td>
                            <td><?= esc($u['username']) ?></td>
                            <td>
                                <?php 
                                    $roleBadge = 'bg-secondary';
                                    if ($u['role'] == 'admin') $roleBadge = 'bg-primary';
                                    if ($u['role'] == 'staff') $roleBadge = 'bg-info';
                                    if ($u['role'] == 'encoder') $roleBadge = 'bg-dark';
                                ?>
                                <span class="badge <?= $roleBadge ?>"><?= ucfirst(esc($u['role'])) ?></span>
                            </td>
                            <td><?= esc($u['office_name']) ?></td>
                            <td>
                                <span class="badge <?= $u['status'] == 'active' ? 'bg-success' : 'bg-danger' ?>">
                                    <?= ucfirst(esc($u['status'])) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('edituser/' . $u['user_id']) ?>" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                                <a href="<?= base_url('deleteuser/' . $u['user_id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');"><i class="bi bi-trash-fill"></i> Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>