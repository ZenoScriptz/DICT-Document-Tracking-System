<?php

namespace App\Models;
use CodeIgniter\Model;

class DocumentModel extends Model
{
    protected $table = 'documents'; // Your table name
    protected $primaryKey = 'document_id';
    protected $allowedFields = [
        'tracking_number',
        'title',
        'description',
        'origin_office_id',
        'date_created',
        'created_by',
        'current_office_id', // The new recommended field
        'current_status'
    ];

    /**
     * Counts all documents in the table.
     * @return int
     */
    public function countTotalDocuments()
    {
        return $this->countAllResults();
    }

    /**
     * Counts documents based on their status.
     * Your statuses: 'Pending', 'Received', 'Forwarded', 'Complete'
     * @param string $status
     * @return int
     */
    public function countByStatus(string $status)
    {
        // Note: The status values from your ENUM are case-sensitive.
        return $this->where('current_status', $status)->countAllResults();
    }
    
    /**
     * Counts documents created by a specific user (for Encoders).
     * @param int $userId
     * @return int
     */
    public function countDocumentsByCreator(int $userId)
    {
        // Matches your 'created_by' column
        return $this->where('created_by', $userId)->countAllResults();
    }
    
    /**
     * Counts documents currently assigned to a specific office (for Staff).
     * @param int $officeId
     * @return int
     */
    public function countDocumentsForOffice(int $officeId)
    {
        // Uses the new 'current_office_id' column for high performance
        return $this->where('current_office_id', $officeId)->countAllResults();
    }
    
    /**
     * Counts documents assigned to an office with a specific status.
     * For example, count how many documents are 'Pending' for the Finance office.
     * @param int $officeId
     * @param string $status
     * @return int
     */
    public function countDocumentsForOfficeByStatus(int $officeId, string $status)
    {
        return $this->where('current_office_id', $officeId)
                    ->where('current_status', $status)
                    ->countAllResults();
    }
    public function getDocumentsByStatuses(array $statuses)
    {
        return $this->select('documents.*, origin_office.office_name as origin_office_name, current_office.office_name as current_office_name, users.fullname as creator_name')
                    ->join('offices as origin_office', 'origin_office.office_id = documents.origin_office_id', 'left')
                    ->join('offices as current_office', 'current_office.office_id = documents.current_office_id', 'left')
                    ->join('users', 'users.user_id = documents.created_by', 'left')
                    ->whereIn('documents.current_status', $statuses)
                    ->orderBy('documents.date_created', 'DESC')
                    ->findAll();
    }
     public function findByTrackingNumber(string $trackingNumber)
    {
        return $this->where('tracking_number', $trackingNumber)->first();
    }
    public function getDocumentsByCreatorId(int $userId)
{
    return $this->select('documents.*, origin_office.office_name as origin_office_name, current_office.office_name as current_office_name')
                ->join('offices as origin_office', 'origin_office.office_id = documents.origin_office_id', 'left')
                ->join('offices as current_office', 'current_office.office_id = documents.current_office_id', 'left')
                ->where('documents.created_by', $userId)
                ->orderBy('documents.date_created', 'DESC')
                ->findAll();
}
 public function getDocumentsByOfficeId(int $officeId)
    {
        // Define the statuses that are considered "active" or "pending action"
        $actionableStatuses = ['Pending', 'Forwarded'];

        return $this->select('documents.*, origin_office.office_name as origin_office_name, users.fullname as creator_name')
                    ->join('offices as origin_office', 'origin_office.office_id = documents.origin_office_id', 'left')
                    ->join('users', 'users.user_id = documents.created_by', 'left')
                    ->where('documents.current_office_id', $officeId)
                    ->whereIn('documents.current_status', $actionableStatuses) // <-- THIS IS THE CRITICAL NEW LINE
                    ->orderBy('documents.date_created', 'DESC')
                    ->findAll();
    }
    public function getAllDocumentsForAdmin()
    {
        return $this->select('documents.*, origin_office.office_name as origin_office_name, current_office.office_name as current_office_name, users.fullname as creator_name')
                    ->join('offices as origin_office', 'origin_office.office_id = documents.origin_office_id', 'left')
                    ->join('offices as current_office', 'current_office.office_id = documents.current_office_id', 'left')
                    ->join('users', 'users.user_id = documents.created_by', 'left')
                    ->orderBy('documents.date_created', 'DESC')
                    ->findAll();
    }
}