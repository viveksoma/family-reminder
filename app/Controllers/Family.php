<?php

namespace App\Controllers;

use App\Models\FamilyModel;
use App\Models\FamilyMembersModel;
use CodeIgniter\Controller;

class Family extends BaseController
{
    public function choose()
    {
        $db = \Config\Database::connect();

        // Check if user already has a family
        $family = $db->table('family_members')
            ->select('families.id, families.name')
            ->join('families', 'families.id = family_members.family_id')
            ->where('family_members.user_id', session()->get('user_id'))
            ->get()
            ->getRow();

        // If the user already has a family → redirect to dashboard
        if ($family) {
            session()->set('active_family_id', $family->id);
            return redirect()->to('/dashboard');
        }

        // Otherwise show create family page
        return view('family/choose');
    }


    public function handle()
    {
        $familyModel = new FamilyModel();
        $familyMembersModel = new FamilyMembersModel();
        $userId = session()->get('user_id');

        // Case 1: Selecting existing family
        if ($this->request->getPost('existing_family_id')) {
            $familyId = $this->request->getPost('existing_family_id');
            session()->set('active_family_id', $familyId);
            return redirect()->to('/dashboard')->with('success', 'Family selected successfully!');
        }

        // Case 2: Creating new family
        $newFamilyName = trim($this->request->getPost('new_family_name'));
        if ($newFamilyName !== '') {
            $familyId = $familyModel->insert([
                'name' => $newFamilyName,
                'created_by_user_id' => $userId,
            ]);

            // Link user as admin
            $familyMembersModel->insert([
                'family_id' => $familyId,
                'user_id' => $userId,
                'role' => 'admin'
            ]);

            session()->set('active_family_id', $familyId);
            return redirect()->to('/dashboard')->with('success', 'Family created successfully!');
        }

        return redirect()->back()->with('error', 'Please select or create a family.');
    }
}
