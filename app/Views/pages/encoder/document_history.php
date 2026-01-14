<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Document History
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Document History</h4>
    </div>
    <div class="card-body">
        <div class="mb-4">
    <h5>Document Details</h5>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <strong>Tracking #:</strong> <?= esc($document['tracking_number']) ?>
        </li>
        <li class="list-group-item">
            <strong>Title:</strong> <?= esc($document['title']) ?>
        </li>
        <li class="list-group-item">
            <strong>Description:</strong> <?= esc($document['description']) ?>
        </li>
         <li class="list-group-item">
            <strong>Current Status:</strong>
            <?php
                $status = esc($document['current_status']);
                $badgeClass = 'bg-secondary'; // Default color
                if ($status == 'Pending')   $badgeClass = 'bg-warning';
                if ($status == 'Forwarded') $badgeClass = 'bg-info';
                if ($status == 'Complete')  $badgeClass = 'bg-success';
            ?>
            <span class="badge <?= $badgeClass ?>"><?= $status ?></span>
        </li>
    </ul>
</div>
        
        <hr>

        <div class="mt-4">
            <h5>Movement History</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Timestamp</th>
                            <th>From (Sender)</th>
                            <th>To (Receiver)</th>
                            <th>Action / Remarks</th>
                            <th>Handled By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($document_logs)): foreach ($document_logs as $log): ?>
                        <tr>
                            <td><?= date('M j, Y h:i A', strtotime($log['timestamp'])) ?></td>
                            <td><?= esc($log['sender_office'] ?? 'N/A') ?></td>
                            <td><?= esc($log['receiver_office'] ?? 'N/A (Completed)') ?></td>
                            <td><?= esc($log['remarks']) ?></td>
                            <td><?= esc($log['handled_by_name']) ?></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No history logs found for this document. It is still in its originating office.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 text-end">
             <a href="<?= site_url('my-documents') ?>" class="btn btn-secondary">Back to My Documents</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>