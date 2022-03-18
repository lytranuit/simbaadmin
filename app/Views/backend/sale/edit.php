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
                                <b class="col-12 col-sm-2 col-form-label">Mã đơn hàng:</b>
                                <div class="col-12 col-sm-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="code" readonly="" required="" disabled="" />
                                </div>
                                <b class="col-12 col-sm-2 col-form-label">Trạng thái đơn hàng:</b>
                                <div class="col-12 col-sm-4 pt-1">
                                    <select name="status" class="form-control form-control-sm">
                                        <option value="">-- Select --</option>
                                        <option value="1">Mới đặt hàng</option>
                                        <option value="2">Đã xác nhận, chờ giao</option>
                                        <option value="8">Đang giao hàng</option>
                                        <option value="3">Đã thanh toán</option>
                                        <option value="4">Hoàn tất giao hàng</option>
                                        <option value="5">Đã hủy</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-sm-2 col-form-label">Ngày đặt hàng:</b>
                                <div class="col-12 col-sm-4 pt-1">
                                    <input class="form-control form-control-sm" type='datetime' name="order_date" readonly="" required="" disabled="" />
                                </div>
                                <b class="col-12 col-sm-2 col-form-label">Ngày giao hàng:</b>
                                <div class="col-12 col-sm-4 pt-1">
                                    <input class="form-control form-control-sm" type='date' name="delivery_date" />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card card-fluid">
                        <h5 class="card-header">
                            <div class="d-inline-block w-100">
                                <ul class="nav nav-tabs mb-0">
                                    <li class="nav-item">
                                        <a class="nav-link active show" data-toggle="tab" href="#menu0">Chi tiết đơn hàng</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link show" data-toggle="tab" href="#menu1">Thông tin khách hàng</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link show" data-toggle="tab" href="#menu2">Thông tin khách hàng</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link show" data-toggle="tab" href="#menu3">Thông tin hóa đơn</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link show" data-toggle="tab" href="#menu4">Ghi chú</a>
                                    </li>
                                </ul>
                            </div>
                        </h5>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="menu0">
                                    <div class="mb-3"><b>Chi tiết đơn hàng</b></div>
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
                                                <tr data-id='<?= $row->product_id ?> ' data-price='<?= $row->unit_price ?>'>
                                                    <td><img src='<?= "https://simbaeshop.com" .  $row->image_url ?>' width="100" /></td>
                                                    <td><?= $row->name ?></td>
                                                    <td><?= $row->code ?></td>
                                                    <td><?= number_format($row->unit_price, 0, ",", ".") ?></td>
                                                    <td><?= $row->quantity ?></td>
                                                    <td><span class="amount"><?= number_format($row->subtotal, 0, ",", ".") ?></span> đ</td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="menu1">
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-2 col-form-label">Tên khách hàng:</b>
                                        <div class="col-12 col-sm-4 pt-1">
                                            <input class="form-control form-control-sm" type='text' name="customer_name" />
                                        </div>
                                        <b class="col-12 col-sm-2 col-form-label">Số điện thoại:</b>
                                        <div class="col-12 col-sm-4 pt-1">
                                            <input class="form-control form-control-sm" type='text' name="customer_phone" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-2 col-form-label">Email:</b>
                                        <div class="col-12 col-sm-4 pt-1">
                                            <input class="form-control form-control-sm" type='email' name="customer_email" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">Địa chỉ:</b>
                                        <div class="col-12 pt-1">
                                            <textarea class="form-control form-control-sm" name="customer_address"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="menu2">
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-2 col-form-label">Tên người nhận:</b>
                                        <div class="col-12 col-sm-4 pt-1">
                                            <input class="form-control form-control-sm" type='text' name="receiver_name" />
                                        </div>
                                        <b class="col-12 col-sm-2 col-form-label">Số điện thoại:</b>
                                        <div class="col-12 col-sm-4 pt-1">
                                            <input class="form-control form-control-sm" type='text' name="receiver_phone" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-2 col-form-label">Email:</b>
                                        <div class="col-12 col-sm-4 pt-1">
                                            <input class="form-control form-control-sm" type='email' name="receiver_email" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">Địa chỉ:</b>
                                        <div class="col-12 pt-1">
                                            <textarea class="form-control form-control-sm" name="receiver_address"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="menu3">
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-2 col-form-label">Tên khách hàng:</b>
                                        <div class="col-12 col-sm-4 pt-1">
                                            <input class="form-control form-control-sm" type='text' name="inv_name" />
                                        </div>
                                        <b class="col-12 col-sm-2 col-form-label">Mã số thuế:</b>
                                        <div class="col-12 col-sm-4 pt-1">
                                            <input class="form-control form-control-sm" type='text' name="inv_tax_code" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">Địa chỉ:</b>
                                        <div class="col-12 pt-1">
                                            <textarea class="form-control form-control-sm" name="inv_address"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="menu4">
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">Ghi chú:</b>
                                        <div class="col-12 pt-1">
                                            <textarea class="form-control form-control-sm" name="notes"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <h3 class="float-right">Tổng đơn hàng: <span class="text-danger total_amount"><?= number_format($tin->total_amount, 0, ",", ".") ?> đ</span></h3>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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