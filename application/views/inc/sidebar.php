<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="<?= base_url('dashboard'); ?>">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <?php if ($this->session->userdata('role') == '1') {
    ?>
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admins'); ?>">
          <i class="fas fa-user-cog menu-icon"></i>
          <span class="menu-title">Admins</span>
        </a>
      </li>
    <?php
    } ?>

    <li class="nav-item">
      <a class="nav-link" href="<?= base_url('categories'); ?>">
        <i class="fas fa-layer-group menu-icon"></i>
        <span class="menu-title">Categories</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="<?= base_url('subCategories'); ?>">
        <i class="fas fa-stream menu-icon"></i>
        <span class="menu-title">Sub-Categories</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="<?= base_url('products'); ?>">
        <i class="fas fa-tags menu-icon"></i>
        <span class="menu-title">Products</span>
      </a>
    </li>

    <li class="nav-item <?= ($this->uri->segment(1) == 'sales') ? 'active' : '' ?>">
      <a class="nav-link" href="<?= base_url('sales'); ?>">
        <i class="icon-grid-2 menu-icon"></i>
        <span class="menu-title">Sales</span>
      </a>
    </li>
  </ul>
</nav>