<?= $this->extend('backend/layouts/main') ?>

<?= $this->section('content') ?>
<div class="row clearfix">
    <div class="col-12">
        <form method="POST" action="" id="form-dang-tin">
            <?= csrf_field() ?>
            <section class="card card-fluid">
                <h5 class="card-header">
                    <div class="d-inline-block w-100">
                        <button type="submit" name="dangtin" class="btn btn-sm btn-primary float-right">Save</button>
                    </div>
                </h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Hiển thị ở trang chủ:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <div class="switch-button switch-button-xs switch-button-success">
                                        <input type="hidden" class="input-tmp" name="is_home" value="0">
                                        <input type="checkbox" id="switch3" name="is_home" value="1">
                                        <span>
                                            <label for="switch3"></label>
                                        </span>
                                    </div>
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Loại:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <select name="type" class="form-control form-control-sm">
                                        <option value="1">Loại 1</option>
                                        <option value="2">Loại 2</option>
                                    </select>
                                </div>
                            </div>-->

                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Đăng nhập:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <div class="switch-button switch-button-xs switch-button-success">
                                        <input type="hidden" class="input-tmp" name="must_login" value="0">
                                        <input type="checkbox" id="switch4" name="must_login" value="1">
                                        <span>
                                            <label for="switch4"></label>
                                        </span>
                                    </div>
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Yêu cầu > 18t:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <div class="switch-button switch-button-xs switch-button-success">
                                        <input type="hidden" class="input-tmp" name="require_year_old" value="0">
                                        <input type="checkbox" id="switch5" name="require_year_old" value="1">
                                        <span>
                                            <label for="switch5"></label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#menu0">Tiếng Việt</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#menu1">Tiếng Anh</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#menu2">Tiếng Nhật</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="menu0" class="tab-pane active">
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Tên:<i class="text-danger">*</i></b>
                                        <div class="col-12 col-lg-4 pt-1">
                                            <input class="form-control form-control-sm" type='text' name="name_vi" required="" placeholder="Tên" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Mô tả:</b>
                                        <div class="col-12">
                                            <textarea class="form-control" name="description_vi"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Banner Text:</b>
                                        <div class="col-12">
                                            <textarea class="edit" name="banner_text_vi"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="menu1" class="tab-pane fade">
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Tên:<i class="text-danger">*</i></b>
                                        <div class="col-12 col-lg-4 pt-1">
                                            <input class="form-control form-control-sm" type='text' name="name_en" placeholder="Tên" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Mô tả:</b>
                                        <div class="col-12">
                                            <textarea class="form-control" name="description_en"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Banner Text:</b>
                                        <div class="col-12">
                                            <textarea class="edit" name="banner_text_en"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="menu2" class="tab-pane fade">
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Tên:<i class="text-danger">*</i></b>
                                        <div class="col-12 col-lg-4 pt-1">
                                            <input class="form-control form-control-sm" type='text' name="name_jp" placeholder="Tên" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Mô tả:</b>
                                        <div class="col-12">
                                            <textarea class="form-control" name="description_jp"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Banner Text:</b>
                                        <div class="col-12">
                                            <textarea class="edit" name="banner_text_jp"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col-12 pt-2 text-center">
                                    <div class="card no-shadow border">
                                        <div class="card-header">
                                            Icon
                                        </div>
                                        <div class="card-body">

                                            <div id="image_url" class="image_ft"></div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12 pt-2 text-center">
                                    <div class="card no-shadow border">
                                        <div class="card-header">
                                            Banner Image
                                        </div>
                                        <div class="card-body">
                                            <div id="banner_img" class="image_ft"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>
</div>

