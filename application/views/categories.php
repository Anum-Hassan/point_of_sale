<?php $this->load->view('inc/top') ?>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php $this->load->view('inc/nav') ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <?php $this->load->view('inc/sidebar') ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper ">
          <div class="card-header bg-transparent">
            <h3 class="text-primary">Categories</h3>
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
                                  Add Category
                                </button>
                              </div>
                              <!-- Modal Code (your provided modal HTML) -->
                              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" style="margin-top: 70px;" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h3 class="modal-title text-primary" id="exampleModalLabel">Add Category</h3>
                                      <button type="button" class="btn btn-secondary fas fa-times" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <!-- Form for Adding Admin -->
                                      <form action="<?= base_url('CategoryController/insert'); ?>" class="row g-3 needs-validation" method="post" enctype="multipart/form-data" novalidate>
                                        <!-- Category Name -->
                                        <div class="col-md-12 mt-3">
                                          <label for="name" class="form-label text-capitalize">Name</label>
                                          <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name'); ?>" required placeholder="Category Name">
                                          <?= form_error('name'); ?>
                                        </div>

                                        <!-- Category Image -->

                                        <div class="col-md-12 mt-3">
                                          <label for="image" class="form-label">Category Image</label>
                                          <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                          <?= isset($error) ? $error : ''; ?>
                                        </div>

                                        <!-- Category Status -->
                                        <div class="col-md-12 mt-3">
                                          <label for="status" class="form-label text-capitalize">Status</label>
                                          <select class="form-control" id="status" name="status" required>
                                            <option value="1" <?= set_select('status', '1'); ?>>Published</option>
                                            <option value="0" <?= set_select('status', '0'); ?>>Unpublished</option>
                                          </select>
                                          <?= form_error('status'); ?>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-md-12 mt-3">
                                          <button type="submit" class="btn btn-primary">Add Category</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>


                              <div class="card-body pt-0">
                                <div class="table-responsive">
                                  <table id="myTable" class="table-hover table-striped table-dashboard mb-0 text-center display expandable-table">
                                    <thead class="text-uppercase">
                                      <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Created at</th>
                                        <th class="text-center">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody class="">
                                      <?php $sr = 1; ?>
                                      <?php foreach ($categories as $category): ?>
                                        <tr>
                                          <td class="text-center"><?= $sr++; ?></td>
                                          <td class="text-center"><?= $category['name'] ?></td>
                                          <td class="text-center">
                                            <img src="<?= base_url('uploads/categories/' . $category['image']); ?>" alt="" height="60px" width="60px" class="rounded-circle">
                                          </td>
                                          <td>
                                            <?php if ($category['status'] == 1): ?>
                                              <a href="<?= base_url('CategoryController/changeStatus/' . $category['id'] . '/0') ?>" class="btn btn-sm btn-primary text-white">Published</a>
                                            <?php else: ?>
                                              <a href="<?= base_url('CategoryController/changeStatus/' . $category['id'] . '/1') ?>" class="btn btn-sm btn-secondary text-white">Unpublished</a>
                                            <?php endif; ?>
                                          </td>
                                          <td>
                                            <?= date("d-m-y H:i:s A", strtotime($category['created_at'])) ?>
                                          </td>
                                          <td>
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editAdminModal"
                                              onclick="editCategory(<?= $category['id'] ?>, '<?= $category['name'] ?>', '<?= $category['image'] ?>', '<?= $category['status'] ?>')">
                                              <span class="fas fa-pen"></span>
                                            </button>


                                            <!-- Delete button -->
                                            <a href="<?= base_url('CategoryController/delete/' . $category['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure?');"><span class="fas fa-trash"></span></a>
                                          </td>
                                          </td>
                                        </tr>
                                      <?php endforeach; ?>
                                    </tbody>
                                  </table>

                                  <!-- Modal for editing admin -->
                                  <div class="modal fade" id="editAdminModal" tabindex="-1" role="dialog" aria-labelledby="editAdminModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" style="margin-top: 70px;" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h3 class="modal-title text-primary" id="editAdminModalLabel">Edit Category</h3>
                                          <button type="button" class="btn btn-secondary fas fa-times" data-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                          <form action="<?= base_url('CategoryController/update'); ?>" method="POST" enctype="multipart/form-data" class="row g-3">
                                            <!-- Hidden field for category ID and old image -->
                                            <input type="hidden" name="id" id="admin_id" value="">
                                            <input type="hidden" name="old_image" id="old_image" value="">

                                            <div class="col-md-12 mt-3">
                                              <label for="name" class="form-label text-capitalize">Name</label>
                                              <input type="text" class="form-control" id="admin_name" name="name" required>
                                            </div>

                                            <!-- New image input -->
                                            <div class="col-md-12 mt-3">
                                              <label for="image" class="form-label text-capitalize">Upload New Image</label>
                                              <input type="file" class="form-control" id="admin_image" name="image" accept="image/*">
                                            </div>

                                            <!-- Status dropdown -->
                                            <div class="col-md-12 mt-3">
                                              <label for="status" class="form-label text-capitalize">Status</label>
                                              <select class="form-control" id="status" name="status" required>
                                                <option value="1">Published</option>
                                                <option value="0">Unpublished</option>
                                              </select>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                              <button type="submit" class="btn btn-primary">Update Category</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
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
  </div>
  <?php $this->load->view('inc/footer')?>
  <?php $this->load->view('inc/bottom')?>