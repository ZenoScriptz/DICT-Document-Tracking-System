<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Pending Documents Report
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Pending Documents Report</h4>
    </div>
    <div class="card-body">
        <p class="card-text">This report shows all documents that are currently in 'Pending' or 'Forwarded' status.</p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Tracking #</th>
                        <th>Title</th>
                        <th>Origin Office</th>
                        <th>Current Office</th>
                        <th>Creator</th>
                        <th>Date Filed</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($documents)): foreach ($documents as $doc): ?>
                        <tr>
                            <td><strong><?= esc($doc['tracking_number']) ?></strong></td>
                            <td><?= esc($doc['title']) ?></td>
                            <td><?= esc($doc['origin_office_name']) ?></td>
                            <td><?= esc($doc['current_office_name']) ?></td>
                            <td><?= esc($doc['creator_name']) ?></td>
                            <td><?= date('M j, Y h:i A', strtotime($doc['date_created'])) ?></td>
                            <td>
                                <?php 
                                    $statusBadge = ($doc['current_status'] == 'Pending') ? 'bg-warning' : 'bg-info';
                                ?>
                                <span class="badge <?= $statusBadge ?>"><?= esc($doc['current_status']) ?></span>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No pending documents found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>