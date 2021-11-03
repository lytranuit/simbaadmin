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
                    <?php foreach ($commons as $tin) : ?>
                        <?php if ($tin['opt_key'] == 'note_order') : ?>

                            <input type='hidden' name="id[]" value="<?= $tin['id'] ?>" />
                            <div class="form-group row">
                                <b class="col-12 col-form-label">
                                    <?= $tin['name'] ?>:
                                </b>
                                <div class="col-12 pt-1">
                                    <textarea class="form-control" name="opt_value[]"><?= $tin['opt_value'] ?></textarea>
                                </div>
                                <b class="col-12 col-form-label">
                                    <?= $tin['name_en'] ?>:
                                </b>
                                <div class="col-12 pt-1">
                                    <textarea class="form-control" name="opt_value_en[]"><?= $tin['opt_value_en'] ?></textarea>
                                </div>
                                <b class="col-12 col-form-label">
                                    <?= $tin['name_jp'] ?>:
                                </b>
                                <div class="col-12 pt-1">
                                    <textarea class="form-control" name="opt_value_jp[]"><?= $tin['opt_value_jp'] ?></textarea>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary btn-sm float-right" type="submit" name="post">Cập nhật</button>
                </div>
            </section>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
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