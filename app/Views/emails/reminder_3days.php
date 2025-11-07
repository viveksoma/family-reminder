<p>Hi <?= esc($member['name']) ?>,</p>
<p>Please note, your reminder <strong><?= esc($reminder['title']) ?></strong> is just <strong>3 days away</strong> — scheduled on <strong><?= date('d M Y', strtotime($reminder['reminder_date'])) ?></strong>.</p>
<p><?= esc($reminder['description'] ?? '') ?></p>
<p>Please ensure you complete this on time.</p>
