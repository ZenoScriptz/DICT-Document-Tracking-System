<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Page Not Found
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="text-center py-5">
    <h1 class="display-1 text-danger">404</h1>
    <h2 class="mb-4">Page Not Found</h2>
    <p class="lead text-muted mb-4">
        Sorry, we couldn't find the page you were looking for.
    </p>
    <a href="<?= site_url('dashboard') ?>" class="btn btn-primary">Go to Dashboard</a>
</div>

<?= $this->endSection() ?>