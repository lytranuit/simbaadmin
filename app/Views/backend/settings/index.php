<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>
<div class="row clearfix">
    <div class="col-12">

        <form id="form_advanced_validation" method="POST" novalidate="novalidate">
            <?= csrf_field() ?>

            <section class="card card-fluid">
                <h5 class="card-header drag-handle">
                    Cài đặt chung
                    <div style="margin-left:auto">
                        <button class="btn btn-primary btn-sm float-right" type="submit" name="post">Cập nhật</button>
                    </div>
                </h5>
                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="pannel">
                                <h3 class="text-on-pannel text-primary"><strong class="text-uppercase">Common</strong></h3>
                                <?php foreach ($commons as $tin) : ?>
                                    <?php if ($tin['opt_key'] == 'note_order') : ?>

                                        <input type='hidden' name="id[]" value="<?= $tin['id'] ?>" />
                                        <div class="form-group row">
                                            <b class="col-12 col-form-label">
                                                <?= $tin['name'] ?>:
                                            </b>
                                            <div class="col-12 pt-1">
                                                <textarea class="form-control" name="opt_value[<?= $tin['id'] ?>]"><?= $tin['opt_value'] ?></textarea>
                                            </div>
                                            <b class="col-12 col-form-label">
                                                <?= $tin['name_en'] ?>:
                                            </b>
                                            <div class="col-12 pt-1">
                                                <textarea class="form-control" name="opt_value_en[<?= $tin['id'] ?>]"><?= $tin['opt_value_en'] ?></textarea>
                                            </div>
                                            <b class="col-12 col-form-label">
                                                <?= $tin['name_jp'] ?>:
                                            </b>
                                            <div class="col-12 pt-1">
                                                <textarea class="form-control" name="opt_value_jp[<?= $tin['id'] ?>]"><?= $tin['opt_value_jp'] ?></textarea>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="form-group row">
                                            <b class="col-12 col-sm-3 col-form-label">
                                                <?= $tin['name'] ?>:
                                            </b>
                                            <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                                <input type="hidden" name="id[]" value="<?= $tin['id'] ?>" />
                                                <input type="text" class="form-control" name="opt_value[<?= $tin['id'] ?>]" value="<?= $tin['opt_value'] ?>" />
                                            </div>
                                        </div>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pannel">
                                <h3 class="text-on-pannel text-primary"><strong class="text-uppercase">Other</strong></h3>
                                <?php foreach ($system_phone as $tin) : ?>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">
                                            <?= $tin['name'] ?>:
                                        </b>
                                        <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                            <input type="hidden" name="id[]" value="<?= $tin['id'] ?>" />
                                            <input type="text" class="form-control" name="opt_value[<?= $tin['id'] ?>]" value="<?= $tin['opt_value'] ?>" />
                                        </div>
                                    </div>
                                <?php endforeach ?>

                                <?php foreach ($time as $tin) : ?>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">
                                            <?= $tin['name'] ?>:
                                        </b>
                                        <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                            <input type="hidden" name="id[]" value="<?= $tin['id'] ?>" />
                                            <input type="text" class="form-control" name="opt_value[<?= $tin['id'] ?>]" value="<?= $tin['opt_value'] ?>" />
                                        </div>
                                    </div>
                                <?php endforeach ?>
                                <?php foreach ($system_popup as $tin) : ?>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">
                                            <?= $tin['name'] ?>:
                                        </b>
                                        <div class="col-12 pt-1">
                                            <input type="hidden" name="id[]" value="<?= $tin['id'] ?>" />
                                            <textarea class="edit" name="opt_value[<?= $tin['id'] ?>]"><?= $tin['opt_value'] ?></textarea>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pannel">
                                <h3 class="text-on-pannel text-primary"><strong class="text-uppercase">System email</strong></h3>
                                <?php foreach ($system_email as $tin) : ?>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">
                                            <?= $tin['name'] ?>:
                                        </b>
                                        <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                            <input type="hidden" name="id[]" value="<?= $tin['id'] ?>" />
                                            <input type="text" class="form-control" name="opt_value[<?= $tin['id'] ?>]" value="<?= $tin['opt_value'] ?>" />
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pannel">
                                <h3 class="text-on-pannel text-primary"><strong class="text-uppercase">System Email Nangniu.vn</strong></h3>
                                <?php foreach ($system_email_pet as $tin) : ?>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">
                                            <?= $tin['name'] ?>:
                                        </b>
                                        <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                            <input type="hidden" name="id[]" value="<?= $tin['id'] ?>" />
                                            <input type="text" class="form-control" name="opt_value[<?= $tin['id'] ?>]" value="<?= $tin['opt_value'] ?>" />
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pannel">
                                <h3 class="text-on-pannel text-primary"><strong class="text-uppercase">System Email Foodzone</strong></h3>
                                <?php foreach ($system_email_foodzone as $tin) : ?>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">
                                            <?= $tin['name'] ?>:
                                        </b>
                                        <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                            <input type="hidden" name="id[]" value="<?= $tin['id'] ?>" />
                                            <input type="text" class="form-control" name="opt_value[<?= $tin['id'] ?>]" value="<?= $tin['opt_value'] ?>" />
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pannel">
                                <h3 class="text-on-pannel text-primary"><strong class="text-uppercase">System Fresh Email</strong></h3>
                                <?php foreach ($system_fresh_email as $tin) : ?>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">
                                            <?= $tin['name'] ?>:
                                        </b>
                                        <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                            <input type="hidden" name="id[]" value="<?= $tin['id'] ?>" />
                                            <input type="text" class="form-control" name="opt_value[<?= $tin['id'] ?>]" value="<?= $tin['opt_value'] ?>" />
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pannel">
                                <h3 class="text-on-pannel text-primary"><strong class="text-uppercase">System Simba Email</strong></h3>
                                <?php foreach ($system_simba_email as $tin) : ?>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">
                                            <?= $tin['name'] ?>:
                                        </b>
                                        <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                            <input type="hidden" name="id[]" value="<?= $tin['id'] ?>" />
                                            <input type="text" class="form-control" name="opt_value[<?= $tin['id'] ?>]" value="<?= $tin['opt_value'] ?>" />
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pannel">
                                <h3 class="text-on-pannel text-primary"><strong class="text-uppercase">Simba Orders App Mail</strong></h3>
                                <?php foreach ($system_simba_order_email as $tin) : ?>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">
                                            <?= $tin['name'] ?>:
                                        </b>
                                        <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                            <input type="hidden" name="id[]" value="<?= $tin['id'] ?>" />
                                            <input type="text" class="form-control" name="opt_value[<?= $tin['id'] ?>]" value="<?= $tin['opt_value'] ?>" />
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pannel">
                                <h3 class="text-on-pannel text-primary"><strong class="text-uppercase">Simba Report Mail</strong></h3>
                                <?php foreach ($system_simba_report_email as $tin) : ?>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">
                                            <?= $tin['name'] ?>:
                                        </b>
                                        <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                            <input type="hidden" name="id[]" value="<?= $tin['id'] ?>" />
                                            <input type="text" class="form-control" name="opt_value[<?= $tin['id'] ?>]" value="<?= $tin['opt_value'] ?>" />
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pannel">
                                <h3 class="text-on-pannel text-primary"><strong class="text-uppercase">Simba Quote Mail</strong></h3>
                                <?php foreach ($system_simba_quote_email as $tin) : ?>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">
                                            <?= $tin['name'] ?>:
                                        </b>
                                        <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                            <input type="hidden" name="id[]" value="<?= $tin['id'] ?>" />
                                            <input type="text" class="form-control" name="opt_value[<?= $tin['id'] ?>]" value="<?= $tin['opt_value'] ?>" />
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pannel">
                                <h3 class="text-on-pannel text-primary"><strong class="text-uppercase">Tờ trình Mail</strong></h3>
                                <?php foreach ($system_totrinh_email as $tin) : ?>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">
                                            <?= $tin['name'] ?>:
                                        </b>
                                        <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                            <input type="hidden" name="id[]" value="<?= $tin['id'] ?>" />
                                            <input type="text" class="form-control" name="opt_value[<?= $tin['id'] ?>]" value="<?= $tin['opt_value'] ?>" />
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pannel">
                                <h3 class="text-on-pannel text-primary"><strong class="text-uppercase">Tờ trình Pháp nhân</strong></h3>
                                <?php foreach ($system_totrinh2_email as $tin) : ?>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">
                                            <?= $tin['name'] ?>:
                                        </b>
                                        <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                            <input type="hidden" name="id[]" value="<?= $tin['id'] ?>" />
                                            <input type="text" class="form-control" name="opt_value[<?= $tin['id'] ?>]" value="<?= $tin['opt_value'] ?>" />
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pannel">
                                <h3 class="text-on-pannel text-primary"><strong class="text-uppercase">Tồn kho Mail</strong></h3>
                                <?php foreach ($system_tonkho_email as $tin) : ?>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">
                                            <?= $tin['name'] ?>:
                                        </b>
                                        <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                            <input type="hidden" name="id[]" value="<?= $tin['id'] ?>" />
                                            <input type="text" class="form-control" name="opt_value[<?= $tin['id'] ?>]" value="<?= $tin['opt_value'] ?>" />
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pannel">
                                <h3 class="text-on-pannel text-primary"><strong class="text-uppercase">Góp ý khách hàng</strong></h3>
                                <?php foreach ($system_gopy as $tin) : ?>
                                    <div class="form-group row">
                                        <b class="col-12 col-sm-3 col-form-label">
                                            <?= $tin['name'] ?>:
                                        </b>
                                        <div class="col-12 col-sm-8 col-lg-6 pt-1">
                                            <input type="hidden" name="id[]" value="<?= $tin['id'] ?>" />
                                            <input type="text" class="form-control" name="opt_value[<?= $tin['id'] ?>]" value="<?= $tin['opt_value'] ?>" />
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary btn-sm float-right" type="submit" name="post">Cập nhật</button>
                </div>
            </section>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<style>
    .pannel {
        margin-top: 25px !important;
        padding-top: 30px !important;
        border: 1px solid #cecece;
        border-radius: 5px;
        padding: 10px;
    }

    .text-on-pannel {
        background: #fff none repeat scroll 0 0;
        height: auto;
        margin-left: 20px;
        padding: 3px 5px;
        position: absolute;
        margin-top: -47px;
        border: 1px solid #337ab7;
        border-radius: 8px;
        font-size: 20px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url("assets/lib/ckeditor/ckeditor.js") ?>"></script>
<script>
    $(document).ready(function() {
        var allEditors = document.querySelectorAll('.edit');
        for (var i = 0; i < allEditors.length; ++i) {
            CKEDITOR.replace(allEditors[i]);
        }
        //$('.edit').froalaEditor({
        //    heightMin: 200,
        //    heightMax: 500, // Set the image upload URL.
        //    imageUploadURL: '<?= base_url() ?>admin/uploadimage',
        //    // Set request type.
        //    imageUploadMethod: 'POST',
        //    // Set max image size to 5MB.
        //    imageMaxSize: 5 * 1024 * 1024,
        //    // Allow to upload PNG and JPG.
        //    imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif'],
        //    htmlRemoveTags: [],
        //});
    })
</script>
<?= $this->endSection() ?>