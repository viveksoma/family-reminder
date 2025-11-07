<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Reminders</title>
    <?= view('common_styles') ?>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-body">
            <!--begin::Container-->
            <div class="container-fluid">
            <!--begin::Start Navbar Links-->
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
                </li>
                <li class="nav-item d-none d-md-block"><a href="<?php echo base_url('dashboard'); ?>" class="nav-link">Home</a></li>
                <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Reminders</a></li>
            </ul>
            <!--end::Start Navbar Links-->
                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item user-menu">
                        <a href="/logout" class="nav-link" id="logoutBtn">
                            <span class="d-none d-md-inline">Sign out</span>
                        </a>
                    </li>
                </ul>
                <!--end::End Navbar Links-->
            </div>
            <!--end::Container-->
        </nav>
        <?= view('common_sidebar') ?>

        <main class="app-main">
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6"><h3 class="mb-0">Reminders</h3></div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Reminders</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <div class="app-content-header">
                <div class="container-fluid">
                    <h3>👋 Welcome <?= esc(session()->get('user_name')) ?> — <?= esc($familyName ?? '') ?> Family Reminders</h3>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
                    <?php endif; ?>

                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Add New Reminder</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('reminders/save') ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="family_id" value="<?= esc($familyId) ?>">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label>Title</label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Type</label>
                                        <select name="type" class="form-control">
                                            <option value="insurance">Insurance</option>
                                            <option value="policy">Policy</option>
                                            <option value="warranty">Warranty</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Reminder Date</label>
                                        <input type="date" name="reminder_date" class="form-control" required>
                                    </div>
                                    <!-- <div class="col-md-2 d-flex align-items-end">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="is_family_reminder" value="1">
                                            <label class="form-check-label">Family Reminder</label>
                                        </div>
                                    </div> -->
                                    <div class="col-md-6">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" rows="2"></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Attach Document</label>
                                        <input type="file" name="document_path" class="form-control">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header"><h5>All Reminders</h5></div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Document</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($reminders)): ?>
                                        <?php foreach ($reminders as $r): ?>
                                            <?php
                                                $reminderDate = new DateTime($r['reminder_date']);
                                                $today = new DateTime();
                                                $diffDays = (int)$today->diff($reminderDate)->format('%r%a');

                                                if ($diffDays < 0) {
                                                    $badgeClass = 'danger';
                                                    $statusText = 'Expired on ' . $reminderDate->format('d-m-Y');
                                                } elseif ($diffDays <= 10) {
                                                    $badgeClass = 'warning';
                                                    $statusText = 'Expiring in ' . $diffDays . ' days';
                                                } elseif ($diffDays <= 15) {
                                                    $badgeClass = 'info';
                                                    $statusText = 'Active';
                                                } else {
                                                    $badgeClass = 'success';
                                                    $statusText = 'Upcoming';
                                                }
                                            ?>
                                            <tr>
                                                <td><?= esc($r['title']) ?></td>
                                                <td><?= ucfirst($r['type']) ?></td>
                                                <td><?= date('d-m-Y', strtotime($r['reminder_date'])) ?></td>
                                                <td>
                                                    <span class="badge bg-<?= $badgeClass ?>"><?= esc($statusText) ?></span>
                                                </td>
                                                <td>
                                                    <?php if (!empty($r['document_path'])): ?>
                                                        <a href="<?= base_url($r['document_path']) ?>" target="_blank">View</a>
                                                    <?php else: ?>—
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('reminders/delete/' . $r['id']) ?>" 
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="6" class="text-center">No reminders found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </main>
        <?= view('common_footer') ?>
</div>

<?= view('common_script') ?>
</body>
</html>
