<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Received Documents
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="bi bi-inbox-fill me-2"></i>My Office Inbox</h4>
    </div>
    <div class="card-body">
        <p class="card-text text-muted">These documents are currently in your office. You must forward them or mark them as complete.</p>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tracking #</th>
                        <th>Title</th>
                        <th>Origin</th>
                        <th>Date Received</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($documents)): foreach ($documents as $doc): ?>
                        <tr>
                            <td class="fw-bold text-primary"><?= esc($doc['tracking_number']) ?></td>
                            <td><?= esc($doc['title']) ?></td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-dark"><?= esc($doc['origin_office_name']) ?></span></td>
                            <td><small class="text-muted"><?= date('M j, h:i A', strtotime($doc['date_created'])) ?></small></td>
                            <td>
                                <?php if($doc['current_status'] == 'Pending'): ?>
                                    <span class="badge bg-warning text-dark">Pending Action</span>
                                <?php elseif($doc['current_status'] == 'Forwarded'): ?>
                                    <span class="badge bg-info text-dark">Received</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <!-- Forward Button -->
                                <a href="<?= site_url('staff/forward/' . $doc['document_id']) ?>" 
   class="btn btn-sm <?= (session()->get('role') === 'admin') ? 'btn-success' : 'btn-primary' ?>" 
   title="<?= (session()->get('role') === 'admin') ? 'Approve & Forward' : 'Forward Document' ?>">
   
   <!-- Icon Change: Checkmark for Admin, Paper Plane for Staff -->
   <?php if(session()->get('role') === 'admin'): ?>
       <i class="bi bi-check-circle-fill me-1"></i> Approve
   <?php else: ?>
       <i class="bi bi-send-fill"></i>
   <?php endif; ?>
</a>
                                <!-- History Button -->
                                <a href="<?= site_url('staff/history/' . $doc['document_id']) ?>" class="btn btn-sm btn-info text-white" title="View History">
                                    <i class="bi bi-clock-history"></i>
                                </a>
                                <!-- Complete Button -->
                                <a href="<?= site_url('staff/complete/' . $doc['document_id']) ?>" class="btn btn-sm btn-success" title="Mark Complete" onclick="confirmAction(event, 'Mark this document as Finished/Completed?')">
                                    <i class="bi bi-check-lg"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox display-4 d-block mb-3 opacity-25"></i>
                                No documents found in your inbox.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>