<?php $this->load->view('inc/top') ?>

<body>
  <div class="container-scroller">
    <?php $this->load->view('inc/nav') ?>

    <div class="container-fluid page-body-wrapper">
      <div class="theme-setting-wrapper">
        <div id="theme-settings" class="settings-panel">
          <div class="color-tiles mx-0 px-4">
          </div>
        </div>
      </div>
      <?php $this->load->view('inc/sidebar') ?>
      <div class="main-panel">
        <div class="content-wrapper ">
          <div class="card-header bg-transparent">
            <h3 class="text-primary">Admins</h3>
          </div>
          <div class="content-wrapper ">
            <div class="container fluid ">
              <div class="row">
                <div class="col-lg-12">

                  <section class="tables mx-auto">
                    <div class="container-fluid">
                      <div class="row gy-4">
                        <div class="col-lg-12">
                          <div class="card mb-0">
                            <div class="card-header bg-transparent">
                              <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">

                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                  <?php echo $this->session->flashdata('success'); ?>
                                </div>
                              <?php endif; ?>

                              <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">

                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                  <?php echo $this->session->flashdata('error'); ?>
                                </div>
                              <?php endif; ?>
                              <div class="card-header bg-transparent">

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                  Add Admin
                                </button>
                              </div>
                              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h3 class="modal-title text-primary" id="exampleModalLabel">Add Admin</h3>
                                      <button type="button" class="btn btn-secondary fas fa-times" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <form action="<?= base_url('AdminController/insert'); ?>" class="row g-3 needs-validation" method="post" enctype="multipart/form-data" novalidate>
                                        <div class="col-md-6 mt-3">
                                          <label for="name" class="form-label text-capitalize">Name</label>
                                          <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name'); ?>" required placeholder="Admin Name">
                                          <?= form_error('name'); ?>
                                        </div>

                                        <div class="col-md-6 mt-3">
                                          <label for="password" class="form-label text-capitalize">Password</label>
                                          <input type="password" class="form-control" id="password" name="password" value="<?= set_value('password'); ?>" required placeholder="******">
                                          <?= form_error('password'); ?>
                                        </div>

                                        <div class="col-md-12 mt-3">
                                          <label for="email" class="form-label text-capitalize">Email</label>
                                          <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email'); ?>" required placeholder="admin@example.com">
                                          <?= form_error('email'); ?>
                                        </div>

                                        <!-- Admin Image -->
                                        <div class="col-md-12 mt-3">
                                          <label for="image" class="form-label text-capitalize">Profile Image</label>
                                          <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                          <?= isset($error) ? $error : ''; ?>
                                        </div>

                                        <!-- Admin Role -->
                                        <div class="col-md-12 mt-3">
                                          <label for="role" class="form-label text-capitalize">Role</label>
                                          <select class="form-control" id="role" name="role" required>
                                            <option value="admin" <?= set_select('role', 'admin'); ?>>Admin</option>
                                            <option value="staff" <?= set_select('role', 'staff'); ?>>Staff</option>
                                          </select>
                                          <?= form_error('role'); ?>
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-12 mt-3">
                                          <label for="status" class="form-label text-capitalize">Status</label>
                                          <select class="form-control" id="status" name="status" required>
                                            <option value="1" <?= set_select('status', '1'); ?>>Active</option>
                                            <option value="0" <?= set_select('status', '0'); ?>>In Active</option>
                                          </select>
                                          <?= form_error('status'); ?>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-md-12 mt-3">
                                          <button type="submit" class="btn btn-primary">Add Admin</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="card-body pt-0">
                                <div class="table-responsive">
                                  <table id="myTable" class=" table-hover table-striped table-dashboard mb-0 text-center display expandable-table">
                                    <thead class="text-uppercase">
                                      <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Created at</th>
                                        <th class="text-center">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody class="">
                                      <?php $sr = 1;
                                      foreach ($admins as $admin): ?>
                                        <tr>
                                          <td><?= $sr++; ?></td>
                                          <td><?= $admin->name; ?></td>
                                          <td><?= $admin->email; ?></td>
                                          <td><img src="<?= base_url($admin->image); ?>" alt="Image" class="rounded-circle" width="50px" height="50px">
                                          </td>
                                          <td><?= $admin->role == 1 ? '<button class="btn btn-primary">Admin</button>' : '<button class="btn btn-secondary text-white">Staff</button>'; ?></td>
                                          <td><?= ($admin->status == 1) ? '<button class="btn btn-primary">Active</button>' : '<button class="btn btn-secondary text-white ">In Active</button>'; ?></td>
                                          <td><?= $admin->created_at; ?></td>
                                          <td>
                                            <!-- Edit button with data-id for the selected admin -->


                                            <!-- Trigger modal for editing admin -->
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editAdminModal"
                                              onclick="editAdmin(<?= $admin->id ?>, '<?= $admin->name ?>', '<?= $admin->email ?>', '<?= $admin->role ?>', '<?= $admin->status ?>', '<?= $admin->image ?>')">
                                              <span class="fas fa-pen"></span>
                                            </button>


                                            <!-- Delete button -->
                                            <a href="<?= base_url('AdminController/delete/' . $admin->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure?');"><span class="fas fa-trash"></span></a>
                                          </td>
                                        </tr>
                                      <?php endforeach; ?>
                                    </tbody>
                                  </table>

                                  <!-- Modal for editing admin -->
                                  <div class="modal fade" id="editAdminModal" tabindex="-1" role="dialog" aria-labelledby="editAdminModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h3 class="modal-title text-primary" id="editAdminModalLabel">Edit Admin</h3>
                                          <button type="button" class="btn btn-secondary fas fa-times" data-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                          <form action="<?= base_url('AdminController/update/'); ?>" method="POST" enctype="multipart/form-data" class="row g-3">
                                            <!-- Hidden field for admin ID -->
                                            <input type="hidden" name="id" id="admin_id" value="">
                                            <input type="hidden" name="old_image" id="old_image" value="">

                                            <div class="col-md-6 mt-3">
                                              <label for="name" class="form-label text-capitalize">Name</label>
                                              <input type="text" class="form-control" id="admin_name" name="name" required>
                                            </div>

                                            <div class="col-md-6 mt-3">
                                              <label for="password" class="form-label text-capitalize">Password</label>
                                              <input type="password" class="form-control" id="admin_password" name="password" required>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                              <label for="email" class="form-label text-capitalize">Email</label>
                                              <input type="email" class="form-control" id="admin_email" name="email" required>
                                            </div>

                                            <!-- Display current image (if any) -->
                                            <div class="col-md-12 mt-3">
                                              <label for="image" class="form-label text-capitalize">Upload New Image</label>
                                              <input type="file" class="form-control" id="admin_image" name="image" accept="image/*">
                                            </div>


                                            <div class="col-md-12 mt-3">
                                              <label for="role" class="form-label text-capitalize">Role</label>
                                              <select class="form-control" id="admin_role" name="role">
                                                <option value="admin" <?= (['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                                <option value="staff" <?= (['role'] == 'staff') ? 'selected' : ''; ?>>Staff</option>
                                              </select>
                                            </div>


                                            <div class="col-md-12 mt-3">
                                              <label for="status" class="form-label text-capitalize">Status</label>
                                              <select class="form-control" id="admin_status" name="status">
                                                <option value="1">Active</option>
                                                <option value="0">In Active</option>
                                              </select>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                              <button type="submit" class="btn btn-primary">Update Admin</button>
                                            </div>
                                          </form>
                                        </div>

                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <!-- Button trigger modal -->



                              </div>
                              <!-- main-panel ends -->
                            </div>
                            <!-- page-body-wrapper ends -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php $this->load->view('inc/footer')?>
  <?php $this->load->view('inc/bottom')?>
  
</body>

</html>