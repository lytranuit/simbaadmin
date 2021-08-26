<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>
<div class="row clearfix">
    <div class="col-12">
        <form method="POST" action="" id="form-dang-tin">
            <input type="hidden" name="parent_id" value="0" />
            <section class="card card-fluid">
                <h5 class="card-header">
                    <div class="d-inline-block w-100">
                        <button type="submit" name="dangtin" class="btn btn-sm btn-primary float-right">Save</button>
                    </div>
                </h5>
                <div class="card-body">
                    <div class="form-group row">
                        <b class="col-12 col-lg-1 col-form-label">Sản phẩm:<i class="text-danger">*</i></b>
                        <div class="col-12 col-lg-6 pt-1">
                            <select name="product_id" class="form-control">
                                <?php foreach ($products as $row) : ?>
                                    <option value="<?= $row->id ?>">
                                        <?= $row->code ?> - <?= $row->name_vi ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <b class="col-12 col-lg-2 col-form-label">Đơn vị tính:(Nếu có)<i class="text-danger">*</i></b>
                        <div class="col-12 col-lg-2 pt-1">
                            <select name="unit_id" class="form-control form-control-sm">

                            </select>
                        </div>

                    </div>
                    <div class="form-group row">
                        <b class="col-12 col-lg-1 col-form-label">Giá bán:<i class="text-danger">*</i></b>
                        <div class="col-12 col-lg-3 pt-1">
                            <input id="price" class="form-control form-control-sm" type='text' name="price" required placeholder="Giá bán" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <b class="col-12 col-lg-1 col-form-label">Thời gian:<i class="text-danger">*</i></b>
                        <div class="col-12 col-lg-3 pt-1">
                            <input type="text" class="form-control" id="daterange" name="daterange" value="" required>
                        </div>

                    </div>
                </div>
            </section>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type='text/javascript'>
    $(document).ready(function() {
        $("select[name='product_id']").chosen();
        $('#daterange').daterangepicker({

        }, function(start, end, label) {

        });
        $('#price').inputmask("numeric", {
            radixPoint: ".",
            groupSeparator: ",",
            autoGroup: true,
            suffix: ' VND', //No Space, this will truncate the first character
            rightAlign: false,
            oncleared: function() {
                self.Value('');
            }
        });
        $("select[name='product_id']").change(function() {
            let product_id = $(this).val();
            $.ajax({
                url: path + "admin/productprice/get_units/" + product_id,
                dataType: "JSON",
                success: function(data) {
                    let append = "";
                    for (let i = 0; i < data.length; i++) {
                        append += "<option value='" + data[i]['id'] + "'>" + data[i]['name_vi'] + "</option>";
                    }
                    $("[name=unit_id]").html(append);
                }
            });
        })
        $("select[name='product_id']").change();
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
            submitHandler: function(form) {
                form.submit();
                return false;
            }
        });
    });
</script>

<?= $this->endSection() ?>