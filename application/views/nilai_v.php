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
                    <li class="active">Score</li>
                </ul><!-- /.breadcrumb -->


            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>Score</h1>
                    <?php if (!isset($_POST['new']) && !isset($_POST['edit']) && $this->session->userdata("position_id") != 4) { ?>

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
                                            $judul = "Update Score";
                                        } else {
                                            $namabutton = 'name="create"';
                                            $judul = "New Score";
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
                                                            ->order_by("kelas_name","ASC")
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
                                                <label class="control-label col-sm-2" for="matpel_id">Subject:</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="matpel_id" name="matpel_id">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="sumatif_id">Sumatif:</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="sumatif_id" name="sumatif_id">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="nilai_score">Score:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="nilai_score" name="nilai_score" value="<?= $nilai_score; ?>">
                                                </div>
                                            </div>





                                            <script>
                                                function carinilai() {
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

                                                    //matapelajaran
                                                    // alert('<?= site_url("api/listmatpel"); ?>?matpel_id=<?= $matpel_id; ?>&kelas_id='+kelas_id);
                                                    $.get("<?= site_url("api/listmatpel"); ?>", {
                                                            matpel_id: '<?= $matpel_id; ?>',
                                                            kelas_id: kelas_id
                                                        })
                                                        .done(function(data) {
                                                            $('#matpel_id').html(data);
                                                        });

                                                    //sumatif
                                                    // alert('<?= site_url("api/listsumatif"); ?>?sumatif_id=<?= $sumatif_id; ?>&kelas_id='+kelas_id);
                                                    $.get("<?= site_url("api/listsumatif"); ?>", {
                                                            sumatif_id: '<?= $sumatif_id; ?>',
                                                            kelas_id: kelas_id
                                                        })
                                                        .done(function(data) {
                                                            $('#sumatif_id').html(data);
                                                        });
                                                }
                                                $("#kelas_id").change(carinilai);
                                                carinilai();
                                            </script>

                                            <input type="hidden" name="sekolah_id" value="<?= $this->session->userdata("sekolah_id"); ?>" />
                                            <input type="hidden" name="nilai_id" value="<?= $nilai_id; ?>" />
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
                                                        <?php if ($this->session->userdata("position_id") != 4) { ?>
                                                            <th class="col-md-2">Action</th>
                                                        <?php } ?>
                                                        <th>School</th>
                                                        <th>Class</th>
                                                        <th>Subject</th>
                                                        <th>Sumatif</th>
                                                        <th>NIK</th>
                                                        <th>Name</th>
                                                        <th>Score</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($this->session->userdata("sekolah_id") > 0) {
                                                        $this->db->where("nilai.sekolah_id", $this->session->userdata("sekolah_id"));
                                                    }

													if ($this->session->userdata("position_id") == 4) {
														$this->db->where("nilai.user_id", $this->session->userdata("user_id"));
													}
                                                    $usr = $this->db
                                                        ->join("sekolah", "sekolah.sekolah_id=nilai.sekolah_id", "left")
                                                        ->join("matpel", "matpel.matpel_id=nilai.matpel_id", "left")
                                                        ->join("sumatif", "sumatif.sumatif_id=nilai.sumatif_id", "left")
                                                        ->join("kelas", "kelas.kelas_id=nilai.kelas_id", "left")
                                                        ->join("user", "user.user_id=nilai.user_id", "left")
                                                        ->get("nilai");
                                                    // echo $this->db->last_query();
                                                    foreach ($usr->result() as $nilai) { ?>
                                                        <tr>
                                                            <?php if ($this->session->userdata("position_id") != 4) { ?>
                                                                <td style="padding-left:0px; padding-right:0px;">
                                                                    <form method="post" class="col-md-3" style="padding:0px;">
                                                                        <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                                        <input type="hidden" name="nilai_id" value="<?= $nilai->nilai_id; ?>" />
                                                                    </form>
                                                                    <form method="post" class="col-md-3" style="padding:0px;">
                                                                        <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                                        <input type="hidden" name="nilai_id" value="<?= $nilai->nilai_id; ?>" />
                                                                    </form>
                                                                </td>
                                                            <?php } ?>
                                                            <td><?= $nilai->sekolah_name; ?></td>
                                                            <td><?= $nilai->kelas_name; ?></td>
                                                            <td><?= $nilai->matpel_name; ?></td>
                                                            <td><?= $nilai->sumatif_name; ?></td>
                                                            <td><?= $nilai->user_nik; ?></td>
                                                            <td><?= $nilai->user_name; ?></td>
                                                            <td><?= $nilai->nilai_score; ?></td>
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