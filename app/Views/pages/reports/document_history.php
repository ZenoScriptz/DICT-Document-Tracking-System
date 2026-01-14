<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Document History & Repository
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Internal CSS for Timeline & Table -->
<style>
    /* Timeline CSS */
    .timeline { border-left: 4px solid var(--dict-blue); margin-left: 20px; padding-left: 30px; position: relative; margin-top: 20px; }
    .timeline-item { position: relative; margin-bottom: 40px; }
    .timeline-item::before { content: ''; position: absolute; left: -42px; top: 5px; width: 20px; height: 20px; border-radius: 50%; background-color: white; border: 4px solid var(--dict-yellow); z-index: 2; }
    .timeline-item:first-child::before { border-color: var(--dict-red); background-color: var(--dict-red); box-shadow: 0 0 0 4px rgba(206, 17, 38, 0.2); }
    .timeline-content { background-color: #f8f9fa; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #eee; }
    .timeline-date { font-size: 0.9rem; color: #6c757d; margin-bottom: 8px; font-weight: 600; display: block; }
    .timeline-action { font-size: 1.1rem; font-weight: 700; color: var(--dict-blue); margin-bottom: 5px; }
    
    /* Search Highlight */
    .highlight-search { background-color: #e9ecef; padding: 2rem; border-radius: 10px; margin-bottom: 2rem; }
</style>

<!-- 1. SEARCH BAR SECTION -->
<div class="highlight-search shadow-sm">
    <h4 class="mb-3 fw-bold text-primary"><i class="bi bi-search me-2"></i>Track a Specific Document</h4>
    <form action="<?= site_url('reports/history') ?>" method="get">
        <div class="input-group input-group-lg">
            <input type="text" class="form-control" name="tracking_number" placeholder="Enter exact Tracking Number (e.g., TRK-173...)" value="<?= esc($tracking_number ?? '') ?>" required>
            <button class="btn btn-primary px-4" type="submit">View Timeline</button>
        </div>
    </form>
</div>

<!-- 2. TIMELINE RESULT SECTION (Only shows if a specific search was found) -->
<?php if (isset($document)): ?>
    <div class="card shadow mb-5 border-primary border-2">
        <div class="card-header bg-white p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-primary fw-bold">Timeline: <?= esc($document['tracking_number']) ?></h4>
                <a href="<?= site_url('reports/history') ?>" class="btn btn-outline-secondary btn-sm">Close Timeline</a>
            </div>
        </div>
        <div class="card-body p-4">
            <!-- Document Info -->
            <div class="row mb-4 bg-light p-3 rounded mx-0">
                <div class="col-md-8">
                    <h5 class="fw-bold"><?= esc($document['title']) ?></h5>
                    <p class="mb-0 text-muted"><?= esc($document['description']) ?></p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-primary fs-6"><?= esc($document['current_status']) ?></span>
                </div>
            </div>

            <!-- Vertical Timeline -->
            <h6 class="text-uppercase text-muted small fw-bold mb-3 ps-2">Movement History</h6>
            <div class="timeline">
                <?php if (!empty($document_logs)): 
                    $logs = array_reverse($document_logs); 
                    foreach ($logs as $log): ?>
                    <div class="timeline-item">
                        <span class="timeline-date"><i class="bi bi-calendar-event me-1"></i> <?= date('M j, Y • h:i A', strtotime($log['timestamp'])) ?></span>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="timeline-action"><?= esc($log['action']) ?></div>
                                <span class="badge bg-white text-dark border"><i class="bi bi-person-circle me-1"></i> <?= esc($log['handled_by_name']) ?></span>
                            </div>
                            <p class="mb-2 mt-2">
                                <strong>From:</strong> <?= esc($log['sender_office'] ?? 'Origin') ?> 
                                <i class="bi bi-arrow-right mx-2 text-muted"></i> 
                                <strong>To:</strong> <?= esc($log['receiver_office'] ?? 'End of Process') ?>
                            </p>
                            <?php if(!empty($log['remarks'])): ?>
                                <div class="alert alert-warning bg-opacity-10 border-0 mb-0 py-2 px-3 small text-dark">
                                    <i class="bi bi-chat-left-quote-fill me-2 text-warning"></i> <?= esc($log['remarks']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <div class="alert alert-info">No history recorded yet.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php elseif (isset($tracking_number)): ?>
    <!-- Error Message if Search Failed -->
    <div class="alert alert-danger d-flex align-items-center shadow-sm mb-5" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
        <div>
            <strong>Document Not Found!</strong><br>
            Tracking Number <strong><?= esc($tracking_number) ?></strong> does not exist. check the table below.
        </div>
    </div>
<?php endif; ?>


<!-- 3. DATA TABLE REPOSITORY (Always Visible) -->
<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-secondary"><i class="bi bi-folder2-open me-2"></i>Document Repository</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped" id="docsTable">
                <thead class="table-dark">
                    <tr>
                        <th>Tracking #</th>
                        <th>Title</th>
                        <th>Current Office</th>
                        <th>Date Filed</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($all_documents)): foreach ($all_documents as $doc): ?>
                        <tr>
                            <td class="fw-bold text-primary"><?= esc($doc['tracking_number']) ?></td>
                            <td><?= esc($doc['title']) ?></td>
                            <td><?= esc($doc['current_office_name'] ?? 'N/A') ?></td>
                            <td><?= date('M j, Y', strtotime($doc['date_created'])) ?></td>
                            <td>
                                <?php 
                                    $statusBadge = 'bg-secondary';
                                    if ($doc['current_status'] == 'Pending') $statusBadge = 'bg-warning text-dark';
                                    if ($doc['current_status'] == 'Forwarded') $statusBadge = 'bg-info text-dark';
                                    if ($doc['current_status'] == 'Complete') $statusBadge = 'bg-success';
                                ?>
                                <span class="badge <?= $statusBadge ?>"><?= esc($doc['current_status']) ?></span>
                            </td>
                            <td class="text-center">
                                <!-- This button links back to this same page but with the tracking_number parameter -->
                                <a href="<?= site_url('reports/history?tracking_number=' . $doc['tracking_number']) ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                                    <i class="bi bi-eye-fill me-1"></i> View History
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DataTables Script -->
<script>
    $(document).ready(function() {
        $('#docsTable').DataTable({
            "order": [[ 3, "desc" ]], // Order by Date Filed (Column index 3) desc
            "pageLength": 10,
            "language": {
                "search": "<i class='bi bi-filter'></i> Quick Search Filter:",
                "searchPlaceholder": "Type tracking #, title, or office..."
            }
        });
    });
</script>

<?= $this->endSection() ?>