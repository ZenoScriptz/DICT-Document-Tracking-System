<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\DocumentLogModel;

class Reports extends BaseController
{
    protected $documentModel;
    protected $documentLogModel;

    public function __construct()
    {
        if (!session()->get('logged_in')) {
            service('response')->redirect('/login')->send();
            exit;
        }

        $this->documentModel = new DocumentModel();
        $this->documentLogModel = new DocumentLogModel();
    }

    /**
     * Displays a list of all documents with a 'Pending' or 'Forwarded' status.
     */
    public function pending()
    {
        $data['documents'] = $this->documentModel->getDocumentsByStatuses(['Pending', 'Forwarded']);
        return view('pages/reports/pending_documents', $data);
    }

    /**
     * Displays a list of all documents with a 'Complete' status.
     */
    public function completed()
    {
        $data['documents'] = $this->documentModel->getDocumentsByStatuses(['Complete']);
        return view('pages/reports/completed_documents', $data);
    }
    
    /**
     * Displays a searchable page to find a document's history.
     */
    /**
     * Displays a searchable page to find a document's history.
     */
    public function history()
    {
        $data = [
            'tracking_number' => null,
            'all_documents'   => $this->documentModel->getAllDocumentsForAdmin() // <--- ADD THIS LINE
        ];
        
        $trackingNumber = $this->request->getGet('tracking_number');

        if ($trackingNumber) {
            $data['tracking_number'] = $trackingNumber;
            // Use the exact match for the specific timeline
            $document = $this->documentModel->findByTrackingNumber($trackingNumber);
            
            if ($document) {
                $data['document'] = $document;
                $data['document_logs'] = $this->documentLogModel->getHistoryByDocumentId($document['document_id']);
            }
        }

        return view('pages/reports/document_history', $data);
    }
}