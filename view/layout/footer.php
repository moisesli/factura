<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/plugins/dist/js/adminlte.min.js"></script>
<!-- InputMask -->
<script src="/plugins/select2/js/select2.full.min.js"></script>
<script src="/plugins/moment/moment.min.js"></script>
<!-- date-range-picker -->
<script src="/plugins/daterangepicker/daterangepicker.js"></script>
<script>
    $(function() {
        // $('#supplier_id').on("change", function() {
        //     app.selected = $(this).val();
        //     console.log('Name : ' + $(this).val());
        // });
        //Initialize Select2 Elements
        $('#supplier_id').select2({
            theme: 'bootstrap4'
        })
    });
</script>
</body>

</html>