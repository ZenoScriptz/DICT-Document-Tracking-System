<?php

namespace App\Models;
use CodeIgniter\Model;

class DocumentLogModel extends Model
{
    protected $table = 'document_logs';
    protected $primaryKey = 'log_id';

    /**
     * THIS IS THE NEWLY ADDED PROPERTY THAT FIXES THE ERROR.
     * It lists all the columns that we are allowed to insert data into.
     */
    protected $allowedFields = [
        'document_id',
        'sender_office_id',
        'receiver_office_id',
        'action',
        'remarks',
        'handled_by'
    ];

    /**
     * Retrieves the complete history for a specific document ID,
     * joining with other tables for detailed, human-readable information.
     * @param int $documentId
     * @return array
     */
    public function getHistoryByDocumentId(int $documentId)
    {
        return $this->select('document_logs.*, sender.office_name as sender_office, receiver.office_name as receiver_office, users.fullname as handled_by_name')
                    ->join('offices as sender', 'sender.office_id = document_logs.sender_office_id', 'left')
                    ->join('offices as receiver', 'receiver.office_id = document_logs.receiver_office_id', 'left')
                    ->join('users', 'users.user_id = document_logs.handled_by', 'left')
                    ->where('document_logs.document_id', $documentId)
                    ->orderBy('document_logs.timestamp', 'ASC')
                    ->findAll();
    }
}