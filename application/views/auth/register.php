<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register - Skydash Admin</title>
    <link rel="stylesheet" href="assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/css/vertical-layout-light/style.css">
    <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-6 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="<?= base_url('assets/images/logo.svg'); ?>" alt="logo">
                            </div>
                            <h3 class="font-weight-light ml-5">Join us today!</h3>
                            <h5 class="font-weight-light ml-5">Create an account.</h5>

                            <!-- Flash message for errors -->
                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            <?php endif; ?>

                            <!-- Registration Form -->
                            <form method="post" action="<?= base_url('AuthController/register'); ?>" enctype="multipart/form-data" class="pt-3">
                                <div class="form-group col-lg-8 mx-auto">
                                    <input type="text" class="form-control form-control-lg text-center" name="name" placeholder="Name" required>
                                </div>
                                <div class="form-group col-lg-8 mx-auto">
                                    <input type="email" class="form-control form-control-lg text-center" name="email" placeholder="Email" required>
                                </div>
                                <div class="form-group col-lg-8 mx-auto">
                                    <input type="password" class="form-control form-control-lg text-center" name="password" placeholder="Password" required>
                                </div>
                                <div class="form-group col-lg-8 mx-auto">
                                    <input type="file" class="form-control form-control-lg text-center" name="image" accept="image/*" required>
                                </div>
                                <div class="form-group col-lg-8 mx-auto">
                                    <select class="form-control form-control-lg text-center" name="role" required>
                                        <option value="">Select Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 mt-3 text-center">
                                    <button class="btn btn-primary btn-lg font-weight-medium auth-form-btn" type="submit" name="btn_submit">REGISTER</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
</body>

</html>
