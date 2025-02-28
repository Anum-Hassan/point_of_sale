<?php $this->load->view('inc/top') ?>

<body>

  <?php $this->load->view('inc/nav') ?>

  <div class="container-fluid page-body-wrapper">

    <?php $this->load->view('inc/sidebar') ?>

    <div class="main-panel">
      <div class="content-wrapper">
        <div class="card-header bg-transparent">
          <h3 class="text-primary">Sales Items</h3>
        </div>
        <div class="content-wrapper">
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSaleItemModal" data-sale-id="<?= isset($sale['id']) ? $sale['id'] : ''; ?>">
                          Add Sale Item
                        </button>

                      </div>

                      <!-- Sales Items Table -->
                      <div class="card-body pt-0">
                        <div class="table-responsive">
                          <table id="salesItemsTable" class="table-hover table-striped table-dashboard mb-0 text-center display expandable-table">
                            <thead class="text-uppercase">
                              <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Sale ID</th>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Created Date</th>
                                <th class="text-center">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $sr = 1; ?>
                              <?php foreach ($sales_items as $item): ?>
                                <tr>
                                  <td><?= $sr++; ?></td>
                                  <td><?= $item['sale_id']; ?></td>
                                  <td><?= $item['product_name']; ?></td>
                                  <td><?= $item['price']; ?></td>
                                  <td><?= $item['quantity']; ?></td>
                                  <td><?= $item['total']; ?></td>
                                  <td><?= date("d-m-Y H:i:s A", strtotime($item['created_at'])) ?></td>
                                  <td>
                                    <button class="btn btn-outline-primary btn-sm"
                                      data-toggle="modal"
                                      data-target="#editSaleModal"
                                      onclick="editSaleItem(<?= $item['id'] ?>, <?= $item['sale_id'] ?>, <?= $item['product_id'] ?>, <?= $item['quantity'] ?>, <?= $item['price'] ?>, <?= $item['total'] ?>)">
                                      <span class="fas fa-pen"></span>
                                    </button>

                                    <a href="<?= base_url('SalesController/deleteItem/' . $item['id']); ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?');">
                                      <span class="fas fa-trash"></span>
                                    </a>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>

                          <!-- Modal for Adding Sale Item -->
                          <div class="modal fade" id="addSaleItemModal" tabindex="-1" role="dialog" aria-labelledby="addSaleItemModalLabel" aria-hidden="true">
                            <div class="modal-dialog mt-5" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title text-primary" id="addSaleItemModalLabel">Add Sale Item</h3>
                                  <button type="button" class="btn btn-sm btn-secondary fas fa-times" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <!-- Form for Adding Sale Item -->
                                  <form action="<?= base_url('SalesController/insertItem') ?>" method="POST">
                                    <div class="row">
                                      <div class="col-md-6 mt-3">
                                        <label for="sale_id" class="form-label">Sale ID</label>
                                        <input type="number" name="sale_id" id="sale_id" class="form-control" placeholder="Sale ID" readonly>
                                      </div>

                                      <div class="col-md-6 mt-3">
                                        <label for="product_id" class="form-label">Product</label>
                                        <select name="product_id" id="product_id" class="form-control">
                                          <option value="">Select Product</option>
                                          <?php if (!empty($products)): ?>
                                            <?php foreach ($products as $product): ?>
                                              <option value="<?= $product['id'] ?>" data-price="<?= $product['price'] ?>">
                                                <?= $product['name'] ?>
                                              </option>
                                            <?php endforeach; ?>
                                          <?php else: ?>
                                            <option value="">No products available</option>
                                          <?php endif; ?>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-6 mt-3">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantity">
                                      </div>

                                      <div class="col-md-6 mt-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" name="price" id="price" class="form-control" placeholder="Price">
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-6 mt-3">
                                        <label for="total" class="form-label">Total</label>
                                        <input type="number" name="total" id="total" class="form-control" placeholder="Total" readonly>
                                      </div>
                                    </div>

                                    <div class="modal-footer mt-3">
                                      <button type="submit" class="btn btn-primary">Add Item</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="modal fade" id="editSaleModal" tabindex="-1" role="dialog" aria-labelledby="editSaleModalLabel" aria-hidden="true">
                            <div class="modal-dialog mt-5" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h3 class="modal-title text-primary" id="editProductModalLabel">Edit Sale Item</h3>
                                  <button type="button" class="btn btn-sm btn-secondary fas fa-times" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <!-- Form for Editing Sale -->
                                  <form action="<?= base_url('SalesController/updateItem') ?>" method="POST">
                                    <input type="hidden" name="id" id="edit_id"> 
                                    <div class="row">
                                      <div class="col-md-6 mt-3">
                                        <label for="edit_sale_id" class="form-label">Sale ID</label>
                                        <input type="number" name="sale_id" id="edit_sale_id" class="form-control" placeholder="Sale ID" readonly>
                                      </div>

                                      <div class="col-md-6 mt-3">
                                        <label for="edit_product_id" class="form-label">Product</label>
                                        <select name="product_id" id="edit_product_id" class="form-control">
                                          <option value="">Select Product</option>
                                          <?php foreach ($products as $product): ?>
                                            <option value="<?= $product['id'] ?>" data-price="<?= $product['price'] ?>">
                                              <?= $product['name'] ?>
                                            </option>
                                          <?php endforeach; ?>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-6 mt-3">
                                        <label for="edit_quantity" class="form-label">Quantity</label>
                                        <input type="number" name="quantity" id="edit_quantity" class="form-control" placeholder="Quantity">
                                      </div>

                                      <div class="col-md-6 mt-3">
                                        <label for="edit_price" class="form-label">Price</label>
                                        <input type="number" name="price" id="edit_price" class="form-control" placeholder="Price">
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-6 mt-3">
                                        <label for="edit_total" class="form-label">Total</label>
                                        <input type="number" name="total" id="edit_total" class="form-control" placeholder="Total" readonly>
                                      </div>
                                    </div>

                                    <div class="modal-footer mt-3">
                                      <button type="submit" class="btn btn-primary">Update Item</button>
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
    $(document).ready(function() {
      // Auto-fill Sale ID when opening the modal
      $('#addSaleItemModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var saleId = button.data('sale-id'); // Extract sale ID from data-sale-id attribute
        $('#sale_id').val(saleId); // Set the sale_id input field
      });

      // Auto-update total based on quantity and price
      $('#product_id').change(function() {
        let selectedOption = $(this).find('option:selected');
        let price = selectedOption.data('price') || 0;
        $('#price').val(price);

        let qty = $('#quantity').val() || 0;
        $('#total').val(qty * price);
      });

      $('#quantity').on('input', function() {
        let qty = $(this).val();
        let price = $('#price').val();
        $('#total').val(qty * price);
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      $('#product_id').change(function() {
        let selectedOption = $(this).find('option:selected');
        let price = selectedOption.data('price') || 0;
        $('#price').val(price);

        let qty = $('#quantity').val() || 0;
        $('#total').val(qty * price);
      });

      $('#quantity').on('input', function() {
        let qty = $(this).val();
        let price = $('#price').val();
        $('#total').val(qty * price);
      });
    });

    function editSaleItem(id, sale_id, product_id, quantity, price, total) {
      $('#edit_id').val(id);
      $('#edit_sale_id').val(sale_id);
      $('#edit_product_id').val(product_id);
      $('#edit_quantity').val(quantity);
      $('#edit_price').val(price);
      $('#edit_total').val(total);
      $('#editSaleModal').modal('show');
    }

    $('#quantity, #price').on('input', function() {
      let qty = $('#quantity').val();
      let price = $('#price').val();
      let total = qty * price;
      $('#total').val(total);
    });
  </script>

</body>