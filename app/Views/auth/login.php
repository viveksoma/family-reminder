<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <?= view('common_styles') ?>
    </head>
    <body class="login-page bg-body-secondary">
        <div class="login-box">
            <div class="login-logo">
                <a href="#"> Family Reminder </a>
            </div>
            <!-- /.login-logo -->
            <div class="card">

                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>
                    <?php if (session()->getFlashdata('error')): ?>
                        <p style="color:red;"><?= esc(session()->getFlashdata('error')) ?></p>
                    <?php endif ?>
                    <?php if (session()->getFlashdata('success')): ?>
                        <p style="color:green;"><?= esc(session()->getFlashdata('success')) ?></p>
                    <?php endif ?>
                    <form method="post" action="<?= site_url('login') ?>">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" name="email" /> 
                            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password"  name="password" />
                            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                        </div>
                        <!--begin::Row-->
                        <div class="row">
                            <div class="col-8">
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                                <label class="form-check-label" for="flexCheckDefault"> Remember Me </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </div>
                        <!-- /.col -->
                        </div>
                        <!--end::Row-->
                    </form>
                    <p class="mb-0">
                        <a href="<?= site_url('register') ?>" class="text-center"> Register a new membership </a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <?= view('common_script') ?>
    </body>
</html>
