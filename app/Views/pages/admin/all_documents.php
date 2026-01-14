<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Master Document List
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- ENHANCED PRINT STYLING -->
<style>
    /* Default: Hide print elements on screen */
    .print-header, .print-footer { display: none; }

    /* PRINT MODE ONLY */
    @media print {
        /* 1. SETUP PAGE & HIDE UI */
        @page {
            size: landscape; /* Force Landscape orientation */
            margin: 1cm;
        }
        nav, .sidebar, header, footer, .no-print, .btn, .dataTables_filter, .dataTables_length, .dataTables_paginate, .dataTables_info {
            display: none !important;
        }
        
        /* 2. RESET CONTAINERS */
        body, .container, .main-content, .card, .card-body {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
            border: none !important;
            background-color: white !important;
            font-family: "Times New Roman", Times, serif !important; /* Official Doc Font */
            color: black !important;
        }

        /* 3. HEADER STYLING */
        .print-header {
            display: flex !important;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid black;
            padding-bottom: 15px;
            gap: 20px;
        }
        .header-text h5 { font-size: 10pt; margin: 0; font-weight: normal; text-transform: uppercase; }
        .header-text h3 { font-size: 14pt; margin: 2px 0; font-weight: bold; text-transform: uppercase; }
        .header-text p { font-size: 9pt; margin: 0; font-style: italic; }
        
        /* Logo styling for print */
        .print-logo {
            width: 80px; 
            height: auto;
            filter: grayscale(100%); /* Optional: Print logo in B&W */
        }

        /* 4. TABLE REFINEMENTS */
        .table {
            width: 100% !important;
            border-collapse: collapse !important;
            font-size: 9pt !important; /* Smaller font to fit */
        }
        .table th {
            background-color: #f0f0f0 !important;
            color: black !important;
            border: 1px solid black !important;
            text-transform: uppercase;
            padding: 8px 4px !important;
            text-align: center;
        }
        .table td {
            border: 1px solid black !important;
            padding: 6px 4px !important;
            vertical-align: top;
        }
        
        /* 5. CLEAN UP UI ELEMENTS (Badges, Icons) */
        .badge {
            border: none !important;
            background: none !important;
            color: black !important;
            font-weight: normal !important;
            padding: 0 !important;
        }
        .bi { display: none !important; } /* Hide icons */
        .text-muted { color: black !important; } /* Make gray text black */

        /* 6. FOOTER/SIGNATURE */
        .print-footer {
            display: flex !important;
            justify-content: flex-end;
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .signature-box {
            text-align: center;
            width: 250px;
        }
    }
</style>

<!-- OFFICIAL PRINT HEADER -->
<div class="print-header">
    <!-- Add your local logo path here if you want -->
    <img src="<?= base_url('assets/img/DICT-Logo-2.jpg') ?>" alt="Logo" class="print-logo">
    
    <div class="header-text">
        <h5>Republic of the Philippines</h5>
        <h3>Dept. of Information & Communications Technology</h3>
        <p>Document Tracking System • Official Report Generated: <?= date('F j, Y') ?></p>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header text-white p-3 no-print" style="background: linear-gradient(90deg, var(--dict-blue) 0%, var(--dict-dark-blue) 100%);">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold"><i class="bi bi-files me-2"></i>Master Document List</h4>
            <div>
                <!-- PRINT BUTTON -->
                <button onclick="window.print()" class="btn btn-light btn-sm text-primary fw-bold shadow-sm">
                    <i class="bi bi-printer-fill me-1"></i> Print Official Report
                </button>
            </div>
        </div>
    </div>
    
    <div class="card-body p-4">
        <!-- Screen-only alert -->
        <div class="alert alert-light border-start border-4 border-warning mb-4 no-print">
            <i class="bi bi-info-circle-fill text-warning me-2"></i>
            <strong>Admin View:</strong> This table shows every document in the system.
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle" id="adminDocsTable">
                <thead class="table-light border-bottom border-2">
                    <tr>
                        <th width="15%">Tracking #</th>
                        <th width="25%">Title / Description</th>
                        <th width="20%">Origin & Creator</th>
                        <th width="15%">Current Location</th>
                        <th width="15%">Date Filed</th>
                        <th width="10%">Status</th>
                        <th class="text-center no-print">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($documents)): foreach ($documents as $doc): ?>
                        <tr>
                            <td class="fw-bold font-monospace"><?= esc($doc['tracking_number']) ?></td>
                            
                            <td>
                                <div class="fw-bold"><?= esc($doc['title']) ?></div>
                                <small class="text-muted"><?= esc($doc['description']) ?></small>
                            </td>

                            <td>
                                <div class="fw-bold small"><?= esc($doc['origin_office_name']) ?></div>
                                <div class="small text-muted"><?= esc($doc['creator_name']) ?></div>
                            </td>

                            <td>
                                <?php if($doc['current_status'] == 'Completed'): ?>
                                    <span>Archived</span>
                                <?php else: ?>
                                    <span><?= esc($doc['current_office_name'] ?? 'In Transit') ?></span>
                                <?php endif; ?>
                            </td>

                            <td><?= date('M j, Y', strtotime($doc['date_created'])) ?></td>

                            <td>
                                <!-- Logic to handle print vs screen styling -->
                                <?php 
                                    $status = $doc['current_status'];
                                    $badge = 'bg-secondary';
                                    if($status == 'Pending') $badge = 'bg-warning text-dark';
                                    if($status == 'Forwarded') $badge = 'bg-info text-white';
                                    if($status == 'Completed') $badge = 'bg-success';
                                ?>
                                <span class="badge <?= $badge ?> rounded-pill border"><?= esc($status) ?></span>
                            </td>

                            <td class="text-center no-print">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="<?= site_url('reports/history?tracking_number=' . $doc['tracking_number']) ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

        <!-- SIGNATURE AREA (Only Visible on Print) -->
        <div class="print-footer">
            <div class="signature-box">
                <p>Certified Correct:</p>
                <br><br><br>
                <p class="fw-bold text-uppercase border-top border-dark pt-2">Admin User</p>
                <p class="small">System Administrator</p>
            </div>
        </div>
    </div>
</div>

<!-- DataTables Script -->
<script>
    $(document).ready(function() {
        $('#adminDocsTable').DataTable({
            "order": [[ 4, "desc" ]],
            "pageLength": 25, 
            "language": { "search": "<i class='bi bi-search'></i> Search Records:" }
        });
    });
</script>

<?= $this->endSection() ?>