<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('content') ?>
<div class="row clearfix">
    <div class="col-12">
        <form method="POST" action="" id="form-dang-tin">
            <input name="dangtin" value="1" type="hidden" />
            <section class="card card-fluid">
                <h5 class="card-header">
                    <div style="margin-left:auto">
                        <button type="submit" class="btn btn-sm btn-primary float-right">Save</button>
                    </div>
                </h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Mã:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" readonly type='text' name="code" required placeholder="Mã" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Tên khách hàng:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="name" required placeholder="Tên khách hàng" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Mã số thuế:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="tax_code" placeholder="Mã số thuế" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Email:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='email' name="email" placeholder="Email" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Phone:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="phone" placeholder="Phone" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Loại khách hàng:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <select class="form-control form-control-sm" name="customer_type">
                                        <option value="0">Khách hàng mua lẻ</option>
                                        <option value="1">Khách hàng mua sĩ</option>
                                    </select>
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Vùng:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <select class="form-control form-control-sm" name="region">
                                        <option value="N">N</option>
                                        <option value="B">B</option>
                                        <option value="T">T</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Sản phẩm riêng:</b>
                                <div class="col-12 col-lg-10 pt-1">
                                    <select name="product_list[]" class="form-control form-control-sm" multiple>
                                        <?php foreach ($products as $product) : ?>
                                            <option value="<?= $product->id ?>"><?= $product->code ?> - <?= $product->name_vi ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </form>
    </div>
</div>


<?= $this->endSection() ?>


<!-- Style --->
<?= $this->section("style") ?>
<link rel="stylesheet" href="<?= base_url("assets/lib/chosen/chosen.min.css") ?> " ?>

<link rel="stylesheet" href="<?= base_url("assets/lib/datatables/datatables.min.css") ?> " ?>
<?= $this->endSection() ?>

<!-- Script --->
<?= $this->section('script') ?>


<script src="<?= base_url("assets/lib/chosen/chosen.jquery.js") ?>"></script>
<script src="<?= base_url("assets/lib/ajaxchosen/chosen.ajaxaddition.jquery.js") ?>"></script>
<script src="<?= base_url('assets/lib/datatables/datatables.min.js') ?>"></script>
<script src="<?= base_url('assets/lib/datatables/jquery.highlight.js') ?>"></script>
<script type='text/javascript'>
    $(document).ready(function() {
        var tin = <?= json_encode($tin) ?>;
        fillForm($("#form-dang-tin"), tin);

        $(".chosen").chosen({
            width: "100%"
        });
        $("[name='product_list[]']").ajaxChosen({
            dataType: 'json',
            type: 'POST',
            url: path + "admin/customer/productlist",
        }, {
            loadingImg: path + 'public/img/loading.gif'
        }, {
            width: "100%",
            allow_single_deselect: true
        });
        $.validator.setDefaults({
            debug: true,
            success: "valid"
        });
        $("#form-dang-tin").validate({
            highlight: function(input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function(input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function(error, element) {
                $(element).parents('.form-group').append(error);
            },
            submitHandler: async function(form) {
                form.submit();
                return false;
            }
        });
    });
</script>
<?= $this->endSection() ?>