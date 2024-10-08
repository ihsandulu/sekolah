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
                    <li class="active">Attandance</li>
                </ul><!-- /.breadcrumb -->


            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>Attandance</h1>
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
                                            $judul = "Update Attandance";
                                        } else {
                                            $namabutton = 'name="create"';
                                            $judul = "New Attandance";
                                        } ?>
                                        <div class="lead">
                                            <h3><?= $judul; ?></h3>
                                        </div>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">

                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="absen_date">Date:</label>
                                                <div class="col-sm-10">
                                                    <input type="date" class="form-control" id="absen_date" name="absen_date" value="<?= $absen_date; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="kelas_id">Class:</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control select2" id="kelas_id" name="kelas_id">
                                                        <option value="" <?= ($kelas_id == "") ? "selected" : ""; ?>>Choose Class</option>
                                                        <?php
                                                        $kelas = $this->db->from("kelas_guru")
                                                            ->join("kelas", "kelas.kelas_id=kelas_guru.kelas_id", "left")
                                                            ->where("kelas_guru.sekolah_id", $this->session->userdata("sekolah_id"))
                                                            ->where("kelas_guru.user_id", $this->session->userdata("user_id"))
                                                            ->order_by("kelas_name", "ASC")
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
                                                    <select onchange="isinisn()" class="form-control select2" id="user_id" name="user_id">

                                                    </select>
                                                    <input id="absen_nisn" name="absen_nisn" type="hidden" />
                                                    <script>
                                                        function isinisn() {
                                                            let absen_nisn = $("#user_id option:selected").attr("absen_nisn");
                                                            $("#absen_nisn").val(absen_nisn);
                                                        }
                                                    </script>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="absen_type">Attandance:</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="absen_type" name="absen_type">
                                                        <option value="0" <?= ($absen_type == "0") ? "selected" : ""; ?>>ALPHA</option>
                                                        <option value="1" <?= ($absen_type == "1") ? "selected" : ""; ?>>IN</option>
                                                        <option value="2" <?= ($absen_type == "2") ? "selected" : ""; ?>>OUT</option>
                                                        <option value="3" <?= ($absen_type == "3") ? "selected" : ""; ?>>SICK</option>
                                                        <option value="4" <?= ($absen_type == "4") ? "selected" : ""; ?>>PERMISSION</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="absen_remarks">Remarks:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="absen_remarks" name="absen_remarks" value="<?= $absen_remarks; ?>">
                                                </div>
                                            </div>

                                            <script>
                                                function cariabsen() {
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
                                                $("#kelas_id").change(cariabsen);
                                                cariabsen();
                                            </script>

                                            <input type="hidden" name="sekolah_id" value="<?= $this->session->userdata("sekolah_id"); ?>" />
                                            <input type="hidden" name="absen_id" value="<?= $absen_id; ?>" />
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
                                    <div class="page-header  mb-5">
                                        <div>

                                            <form class="form-inline ">
                                                <?php
                                                if (isset($_GET["from"]) && $_GET["from"] != "") {
                                                    $from = $_GET["from"];
                                                } else {
                                                    $from = date("Y-m-d");
                                                }
                                                if (isset($_GET["to"]) && $_GET["to"] != "") {
                                                    $to = $_GET["to"];
                                                } else {
                                                    $to = date("Y-m-d");
                                                }
                                                ?>
                                                <div class="form-group">
                                                    <label for="from">From:</label>
                                                    <input type="date" name="from" id="from" class="form-control" value="<?= $from; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="to">To:</label>
                                                    <input type="date" name="to" id="to" class="form-control" value="<?= $to; ?>">
                                                </div>
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
                                    <div class="box">
                                        <div id="collapse4" class="body table-responsive">
                                            <table id="dataTable" class="table table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="col-md-2">Action</th>
                                                        <th>Datetime</th>
                                                        <th>Attandance</th>
                                                        <th>Remarks</th>
                                                        <th>School</th>
                                                        <th>Class</th>
                                                        <th>NISN</th>
                                                        <th>Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $kelasguru=$this->db->where("user_id",$this->session->userdata("user_id"))->get("kelas_guru");
                                                    $arrkelguru=array();
                                                    foreach($kelasguru->result() as $row){
                                                        $arrkelguru[]=$row->kelas_id;
                                                    }

                                                    if ($this->session->userdata("sekolah_id") > 0) {
                                                        $this->db->where("absen.sekolah_id", $this->session->userdata("sekolah_id"));
                                                    }
                                                    if (isset($_GET['kelas_id']) && $_GET['kelas_id'] > 0) {
                                                        $this->db->where("absen.kelas_id", $_GET['kelas_id']);
                                                    }else{
                                                        $this->db->where_in("absen.kelas_id", $arrkelguru);
                                                    }
                                                    if (isset($_GET['user_id']) && $_GET['user_id'] > 0) {
                                                        $this->db->where("absen.user_id", $_GET['user_id']);
                                                    }
                                                    $this->db->where("absen.absen_date >=", $from);
                                                    $this->db->where("absen.absen_date <=", $to);
                                                    $usr = $this->db
                                                        ->join("sekolah", "sekolah.sekolah_id=absen.sekolah_id", "left")
                                                        ->join("kelas", "kelas.kelas_id=absen.kelas_id", "left")
                                                        ->join("user", "user.user_id=absen.user_id", "left")
                                                        ->where("absen_year", date("Y"))
                                                        ->get("absen");
                                                    // echo $this->db->last_query();
                                                    foreach ($usr->result() as $absen) {
                                                        $type = array("Alpha", "In", "Out", "Sick", "Permission")
                                                    ?>
                                                        <tr>
                                                            <td style="padding-left:0px; padding-right:0px;">
                                                                <form method="post" class="col-md-3" style="padding:0px;">
                                                                    <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                                    <input type="hidden" name="absen_id" value="<?= $absen->absen_id; ?>" />
                                                                </form>
                                                                <form method="post" class="col-md-3" style="padding:0px;">
                                                                    <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                                    <input type="hidden" name="absen_id" value="<?= $absen->absen_id; ?>" />
                                                                </form>
                                                            </td>
                                                            <td><?= $absen->absen_datetime; ?></td>
                                                            <td><?= $type[$absen->absen_type]; ?></td>
                                                            <td><?= $absen->absen_remarks; ?></td>
                                                            <td><?= $absen->sekolah_name; ?></td>
                                                            <td><?= $absen->kelas_name; ?></td>
                                                            <td><?= $absen->user_nisn; ?></td>
                                                            <td><?= $absen->user_name; ?></td>
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