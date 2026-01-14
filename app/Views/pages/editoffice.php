<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Edit Office
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Office</h5>
            </div>
            <div class="card-body">
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('updateoffice') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="office_id" value="<?= esc($off['office_id']) ?>">

                    <div class="mb-3">
                        <label for="office_name" class="form-label">Office Name</label>
                        <input type="text" class="form-control" id="office_name" name="office_name" value="<?= esc($off['office_name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="office_code" class="form-label">Office Code</label>
                        <input type="text" class="form-control" id="office_code" name="office_code" value="<?= esc($off['office_code']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="office_description" class="form-label">Office Description</label>
                        <textarea class="form-control" id="office_description" name="office_description" rows="3"><?= esc($off['office_description']) ?></textarea>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?= base_url('offices') ?>" class="btn btn-secondary me-md-2">Back to List</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill"></i> Update Office</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>