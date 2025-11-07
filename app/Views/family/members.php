<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Family Members</title>
    <?= view('common_styles') ?>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!--begin::Header-->
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
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Dashboard</a></li>
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
            <!--end::Header-->

        <?= view('common_sidebar') ?>

        <main class="app-main">
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6"><h3 class="mb-0">Members</h3></div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Members</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <div class="app-content-header">
                <div class="container-fluid">
                    <h3>👨‍👩‍👧 Welcome <?= esc(session()->get('user_name')) ?> — <?= esc($familyName ?? '') ?> Family</h3>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">

                    <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
                    <?php endif; ?>

                    <div class="card mb-4">
                        <div class="card-header"><h5>Add Member</h5></div>
                        <div class="card-body">
                            <form action="<?= base_url('members/save') ?>" method="post">
                                <input type="hidden" name="family_id" value="<?= esc($familyId) ?>">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header"><h5>All Members</h5></div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($members)): ?>
                                        <?php foreach ($members as $m): ?>
                                            <tr>
                                                <td><?= esc($m['name']) ?></td>
                                                <td><?= esc($m['email']) ?></td>
                                                <td>
                                                    <a href="<?= base_url('members/delete/' . $m['id']) ?>" 
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">Remove</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="4" class="text-center">No members yet.</td></tr>
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