<div class="row mt-5">
    <div class="col-12">
        <div class="card card-fluid">
            <div class="card-header">
                Sản phẩm
                <div class="ml-auto">
                    <select class="form-control product_add" multiple>
                        <?php foreach ($products_add as $row) : ?>
                            <option value="<?= $row->id ?>" <?= in_array($row->id, $products_disable) ? "disabled" : "" ?>>
                                <?= $row->code ?> - <?= $row->name_vi ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <button class="btn btn-success add_product">
                        Add
                    </button>
                </div>
            </div>
            <div class="card-body">

                <?php if (!empty($products)) : ?>
                    <div class="dd" id="nestable2">
                        <ol class="dd-list ui-sortable" id="nestable">
                            <?php foreach ($products as $row) : ?>
                                <li class="dd-item ui-sortable-handle" id="menuItem_<?= $row->pc_id ?>" data-id="<?= $row->pc_id ?>">
                                    <div class="dd-handle">
                                        <div><?= $row->code ?> - <?= $row->name_vi ?></div>
                                        <div class="dd-nodrag btn-group ml-auto">
                                            <a class="btn btn-sm btn-outline-light" href="<?= base_url() ?>/admin/product/edit/<?= $row->product_id ?>">Edit</a>
                                            <a class="btn btn-sm btn-outline-light" href="<?= base_url() ?>/admin/<?= $controller ?>/remove_product/<?= $row->pc_id ?>" data-type="confirm" title="Xóa ra khỏi dạnh mục">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <ol class="dd-list"></ol>
                                </li>
                            <?php endforeach ?>
                        </ol>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<div style="height: 300px">
</div>
<?= $this->endSection() ?>


<!-- Style --->
<?= $this->section("style") ?>

<link rel="stylesheet" href="<?= base_url("assets/lib/sortable/sortable.css") ?> " ?>
<link rel="stylesheet" href="<?= base_url("assets/lib/chosen/chosen.min.css") ?> " ?>
<?= $this->endSection() ?>

<!-- Script --->
<?= $this->section('script') ?>

<script src="<?= base_url("assets/lib/mustache/mustache.min.js") ?>"></script>
<script src="<?= base_url("assets/lib/image_feature/jquery.image_v2.js") ?>"></script>

<script src="<?= base_url("assets/lib/chosen/chosen.jquery.js") ?>"></script>
<script src="<?= base_url("assets/lib/sortable/jquery.mjs.nestedSortable.js") ?>"></script>
<script src="<?= base_url("assets/lib/ckfinder/ckfinder.js") ?>"></script>
<script src="<?= base_url("assets/lib/ckeditor/ckeditor.js") ?>"></script>


<script type='text/javascript'>
    var tin = <?= json_encode($tin) ?>;
    var controller = '<?= $controller ?>';
    fillForm($("#form-dang-tin"), tin);
    var allEditors = document.querySelectorAll('.edit');
    for (var i = 0; i < allEditors.length; ++i) {
        CKEDITOR.replace(allEditors[i]);
    }
    $(document).ready(function() {

        $("select[multiple]").chosen();
        $(".image_ft").imageFeature();

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
        $.validator.setDefaults({
            debug: true,
            success: "valid"
        });

        if (tin.image_url) {
            $("#image_url").imageFeature("set_image", tin.image_url);
        }
        if (tin.banner_img) {
            $("#banner_img").imageFeature("set_image", tin.banner_img);
        }
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
                var arraied = $('#nestable').nestedSortable('toArray', {
                    excludeRoot: true
                });
                console.log(arraied);
                let append = "";
                for (var i = 0; i < arraied.length; i++) {
                    let id = arraied[i]['id'];
                    append += "<input type='hidden' name='product_category[]' value='" + id + "' />";
                }
                $(form).append(append);
                form.submit();
                return false;
            }
        });
        $('#nestable').nestedSortable({
            forcePlaceholderSize: true,
            items: 'li',
            opacity: .6,
            maxLevels: 1,
            placeholder: 'dd-placeholder',
        });
        $(".add_product").click(function() {

            let product = $(".product_add").val();
            let category_id = tin['id'];
            $.ajax({
                type: "POST",
                data: {
                    data: JSON.stringify(product),
                    category_id: category_id,
                },
                url: path + "admin/" + controller + "/addproductcategory",
                success: function(msg) {
                    // alert("Success!");
                    location.reload();
                }
            })
        });
    });
</script>

<?= $this->endSection() ?>