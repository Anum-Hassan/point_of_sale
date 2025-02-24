<?php $this->load->view('inc/top') ?>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php $this->load->view('inc/nav') ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php $this->load->view('inc/sidebar') ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper ">
          <div class="card-header bg-transparent">
            <h3 class="text-primary">Sub Categories</h3>
          </div>
          <div class="content-wrapper ">
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

                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSubCategoryModal">
                            Add Sub-Category
                          </button>
                        </div>
                        <!-- Sub-Categories Table -->
                        <div class="card-body pt-0">
                          <div class="table-responsive">
                            <table id="myTable" class="table-hover table-striped table-dashboard mb-0 text-center display expandable-table">
                              <thead class="text-uppercase">
                                <tr>
                                  <th class="text-center">#</th>
                                  <th class="text-center">Category Name</th>
                                  <th class="text-center">Sub-Category Name</th>
                                  <th class="text-center">Image</th>
                                  <th class="text-center">Status</th>
                                  <th class="text-center">Created at</th>
                                  <th class="text-center">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php $sr = 1; ?>
                                <?php foreach ($sub_categories as $sub_category): ?>
                                  <tr>
                                    <td><?= $sr++; ?></td>
                                    <td><?= $sub_category['category_name']; ?></td>
                                    <td><?= $sub_category['name']; ?></td>
                                    <td>
                                      <?php if (!empty($sub_category['image'])): ?>
                                        <img src="<?= base_url('uploads/sub-category/' . $sub_category['image']); ?>" alt="Image" width="70px" height="70px">
                                      <?php else: ?>
                                        No Image
                                      <?php endif; ?>
                                    </td>
                                    <td>
                                      <?php if ($sub_category['status'] == 1): ?>
                                        <a href="<?= base_url('SubController/changeStatus/' . $sub_category['id'] . '/0'); ?>" class="btn btn-primary text-white">Published</a>
                                      <?php else: ?>
                                        <a href="<?= base_url('SubController/changeStatus/' . $sub_category['id'] . '/1'); ?>" class="btn btn-secondary text-white">Unpublished</a>
                                      <?php endif; ?>
                                    </td>
                                    <td>
                                      <?= date("d-m-y H:i:s A", strtotime($sub_category['created_at'])) ?>
                                    </td>
                                    <td>
                                      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editAdminModal">
                                        <span class="fas fa-pen"></span>
                                      </button>
                                      <a href="<?= base_url('SubController/delete/' . $sub_category['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');"><span class="fas fa-trash"></span></< /a>
                                    </td>
                                  </tr>
                                <?php endforeach; ?>
                              </tbody>
                            </table>

                            <!-- Modal for adding new sub-category -->
                            <div class="modal fade" id="addSubCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h3 class="modal-title text-primary" id="exampleModalLabel">Add Sub-Category</h3>
                                    <button type="button" class="btn btn-secondary fas fa-times" data-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <!-- Form for Adding Admin -->
                                    <form action="<?= base_url('SubController/insert') ?>" method="POST" enctype="multipart/form-data">
                                      <div class="col-md-12 mt-3">
                                        <label for="category_id" class="form-label text-capitalize">Category</label>
                                        <select ame="category_id" id="category_id" class="form-control" required>
                                          <option value="">Select Category</option>
                                          <?php if (isset($categories) && !empty($categories)): ?>
                                            <?php foreach ($categories as $category): ?>
                                              <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                                            <?php endforeach; ?>
                                          <?php else: ?>
                                            <option value="">No categories available</option>
                                          <?php endif; ?>
                                        </select>
                                      </div>

                                      <!-- Sub-Category Name -->
                                      <div class="col-md-12 mt-3">
                                        <label for="name" class="form-label text-capitalize">Sub-Category Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Sub-Category Name">
                                      </div>

                                      <!-- Image Upload -->
                                      <div class="col-md-12 mt-3">
                                        <label for="image" class="form-label text-capitalize">Sub-Category Image</label>
                                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                      </div>

                                      <!-- Status Dropdown -->
                                      <div class="col-md-12 mt-3">
                                        <label for="status" id="status" class="form-label text-capitalize">Status</label>
                                        <select name="status" class="form-control">
                                          <option value="1">Published</option>
                                          <option value="0">Unpublished</option>
                                        </select>
                                      </div>

                                      <!-- Submit Button -->
                                      <div class="modal-footer mt-3">
                                        <button type="submit" class="btn btn-primary">Add Sub-Category</button>
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
    <?php $this->load->view('inc/footer')?>
    <?php $this->load->view('inc/bottom')?>
</body>