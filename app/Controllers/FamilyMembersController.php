<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\FamilyMemberModel;

class FamilyMembersController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $db = \Config\Database::connect();

        // Get user's family
        $family = $db->table('family_members')
            ->select('family_id')
            ->where('user_id', $userId)
            ->get()
            ->getRow();

        if (!$family) {
            return redirect()->to('/family/choose')->with('error', 'Please create or join a family first.');
        }

        $familyId = $family->family_id;

        $memberModel = new FamilyMemberModel();
        $userModel = new UserModel();

        // Fetch family members with user details
        $members = $memberModel->select('users.id, users.name, users.email')
            ->join('users', 'users.id = family_members.user_id')
            ->where('family_members.family_id', $familyId)
            ->get()
            ->getResultArray();

        $data = [
            'familyId' => $familyId,
            'members' => $members,
            'familyName' => $db->table('families')->where('id', $familyId)->get()->getRow()->name ?? ''
        ];

        return view('family/members', $data);
    }

    public function save()
    {
        $userModel = new UserModel();
        $memberModel = new FamilyMemberModel();

        $familyId = $this->request->getPost('family_id');
        $email = $this->request->getPost('email');
        $name = $this->request->getPost('name');

        // Check if user exists or create new one
        $user = $userModel->where('email', $email)->first();
        if (!$user) {
            $userModel->insert([
                'name' => $name,
                'email' => $email,
                'password' => password_hash('password', PASSWORD_DEFAULT) // default password
            ]);
            $userId = $userModel->insertID();
        } else {
            $userId = $user['id'];
        }

        // Add user to family if not already
        $exists = $memberModel->where('family_id', $familyId)->where('user_id', $userId)->first();
        if (!$exists) {
            $memberModel->insert([
                'family_id' => $familyId,
                'user_id' => $userId,
            ]);
        }

        return redirect()->to('/members')->with('message', 'Member added successfully.');
    }

    public function delete($id)
    {
        $memberModel = new FamilyMemberModel();
        $memberModel->where('user_id', $id)->delete();

        return redirect()->to('/members')->with('message', 'Member removed successfully.');
    }
}
