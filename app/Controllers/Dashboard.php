<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ReminderModel;
use App\Models\WarrantyModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $db = \Config\Database::connect();

        $family = $db->table('family_members')
            ->select('families.id as family_id, families.name as family_name')
            ->join('families', 'families.id = family_members.family_id')
            ->where('family_members.user_id', $userId)
            ->get()
            ->getRow();


        $familyId = $family ? $family->family_id : null;
        $familyName = $family ? $family->family_name : null;

        $reminderModel = new ReminderModel();
        $warrantyModel = new WarrantyModel();

        $reminderCount = $reminderModel->where('user_id', $userId)->countAllResults();
        $warrantyCount = $warrantyModel->where('user_id', $userId)->countAllResults();

        $userCount = $familyId ? $db->table('family_members')
            ->where('family_id', $familyId)
            ->countAllResults() : 0;

        $familyReminders = $familyId ? count($reminderModel->getFamilyRemindersInWeek($familyId)) : 0;

        $data = [
            'reminderCount' => $reminderCount,
            'warrantyCount' => $warrantyCount,
            'userCount' => $userCount,
            'familyReminders' => $familyReminders,
            'familyName' => $familyName
        ];

        return view('dashboard/index', $data);
    }
}
