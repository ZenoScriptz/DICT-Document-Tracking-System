<?php

namespace App\Models;
use CodeIgniter\Model;

class OfficeModel extends Model
{
    protected $table = 'offices'; // Database table
    protected $primaryKey = 'office_id';
    protected $allowedFields = ['office_name', 'office_code', 'office_description'];

    // Get all office records
    public function getAllOffices(){
        return $this->findAll();
    }

    // Get a single office record by primary key
    public function getOfficeById($id){
        return $this->find($id);
    }

    // Insert a new office record
    public function insertOffice($data){
        // $data should be an associative array with keys matching allowedFields
        return $this->insert($data);
    }

    // Update an existing office record by primary key
    public function updateOffice($id, $data){
        // $data should be an associative array with keys matching allowedFields
        return $this->update($id, $data);
    }

    // Delete an office record by primary key
    public function deleteOffice($id){
        return $this->delete($id);
    }
}


