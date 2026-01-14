<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Received Documents
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Received Documents</h4>
    </div>
    <div class="card-body">
        <p class="card-text">This page lists all documents currently assigned to your office.</p>
        
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
                        <th>Tracking #</th>
                        <th>Title</th>
                        <th>Origin Office</th>
                        <th>Creator</th>
                        <th>Date Received</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($documents)): foreach ($documents as $doc): ?>
                        <tr>
                            <!-- THESE DATA CELLS WERE MISSING -->
                            <t<td class="text-center">
    <a href="<?= site_url('staff/forward/' . $doc['document_id']) ?>" class="btn btn-sm btn-primary me-1" title="Forward">
        <i class="bi bi-send-fill"></i>
    </a>
    <!-- THIS IS THE NEW BUTTON -->
    <a href="<?= site_url('staff/history/' . $doc['document_id']) ?>" class="btn btn-sm btn-info me-1" title="View History">
        <i class="bi bi-clock-history"></i>
    </a>
    <a href="<?= site_url('staff/complete/' . $doc['document_id']) ?>" class="btn btn-sm btn-success" title="Mark as Complete" onclick="return confirm('Are you sure you want to mark this document as complete?');">
        <i class="bi bi-check2-circle"></i>
    </a>
</td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No documents are currently assigned to your office.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>