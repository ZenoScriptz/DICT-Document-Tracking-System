<?php

namespace App\Controllers;

use App\Models\OfficeModel;
use App\Models\DocumentModel;
use App\Models\DocumentLogModel;

class Encoder extends BaseController
{
    protected $officeModel;
    protected $documentModel;
    protected $mydocumentLogModel;

    public function __construct()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'encoder') {
            echo 'Access Denied. You must be logged in as an Encoder to access this page.';
            exit;
        }

        $this->officeModel = new OfficeModel();
        $this->documentModel = new DocumentModel();
        $this->documentLogModel = new DocumentLogModel();
    }

    public function myDocuments()
    {
        $userId = session()->get('user_id');
        $data['documents'] = $this->documentModel->getDocumentsByCreatorId($userId);
        return view('pages/encoder/my_documents', $data);
    }
    
    public function newDocument()
    {
        $data['offices'] = $this->officeModel->getAllOffices();
        return view('pages/encoder/new_document', $data);
    }
    
   public function saveDocument()
    {
        // 1. Validation
        $rules = [
            'title'            => 'required|min_length[5]|max_length[150]',
            'origin_office_id' => 'required|integer',
            'description'      => 'permit_empty|max_length[500]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Prepare the document data
        $docData = [
            'tracking_number'   => 'TRK-' . time() . '-' . random_int(100, 999),
            'title'             => $this->request->getPost('title'),
            'description'       => $this->request->getPost('description'),
            'origin_office_id'  => $this->request->getPost('origin_office_id'),
            'created_by'        => session()->get('user_id'),
            'current_office_id' => session()->get('office_id'),
            'current_status'    => 'Pending'
        ];

        // 3. Use the model to insert the document
        $documentId = $this->documentModel->insert($docData);

        if ($documentId) {
            // 4. THIS IS THE NEW LOGIC: If document insertion is successful, create the first log entry.
            $logData = [
                'document_id'       => $documentId,
                'sender_office_id'  => session()->get('office_id'),
                'action'            => 'Created',
                'remarks'           => 'Document has been registered in the system.',
                'handled_by'        => session()->get('user_id')
            ];
            $this->documentLogModel->insert($logData);

            // 5. Redirect with success message
            return redirect()->to('/my-documents')->with('success', 'Document registered successfully! Tracking #: ' . $docData['tracking_number']);
        } else {
            // If insertion fails
            return redirect()->back()->withInput()->with('error', 'Failed to register the document.');
        }
    }

    /**
     * Displays the full details and history of a single document created by the encoder.
     */
    public function history($document_id)
    {
        // 1. Fetch the main document details
        $document = $this->documentModel->find($document_id);
        $encoderId = session()->get('user_id');

        // 2. Security Check: Encoders can ONLY view the history of documents they created.
        if (!$document || $document['created_by'] != $encoderId) {
            return redirect()->to('/my-documents')->with('error', 'You do not have permission to view this document\'s history.');
        }

        // 3. Prepare data for the view
        $data = [
            'document'      => $document,
            'document_logs' => $this->documentLogModel->getHistoryByDocumentId($document_id)
        ];

        // 4. Load the view
        return view('pages/encoder/document_history', $data);
    }
}