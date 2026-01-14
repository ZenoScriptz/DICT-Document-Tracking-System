<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\OfficeModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    protected $documentModel;
    protected $officeModel;
    protected $userModel;

    public function __construct()
    {
        // 1. Security Check
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            echo 'Access Denied. Administrator privileges required.';
            exit;
        }
        
        // 2. Initialize Models
        $this->documentModel = new DocumentModel();
        $this->officeModel = new OfficeModel(); 
        $this->userModel = new UserModel();
    }

    // --------------------------------------------------------------------
    // THIS IS THE FUNCTION YOUR SYSTEM WAS MISSING
    // --------------------------------------------------------------------
    public function allDocuments()
    {
        // Fetch ALL documents using the specialized method in DocumentModel
        $data['documents'] = $this->documentModel->getAllDocumentsForAdmin();
        
        // Load the view: app/Views/pages/admin/all_documents.php
        return view('pages/admin/all_documents', $data);
    }
}