<?= $this->extend('backend/layouts/main') ?>


<?= $this->section('content') ?>
<div class="row clearfix">
    <div class="col-12">

        <form id="form_advanced_validation" method="POST" novalidate="novalidate">
            <?= csrf_field() ?>

            <section class="card card-fluid">
                <h5 class="card-header drag-handle">
                    Ngôn ngữ
                    <div style="margin-left:auto">
                        <button class="btn btn-primary btn-sm float-right" type="submit" id="Save">Cập nhật</button>
                    </div>
                </h5>
                <div class="card-body">
                    <table id="quanlytin" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Key</th>
                                <th>Tiếng Việt</th>
                                <th>Tiếng Anh</th>
                                <th>Tiếng Nhật</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0 ?>
                            <?php foreach ($moduleData as $key => $row) : ?>

                                <?php $i++ ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td class="key"><?= $key ?></td>
                                    <td><input type='text' style="width:100%;" class="form-control vietnamese" value='<?= $row['vi'] ?>' /></td>
                                    <td><input type='text' style="width:100%;" class="form-control english" value='<?= $row['en'] ?>' /></td>
                                    <td><input type='text' style="width:100%;" class="form-control japanese" value='<?= $row['jp'] ?>' /></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
<!-- Style --->
<?= $this->section("style") ?>

<link rel="stylesheet" href="<?= base_url("assets/lib/datatables/datatables.min.css") ?> " ?>
<?= $this->endSection() ?>

<!-- Script --->
<?= $this->section('script') ?>

<script src="<?= base_url('assets/lib/datatables/datatables.min.js') ?>"></script>
<script src="<?= base_url('assets/lib/datatables/jquery.highlight.js') ?>"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.fn.dataTableExt.ofnSearch['html-input'] = function(value) {
            return $(value).val();
        };
        $('#quanlytin').DataTable({
            columnDefs: [{
                "type": "html-input",
                "targets": [2, 3, 4]
            }],
            "lengthMenu": [
                [-1],
                ["All"]
            ]
        });
        $("#Save").click(function(e) {
            e.preventDefault();
            var data = {
                vi: {},
                en: {},
                jp: {}
            };
            $("#quanlytin tbody tr").each(function() {
                var key = $(".key", $(this)).text();
                var vietnamese = $(".vietnamese", $(this)).val();
                var english = $(".english", $(this)).val();
                var japanese = $(".japanese", $(this)).val();
                data['vi'][key] = vietnamese;
                data['en'][key] = english;
                data['jp'][key] = japanese;
            });
            //            console.log(data);
            //           return false;
            $.ajax({
                url: path + "admin/language/savelanguage",
                type: "POST",
                dataType: "JSON",
                data: {
                    data: JSON.stringify(data)
                },
                success: function(res) {
                    if (res == 1) {
                        alert("Success!");
                        location.reload();
                    }
                }
            })
        })
    });
</script>
<?= $this->endSection() ?>