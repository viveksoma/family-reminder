<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Warranties</title>
    <?= view('common_styles') ?>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block"><a href="<?= base_url('dashboard'); ?>" class="nav-link">Home</a></li>
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Warranties</a></li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item user-menu">
                        <a href="/logout" class="nav-link" id="logoutBtn">
                            <span class="d-none d-md-inline">Sign out</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <?= view('common_sidebar') ?>

        <main class="app-main">
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6"><h3 class="mb-0">Warranties</h3></div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Warranties</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <div class="app-content-header">
                <div class="container-fluid">
                    <h3>👋 Welcome <?= esc(session()->get('user_name')) ?> — <?= esc($familyName ?? '') ?> Family Warranties</h3>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">

                    <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
                    <?php endif; ?>

                    <!-- Add Warranty Form -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Add New Warranty</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('warranties/save') ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="family_id" value="<?= esc($familyId) ?>">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label>Item Name</label>
                                        <input type="text" name="item_name" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Purchase Date</label>
                                        <input type="date" name="purchase_date" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Expiry Date</label>
                                        <input type="date" name="expiry_date" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Upload Warranty Document</label>
                                        <input type="file" name="warranty_document" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Notes</label>
                                        <textarea name="notes" class="form-control" rows="2"></textarea>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Warranties List -->
                    <div class="card">
                        <div class="card-header"><h5>All Warranties</h5></div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Purchase Date</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Document</th>
                                        <th>Notes</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($warranties)): ?>
                                        <?php foreach ($warranties as $w): ?>
                                            <?php
                                                $expiry = new DateTime($w['expiry_date']);
                                                $today = new DateTime();
                                                $diffDays = (int)$today->diff($expiry)->format('%r%a');

                                                if ($diffDays < 0) {
                                                    $badgeClass = 'danger';
                                                    $statusText = 'Expired';
                                                } elseif ($diffDays <= 30) {
                                                    $badgeClass = 'warning';
                                                    $statusText = 'Expiring Soon';
                                                } else {
                                                    $badgeClass = 'success';
                                                    $statusText = 'Active';
                                                }
                                            ?>
                                            <tr>
                                                <td><?= esc($w['item_name']) ?></td>
                                                <td><?= date('d-m-Y', strtotime($w['purchase_date'])) ?></td>
                                                <td><?= date('d-m-Y', strtotime($w['expiry_date'])) ?></td>
                                                <td><span class="badge bg-<?= $badgeClass ?>"><?= esc($statusText) ?></span></td>
                                                <td>
                                                    <?php if (!empty($w['warranty_document'])): ?>
                                                        <a href="<?= base_url($w['warranty_document']) ?>" target="_blank">View</a>
                                                    <?php else: ?>—
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= esc($w['notes'] ?? '-') ?></td>
                                                <td>
                                                    <a href="<?= base_url('warranties/delete/' . $w['id']) ?>" 
                                                       class="btn btn-sm btn-danger"
                                                       onclick="return confirm('Are you sure?')">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="7" class="text-center">No warranties found.</td></tr>
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
