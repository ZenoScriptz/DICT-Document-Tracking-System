<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\DocumentLogModel;
use App\Models\OfficeModel;

class Staff extends BaseController
{
    protected $documentModel;
    protected $documentLogModel;
    protected $officeModel;

   public function __construct()
    {
        // Security Check: Allow if user is logged in AND is either 'staff' OR 'admin'
        $role = session()->get('role');
        
        if (!session()->get('logged_in') || ($role !== 'staff' && $role !== 'admin')) {
            echo 'Access Denied. You must be Staff or Admin to access this inbox.';
            exit;
        }

        $this->documentModel = new DocumentModel();
        $this->documentLogModel = new DocumentLogModel();
        $this->officeModel = new OfficeModel();
    }

    // 1. INBOX: Show documents currently in this user's office
    public function index()
    {
        $officeId = session()->get('office_id');
        // Uses the model method I fixed for you earlier
        $data['documents'] = $this->documentModel->getDocumentsByOfficeId($officeId);
        return view('pages/staff/received_documents', $data);
    }

    // 2. SHOW FORWARD FORM
    public function forward($documentId)
    {
        $data['document'] = $this->documentModel->find($documentId);
        $data['offices']  = $this->officeModel->findAll();
        return view('pages/staff/forward_document', $data);
    }

    // 3. EXECUTE FORWARD (The most important logic)
    public function executeForward()
    {
        $documentId = $this->request->getPost('document_id');
        $receiverOfficeId = $this->request->getPost('receiver_office_id');
        $remarks = $this->request->getPost('remarks');
        
        $currentOfficeId = session()->get('office_id');
        $userId = session()->get('user_id');

        // A. Update the Main Document Table
        // We change 'current_office_id' to the NEW office, and status to 'Forwarded'
        $this->documentModel->update($documentId, [
            'current_office_id' => $receiverOfficeId,
            'current_status'    => 'Forwarded'
        ]);

        // B. Insert into History Log
        $this->documentLogModel->insert([
            'document_id'       => $documentId,
            'sender_office_id'  => $currentOfficeId,
            'receiver_office_id'=> $receiverOfficeId,
            'action'            => 'Forwarded',
            'remarks'           => $remarks,
            'handled_by'        => $userId
        ]);

        return redirect()->to('/staff')->with('success', 'Document forwarded successfully!');
    }

    // 4. MARK AS COMPLETE
    public function complete($documentId)
    {
        $currentOfficeId = session()->get('office_id');
        $userId = session()->get('user_id');

        // A. Update Document to 'Complete'
        $this->documentModel->update($documentId, [
            'current_status' => 'Completed' // Logic: It stays in current office but is marked complete
        ]);

        // B. Log it
        $this->documentLogModel->insert([
            'document_id'       => $documentId,
            'sender_office_id'  => $currentOfficeId,
            'receiver_office_id'=> null, // No receiver, it ends here
            'action'            => 'Released', // or 'Completed'
            'remarks'           => 'Document marked as complete.',
            'handled_by'        => $userId
        ]);

        return redirect()->to('/staff')->with('success', 'Document marked as completed!');
    }

    // 5. VIEW HISTORY (Reusing the logic)
    public function history($documentId)
    {
        $data['document'] = $this->documentModel->find($documentId);
        $data['document_logs'] = $this->documentLogModel->getHistoryByDocumentId($documentId);
        return view('pages/staff/document_history', $data);
    }
}