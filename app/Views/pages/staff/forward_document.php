<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Process Document
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Check Role for UI Logic -->
<?php 
    $isAdmin = (session()->get('role') === 'admin'); 
    $headerClass = $isAdmin ? 'bg-success' : 'bg-primary';
    $titleText = $isAdmin ? 'Approve & Forward Document' : 'Forward Document';
    $icon = $isAdmin ? 'bi-patch-check-fill' : 'bi-send-fill';
    $btnText = $isAdmin ? 'Approve & Send' : 'Confirm Transfer';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            
            <!-- Dynamic Header -->
            <div class="card-header <?= $headerClass ?> text-white p-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi <?= $icon ?> me-2"></i><?= $titleText ?>
                </h5>
            </div>

            <div class="card-body p-4">
                
                <!-- Document Info Summary -->
                <div class="alert alert-light border d-flex align-items-center mb-4 shadow-sm">
                    <div class="me-3 text-center" style="min-width: 60px;">
                        <i class="bi bi-file-earmark-text text-primary display-6"></i>
                    </div>
                    <div>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Processing Document:</small>
                        <h5 class="mb-1 fw-bold text-dark"><?= esc($document['title']) ?></h5>
                        <span class="badge bg-dark font-monospace"><?= esc($document['tracking_number']) ?></span>
                    </div>
                </div>

                <form action="<?= site_url('staff/execute-forward') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="document_id" value="<?= esc($document['document_id']) ?>">

                    <!-- Destination Selection -->
                    <div class="mb-4">
                        <label for="receiver_office_id" class="form-label fw-bold text-secondary">
                            <i class="bi bi-geo-alt-fill me-1"></i> Destination Office (Forward To):
                        </label>
                        <select class="form-select form-select-lg border-primary" id="receiver_office_id" name="receiver_office_id" required>
                            <option value="">-- Select Destination --</option>
                            <?php foreach ($offices as $office): ?>
                                <?php // Prevent forwarding to the same office ?>
                                <?php if ($office['office_id'] != session()->get('office_id')): ?>
                                    <option value="<?= esc($office['office_id']) ?>">
                                        <?= esc($office['office_name']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Select the office that needs to handle this document next.</div>
                    </div>
                    
                    <!-- Remarks -->
                    <div class="mb-4">
                        <label for="remarks" class="form-label fw-bold text-secondary">
                            <i class="bi bi-pencil-square me-1"></i> Remarks / Instructions:
                        </label>
                        <textarea class="form-control" name="remarks" id="remarks" rows="3" 
                            placeholder="<?= $isAdmin ? 'E.g., Budget approved. Proceed with procurement.' : 'Add notes for the receiver...' ?>"></textarea>
                    </div>

                    <hr class="my-4">

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="<?= site_url('staff') ?>" class="btn btn-light border text-muted px-4">
                            Cancel
                        </a>
                        <button type="submit" class="btn <?= $headerClass ?> btn-lg px-4 shadow-sm fw-bold">
                            <i class="bi <?= $icon ?> me-2"></i><?= $btnText ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>