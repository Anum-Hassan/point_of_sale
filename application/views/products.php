<?php $this->load->view('inc/top') ?>

<body>

  <?php $this->load->view('inc/nav') ?>

  <div class="container-fluid page-body-wrapper">

    <?php $this->load->view('inc/sidebar') ?>

    <div class="main-panel" >
      <div class="content-wrapper ">
        <div class="card-header bg-transparent">
          <h3 class="text-primary">Products</h3>
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

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">
                          Add Product
                        </button>
                      </div>
                      <!-- Sub-Categories Table -->
                      <div class="card-body pt-0">
                        <div class="table-responsive">
                          <table id="myTable" class="table-hover table-striped table-dashboard mb-0 text-center display expandable-table">
                            <thead class="text-uppercase">
                              <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Sub-Category</th>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Image</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">MRP</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Short Description</th>
                                <th class="text-center">Long Description</th>
                                <th class="text-center">Created at</th>
                                <th class="text-center">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $sr = 1; ?>
                              <?php foreach ($products as $product): ?>
                                <tr>
                                  <td><?= $sr++; ?></td>
                                  <td><?= $product['category_name']; ?></td>
                                  <td><?= $product['sub_category_name']; ?></td>
                                  <td><?= $product['name']; ?></td>
                                  <td>
                                    <?php if (!empty($product['image'])): ?>
                                      <img src="<?= base_url('uploads/products/' . $product['image']); ?>" alt="Image" height="70px" width="70px" class="rounded-circle">
                                    <?php else: ?>
                                      No Image
                                    <?php endif; ?>
                                  </td>
                                  <td><?= $product['qty']; ?></td>
                                  <td><?= $product['mrp']; ?></td>
                                  <td><?= $product['price']; ?></td>
                                  <td>
                                    <?php if ($product['status'] == 1): ?>
                                      <a href="<?= base_url('ProductController/changeStatus/' . $product['id'] . '/0'); ?>" class="btn btn-sm btn-primary text-white">InStock</a>
                                    <?php else: ?>
                                      <a href="<?= base_url('ProductController/changeStatus/' . $product['id'] . '/1'); ?>" class="btn btn-sm btn-secondary text-white">OutOfStock</a>
                                    <?php endif; ?>
                                  </td>
                                  <td><?= $product['short_description']; ?></td>
                                  <td><?= $product['long_description']; ?></td>
                                  <td>
                                    <?= date("d-m-y H:i:s A", strtotime($product['created_at'])) ?>
                                  </td>
                                  <td>
                                    <button class="btn btn-outline-primary btn-sm"
                                      data-toggle="modal"
                                      data-target="#editProductModal"
                                      onclick="editProduct(<?= $product['id'] ?>, <?= $product['category_id'] ?>, <?= $product['sub_category_id'] ?>, '<?= $product['name'] ?>', <?= $product['qty'] ?>, <?= $product['mrp'] ?>, <?= $product['price'] ?>, '<?= $product['image'] ?>', '<?= $product['short_description'] ?>', '<?= $product['long_description'] ?>')">
                                      <span class="fas fa-pen"></span>
                                    </button>

                                    <a href="<?= base_url('ProductController/delete/' . $product['id']); ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?');"><span class="fas fa-trash"></span></< /a>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>

                          <!-- Modal for adding new product -->
                          <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog mt-1" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title text-primary" id="exampleModalLabel">Add Product</h3>
                                  <button type="button" class="btn btn-sm btn-secondary fas fa-times" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <!-- Form for Adding Product -->
                                  <form action="<?= base_url('ProductController/insert') ?>" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                      <!-- Category Dropdown -->
                                      <div class="col-md-6 mt-3">
                                        <label for="category_id" class="form-label text-capitalize">Category</label>
                                        <select name="category_id" id="category_id" class="form-control" required onchange="fetchSubCategories(this.value)">
                                          <option value="">Select Category</option>
                                          <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                                          <?php endforeach; ?>
                                        </select>
                                      </div>

                                      <!-- Subcategory Dropdown -->
                                      <div class="col-md-6 mt-3">
                                        <label for="sub_category_id" class="form-label text-capitalize">SubCategory</label>
                                        <select name="sub_category_id" id="sub_category_id" class="form-control" required>
                                          <option value="">Select SubCategory</option>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <!-- Product Name -->
                                      <div class="col-md-6 mt-3">
                                        <label for="name" class="form-label text-capitalize">Product Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Product Name">
                                      </div>
                                      <!-- Quantity -->
                                      <div class="col-md-6 mt-3">
                                        <label for="qty" class="form-label text-capitalize">Quantity</label>
                                        <input type="number" name="qty" id="qty" class="form-control" placeholder="Quantity">
                                      </div>
                                    </div>

                                    <div class="row">
                                      <!-- Product Name -->
                                      <div class="col-md-6 mt-3">
                                        <label for="mrp" class="form-label text-capitalize">MRP</label>
                                        <input type="number" name="mrp" id="mrp" class="form-control" placeholder="MRP">
                                      </div>
                                      <!-- Quantity -->
                                      <div class="col-md-6 mt-3">
                                        <label for="price" class="form-label text-capitalize">Price</label>
                                        <input type="number" name="price" id="price" class="form-control" placeholder="Price">
                                      </div>
                                    </div>

                                    <!-- Image Upload -->
                                    <div class="row">
                                      <div class="col-md-12 mt-3">
                                        <label for="image" class="form-label text-capitalize">Product Image</label>
                                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                      </div>
                                    </div>

                                    <div class="row">
                                      <!-- Product Name -->
                                      <div class="col-md-6 mt-3">
                                        <label for="shortDesc" class="form-label text-capitalize">Short Description</label>
                                        <textarea type="text" name="shortDesc" id="shortDesc" class="form-control"></textarea>
                                      </div>
                                      <!-- Quantity -->
                                      <div class="col-md-6 mt-3">
                                        <label for="longDesc" class="form-label text-capitalize">Long Description</label>
                                        <textarea type="text" name="longDesc" id="longDesc" class="form-control"></textarea>
                                      </div>
                                    </div>
                                    <!-- Submit Button -->
                                    <div class="modal-footer mt-3">
                                      <button type="submit" class="btn btn-primary">Add Product</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
                            <div class="modal-dialog mt-1" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title text-primary" id="editProductModalLabel">Edit Product</h3>
                                  <button type="button" class="btn btn-sm btn-secondary fas fa-times" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <!-- Form for Editing Product -->
                                  <form action="<?= base_url('ProductController/update') ?>" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" id="edit_product_id" value="">
                                    <input type="hidden" name="old_image" id="edit_old_image" value="">
                                    <div class="row">
                                      <!-- Category Dropdown -->
                                      <div class="col-md-6 mt-3">
                                        <label for="edit_category_id" class="form-label text-capitalize">Category</label>
                                        <select name="category_id" id="edit_category_id" class="form-control" required onchange="fetchSubCategories(this.value, null, 'edit_sub_category_id')">
                                          <option value="">Select Category</option>
                                          <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                                          <?php endforeach; ?>
                                        </select>
                                      </div>

                                      <div class="col-md-6 mt-3">
                                        <label for="edit_sub_category_id" class="form-label text-capitalize">SubCategory</label>
                                        <select name="sub_category_id" id="edit_sub_category_id" class="form-control" required>
                                          <option value="">Select SubCategory</option>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-6 mt-3">
                                        <label for="edit_name" class="form-label text-capitalize">Product Name</label>
                                        <input type="text" name="name" id="edit_name" class="form-control" placeholder="Product Name">
                                      </div>
                                      <div class="col-md-6 mt-3">
                                        <label for="edit_qty" class="form-label text-capitalize">Quantity</label>
                                        <input type="number" name="qty" id="edit_qty" class="form-control" placeholder="Quantity">
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6 mt-3">
                                        <label for="edit_mrp" class="form-label text-capitalize">MRP</label>
                                        <input type="number" name="mrp" id="edit_mrp" class="form-control" placeholder="MRP">
                                      </div>
                                      <div class="col-md-6 mt-3">
                                        <label for="edit_price" class="form-label text-capitalize">Price</label>
                                        <input type="number" name="price" id="edit_price" class="form-control" placeholder="Price">
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-12 mt-3">
                                        <label for="edit_image" class="form-label text-capitalize">Product Image</label>
                                        <input type="file" name="image" id="edit_image" class="form-control" accept="image/*">
                                        <div class="mt-2">
                                          <img id="edit_preview_image" src="" alt="Image Preview" height="70px" width="70px" class="rounded-circle" style="display: none;">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6 mt-3">
                                        <label for="edit_shortDesc" class="form-label text-capitalize">Short Description</label>
                                        <textarea name="shortDesc" id="edit_shortDesc" class="form-control"></textarea>
                                      </div>
                                      <div class="col-md-6 mt-3">
                                        <label for="edit_longDesc" class="form-label text-capitalize">Long Description</label>
                                        <textarea name="longDesc" id="edit_longDesc" class="form-control"></textarea>
                                      </div>
                                    </div>
                                    <div class="modal-footer mt-3">
                                      <button type="submit" class="btn btn-primary">Update Product</button>
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
  <?php $this->load->view('inc/footer') ?>
  <?php $this->load->view('inc/bottom') ?>
  <script>
    function fetchSubCategories(categoryId, selectedSubCategoryId = null, targetDropdownId = "sub_category_id") {
      $.ajax({
        url: "<?= base_url('ProductController/getSubCategories') ?>",
        type: "POST",
        data: {
          category_id: categoryId
        },
        dataType: "json",
        success: function(response) {
          let subCategoryDropdown = $("#" + targetDropdownId); // Target dropdown dynamically
          subCategoryDropdown.empty();
          subCategoryDropdown.append('<option value="">Select SubCategory</option>');

          if (response.length > 0) {
            $.each(response, function(index, subCategory) {
              let isSelected = (selectedSubCategoryId == subCategory.id) ? "selected" : "";
              subCategoryDropdown.append('<option value="' + subCategory.id + '" ' + isSelected + '>' + subCategory.name + '</option>');
            });
          } else {
            subCategoryDropdown.append('<option value="">No Subcategories Available</option>');
          }
        }
      });
    }

    function editProduct(id, category_id, sub_category_id, name, qty, mrp, price, image, shortDesc, longDesc) {
      document.getElementById('edit_product_id').value = id;
      document.getElementById('edit_category_id').value = category_id;
      document.getElementById('edit_name').value = name;
      document.getElementById('edit_qty').value = qty;
      document.getElementById('edit_mrp').value = mrp;
      document.getElementById('edit_price').value = price;
      document.getElementById('edit_shortDesc').value = shortDesc;
      document.getElementById('edit_longDesc').value = longDesc;
      document.getElementById('edit_old_image').value = image;

      fetchSubCategories(category_id, sub_category_id, "edit_sub_category_id");

      if (image) {
        document.getElementById('edit_preview_image').src = 'uploads/products/' + image;
        document.getElementById('edit_preview_image').style.display = 'block';
      } else {
        document.getElementById('edit_preview_image').style.display = 'none';
      }
    }
  </script>
</body>