<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
My Documents
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">My Documents</h4>
        <a href="<?= site_url('encoder/new') ?>" class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i> Register New Document</a>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <p class="card-text">This page lists all the documents you have registered in the system.</p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Tracking #</th>
                        <th>Title</th>
                        <th>Origin Office</th>
                        <th>Current Office</th>
                        <th>Date Filed</th>
                        <th>Status</th>
                        <!-- NEW HEADER -->
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($documents)): foreach ($documents as $doc): ?>
                        <tr>
                            <td><strong><?= esc($doc['tracking_number']) ?></strong></td>
                            <td><?= esc($doc['title']) ?></td>
                            <td><?= esc($doc['origin_office_name']) ?></td>
                            <td><?= esc($doc['current_office_name'] ?? 'N/A') ?></td>
                            <td><?= date('M j, Y h:i A', strtotime($doc['date_created'])) ?></td>
                            <td>
                                <?php 
                                    $statusBadge = 'bg-secondary';
                                    if ($doc['current_status'] == 'Pending') $statusBadge = 'bg-warning';
                                    if ($doc['current_status'] == 'Forwarded') $statusBadge = 'bg-info';
                                    if ($doc['current_status'] == 'Complete') $statusBadge = 'bg-success';
                                ?>
                                <span class="badge <?= $statusBadge ?>"><?= esc($doc['current_status']) ?></span>
                            </td>
                            <!-- NEW ACTION CELL -->
                            <td class="text-center">
                                <a href="<?= site_url('encoder/history/' . $doc['document_id']) ?>" class="btn btn-sm btn-info" title="View History">
                                    <i class="bi bi-clock-history"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <!-- UPDATE COLSPAN TO 7 -->
                            <td colspan="7" class="text-center">You have not created any documents yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>