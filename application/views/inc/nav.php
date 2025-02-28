<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo mr-5" href="<?= base_url('dashboard') ?>"><img src="<?= base_url('assets/images/logo.svg') ?>" class="mr-2" alt="logo" /></a>
    <a class="navbar-brand brand-logo-mini" href="<?= base_url('dashboard') ?>"><img src="<?= base_url('assets/images/logo-mini.svg') ?>" alt="logo" /></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>
    <ul class="navbar-nav mr-lg-2">
      <li class="nav-item nav-search d-none d-lg-block">

      </li>
    </ul>
    <ul class="navbar-nav navbar-nav-right">

      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
          <img src="<?php echo !empty($this->session->userdata('image')) ? base_url($this->session->userdata('image')) : base_url('assets/images/default-profile.jpg'); ?>" alt="user" class="user">
          <span class="user-name px-3">
            <?php echo !empty($this->session->userdata('name')) ? $this->session->userdata('name') : 'Guest'; ?>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" data-toggle="modal" data-target="#editProfileModal">
            <i class="icon-head menu-icon text-primary"></i>
            Profile
          </a>
          <a class="dropdown-item" href="<?= base_url('AuthController/logout'); ?>">
            <i class="ti-power-off text-primary"></i>
            Logout
          </a>
        </div>
      </li>

    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="icon-menu"></span>
    </button>
  </div>
</nav>


<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog mt-3" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-primary" id="editAdminModalLabel">Edit Profile</h3>
        <button type="button" class="btn btn-secondary fas fa-times" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('AuthController/updateProfile'); ?>" method="POST" enctype="multipart/form-data" class="row g-3">
          <input type="hidden" name="id" value="<?= $this->session->userdata('admin_id'); ?>">
          <input type="hidden" name="old_image" value="<?= $this->session->userdata('image'); ?>">

          <div class="col-md-6 mt-3">
            <label for="name" class="form-label text-capitalize">Name</label>
            <input type="text" class="form-control" name="name" value="<?= $this->session->userdata('name'); ?>" required>
          </div>

          <div class="col-md-6 mt-3">
            <label for="password" class="form-label text-capitalize">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Leave blank if not changing">
          </div>

          <div class="col-md-12 mt-3">
            <label for="email" class="form-label text-capitalize">Email</label>
            <input type="email" class="form-control" name="email" value="<?= $this->session->userdata('email'); ?>" required>
          </div>

          <!-- Display Current Image -->
          <div class="col-md-12 mt-3">
            <label for="image" class="form-label text-capitalize">Current Profile Image</label><br>
            <img src="<?= base_url($this->session->userdata('image')); ?>" alt="Profile Image" width="100">
          </div>

          <div class="col-md-12 mt-3">
            <label for="image" class="form-label text-capitalize">Upload New Image</label>
            <input type="file" class="form-control" name="image" accept="image/*">
          </div>

          <div class="col-md-12 mt-3">
            <button type="submit" class="btn btn-primary">Update Profile</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
