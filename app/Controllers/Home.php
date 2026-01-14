<?php

namespace App\Controllers;

// Use statements to import the model classes
use App\Models\OfficeModel;
use App\Models\UserModel;
use App\Models\DocumentModel;

class Home extends BaseController
{
    // Define properties to hold the model instances
    protected $officeModel;
    protected $userModel;
    protected $documentModel;

    /**
     * Constructor.
     * This function is automatically called when the controller is loaded.
     * It's the perfect place to load models and other dependencies.
     */
    public function __construct()
    {
        // Create new instances of the models and assign them to the properties
        $this->officeModel = new OfficeModel();
        $this->userModel = new UserModel();
        $this->documentModel = new DocumentModel(); // This line fixes the error
    }

    public function index()
    {
        // Redirecting to login page by default is a good practice
        return redirect()->to('/login');
    }

  public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data = [];
        $role = session()->get('role');
        
        if ($role === 'admin') {
            $data['totalDocuments'] = $this->documentModel->countTotalDocuments();
            $data['pendingDocuments'] = $this->documentModel->countByStatus('Pending'); 
            $data['forwardedDocuments'] = $this->documentModel->countByStatus('Forwarded');
           $data['completedDocuments'] = $this->documentModel->countByStatus('Completed');

        } elseif ($role === 'encoder') {
            $userId = session()->get('user_id');
            $data['newlyAdded'] = $this->documentModel->countDocumentsByCreator($userId);

        }elseif ($role === 'staff') {
    $officeId = session()->get('office_id'); 
    
    // Debugging: Uncomment the line below to see your Office ID on screen
    // die("My Office ID is: " . $officeId);

    if ($officeId) {
        // Count documents that are currently IN this office
        $pending = $this->documentModel->countDocumentsForOfficeByStatus($officeId, 'Pending');
        $forwarded = $this->documentModel->countDocumentsForOfficeByStatus($officeId, 'Forwarded');
        
        $data['assignedToOffice'] = $pending + $forwarded;
        $data['pendingInOffice'] = $pending + $forwarded;
    }

        }

        return view('pages/dashboard', $data);
    }

    // --- Authentication Methods ---

    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function savelogin()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->getUserByUsername($username);

        if (!$user) {
            return redirect()->back()->with('error', 'Invalid username or password');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Invalid username or password');
        }

        // Save user info in session
        $session = session();
        $session->set([
            'user_id'   => $user['user_id'],
            'fullname'  => $user['fullname'],
            'username'  => $user['username'],
            'role'      => $user['role'],
            'office_id' => $user['office_id'], // Important for staff dashboard
            'logged_in' => true,
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    // --- Office Management Methods ---

    public function offices()
    {
        $data['off'] = $this->officeModel->getAllOffices();
        return view('pages/offices', $data);
    }

    public function addoffice()
    {
        return view('pages/addoffice');
    }

    public function saveoffice()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'office_name' => 'required|min_length[3]|max_length[100]',
            'office_code' => 'required|min_length[2]|max_length[20]',
            'office_description' => 'permit_empty|max_length[255]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $validation->getErrors()));
        }

        $data = [
            'office_name' => $this->request->getPost('office_name'),
            'office_code' => $this->request->getPost('office_code'),
            'office_description' => $this->request->getPost('office_description')
        ];

        $this->officeModel->insertOffice($data);
        return redirect()->to(base_url('offices'))->with('success', 'Office added successfully.');
    }

    public function editoffice($officeid)
    {
        $data['off'] = $this->officeModel->getOfficeById($officeid);
        return view('pages/editoffice', $data);
    }

    public function updateoffice()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'office_name' => 'required|min_length[3]|max_length[100]',
            'office_code' => 'required|min_length[2]|max_length[20]',
            'office_description' => 'permit_empty|max_length[255]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $validation->getErrors()));
        }

        $data = [
            'office_name' => $this->request->getPost('office_name'),
            'office_code' => $this->request->getPost('office_code'),
            'office_description' => $this->request->getPost('office_description')
        ];
        $officeid = $this->request->getPost('office_id');

        $this->officeModel->updateOffice($officeid, $data);
        return redirect()->to(base_url('offices'))->with('success', 'Office updated successfully.');
    }

    public function deleteoffice($officeid)
    {
        $result = $this->officeModel->deleteOffice($officeid);
        if($result){
            return redirect()->to('/offices')->with('success', 'Office deleted successfully.');
        } else {
            return redirect()->to('/offices')->with('error', 'Failed to delete office.');
        }
    }

    // --- User Management Methods ---

    public function users()
    {
        $data['user'] = $this->userModel->getAllUsers();
        return view('pages/users', $data);
    }

    public function adduser()
    {
        $data['offices'] = $this->officeModel->getAllOffices();
        return view('pages/adduser', $data);
    }

    public function saveUser()
    {
        $validation = $this->validate([
            'fullname'  => 'required|min_length[3]',
            'username'  => 'required|min_length[3]|is_unique[users.username]',
            'password'  => 'required|min_length[6]',
            'role'      => 'required',
            'office_id' => 'required|integer',
            'status'    => 'required'
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'fullname'  => $this->request->getPost('fullname'),
            'username'  => $this->request->getPost('username'),
            'password'  => $this->request->getPost('password'),
            'role'      => $this->request->getPost('role'),
            'office_id' => $this->request->getPost('office_id'),
            'status'    => $this->request->getPost('status')
        ];

        $this->userModel->insertUser($data);
        return redirect()->to('/users')->with('success', 'User added successfully!');
    }

    public function edituser($userid)
    {
        $data['user'] = $this->userModel->getUserById($userid);
        $data['offices'] = $this->officeModel->getAllOffices();
        return view('pages/edituser', $data);
    }

    public function updateUser($userid)
    {
        $validation = $this->validate([
            'fullname'  => 'required|min_length[3]',
            'username'  => "required|min_length[3]|is_unique[users.username,user_id,$userid]",
            'password'  => 'permit_empty|min_length[6]',
            'role'      => 'required',
            'office_id' => 'required|integer',
            'status'    => 'required'
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'fullname'  => $this->request->getPost('fullname'),
            'username'  => $this->request->getPost('username'),
            'role'      => $this->request->getPost('role'),
            'office_id' => $this->request->getPost('office_id'),
            'status'    => $this->request->getPost('status')
        ];

        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $this->userModel->updateUser($userid, $data);
        return redirect()->to('/users')->with('success', 'User updated successfully!');
    }

    public function deleteuser($userid)
    {
        $result = $this->userModel->deleteUser($userid);
        if($result){
            return redirect()->to('/users')->with('success', 'User deleted successfully.');
        } else {
            return redirect()->to('/users')->with('error', 'Failed to delete user.');
        }
    }
}