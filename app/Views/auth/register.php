<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <?= view('common_styles') ?>

    </head>
    <body class="register-page bg-body-secondary">
        <div class="register-box">
            <div class="register-logo">
                <a href="#">Family Reminder</a>
            </div>

            <!-- /.register-logo -->
            <div class="card">
                <div class="card-body register-card-body">
                    <p class="register-box-msg">Register a new membership</p>
                    <?php if (session()->getFlashdata('errors')): ?>
                        <ul style="color:red;">
                            <?php foreach(session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    <?php endif ?>
                    <form action="<?= site_url('register') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Full Name" name="name" value="<?= old('name') ?>" />
                            <div class="input-group-text"><span class="bi bi-person"></span></div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" name="email" value="<?= old('email') ?>" />
                            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" name="password" />
                            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                        </div>
                        <!--begin::Row-->
                        <div class="col-4">
                            <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </div>
                        <!-- /.col -->
                        <!--end::Row-->
                    </form>
                    <!-- /.social-auth-links -->
                    <p class="mb-0">
                        <a href="<?= site_url('login') ?>" class="text-center"> I already have a membership </a>
                    </p>
                </div>
                <!-- /.register-card-body -->
            </div>
        </div>
        <?= view('common_script') ?>
    </body>
</html>
