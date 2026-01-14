<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        // All methods in this controller require a logged-in user
        if (!session()->get('logged_in')) {
            service('response')->redirect('/login')->send();
            exit;
        }

        $this->userModel = new UserModel();
    }

    /**
     * Display the user's profile page.
     */
    public function index()
    {
        $userId = session()->get('user_id');
        $data['user'] = $this->userModel->find($userId);
        
        return view('pages/profile/index', $data);
    }

    /**
     * Handle updating the user's fullname.
     */
    public function updateDetails()
    {
        $userId = session()->get('user_id');
        
        $rules = ['fullname' => 'required|min_length[3]|max_length[100]'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = ['fullname' => $this->request->getPost('fullname')];
        $this->userModel->update($userId, $data);

        // IMPORTANT: Update the fullname in the session as well
        session()->set('fullname', $data['fullname']);

        return redirect()->to('/profile')->with('success', 'Profile details updated successfully.');
    }

    /**
     * Handle updating the user's password.
     */
    public function updatePassword()
    {
        $userId = session()->get('user_id');
        
        // 1. Validation Rules
        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Verify Current Password
        $user = $this->userModel->find($userId);
        $currentPassword = $this->request->getPost('current_password');

        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Your current password does not match.');
        }

        // 3. Hash and Update New Password
        $newPassword = password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT);
        $this->userModel->update($userId, ['password' => $newPassword]);

        return redirect()->to('/profile')->with('success', 'Password changed successfully.');
    }
}