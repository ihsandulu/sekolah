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
                    <li class="active">Note</li>
                </ul><!-- /.breadcrumb -->


            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>Note</h1>
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
                                            $judul = "Update Note";
                                        } else {
                                            $namabutton = 'name="create"';
                                            $judul = "New Note";
                                        } ?>
                                        <div class="lead">
                                            <h3><?= $judul; ?></h3>
                                        </div>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">

                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="kelas_id">Class:</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="kelas_id" name="kelas_id">
                                                        <option value="" <?= ($kelas_id == "") ? "selected" : ""; ?>>Choose Class</option>
                                                        <?php
                                                        $kelas = $this->db->from("kelas_sekolah")
                                                            ->join("kelas", "kelas.kelas_id=kelas_sekolah.kelas_id", "left")
                                                            ->where("kelas_sekolah.sekolah_id", $this->session->userdata("sekolah_id"))
                                                            ->order_by("kelas_name")
                                                            ->get();
                                                        foreach ($kelas->result() as $row) { ?>
                                                            <option value="<?= $row->kelas_id; ?>" <?= ($kelas_id == $row->kelas_id) ? "selected" : ""; ?>><?= $row->kelas_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="user_id">Student:</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="user_id" name="user_id">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="catatan_note">Note:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="catatan_note" name="catatan_note" value="<?= $catatan_note; ?>">
                                                </div>
                                            </div>





                                            <script>
                                                function caricatatan() {
                                                    let kelas_id = $('#kelas_id').val();
                                                    // alert('<?= site_url("api/liststudent"); ?>?user_id=<?= $user_id; ?>&kelas_id='+kelas_id);

                                                    //siswa
                                                    $.get("<?= site_url("api/liststudent"); ?>", {
                                                            user_id: '<?= $user_id; ?>',
                                                            kelas_id: kelas_id
                                                        })
                                                        .done(function(data) {
                                                            $('#user_id').html(data);
                                                        });


                                                }
                                                $("#kelas_id").change(caricatatan);
                                                caricatatan();
                                            </script>

                                            <input type="hidden" name="sekolah_id" value="<?= $this->session->userdata("sekolah_id"); ?>" />
                                            <input type="hidden" name="catatan_id" value="<?= $catatan_id; ?>" />
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
                                        <div id="collapse4" class="body table-responsive">
                                            <table id="dataTable" class="table table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="col-md-2">Action</th>
                                                        <th>Year</th>
                                                        <th>School</th>
                                                        <th>Class</th>
                                                        <th>NISN</th>
                                                        <th>Name</th>
                                                        <th>Note</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($this->session->userdata("sekolah_id") > 0) {
                                                        $this->db->where("catatan.sekolah_id", $this->session->userdata("sekolah_id"));
                                                    }
                                                    $usr = $this->db
                                                        ->join("sekolah", "sekolah.sekolah_id=catatan.sekolah_id", "left")
                                                        ->join("kelas", "kelas.kelas_id=catatan.kelas_id", "left")
                                                        ->join("user", "user.user_id=catatan.user_id", "left")
                                                        ->where("catatan_year",date("Y"))
                                                        ->get("catatan");
                                                    // echo $this->db->last_query();
                                                    foreach ($usr->result() as $catatan) { ?>
                                                        <tr>
                                                            <td style="padding-left:0px; padding-right:0px;">
                                                                <form method="post" class="col-md-3" style="padding:0px;">
                                                                    <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                                    <input type="hidden" name="catatan_id" value="<?= $catatan->catatan_id; ?>" />
                                                                </form>
                                                                <form method="post" class="col-md-3" style="padding:0px;">
                                                                    <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                                    <input type="hidden" name="catatan_id" value="<?= $catatan->catatan_id; ?>" />
                                                                </form>
                                                            </td>
                                                            <td><?= $catatan->catatan_year; ?></td>
                                                            <td><?= $catatan->sekolah_name; ?></td>
                                                            <td><?= $catatan->kelas_name; ?></td>
                                                            <td><?= $catatan->user_nisn; ?></td>
                                                            <td><?= $catatan->user_name; ?></td>
                                                            <td><?= $catatan->catatan_note; ?></td>
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