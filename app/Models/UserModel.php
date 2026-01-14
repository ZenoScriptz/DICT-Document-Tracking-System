<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; // Database table
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['fullname', 'username', 'password', 'role', 'office_id', 'status'];

    // Get all user records
    public function getAllUsers(){
        return $this->select('users.*, offices.*')
                ->join('offices', 'offices.office_id = users.office_id', 'left')
                ->findAll();
    }

    // Get a single user record by primary key
    public function getUserById($id){
        return $this->select('users.*, offices.*')
                ->join('offices', 'offices.office_id = users.office_id', 'left')
                ->find($id);
    }

    // Insert a new user record
   public function insertUser($data){
        // Check if password is set
        if (isset($data['password'])) {
            // Hash the password using password_hash()
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        // Insert the user record
        return $this->insert($data);
    }

    // Update an existing user record by primary key
    public function updateUser($id, $data){
        return $this->update($id, $data);
    }

    // Delete a user record by primary key
    public function deleteUser($id){
        return $this->delete($id);
    }

    //get users by role
    public function getUsersByRole($role){
        return $this->where('role', $role)->findAll();
    }

    public function getUserByUsername($username){
        return $this->where('username', $username)->first();
    }
}



