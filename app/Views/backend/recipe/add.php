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
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Thời gian chuẩn bị:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="prepare_time" placeholder="" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Thời gian chế biến:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="cook_time" placeholder="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Sẵn sàng thưởng thức:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="ready_to_eat" placeholder="" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Khẩu phần phục vụ:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="number_of_eat" placeholder="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <b class="col-12 col-lg-2 col-form-label">Năng lượng:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='text' name="energy" placeholder="" />
                                </div>
                                <b class="col-12 col-lg-2 col-form-label">Đánh giá chất lượng:</b>
                                <div class="col-12 col-lg-4 pt-1">
                                    <input class="form-control form-control-sm" type='number' name="star" placeholder="" />
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
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div id="menu0" class="tab-pane active">
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Tiêu đề:<i class="text-danger">*</i></b>
                                        <div class="col-12 col-lg-4 pt-1">
                                            <input class="form-control form-control-sm" type='text' name="name_vi" required="" placeholder="Tiêu đề" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Thành phần:<i class="text-danger">*</i></b>
                                        <div class="col-12">
                                            <textarea class="edit" name="element_vi"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Nội dung:<i class="text-danger">*</i></b>
                                        <div class="col-12">
                                            <textarea class="edit" name="content_vi"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="menu1" class=" tab-pane fade">
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Tiêu đề:<i class="text-danger">*</i></b>
                                        <div class="col-12 col-lg-4 pt-1">
                                            <input class="form-control form-control-sm" type='text' name="name_en" placeholder="Tiêu đề" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Thành phần:<i class="text-danger">*</i></b>
                                        <div class="col-12">
                                            <textarea class="edit" name="element_en"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Nội dung:<i class="text-danger">*</i></b>
                                        <div class="col-12">
                                            <textarea class="edit" name="content_en"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="menu2" class=" tab-pane fade">
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Tiêu đề:<i class="text-danger">*</i></b>
                                        <div class="col-12 col-lg-4 pt-1">
                                            <input class="form-control form-control-sm" type='text' name="name_jp" placeholder="Tiêu đề" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Thành phần:<i class="text-danger">*</i></b>
                                        <div class="col-12">
                                            <textarea class="edit" name="element_jp"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <b class="col-12 col-lg-2 col-form-label">Nội dung:<i class="text-danger">*</i></b>
                                        <div class="col-12">
                                            <textarea class="edit" name="content_jp"></textarea>
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
                                            Hình ảnh
                                        </div>
                                        <div class="card-body">

                                            <div id="image_url" class="image_ft"></div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-12 pt-1">
                                    <div class="card no-shadow border">
                                        <div class="card-header">
                                            Danh mục
                                        </div>
                                        <div class="card-body">
                                            <?= $category ?>
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

<?= $this->endSection() ?>


<!-- Script --->
<?= $this->section('script') ?>

<script src="<?= base_url("assets/lib/mustache/mustache.min.js") ?>"></script>
<script src="<?= base_url("assets/lib/image_feature/jquery.image_v2.js") ?>"></script>

<!--<script src="https://cdn.ckeditor.com/ckeditor5/12.3.1/classic/ckeditor.js"></script>-->
<script src="<?= base_url("assets/lib/ckfinder/ckfinder.js") ?>"></script>
<script src="<?= base_url("assets/lib/ckeditor/ckeditor.js") ?>"></script>
<script type='text/javascript'>
    var allEditors = document.querySelectorAll('.edit');
    for (var i = 0; i < allEditors.length; ++i) {
        CKEDITOR.replace(allEditors[i]);
        //ClassicEditor.create(allEditors[i]);
    }
    $(document).ready(function() {
        $(".image_ft").imageFeature();
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