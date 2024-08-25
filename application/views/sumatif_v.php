<!doctype html>
<html>

<head>
    <?php
    require_once("meta.php"); ?>
</head>

<body class="no-skin">
    <?php require_once("header.php"); ?>
    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="<?= site_url(); ?>">Home</a>
                    </li>
                    <li class="active">Sumatif</li>
                </ul><!-- /.breadcrumb -->


            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>Sumatif</h1>
                    <?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>

                        <form method="post" class="col-md-2" style="margin-top:-30px; float:right;">

                            <button name="new" class="btn btn-info btn-block btn-sm" value="OK" style="">New</button>
                            <input type="hidden" name="sumatif_id" />

                        </form>

                    <?php } ?>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
                                    <div class="">
                                        <?php if (isset($_POST['edit'])) {
                                            $namabutton = 'name="change"';
                                            $judul = "Update Sumatif";
                                        } else {
                                            $namabutton = 'name="create"';
                                            $judul = "New Sumatif";
                                        } ?>
                                        <div class="lead">
                                            <h3><?= $judul; ?></h3>
                                        </div>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">

                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="sumatif_name">Sumatif:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="sumatif_name" name="sumatif_name" placeholder="Enter Class" value="<?= $sumatif_name; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-offset-2 col-md-10 alert alert-danger alert-dismissable fade in" id="ceksumatif" style="display:none;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong>Attention!</strong> Class has been created.
                                            </div>

                                            <script>
                                                $("#sumatif_name").keyup(function() {
                                                    $.get("<?= site_url("api/ceksumatif"); ?>", {
                                                            sumatif_name: $("#sumatif_name").val()
                                                        })
                                                        .done(function(data) {
                                                            if (data == "ada") {
                                                                $("#ceksumatif").fadeIn();
                                                                $("#submit").prop("disabled", "disabled");
                                                            } else {
                                                                $("#ceksumatif").fadeOut();
                                                                $("#submit").prop("disabled", "");
                                                            }
                                                        });
                                                });
                                            </script>
                                            <input type="hidden" name="sekolah_id" value="<?= $this->session->userdata("sekolah_id"); ?>" />
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                                    <button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("sumatif"); ?>">Back</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php } else { ?>
                                    <?php if ($message != "") { ?>
                                        <div class="alert alert-info alert-dismissable">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong><?= $message; ?></strong><br /><?= $uploadsumatif_picture; ?>
                                        </div>
                                    <?php } ?>
                                    <div class="box">
                                        <div id="collapse4" class="body table-responsive">
                                            <table id="dataTable" class="table table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="col-md-1">Action</th>
                                                        <th>Sumatif</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($this->session->userdata("sekolah_id") > 0) {
                                                        $this->db->where("sumatif.sekolah_id", $this->session->userdata("sekolah_id"));
                                                    }
                                                    $usr = $this->db
                                                        ->order_by("sumatif_name", "asc")
                                                        ->get("sumatif");
                                                    // echo $this->db->last_query();
                                                    foreach ($usr->result() as $sumatif) { ?>
                                                        <tr>
                                                            <td style="padding-left:0px; padding-right:0px;">

                                                                <form method="post" class="col-md-6" style="padding:0px;">
                                                                    <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                                    <input type="hidden" name="sumatif_id" value="<?= $sumatif->sumatif_id; ?>" />
                                                                </form>

                                                                <form method="post" class="col-md-6" style="padding:0px;">
                                                                    <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                                    <input type="hidden" name="sumatif_id" value="<?= $sumatif->sumatif_id; ?>" />
                                                                </form>
                                                            </td>
                                                            <td><?= $sumatif->sumatif_name; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#wrap -->
    <?php require_once("footer.php"); ?>
</body>

</html>