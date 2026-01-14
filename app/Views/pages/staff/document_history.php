<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Document History
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    /* Timeline CSS */
    .timeline { border-left: 4px solid var(--dict-blue); margin-left: 20px; padding-left: 30px; position: relative; margin-top:20px; }
    .timeline-item { position: relative; margin-bottom: 40px; }
    .timeline-item::before { content: ''; position: absolute; left: -42px; top: 5px; width: 20px; height: 20px; border-radius: 50%; background-color: white; border: 4px solid var(--dict-yellow); z-index: 2; }
    .timeline-item:first-child::before { border-color: var(--dict-red); background-color: var(--dict-red); box-shadow: 0 0 0 4px rgba(206, 17, 38, 0.2); }
    .timeline-content { background-color: #f8f9fa; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #eee; }
    .timeline-date { font-size: 0.9rem; color: #6c757d; margin-bottom: 8px; font-weight: 600; display: block; }
    .timeline-action { font-size: 1.1rem; font-weight: 700; color: var(--dict-blue); margin-bottom: 5px; }
</style>

<div class="card">
    <div class="card-header bg-white border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary">Document History: <?= esc($document['tracking_number']) ?></h5>
            <a href="<?= site_url('staff') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back to Inbox</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h4 class="fw-bold"><?= esc($document['title']) ?></h4>
                <p class="text-muted"><?= esc($document['description']) ?></p>
                <hr>
                
                <h6 class="text-uppercase text-muted small fw-bold">Timeline</h6>
                
                <div class="timeline">
                    <?php if (!empty($document_logs)): 
                        $logs = array_reverse($document_logs); 
                        foreach ($logs as $log): ?>
                        <div class="timeline-item">
                            <span class="timeline-date"><?= date('M j, Y • h:i A', strtotime($log['timestamp'])) ?></span>
                            <div class="timeline-content">
                                <div class="timeline-action"><?= esc($log['action']) ?></div>
                                <p class="mb-1">
                                    <span class="badge bg-light text-dark border"><i class="bi bi-person"></i> <?= esc($log['handled_by_name']) ?></span>
                                </p>
                                <p class="mb-2 mt-2 small">
                                    From: <strong><?= esc($log['sender_office'] ?? 'Origin') ?></strong> 
                                    <i class="bi bi-arrow-right mx-1"></i> 
                                    To: <strong><?= esc($log['receiver_office'] ?? 'End') ?></strong>
                                </p>
                                <?php if($log['remarks']): ?>
                                    <div class="alert alert-warning py-1 px-2 small mb-0"><i class="bi bi-chat-quote me-1"></i> <?= esc($log['remarks']) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; else: ?>
                        <p>No history available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>