<?php

namespace App\Controllers;

use App\Models\ReminderModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class CronController extends Controller
{
    public function sendReminderEmails()
    {
        $reminderModel = new ReminderModel();
        $userModel = new UserModel();

        $today = date('Y-m-d');

        // Fetch all upcoming and expired reminders
        $reminders = $reminderModel
            ->where('reminder_date >=', date('Y-m-d', strtotime('-1 day')))
            ->findAll();

        foreach ($reminders as $reminder) {
            $daysLeft = (strtotime($reminder['reminder_date']) - strtotime($today)) / 86400;

            // Fetch all family members for the reminder’s family
            $members = $userModel
                ->select('email, name')
                ->join('family_members', 'users.id = family_members.user_id')
                ->where('family_members.family_id', $reminder['family_id'])
                ->findAll();

            foreach ($members as $member) {
                $subject = '';
                $message = '';

                if ($daysLeft === 7) {
                    $subject = "Upcoming Reminder in 7 Days: {$reminder['title']}";
                    $message = view('emails/reminder_7days', ['reminder' => $reminder, 'member' => $member]);
                } elseif ($daysLeft === 3) {
                    $subject = "Reminder Approaching in 3 Days: {$reminder['title']}";
                    $message = view('emails/reminder_3days', ['reminder' => $reminder, 'member' => $member]);
                } elseif ($daysLeft === 0) {
                    $subject = "Today’s Reminder: {$reminder['title']}";
                    $message = view('emails/reminder_today', ['reminder' => $reminder, 'member' => $member]);
                } elseif ($daysLeft < 0) {
                    $subject = "Expired Reminder: {$reminder['title']}";
                    $message = view('emails/reminder_expired', ['reminder' => $reminder, 'member' => $member]);
                }

                if ($subject && $message) {
                    $email = \Config\Services::email();
                    $email->setTo($member['email']);
                    $email->setSubject($subject);
                    $email->setMessage($message);
                    $email->send();
                }
            }
        }

        return 'Reminder emails processed successfully.';
    }
}
