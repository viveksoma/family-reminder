<p>Hi <?= esc($member['name']) ?>,</p>
<p>This is a <strong>critical reminder</strong> — <strong><?= esc($reminder['title']) ?></strong> is due <strong>today</strong> (<?= date('d M Y', strtotime($reminder['reminder_date'])) ?>).</p>
<p><?= esc($reminder['description'] ?? '') ?></p>
<p>Please take necessary action immediately.</p>
