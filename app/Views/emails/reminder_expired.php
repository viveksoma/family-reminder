<p>Hi <?= esc($member['name']) ?>,</p>
<p>The reminder <strong><?= esc($reminder['title']) ?></strong> scheduled for
<strong><?= date('d M Y', strtotime($reminder['reminder_date'])) ?></strong> has <strong>expired</strong>.</p>
<p><?= esc($reminder['description'] ?? '') ?></p>
<p>You may review and mark it as completed or update the reminder if needed.</p>
