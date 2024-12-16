<!doctype html>
<html>

<head>
    <?php
    require_once("meta.php");
    $user_id = $this->session->userdata("user_id");
    ?>
    <style>
        .mt-5 {
            margin-top: 20px !important;
        }

        .mb-5 {
            margin-bottom: 20px !important;
        }

        .tengah {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
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
                                                    <select onchange="kelasname()" class="form-control select2" id="kelas_id" name="kelas_id">
                                                        <option value="" <?= ($kelas_id == "") ? "selected" : ""; ?>>Choose Class</option>
                                                        <?php
                                                        $kelas = $this->db->from("kelas_guru")
                                                            ->join("kelas", "kelas.kelas_id=kelas_guru.kelas_id", "left")
                                                            ->where("kelas_guru.sekolah_id", $this->session->userdata("sekolah_id"))
                                                            ->where("kelas_guru.user_id", $this->session->userdata("user_id"))
                                                            ->order_by("kelas_name", "ASC")
                                                            ->get();
                                                        foreach ($kelas->result() as $row) { ?>
                                                            <option kelas_name="<?= $row->kelas_name; ?>" value="<?= $row->kelas_id; ?>" <?= ($kelas_id == $row->kelas_id) ? "selected" : ""; ?>><?= $row->kelas_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <input type="hidden" id="kelas_name" name="kelas_name" />
                                                    <script>
                                                        function kelasname() {
                                                            let kelas_name = $("#kelas_id option:selected").attr("kelas_name");
                                                            $("#kelas_name").val(kelas_name);
                                                        }
                                                    </script>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="user_id">Student:</label>
                                                <div class="col-sm-10">
                                                    <select onchange="username()" class="form-control select2" id="user_id" name="user_id">

                                                    </select>
                                                    <input type="hidden" id="user_name" name="user_name" />
                                                    <script>
                                                        function username() {
                                                            let user_name = $("#user_id option:selected").text();
                                                            $("#user_name").val(user_name);
                                                        }
                                                    </script>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="matpel_id">Subject:</label>
                                                <div class="col-sm-10">
                                                    <select onchange="matpelname()" class="form-control select2" id="matpel_id" name="matpel_id">

                                                    </select>
                                                    <input type="hidden" id="matpel_name" name="matpel_name" />
                                                    <script>
                                                        function matpelname() {
                                                            let matpel_name = $("#matpel_id option:selected").text();
                                                            $("#matpel_name").val(matpel_name);
                                                        }
                                                    </script>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="sumatif_id">Sumatif:</label>
                                                <div class="col-sm-10">
                                                    <select onchange="sumatifname()" class="form-control" id="sumatif_id" name="sumatif_id">

                                                    </select>
                                                    <input type="hidden" id="sumatif_name" name="sumatif_name" />
                                                    <script>
                                                        function sumatifname() {
                                                            let sumatif_name = $("#sumatif_id option:selected").text();
                                                            $("#sumatif_name").val(sumatif_name);
                                                        }
                                                    </script>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="nilai_score">Score:</label>
                                                <div class="col-sm-10">
                                                    <input type="number" min="78" class="form-control" id="nilai_score" name="nilai_score" value="<?= $nilai_score; ?>">
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
                                                    // alert('<?= site_url("api/listmatpel"); ?>?matpel_id=<?= $matpel_id; ?>&kelas_id='+kelas_id+'&user_id=<?= $user_id; ?>');
                                                    $.get("<?= site_url("api/listmatpel"); ?>", {
                                                            matpel_id: '<?= $matpel_id; ?>',
                                                            user_id: '<?= $user_id; ?>'
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
                                            <?php if ($this->session->userdata("position_id") != 4) { ?>
                                                <form id="importn" method="post" class="col-md-12 form well" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="kelas_id">Class:</label>
                                                        <div class="col-sm-10">
                                                            <select onchange="kelasname()" class="form-control" id="kelas_id" name="kelas_id">
                                                                <option value="" <?= ($kelas_id == "") ? "selected" : ""; ?>>Choose Class</option>
                                                                <?php
                                                                $kelas = $this->db->from("kelas_guru")
                                                                    ->join("kelas", "kelas.kelas_id=kelas_guru.kelas_id", "left")
                                                                    ->where("kelas_guru.sekolah_id", $this->session->userdata("sekolah_id"))
                                                                    ->where("kelas_guru.user_id", $this->session->userdata("user_id"))
                                                                    ->order_by("kelas_name", "ASC")
                                                                    ->get();
                                                                foreach ($kelas->result() as $row) { ?>
                                                                    <option kelas_name="<?= $row->kelas_name; ?>" value="<?= $row->kelas_id; ?>" <?= ($kelas_id == $row->kelas_id) ? "selected" : ""; ?>><?= $row->kelas_name; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <input type="hidden" id="kelas_name" name="kelas_name" />
                                                            <script>
                                                                function kelasname() {
                                                                    let kelas_name = $("#kelas_id option:selected").attr("kelas_name");
                                                                    $("#kelas_name").val(kelas_name);
                                                                }
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="matpel_id">Subject:</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" id="matpel_id" name="matpel_id">
                                                                <option value="" <?= ($matpel_id == "") ? "selected" : ""; ?>>Choose Subject</option>
                                                                <?php
                                                                $matpel = $this->db->from("matpelguru")
                                                                    ->join("matpel", "matpel.matpel_id=matpelguru.matpel_id", "left")
                                                                    ->where("matpelguru.sekolah_id", $this->session->userdata("sekolah_id"))
                                                                    ->where("matpelguru.user_id", $this->session->userdata("user_id"))
                                                                    ->get();
                                                                // echo $this->db->last_query();
                                                                foreach ($matpel->result() as $row) { ?>
                                                                    <option value="<?= $row->matpel_id; ?>"><?= $row->matpel_name; ?></option>
                                                                <?php } ?>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2" for="sumatif_id">Sumatif:</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" id="sumatif_id" name="sumatif_id">
                                                                <option value="" <?= ($sumatif_id == "") ? "selected" : ""; ?>>Choose Sumatif</option>
                                                                <option value="100" <?= ($sumatif_id == "100") ? "selected" : ""; ?>>Tengah Semester</option>
                                                                <option value="101" <?= ($sumatif_id == "101") ? "selected" : ""; ?>>Akhir Semester</option>
                                                                <?php
                                                                $sumatif = $this->db->from("sumatif")
                                                                    ->where("sumatif.sekolah_id", $this->session->userdata("sekolah_id"))
                                                                    ->get();
                                                                // echo $this->db->last_query();
                                                                foreach ($sumatif->result() as $row) { ?>
                                                                    <option value="<?= $row->sumatif_id; ?>" <?= ($sumatif_id == $row->sumatif_id) ? "selected" : ""; ?>><?= $row->sumatif_name; ?></option>
                                                                <?php } ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Import Excel : </label>
                                                        <input class="form-control" name="filesiswa" type="file" />
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="hidden" name="nilaigagal_temporary" value="<?= date("ymdHis"); ?>" />
                                                        <button class="btn btn-primary" type="submit" name="import">Import</button>
                                                        <button class="btn btn-danger" type="button" onclick="tutupimport()">Close</button>
                                                    </div>
                                                </form>
                                                <button id="btnimport" class="btn btn-primary" type="button" onclick="bukaimport()">Import Excel</button>
                                                <button id="btntemplate" class="btn btn-success" type="button" onclick="downloadtemplate()"><i class="fa fa-print"></i> Download Excel Template</button>
                                                <script>
                                                    function tutupimport() {
                                                        $("#importn").hide();
                                                        $("#btnimport").show();
                                                    }

                                                    function bukaimport() {
                                                        $("#importn").show();
                                                        $("#btnimport").hide();
                                                    }
                                                    tutupimport();

                                                    function downloadtemplate() {
                                                        window.open("<?= base_url("score.xlsx"); ?>", '_self');
                                                    }
                                                </script>
                                                <br />
                                                <br />
                                            <?php } ?>
                                            <?php
                                            if ($this->session->userdata("position_id") != 4) {
                                            ?>
                                                <div class="page-header  mb-5">
                                                    <div>

                                                        <form class="form-inline col-md-6">

                                                            <div class="form-group">
                                                                <label for="kelas_id">Class:</label>
                                                                <?php
                                                                if (isset($_GET["kelas_id"])) {
                                                                    $kelas_id = $this->input->get("kelas_id");
                                                                } else {
                                                                    $kelas_id = 0;
                                                                }
                                                                if (isset($_GET["user_id"])) {
                                                                    $user_id = $this->input->get("user_id");
                                                                } else {
                                                                    $user_id = 0;
                                                                }
                                                                $this->db->join("kelas", "kelas.kelas_id=kelas_guru.kelas_id", "left");
                                                                if ($this->session->userdata("sekolah_id") > 0) {
                                                                    $this->db->where("kelas.sekolah_id", $this->session->userdata("sekolah_id"));
                                                                }
                                                                if ($this->session->userdata("position_id") != 1 && $this->session->userdata("position_id") != 2) {
                                                                    $this->db->where("kelas_guru.user_id", $this->session->userdata("user_id"));
                                                                }
                                                                $gru = $this->db->group_by("kelas_guru.kelas_id")
                                                                    ->get("kelas_guru");
                                                                // echo $this->db->last_query();
                                                                // echo $this->session->userdata("position_id");
                                                                ?>
                                                                <select onchange="listsiswasekolah();" name="kelas_id" id="kelas_id" class="form-control" onChange="cari_user(this.value)">
                                                                    <option value="0" <?= ($kelas_id == 0) ? 'selected="selected"' : ""; ?>>Choose Class</option>
                                                                    <?php

                                                                    foreach ($gru->result() as $kelas) { ?>
                                                                        <option value="<?= $kelas->kelas_id; ?>" <?= ($kelas_id == $kelas->kelas_id) ? 'selected="selected"' : ""; ?>><?= $kelas->kelas_name; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>

                                                            <script>
                                                                function listsiswasekolah() {
                                                                    let kelas_id = $("#kelas_id").val();
                                                                    // alert("<?= base_url("api/listsiswakelas"); ?>?kelas_id="+kelas_id+"&user_id=<?= $user_id; ?>");
                                                                    if (kelas_id > 0) {
                                                                        $.get("<?= base_url("api/listsiswakelas"); ?>", {
                                                                                kelas_id: kelas_id,
                                                                                user_id: '<?= $user_id; ?>'
                                                                            })
                                                                            .done(function(data) {
                                                                                $("#user_id").html(data);
                                                                            });
                                                                    } else {
                                                                        $("#user_id").html('');
                                                                    }
                                                                }

                                                                listsiswasekolah();
                                                            </script>


                                                            <div class="form-group">
                                                                <label for="user_id">Student:</label>
                                                                <select name="user_id" id="user_id" class="form-control">

                                                                </select>
                                                            </div>

                                                            <button type="submit" class="btn btn-default">Submit</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="margin-top:10px; margin-bottom:10px;">
                                                    <?php
                                                    if (isset($_GET["kelas_id"]) && $_GET["kelas_id"] != "") {
                                                        $kelas_id = $_GET["kelas_id"];
                                                    } else {
                                                        $kelas_id = "";
                                                    }
                                                    if (isset($_GET["user_id"]) && $_GET["user_id"] != "") {
                                                        $user_id = $_GET["user_id"];
                                                    } else {
                                                        $user_id = "";
                                                    }
                                                    $matpelguru = $this->db
                                                        ->join("matpel", "matpel.matpel_id=matpelguru.matpel_id", "left")
                                                        ->where("user_id", $this->session->userdata("user_id"))
                                                        ->get("matpelguru");
                                                    foreach ($matpelguru->result() as $matpelguru) {
                                                        $matpel_id = $matpelguru->matpel_id;
                                                    ?>
                                                        <a title="Raport STS <?= $matpelguru->matpel_name; ?>" href="<?= base_url("raportsts?matpel_id=" . $matpel_id . "&kelas_id=" . $kelas_id . "&user_id=" . $user_id . "&matpel_name=" . $matpelguru->matpel_name. "&guru_id=" . $this->session->userdata("user_id")); ?>" target="_blank" type="submit" class="btn btn-success fa fa-file-excel-o" style="font-size:12px;"> Raport STS <?= $matpelguru->matpel_name; ?></a>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                            <br />

                                            <?php
                                            if (isset($_GET["kelas_id"]) && $_GET["kelas_id"] > 0) {
                                            ?>
                                                <table id="dataTable" class="table table-condensed table-hover ">
                                                    <thead>
                                                        <tr>
                                                            <?php if ($this->session->userdata("position_id") != 4) { ?>
                                                                <th class="col-md-2">Action</th>
                                                            <?php } ?>
                                                            <th>Tahun</th>
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
                                                        if (isset($_GET['kelas_id']) && $_GET['kelas_id'] > 0) {
                                                            $this->db->where("kelas.kelas_id", $_GET['kelas_id']);
                                                        }
                                                        if (isset($_GET['user_id']) && $_GET['user_id'] > 0) {
                                                            $this->db->where("user.user_id", $_GET['user_id']);
                                                        }
                                                        $usr = $this->db
                                                            ->select("*,nilai.sumatif_id as sumatif_id")
                                                            ->join("sekolah", "sekolah.sekolah_id=nilai.sekolah_id", "left")
                                                            ->join("matpel", "matpel.matpel_id=nilai.matpel_id", "left")
                                                            ->join("sumatif", "sumatif.sumatif_id=nilai.sumatif_id", "left")
                                                            ->join("kelas", "kelas.kelas_id=nilai.kelas_id", "left")
                                                            ->join("user", "user.user_id=nilai.user_id", "left")
                                                            ->where("nilai_year", date("Y"))
                                                            ->get("nilai");
                                                        // echo $this->db->last_query();
                                                        foreach ($usr->result() as $nilai) {
                                                            $sumatif_name = $nilai->sumatif_name;
                                                            if ($nilai->sumatif_id == "100") {
                                                                $sumatif_name = "Sumatif Tengah Semester";
                                                            }
                                                            if ($nilai->sumatif_id == "101") {
                                                                $sumatif_name = "Sumatif Akhir Semester";
                                                            }
                                                        ?>
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
                                                                <td><?= $nilai->nilai_year; ?></td>
                                                                <td><?= $nilai->sekolah_name; ?></td>
                                                                <td><?= $nilai->kelas_name; ?></td>
                                                                <td><?= $nilai->matpel_name; ?></td>
                                                                <td><?= $sumatif_name; ?></td>
                                                                <td><?= $nilai->user_nik; ?></td>
                                                                <td><?= $nilai->user_name; ?></td>
                                                                <td><?= $nilai->nilai_score; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            <?php } else if (isset($_POST["nilaigagal_temporary"])) { ?>
                                                <h1 style="margin-top:30px; border-top:black solid 1px; padding-top:30px;padding-bottom:30px;">Failed Import Data</h1>
                                                <table id="dataTable" class="table table-condensed table-hover ">
                                                    <thead>
                                                        <tr>
                                                            <th>NISN</th>
                                                            <th>Name</th>
                                                            <th>Score</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                        $usr = $this->db
                                                            ->where("nilaigagal_temporary", $_POST["nilaigagal_temporary"])
                                                            ->get("nilaigagal");
                                                        // echo $this->db->last_query();
                                                        foreach ($usr->result() as $nilai) {
                                                        ?>
                                                            <tr>
                                                                <td><?= $nilai->user_nisn; ?></td>
                                                                <td><?= $nilai->user_name; ?></td>
                                                                <td><?= $nilai->nilaigagal_score; ?></td>
                                                                <td><?= $nilai->nilaigagal_remarks; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <h1 style="margin-top:30px; border-top:black solid 1px; padding-top:30px;padding-bottom:30px;">Successed Data</h1>
                                                <table id="dataTable" class="table table-condensed table-hover ">
                                                    <thead>
                                                        <tr>
                                                            <th>NISN</th>
                                                            <th>Name</th>
                                                            <th>Score</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                        $usr = $this->db
                                                        ->join("user","user.user_id=nilai.user_id","left")
                                                            ->where("nilaigagal_temporary", $_POST["nilaigagal_temporary"])
                                                            ->get("nilai");
                                                        // echo $this->db->last_query();
                                                        foreach ($usr->result() as $nilai) {
                                                        ?>
                                                            <tr>
                                                                <td><?= $nilai->user_nisn; ?></td>
                                                                <td><?= $nilai->user_name; ?></td>
                                                                <td><?= $nilai->nilai_score; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            <?php } else { ?>
                                                <div class="tengah1">
                                                    <h1><b>Choose Class First!</b></h1>
                                                </div>
                                            <?php } ?>
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