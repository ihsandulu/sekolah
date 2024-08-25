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
                    <li class="active">Telpon</li>
                </ul><!-- /.breadcrumb -->


            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>Telephone</h1>
                    <?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>

                        <form method="post" class="col-md-2" style="margin-top:-30px; float:right;">

                            <button name="new" class="btn btn-info btn-block btn-sm" value="OK" style="">New</button>
                            <input type="hidden" name="user_id" />

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
                                            $judul = "Update Telephone";
                                        } else {
                                            $namabutton = 'name="create"';
                                            $judul = "New Telephone";
                                        } ?>
                                        <div class="lead">
                                            <h3><?= $judul; ?></h3>
                                        </div>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">

                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="user_nisn">NISN:</label>
                                                <div class="col-sm-10">
                                                    <input type="user_name" class="form-control" id="user_nisn" name="user_nisn" placeholder="Enter NISN" value="<?= $user_nisn; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-offset-2 col-md-10 alert alert-danger alert-dismissable fade in" id="cekuser" style="display:none;">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong>Attention!</strong> NISN has been used.
                                            </div>

                                            <script>
                                                $("#user_nisn").keyup(function() {
                                                    $.get("<?= site_url("api/cekuser"); ?>", {
                                                            user: 'user_nisn',
                                                            isi: $("#user_nisn").val(),
                                                            sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>'
                                                        })
                                                        .done(function(data) {
                                                            if (data > 0) {
                                                                $("#cekuser").fadeIn();
                                                                $("#submit").prop("disabled", "disabled");
                                                            } else {
                                                                $("#cekuser").fadeOut();
                                                                $("#submit").prop("disabled", "");
                                                            }
                                                        });
                                                });
                                            </script>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="telpon_number">Number:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="telpon_number" name="telpon_number" placeholder="Enter Telephone" value="<?= $telpon_number; ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="telpon_type">Type:</label>
                                                <div class="col-sm-10">
                                                    <select id="telpon_type" name="telpon_type" class="form-control">
                                                        <option <?= ($telpon_type == "1") ? 'selected="selected"' : ""; ?> value="1">Orang Tua</option>
                                                        <option <?= ($telpon_type == "2") ? 'selected="selected"' : ""; ?> value="2">Murid</option>
                                                    </select>
                                                </div>
                                            </div>



                                            <input type="hidden" name="sekolah_id" value="<?= $this->session->userdata("sekolah_id"); ?>" />
                                            <input type="hidden" name="telpon_id" value="<?= $telpon_id; ?>" />
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                                    <button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("user"); ?>">Back</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php } else { ?>
                                    <?php if ($message != "") { ?>
                                        <div class="alert alert-info alert-dismissable">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong><?= $message; ?></strong>
                                        </div>
                                    <?php } ?>
                                    <div class="box">

                                        <form method="post" class="form well col-md-6" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label>Import Excel : </label>
                                                <input class="form-control" name="filetelpon" type="file" />
                                            </div>
                                            <div class="form-group">
                                                <input id="drop" class="" name="drop" type="checkbox" value="1" />
                                                <label for="drop"> Erase all Telephone data</label>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary" type="submit" name="import">Import</button>
                                            </div>
                                        </form>
                                        <div class="well col-md-offset-1 col-md-5" style="padding:30px; height:210px;" align="center">
                                            <a target="_blank" href="<?= base_url("telpon.xlsx"); ?>" class="fa fa-download btn btn-lg btn-success" style="top:50%; position:relative; top:50%; transform:translate(0,-50%);" /> Download Excel Template</a>
                                        </div>

                                        <div id="collapse4" class="body table-responsive col-md-12">
                                            <table id="dataTable" class="table table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="col-md-2">Action</th>
                                                        <th>School</th>
                                                        <th>Thn. Ajaran</th>
                                                        <th>NISN</th>
                                                        <th>Name</th>
                                                        <th>Number</th>
                                                        <th>Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($this->session->userdata("sekolah_id") > 0) {
                                                        $this->db->where("telpon.sekolah_id", $this->session->userdata("sekolah_id"));
                                                    }
                                                    if (isset($_GET["user_id"])) {
                                                        $this->db->where("telpon.user_id", $this->input->get("user_id"));
                                                    }
                                                    $telpon = $this->db
                                                        ->join("user", "telpon.user_id=user.user_id", "left")
                                                        ->join("sekolah", "sekolah.sekolah_id=user.sekolah_id", "left")
                                                        ->where("user.position_id", "4")
                                                        ->get("telpon");
                                                    // echo $this->db->last_query();
                                                    foreach ($telpon->result() as $telpon) {
                                                        if ($telpon->telpon_type == 1) {
                                                            $type = "Ortu";
                                                        } else {
                                                            $type = "Murid";
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td style="padding-left:0px; padding-right:0px;">
                                                                <form method="post" class="col-md-6" style="padding:0px;">
                                                                    <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                                    <input type="hidden" name="telpon_id" value="<?= $telpon->telpon_id; ?>" />
                                                                </form>

                                                                <form method="post" class="col-md-6" style="padding:0px;">
                                                                    <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                                    <input type="hidden" name="telpon_id" value="<?= $telpon->telpon_id; ?>" />
                                                                </form>
                                                            </td>
                                                            <td><?= $telpon->sekolah_name; ?></td>
                                                            <td><?= $telpon->user_tahunajaran; ?></td>
                                                            <td><?= $telpon->user_nisn; ?></td>
                                                            <td><?= $telpon->user_name; ?></td>
                                                            <td><?= $telpon->telpon_number; ?></td>
                                                            <td><?= $type; ?></td>
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