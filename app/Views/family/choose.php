<!DOCTYPE html>
<html>
<head>
    <title>Choose or Create Family</title>
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
                    <p class="login-box-msg">Create family</p>
                    <?php if (session()->getFlashdata('error')): ?>
                        <p style="color:red;"><?= esc(session()->getFlashdata('error')) ?></p>
                    <?php endif ?>
                    <?php if (session()->getFlashdata('success')): ?>
                        <p style="color:green;"><?= esc(session()->getFlashdata('success')) ?></p>
                    <?php endif ?>
                    <form method="post" action="<?= site_url('family/handle') ?>">
                        <div class="input-group mb-3">
                            <input type="name" class="form-control" name="new_family_name" placeholder="Enter new family name" /> 
                            <div class="input-group-text"><span class="bi bi-person-hearts"></span></div>
                        </div>
                        <div class="col-4">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Continue</button>
                            </div>
                        </div>
                        <!-- /.col -->
                        </div>
                        <!--end::Row-->
                    </form>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>

        <?= view('common_script') ?>
    </body>
</html>
