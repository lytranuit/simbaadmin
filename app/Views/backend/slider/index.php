<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>
<!-- ============================================================== -->
<!-- pageheader -->
<!-- ============================================================== -->
<div class="row clearfix">
    <div class="col-12">
        <section class="card card-fluid">
            <h5 class="card-header drag-handle">
                <a class="btn btn-success btn-sm" href="<?= base_url("admin/$controller/add") ?>">Thêm</a>
                <div style="margin-left:auto;">
                    <a class="btn btn-sm btn-primary" id='save' href="#">Save</a>
                </div>
            </h5>
            <div class="card-body">
                <div class="dd" id="nestable2">
                    <ol class="dd-list ui-sortable" id="nestable">
                        <?php foreach ($slider as $row) : ?>
                            <li class="dd-item ui-sortable-handle" id="menuItem_<?= $row->id ?>" data-id="<?= $row->id ?>">
                                <div class="dd-handle">
                                    <div>
                                        <a href="<?= base_url("admin/slider/edit/" . $row->id) ?>">Slider #ID<?= $row->id ?></a>
                                        <img src="<?= config('App')->simbaURL . $row->image_url ?>" width="100" />
                                    </div>
                                    <div class="dd-nodrag btn-group ml-auto">
                                        <button class="btn btn-sm btn-outline-light dd-item-delete">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach ?>
                    </ol>

                </div>
            </div>
        </section>
    </div>
</div>

<?= $this->endSection() ?>

<!-- Style --->
<?= $this->section("style") ?>

<link rel="stylesheet" href="<?= base_url("assets/lib/sortable/sortable.css") ?> " ?>
<?= $this->endSection() ?>

<!-- Script --->
<?= $this->section('script') ?>

<script src="<?= base_url("assets/lib/sortable/jquery.mjs.nestedSortable.js") ?>"></script>
<script type="text/javascript">
    var controller = '<?= $controller ?>';
    $(document).ready(function() {
        $('#nestable').nestedSortable({
            forcePlaceholderSize: true,
            items: 'li',
            opacity: .6,
            maxLevels: 1,
            placeholder: 'dd-placeholder',
        });
        $("#save").click(function() {
            var arraied = $('#nestable').nestedSortable('toArray', {
                excludeRoot: true
            });

            $.ajax({
                type: "POST",
                data: {
                    data: JSON.stringify(arraied)
                },
                url: path + `admin/${controller}/saveorder`,
                success: function(msg) {
                    alert("Success!");
                }
            })
        });
    });
</script>

<?= $this->endSection() ?>