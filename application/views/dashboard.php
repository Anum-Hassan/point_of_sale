<?php $this->load->view('inc/top'); ?>

<body>
  <div class="container-scroller">
    <?php $this->load->view('inc/nav'); ?>

    <div class="container-fluid page-body-wrapper">
      <?php $this->load->view('inc/btn')?>
      <?php $this->load->view('inc/sidebar'); ?>

      <div class="main-panel" >
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <?php
                  $total_sales = $this->db->select_sum('total_amount')->get('sales')->row()->total_amount;
                  $total_orders = $this->db->count_all('sales');
                  $total_products = $this->db->count_all('products');
                  $total_items_sold = $this->db->select_sum('quantity')->get('sales_items')->row()->quantity;

                  // Fetch sales data grouped by month
                  $sales_data = $this->db->query("SELECT MONTH(created_at) AS month, SUM(final_amount) AS total_sales FROM sales GROUP BY MONTH(created_at)")->result_array();
                  $orders_data = $this->db->query("SELECT MONTH(created_at) AS month, COUNT(id) AS total_orders FROM sales WHERE status='completed' GROUP BY MONTH(created_at)")->result_array();
                ?>
                <div class="col-md-3 stretch-card">
                  <div class="card card-tale">
                    <div class="card-body">
                      <p class="mb-4">Total Profit</p>
                      <p class="fs-30 mb-2"><?= number_format($total_sales, 2) ?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 stretch-card">
                  <div class="card card-dark-blue">
                    <div class="card-body">
                      <p class="mb-4">Total Sales</p>
                      <p class="fs-30 mb-2"><?= $total_orders ?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 stretch-card">
                  <div class="card card-light-blue">
                    <div class="card-body">
                      <p class="mb-4">Total Products</p>
                      <p class="fs-30 mb-2"><?= $total_products ?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 stretch-card">
                  <div class="card card-light-danger">
                    <div class="card-body">
                      <p class="mb-4">Total Items Sold</p>
                      <p class="fs-30 mb-2"><?= $total_items_sold ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Sales Profit</h4>
                  <canvas id="salesChart"></canvas>
                </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Total Sales</h4>
                  <canvas id="ordersChart"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php $this->load->view('inc/footer') ?>
  <?php $this->load->view('inc/bottom') ?>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    var salesData = <?= json_encode(array_column($sales_data, 'total_sales')) ?>;
    var salesLabels = <?= json_encode(array_map(function($m) { return date('M', mktime(0, 0, 0, $m, 1)); }, array_column($sales_data, 'month'))) ?>;
    
    var salesCtx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(salesCtx, {
      type: 'line',
      data: {
        labels: salesLabels,
        datasets: [{
          label: 'Total Sales',
          data: salesData,
          borderColor: '#7DA0FA',
          fill: false
        }]
      }
    });

    var ordersData = <?= json_encode(array_column($orders_data, 'total_orders')) ?>;
    var ordersLabels = <?= json_encode(array_map(function($m) { return date('M', mktime(0, 0, 0, $m, 1)); }, array_column($orders_data, 'month'))) ?>;
    
    var ordersCtx = document.getElementById('ordersChart').getContext('2d');
    var ordersChart = new Chart(ordersCtx, {
      type: 'bar',
      data: {
        labels: ordersLabels,
        datasets: [{
          label: 'Total Orders',
          data: ordersData,
          backgroundColor: '#7978E9',
          borderColor: '#4747A1',
          borderWidth: 1
        }]
      }
    });
  </script>
</body>
