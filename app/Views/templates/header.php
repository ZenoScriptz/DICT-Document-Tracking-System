<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background: linear-gradient(90deg, var(--dict-blue) 0%, var(--dict-dark-blue) 100%);">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= site_url('dashboard') ?>">
            <!-- You can uncomment this if you want the small image logo in header too -->
            <!-- <img src="<?= base_url('assets/img/DICT-Logo-2.jpg') ?>" height="30" alt="Logo" class="rounded-circle bg-white p-1"> -->
            <i class="bi bi-file-earmark-text-fill"></i>
            <span class="fw-semibold">DICT Tracker</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                
                <!-- STAFF LINK -->
               <?php if (session()->get('role') === 'staff' || session()->get('role') === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('staff') ?>">
                        <i class="bi bi-inbox-fill me-1"></i> My Office Inbox
                    </a>
                </li>
                <?php endif; ?>

                <!-- ADMIN REPORTS -->
                <?php if (session()->get('role') === 'admin'): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bar-chart-fill me-1"></i> Reports
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="reportsDropdown">
                        <li><a class="dropdown-item" href="<?= site_url('admin/documents') ?>">All Documents</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header text-uppercase small fw-bold">Generate Reports</h6></li>
                        <li><a class="dropdown-item" href="<?= site_url('reports/pending') ?>">Pending Documents</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('reports/completed') ?>">Completed Documents</a></li>
                        <li><a class="dropdown-item" href="<?= site_url('reports/history') ?>">History Search</a></li>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- USER PROFILE -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i> 
                        <?= session()->get('fullname') ?? 'User' ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="navbarUserDropdown">
                        <li class="px-3 py-2 text-muted small">
                            Signed in as <br><strong><?= ucfirst(session()->get('role') ?? 'Guest') ?></strong>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= site_url('profile') ?>">My Profile</a></li>
                        <li><a class="dropdown-item text-danger" href="<?= site_url('logout') ?>"><i class="bi bi-box-arrow-right me-1"></i> Logout</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>