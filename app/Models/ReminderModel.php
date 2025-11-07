<?php

namespace App\Models;

use CodeIgniter\Model;

class ReminderModel extends Model
{
    protected $table = 'reminders';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'family_id',
        'user_id',
        'title',
        'description',
        'type',
        'reminder_date',
        'document_path',
        'is_family_reminder',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;

    public function getRemindersByUserOrFamily($userId, $familyId)
    {
        return $this->where('user_id', $userId)
                    ->orWhere('family_id', $familyId)
                    ->orderBy('reminder_date', 'ASC')
                    ->findAll();
    }

    public function getFamilyRemindersInWeek($familyId)
    {
        $today = date('Y-m-d');
        $weekEnd = date('Y-m-d', strtotime('+7 days'));

        return $this->where('family_id', $familyId)
            ->where('reminder_date >=', $today)
            ->where('reminder_date <=', $weekEnd)
            ->findAll();
    }
}
