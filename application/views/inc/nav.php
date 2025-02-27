<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo mr-5" href="index.html"><img src="<?= base_url('assets/images/logo.svg')?>" class="mr-2" alt="logo" /></a>
    <a class="navbar-brand brand-logo-mini" href="index.html"><img src="<?= base_url('assets/images/logo-mini.svg')?>" alt="logo" /></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>
    <ul class="navbar-nav mr-lg-2">
      <li class="nav-item nav-search d-none d-lg-block">

      </li>
    </ul>
    <ul class="navbar-nav navbar-nav-right mr-5 pr-3">

      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
          <img src="<?php echo !empty($this->session->userdata('image')) ? base_url($this->session->userdata('image')) : base_url('assets/images/default-profile.jpg'); ?>" alt="user" class="user">
            <span class="user-name px-3">
            <?php echo !empty($this->session->userdata('name')) ? $this->session->userdata('name') : 'Guest'; ?>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item">
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