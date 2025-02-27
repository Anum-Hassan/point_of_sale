<?php $this->load->view('inc/top'); ?>

<body>

  <?php $this->load->view('inc/nav'); ?>

  <div class="container-fluid page-body-wrapper">
    <?php $this->load->view('inc/sidebar'); ?>

    <div class="main-panel">
      <div class="content-wrapper">
        <div class="card-header bg-transparent">
          <h3 class="text-primary">Sales Record</h3>
        </div>
        <div class="content-wrapper">
          <section class="tables mx-auto">
            <div class="container-fluid">
              <div class="row gy-4">
                <div class="col-lg-12">
                  <div class="card mb-0">

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
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSaleModal">
                        Add Sale Record
                      </button>
                    </div>
                    <div class="card-body pt-0">
                      <div class="table-responsive">
                        <table id="salesTable" class="table-hover table-striped table-dashboard mb-0 text-center display expandable-table">
                          <thead class="text-uppercase">
                            <tr>
                              <th>#</th>
                              <th>Invoice No</th>
                              <th>Total Amount</th>
                              <th>Discount</th>
                              <th>Tax</th>
                              <th>Final Amount</th>
                              <th>Payment Method</th>
                              <th>Status</th>
                              <th>Created At</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $sr = 1; ?>
                            <?php foreach ($sales as $sale): ?>
                              <tr>
                                <td><?= $sr++; ?></td>
                                <td><?= $sale['invoice_no']; ?></td>
                                <td><?= $sale['total_amount']; ?></td>
                                <td><?= $sale['discount']; ?></td>
                                <td><?= $sale['tax']; ?></td>
                                <td><?= $sale['final_amount']; ?></td>
                                <td><?= $sale['payment_method']; ?></td>
                                <td>
                                  <?php if ($sale['status'] == 'completed'): ?>
                                    <a href="<?= base_url('SalesController/changeStatus/' . $sale['id'] . '/pending'); ?>" class="btn btn-sm btn-primary text-white">Completed</a>
                                  <?php else: ?>
                                    <a href="<?= base_url('SalesController/changeStatus/' . $sale['id'] . '/completed'); ?>" class="btn btn-sm btn-secondary text-white">Pending</a>
                                  <?php endif; ?>
                                </td>
                                <td><?= $sale['created_at']; ?></td>
                                <td>
                                  <a href="<?= base_url('sales/items/' . $sale['id']); ?>" class="btn btn-outline-primary btn-sm"><span class="fas fa-eye"></span></a>
                                  <button class="btn btn-outline-dark btn-sm"
                                    data-toggle="modal"
                                    data-target="#editSaleModal"
                                    onclick="editSaleItem('<?= $sale['id'] ?>', '<?= $sale['invoice_no'] ?>', '<?= $sale['total_amount'] ?>', '<?= $sale['discount'] ?>', '<?= $sale['tax'] ?>', '<?= $sale['payment_method'] ?>')"><span class="fas fa-pen"></span></button>

                                    <a href="<?= base_url('SalesController/delete/' . $sale['id']); ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?');">
                                      <span class="fas fa-trash"></span>
                                    </a>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>

                        <div class="modal fade" id="addSaleModal" tabindex="-1" role="dialog" aria-labelledby="addSaleModalLabel" aria-hidden="true">
                          <div class="modal-dialog mt-1" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h3 class="modal-title text-primary" id="addSaleItemModalLabel">Add Sale Record</h3>
                                <button type="button" class="btn btn-sm btn-secondary fas fa-times" data-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <!-- Form for Adding Sale -->
                                <form action="<?= base_url('SalesController/insert') ?>" method="POST">
                                  <div class="row">
                                    <div class="col-md-6 mt-3">
                                      <label for="sale_id" class="form-label">Invoice No</label>
                                      <input type="number" name="invoice_no" id="invoice_no" class="form-control" placeholder="Invoice No">
                                    </div>

                                    <div class="col-md-6 mt-3">
                                      <label for="sale_id" class="form-label">Total Amount</label>
                                      <input type="number" name="total_amount" id="total_amount" class="form-control" placeholder="Total Amount">
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-md-6 mt-3">
                                      <label for="discount" class="form-label">Discount</label>
                                      <input type="number" name="discount" id="discount" class="form-control" placeholder="Discount">
                                    </div>

                                    <div class="col-md-6 mt-3">
                                      <label for="tax" class="form-label">Tax</label>
                                      <input type="number" name="tax" id="tax" class="form-control" placeholder="Tax">
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-md-6 mt-3">
                                      <label for="payment_method" class="form-label">Payment Method</label>
                                      <select name="payment_method" id="payment_method" class="form-control">
                                        <option value="">Select Payment Method</option>
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                        <option value="other">Other</option>
                                      </select>
                                    </div>
                                  </div>

                                  <div class="modal-footer mt-3">
                                    <button type="submit" class="btn btn-primary">Add Sale Record</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="modal fade" id="editSaleModal" tabindex="-1" role="dialog" aria-labelledby="editSaleModalLabel" aria-hidden="true">
                          <div class="modal-dialog mt-1" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h3 class="modal-title text-primary" id="editProductModalLabel">Edit Sale Record</h3>
                                <button type="button" class="btn btn-sm btn-secondary fas fa-times" data-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <!-- Form for Editing Sale -->
                                <form action="<?= base_url('SalesController/update') ?>" method="POST">
                                  <input type="hidden" name="id" id="edit_sale_id">
                                  <div class="row">
                                    <div class="col-md-6 mt-3">
                                      <label for="sale_id" class="form-label">Invoice No</label>
                                      <input type="number" name="invoice_no" id="edit_invoice_no" class="form-control" placeholder="Invoice No" readonly>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                      <label for="sale_id" class="form-label">Total Amount</label>
                                      <input type="number" name="total_amount" id="edit_total_amount" class="form-control" placeholder="Total Amount" readonly>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-md-6 mt-3">
                                      <label for="discount" class="form-label">Discount</label>
                                      <input type="number" name="discount" id="edit_discount" class="form-control" placeholder="Discount">
                                    </div>

                                    <div class="col-md-6 mt-3">
                                      <label for="tax" class="form-label">Tax</label>
                                      <input type="number" name="tax" id="edit_tax" class="form-control" placeholder="Tax">
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-md-6 mt-3">
                                      <label for="payment_method" class="form-label">Payment Method</label>
                                      <select name="payment_method" id="edit_payment_method" class="form-control">
                                        <option value="">Select Payment Method</option>
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                        <option value="other">Other</option>
                                      </select>
                                    </div>
                                  </div>

                                  <div class="modal-footer mt-3">
                                    <button type="submit" class="btn btn-primary">Update Sale Record</button>
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
          </section>
        </div>
      </div>
    </div>
  </div>

  <?php $this->load->view('inc/footer'); ?>
  <?php $this->load->view('inc/bottom'); ?>
  <script>
    function editSaleItem(id, invoice_no, total_amount, discount, tax, payment_method) {
      document.getElementById('edit_sale_id').value = id;
      document.getElementById('edit_invoice_no').value = invoice_no;
      document.getElementById('edit_total_amount').value = total_amount;
      document.getElementById('edit_discount').value = discount;
      document.getElementById('edit_tax').value = tax;
      document.getElementById('edit_payment_method').value = payment_method;
    }
  </script>
</body>