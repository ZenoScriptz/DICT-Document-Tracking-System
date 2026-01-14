<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Manage Offices
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Manage Offices</h4>
        <a href="<?= base_url('addoffice') ?>" class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i> Add New Office</a>
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
                        <th scope="col">ID</th>
                        <th scope="col">Office Name</th>
                        <th scope="col">Office Code</th>
                        <th scope="col">Description</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($off)): foreach ($off as $office): ?>
                        <tr>
                            <td><?= esc($office['office_id']) ?></td>
                            <td><?= esc($office['office_name']) ?></td>
                            <td><?= esc($office['office_code']) ?></td>
                            <td><?= esc($office['office_description']) ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('editoffice/' . $office['office_id']) ?>" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                                <a href="<?= base_url('deleteoffice/' . $office['office_id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this office?');"><i class="bi bi-trash-fill"></i> Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No offices found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>```

---

