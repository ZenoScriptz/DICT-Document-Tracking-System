<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Welcome Header -->
<div class="mb-5 position-relative">
    <!-- Decorative Accent Line (Matches Login) -->
    <div style="width: 60px; height: 4px; background: linear-gradient(to right, var(--dict-yellow), var(--dict-red)); border-radius: 2px; margin-bottom: 1rem;"></div>
    
    <h2 class="fw-bold" style="color: var(--dict-dark-blue);">Welcome Back, <?= session()->get('fullname') ?? 'User' ?>!</h2>
    <div class="d-flex justify-content-between align-items-end flex-wrap">
        <p class="text-muted mb-0">
            Role: <span class="badge rounded-pill bg-secondary"><?= ucfirst(session()->get('role') ?? 'Guest') ?></span>
        </p>
        <p class="text-primary fw-medium mb-0" id="current-time" style="color: var(--dict-blue) !important;"></p>
    </div>
</div>

<!-- =================================================================================== -->
<!-- ADMIN DASHBOARD CARDS -->
<!-- =================================================================================== -->
<?php if (session()->get('role') === 'admin'): ?>
<div class="row g-4">
    <!-- Total Documents: DICT Blue -->
    <div class="col-md-6 col-xl-3">
        <div class="card text-white h-100" style="background-color: var(--dict-blue);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title text-white-50 text-uppercase fs-7 fw-bold">Total Documents</h6>
                        <h2 class="display-5 fw-bold mb-0"><?= $totalDocuments ?? 0 ?></h2>
                    </div>
                    <i class="bi bi-files display-5 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Documents: DICT Yellow (Dark text for contrast) -->
    <div class="col-md-6 col-xl-3">
        <div class="card h-100" style="background-color: var(--dict-yellow); color: #333;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title text-uppercase fs-7 fw-bold opacity-75">Pending</h6>
                        <h2 class="display-5 fw-bold mb-0"><?= $pendingDocuments ?? 0 ?></h2>
                    </div>
                    <i class="bi bi-clock-history display-5 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Forwarded Documents: Cyan/Teal -->
    <div class="col-md-6 col-xl-3">
        <div class="card text-white h-100 bg-info bg-gradient">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title text-white-50 text-uppercase fs-7 fw-bold">Forwarded</h6>
                        <h2 class="display-5 fw-bold mb-0"><?= $forwardedDocuments ?? 0 ?></h2>
                    </div>
                    <i class="bi bi-send-fill display-5 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Completed Documents: Green -->
    <div class="col-md-6 col-xl-3">
        <div class="card text-white h-100 bg-success bg-gradient">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title text-white-50 text-uppercase fs-7 fw-bold">Completed</h6>
                        <h2 class="display-5 fw-bold mb-0"><?= $completedDocuments ?? 0 ?></h2>
                    </div>
                    <i class="bi bi-check2-circle display-5 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<!-- =================================================================================== -->
<!-- ENCODER DASHBOARD -->
<!-- =================================================================================== -->
<?php if (session()->get('role') === 'encoder'): ?>
<div class="row g-4">
    <div class="col-md-6">
        <a href="<?= site_url('encoder/new') ?>" class="text-decoration-none">
            <div class="card bg-success text-white h-100">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-bold">Add New Document</h5>
                        <span class="badge bg-white text-success mb-2">Newly Added: <?= $newlyAdded ?? 0 ?></span>
                        <p class="small opacity-75 mb-0">Click to encode a new entry</p>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-plus-lg fs-2"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-6">
        <a href="<?= site_url('my-documents') ?>" class="text-decoration-none">
            <div class="card bg-white border h-100">
                <div class="card-body p-4 d-flex justify-content-between align-items-center text-dark">
                    <div>
                        <h5 class="card-title fw-bold" style="color: var(--dict-blue)">My Documents</h5>
                        <p class="small text-muted mb-0">View history of encoded docs</p>
                    </div>
                    <div class="bg-light rounded-circle p-3">
                        <i class="bi bi-list-ul fs-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<?php endif; ?>


<!-- =================================================================================== -->
<!-- OFFICE STAFF DASHBOARD -->
<!-- =================================================================================== -->
<?php if (session()->get('role') === 'staff'): ?>
<div class="row g-4">
    <div class="col-md-6">
        <a href="<?= site_url('staff') ?>" class="text-decoration-none">
            <div class="card text-white h-100" style="background-color: var(--dict-blue);">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="display-6 fw-bold"><?= $assignedToOffice ?? 0 ?></h2>
                        <h5 class="card-title mb-0">Assigned to Office</h5>
                    </div>
                    <i class="bi bi-building fs-1 opacity-50"></i>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-6">
        <a href="<?= site_url('staff') ?>" class="text-decoration-none">
            <div class="card bg-danger text-white h-100">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="display-6 fw-bold"><?= $pendingInOffice ?? 0 ?></h2>
                        <h5 class="card-title mb-0">Action Required</h5>
                    </div>
                    <i class="bi bi-exclamation-circle fs-1 opacity-50"></i>
                </div>
            </div>
        </a>
    </div>
</div>
<?php endif; ?>


<!-- =================================================================================== -->
<!-- SYSTEM MANAGEMENT (ADMIN) -->
<!-- =================================================================================== -->
<?php if (session()->get('role') === 'admin'): ?>
<div class="mt-5">
    <h5 class="fw-bold text-muted text-uppercase small mb-4 ps-1">System Management</h5>
    
    <div class="row g-4">
        <!-- Office Management -->
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm hover-shadow">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="feature-icon rounded-3 me-4 d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background-color: rgba(0, 56, 168, 0.1); color: var(--dict-blue);">
                        <i class="bi bi-building fs-3"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-1">Office Management</h5>
                        <p class="text-muted small mb-2">Add, edit, or delete office records.</p>
                        <a href="<?= base_url('offices'); ?>" class="btn btn-sm btn-outline-primary stretched-link">Manage Offices</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Management -->
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm hover-shadow">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="feature-icon rounded-3 me-4 d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background-color: rgba(25, 135, 84, 0.1); color: #198754;">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-1">User Management</h5>
                        <p class="text-muted small mb-2">Manage accounts and roles.</p>
                        <a href="<?= base_url('users'); ?>" class="btn btn-sm btn-outline-success stretched-link">Manage Users</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Updated Date Script for clearer formatting
    function updateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour:'2-digit', minute:'2-digit', second:'2-digit' };
        const timeElem = document.getElementById('current-time');
        if (timeElem) {
            timeElem.innerText = now.toLocaleString('en-PH', options);
        }
    }
    setInterval(updateTime, 1000);
    updateTime(); 
</script>
<?= $this->endSection() ?>