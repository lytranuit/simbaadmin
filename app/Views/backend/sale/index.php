<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>
<!-- ============================================================== -->
<!-- saleheader -->
<!-- ============================================================== -->
<div class="row clearfix">
    <div class="col-12">
        <section class="card card-fluid">

            <div class="card-body">
                <table id="quanlytin" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Ngày đặt hàng</th>
                            <th>Ngày giao hàng</th>
                            <th>Tên khách hàng</th>
                            <th>Giảm giá</th>
                            <th>Tổng số tiền</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<?= $this->endSection() ?>
<!-- Style --->
<?= $this->section("style") ?>

<link rel="stylesheet" href="<?= base_url("assets/lib/datatables/datatables.min.css") ?> " ?>
<?= $this->endSection() ?>

<!-- Script --->
<?= $this->section('script') ?>

<script src="<?= base_url('assets/lib/datatables/datatables.min.js') ?>"></script>
<script src="<?= base_url('assets/lib/datatables/jquery.highlight.js') ?>"></script>

<script type="text/javascript">
    $(document).ready(function() {
        let list_status = <?= json_encode($status) ?>;
        $('#quanlytin').DataTable({
            "stateSave": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": path + "admin/sale/table",
                "dataType": "json",
                "type": "POST",
                'data': function(data) {
                    // Read values
                    let orders = data['order'];
                    for (let i in orders) {
                        let order = orders[i];
                        let column = order['column'];
                        orders[i]['data'] = data['columns'][column]['data'];
                    }
                    let search_type = localStorage.getItem('SEARCH_TYPE') || "code";
                    let search_status = localStorage.getItem('SEARCH_STATUS') || "0";
                    data['search_type'] = search_type;
                    data['search_status'] = search_status;
                    data['<?= csrf_token() ?>'] = "<?= csrf_hash() ?>";
                }
            },
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "order_date"
                },
                {
                    "data": "delivery_date"
                },
                {
                    "data": "customer_name"
                },
                {
                    "data": "discount"
                },
                {
                    "data": "total_amount"
                },
                {
                    "data": "status"
                },
                {
                    "data": "action"
                }
            ],
            initComplete: function() {
                $(".dataTables_filter label").prepend("<select style='margin-right: 0.5em;display: inline-block;width: auto;' class='form-control form-control-sm search_type'><option value='id'>ID</option><option value='code'>Mã đơn hàng</option><option value='status'>Trạng thái</option><option value='description_vi'>Ghi chú</option></select>");
                $(".dataTables_filter label").append("<select style='margin-left: 0.5em;display: inline-block;width: auto;' class='form-control form-control-sm search_status d-none'></select>");
                let html = "";

                html += "<option value='-1'>-- Select --</option>";
                html += "<option value='1'>Mới đặt hàng</option>";
                html += "<option value='2'>Đã xác nhận, chờ giao</option>";
                html += "<option value='8'>Đang giao hàng</option>";
                html += "<option value='3'>Đã thanh toán</option>";
                html += "<option value='4'>Hoàn tất giao hàng</option>";
                html += "<option value='5'>Đã hủy</option>";

                $(".search_status").append(html);



                let search_type = localStorage.getItem('SEARCH_TYPE') || "code";
                $(".search_type").val(search_type);

                if (search_type == "status") {
                    $(".search_status").removeClass("d-none");
                    $(".dataTables_filter label input").addClass("d-none");
                } else {
                    $(".search_status").addClass("d-none");
                    $(".dataTables_filter label input").removeClass("d-none");
                }



                let search_status = localStorage.getItem('SEARCH_STATUS') || "0";
                $(".search_status").val(search_status);

            }

        });
    });
</script>

<?= $this->endSection() ?>