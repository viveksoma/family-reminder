<?php

namespace App\Controllers;

use App\Models\ReminderModel;

class ReminderController extends BaseController
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

        $reminderModel = new ReminderModel();
        $reminders = $reminderModel->getRemindersByUserOrFamily($userId, $familyId);

        return view('reminders/index', [
            'reminders' => $reminders,
            'familyId' => $familyId,
            'familyName' => $family ? $family->family_name : null,
        ]);
    }

    public function save()
    {
        $reminderModel = new ReminderModel();

        $userId = session()->get('user_id');
        $familyId = $this->request->getPost('family_id');
        $file = $this->request->getFile('document_path');
        $filePath = null;

        // === File Handling with Cleaned File Name ===
        if ($file && $file->isValid()) {
            $originalName = $file->getClientName();
            $title = $this->request->getPost('title');

            // Remove whitespace and special chars from title for filename
            $cleanTitle = preg_replace('/[^A-Za-z0-9_-]/', '_', strtolower($title));

            // Append timestamp to avoid collisions
            $newFileName = $cleanTitle . '_' . time() . '.' . $file->getExtension();

            // Move file to uploads/reminders
            $file->move('uploads/reminders', $newFileName);
            $filePath = 'uploads/reminders/' . $newFileName;
        }

        // === Compute Status Based on Date ===
        $reminderDate = new \DateTime($this->request->getPost('reminder_date'));
        $today = new \DateTime();
        $diffDays = (int)$today->diff($reminderDate)->format('%r%a');

        if ($diffDays < 0) {
            $status = 'expired'; // past date
        } elseif ($diffDays <= 10) {
            $status = 'warning'; // within 10 days
        } elseif ($diffDays <= 15) {
            $status = 'active'; // within 15 days
        } else {
            $status = 'upcoming'; // more than 15 days ahead
        }

        // === Save Data ===
        $data = [
            'family_id' => $familyId ?: null,
            'user_id' => $userId,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'type' => $this->request->getPost('type'),
            'reminder_date' => $this->request->getPost('reminder_date'),
            'document_path' => $filePath,
            'is_family_reminder' => $this->request->getPost('is_family_reminder') ? 1 : 0,
            'status' => $status,
        ];

        $reminderModel->insert($data);

        return redirect()->to('/reminders')->with('message', 'Reminder added successfully!');
    }


    public function delete($id)
    {
        $reminderModel = new ReminderModel();
        $reminderModel->delete($id);
        return redirect()->to('/reminders')->with('message', 'Reminder deleted.');
    }
}
