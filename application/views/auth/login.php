<?php $this->load->view('inc/top')?>

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
                            <h3 class="font-weight-light ml-5">Hello! Let's get started</h3>
                            <h5 class="font-weight-light ml-5">Log in to continue.</h5>

                            <!-- Flash message for errors -->
                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-primary">
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            <?php endif; ?>


                            <!-- Login Form -->
                            <form method="post" action="<?= base_url('AuthController/login'); ?>" class="pt-3">
                                <div class="form-group col-lg-8 mx-auto">
                                    <input type="email" class="form-control form-control-lg text-center" name="email" placeholder="Email" required>
                                </div>
                                <div class="form-group col-lg-8 mx-auto">
                                    <input type="password" class="form-control form-control-lg text-center" name="password" placeholder="Password" required>
                                </div>
                                <div class="col-lg-12 mt-3 text-center">
                                    <button class="btn btn-primary btn-lg font-weight-medium auth-form-btn" type="submit" name="btn_submit">LOG IN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('inc/bottom')?>
</body>

</html>