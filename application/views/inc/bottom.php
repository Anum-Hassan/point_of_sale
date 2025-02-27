<!-- Your other head content goes here -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= base_url('assets/js/admin.js')?>"></script>
<script src="<?= base_url('assets/js/category.js')?>"></script>
<!-- plugins:js -->
<script src="<?= base_url('assets/vendors/js/vendor.bundle.base.js')?>"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="<?= base_url('assets/vendors/chart.js/Chart.min.js')?>"></script>
<script src="<?= base_url('assets/vendors/datatables.net/jquery.dataTables.js')?>"></script>
<script src="<?= base_url('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js')?>"></script>
<script src="<?= base_url('assets/js/dataTables.select.min.js')?>"></script>

<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="<?= base_url('assets/js/off-canvas.js')?>"></script>
<script src="<?= base_url('assets/js/hoverable-collapse.js')?>"></script>
<script src="<?= base_url('assets/js/template.js')?>"></script>
<script src="<?= base_url('assets/js/settings.js')?>"></script>
<script src="<?= base_url('assets/js/todolist.js')?>"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="<?= base_url('assets/js/dashboard.js')?>"></script>
<script src="<?= base_url('assets/js/Chart.roundedBarCharts.js')?>"></script>
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#myTable');
</script>
<script>
    $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    })
</script>
<script>
    $('#adminForm').submit(function(e) {
        e.preventDefault(); 

        var formData = new FormData(this); 

        $.ajax({
            url: '<?= base_url('AdminController/insert'); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#exampleModal').modal('hide'); 
                    $('#myTable tbody').append(response.new_row); 
                } else {
                    alert('Error adding admin');
                }
            },
            error: function() {
                alert('Error processing your request');
            }
        });
    });
</script>
</body>

</html>