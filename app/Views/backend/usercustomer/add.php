<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>
<div class="row clearfix">
    <div class="col-12">
        <form method="POST" action="" id="form-dang-tin">
            <?= csrf_field() ?>

            <input type="hidden" name="parent_id" value="0" />
            <section class="card card-fluid">
                <h5 class="card-header">
                    <div class="d-inline-block w-100">
                        <button type="submit" name="dangtin" class="btn btn-sm btn-primary float-right">Save</button>
                    </div>
                </h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Username:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm form-control form-control-sm-sm" type="text" name="username" required="" placeholder="Username" aria-required="true">
                                </div>

                                <b class="col-12 col-lg-2 col-form-label">Fullname:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm form-control form-control-sm-sm price" type="text" name="fullname" required="" placeholder="Tên" im-insert="true" aria-required="true">
                                </div>
                            </div>

                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Mât khẩu:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input type="password" id="password" class="form-control form-control-sm" name="password" minlength="6" required="" aria-required="true">
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Xác nhận mật khẩu:<i class="text-danger">*</i></b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input type="password" class="form-control form-control-sm" name="confirmpassword" minlength="6" data-rule-equalTo="#password" required="" aria-required="true">
                                </div>
                            </div>

                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Role:</b>
                                <div class="col-lg-4 pt-1">
                                    <select name="role" class="form-control form-control-sm">
                                        <option value="1">Admin</option>
                                        <option value="2">Manager</option>
                                        <option value="3" selected>Customer</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Customer:</b>
                                <div class="col-lg-4 pt-1">
                                    <select name="customer_id" class="form-control form-control-sm">
                                        <?php foreach ($customers as $row) : ?>
                                            <option value="<?= $row->id ?>"><?= $row->code . " - " . $row->name ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Active:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <div class="switch-button switch-button-success">
                                        <input type="hidden" name="active" value="0" class="input-tmp">
                                        <input type="checkbox" checked="" name="active" id="switch19" value="1">
                                        <span>
                                            <label for="switch19"></label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>
</div>

<?= $this->endSection() ?>


<!-- Script --->
<?= $this->section('style') ?>
<?= $this->endSection() ?>
<!-- Script --->
<?= $this->section('script') ?>
<script type='text/javascript'>
    $(document).ready(function() {
        $.validator.setDefaults({
            debug: true,
            success: "valid",
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