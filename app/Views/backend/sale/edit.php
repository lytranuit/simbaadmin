<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>
<div class="row clearfix">
    <div class="col-12">
        <form method="POST" action="" id="form-dang-tin">
            <input type="hidden" name="user_id" value="0" />
            <section class="card card-fluid">
                <h5 class="card-header">
                    <div class="d-inline-block w-100">
                        <button type="submit" name="dangtin" class="btn btn-sm btn-primary float-right">Save</button>
                    </div>
                </h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <b class="col-12 col-sm-3 col-form-label text-sm-right">Mã đơn hàng:<i class="text-danger">*</i></b>
                                <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                    <input class="form-control" type='text' name="id" readonly="" required="" disabled="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-sm-3 col-form-label text-sm-right">Tên khách hàng:<i class="text-danger">*</i></b>
                                <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                    <input class="form-control" type='text' name="name" required="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-sm-3 col-form-label text-sm-right">Số điện thoại:</b>
                                <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                    <input class="form-control" type='text' name="phone" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-sm-3 col-form-label text-sm-right">Email khách hàng:</b>
                                <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                    <input class="form-control" type='text' name="email" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-sm-3 col-form-label text-sm-right">Địa chỉ giao hàng:</b>
                                <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                    <input class="form-control" type='text' name="address" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-sm-3 col-form-label text-sm-right">Notes:</b>
                                <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                    <textarea class="form-control" name="notes">
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card card-fluid">
                    <h5 class="card-header">
                        <div class="d-inline-block w-100">
                            Sản phẩm
                        </div>
                    </h5>
                    <div class="card-body">
                        <table id="quanlytin" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tin->details as $row) : ?>
                                    <tr data-id='<?= $row->product->id ?> ' data-price='<?= $row->product->price ?>'>
                                        <td><img src='<?= base_url(isset($row->product->image->src) ? $row->product->image->src : "assets/images/placeholder.png") ?>' width="100" /></td>
                                        <td><?= $row->product->name_vi ?></td>
                                        <td><?= $row->product->code ?></td>
                                        <td><?= number_format($row->product->price, 0, ",", ".") ?></td>
                                        <td><?= $row->quantity ?></td>
                                        <td><span class="amount"><?= number_format($row->product->price * $row->quantity, 0, ",", ".") ?></span> đ</td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <h3 class="float-right">Tổng đơn hàng: <span class="text-danger total_amount"><?= number_format($tin->total_amount, 0, ",", ".") ?> đ</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<!-- Script --->
<?= $this->section('script') ?>

<script src="<?= base_url("assets/lib/mustache/mustache.min.js") ?>"></script>
<script src="<?= base_url("assets/lib/image_feature/jquery.image.js") ?>"></script>

<!--<script src="https://cdn.ckeditor.com/ckeditor5/12.3.1/classic/ckeditor.js"></script>-->
<script src="<?= base_url("assets/lib/ckeditor/ckeditor.js") ?>"></script>-

<!--<script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/balloon-block/ckeditor.js"></script>-->

<script type='text/javascript'>
    $(document).ready(function() {
        var tin = <?= json_encode($tin) ?>;
        fillForm($("#form-dang-tin"), tin);
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
        $(".input-qty").change(function() {
            //            consoe.log(1);
            var tbody = $(this).parents("tbody");
            var total_amount = 0;
            $("tr", tbody).each(function() {
                var price = $(this).data("price");
                var qty = $(".input-qty", $(this)).val();
                var amount = price * qty;
                total_amount += amount;
                $(".amount", $(this)).text(number_currency(amount, 0));
            });
            $(".total_amount").text(number_currency(total_amount, 0));
        });
        number_currency = function(price, x) {
            //            price += ".0";
            //            console.log(price);
            var re = '\\d(?=(\\d{' + (x || 3) + '})+' + '$)';
            return price.toFixed(0).replace(new RegExp(re, 'g'), '$&.');
        };
    });
</script>

<?= $this->endSection() ?>