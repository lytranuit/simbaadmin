<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>
<!-- ============================================================== -->
<!-- pageheader -->
<!-- ============================================================== -->
<div class="row clearfix">
    <div class="col-12">
        <section class="card card-fluid">
            <div class="card-body">
                <table id="quanlytin" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hình ảnh</th>
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>Giá lẻ</th>
                            <th>Giá sĩ</th>
                            <th>Fresh</th>
                            <th>Rượu</th>
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
        $('#quanlytin').DataTable({
            "stateSave": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": path + "admin/product/table",
                "dataType": "json",
                "type": "POST",
            },
            "columns": [{
                    "data": "id"
                }, {
                    "data": "image"
                }, {
                    "data": "code"
                }, {
                    "data": "name_vi"
                },
                {
                    "data": "retain_price"
                },
                {
                    "data": "wholesale_price"
                },
                {
                    "data": "fresh"
                },
                {
                    "data": "alcohol"
                },
            ]

        });
        $(document).on("change", "[name=is_fresh]", function() {
            let is_fresh = +$(this).is(":checked");
            let id = $(this).val();
            $.ajax({
                url: path + "admin/product/update/" + id,
                data: {
                    is_fresh: is_fresh
                },
                dataType: "JSON",
                type: "POST"
            });
        });

        $(document).on("change", "[name=is_alcohol]", function() {
            let is_alcohol = +$(this).is(":checked");
            let id = $(this).val();
            $.ajax({
                url: path + "admin/product/update/" + id,
                data: {
                    is_alcohol: is_alcohol
                },
                dataType: "JSON",
                type: "POST"
            });
        });
    });
</script>

<?= $this->endSection() ?>