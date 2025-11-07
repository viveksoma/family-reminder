<p>Hi <?= esc($member['name']) ?>,</p>
<p>This is a friendly reminder that <strong><?= esc($reminder['title']) ?></strong> is scheduled on
<strong><?= date('d M Y', strtotime($reminder['reminder_date'])) ?></strong>.</p>
<p><?= esc($reminder['description'] ?? '') ?></p>
<p>Kind regards,<br>Family Reminder System</p>
