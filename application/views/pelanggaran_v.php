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
                    <li class="active">Violation</li>
                </ul><!-- /.breadcrumb -->


            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>
                        Violation

                    </h1>
                    <?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>
                        <?php if (!isset($_GET["laporan"])) { ?>

                            <form method="post" class="col-md-2" style="margin-top:-30px; float:right;">

                                <button name="new" class="btn btn-info btn-block btn-sm" value="OK" style="">New</button>
                                <input type="hidden" name="user_id" />

                            </form>

                        <?php } ?>
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
                                            $judul = "Update Violation";
                                        } else {
                                            $namabutton = 'name="create"';
                                            $judul = "New Violation";
                                        } ?>
                                        <div class="lead">
                                            <h3><?= $judul; ?></h3>
                                        </div>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">

                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="pelanggaran_date">Date:</label>
                                                <div class="col-sm-10">
                                                    <input type="date" class="form-control" id="pelanggaran_date" name="pelanggaran_date" value="<?= $pelanggaran_date; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="user_nisn">NISN:</label>
                                                <div class="col-sm-10">
                                                    <input autofocus data-kelas_id="<?= $kelas_id; ?>" type="user_name" class="form-control" id="user_nisn" name="user_nisn" placeholder="Enter nisn" value="<?= $user_nisn; ?>">
                                                    <div class="col-sm-12" id="message" style="color:red;">

                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    // Event ketika input kehilangan fokus
                                                    $("#user_nisn").on('blur', cekkelas);

                                                    // Event ketika tombol Enter ditekan
                                                    $("#user_nisn").on('keypress', function(e) {
                                                        if (e.which == 13) {
                                                            e.preventDefault(); // Mencegah perilaku default (submit form)
                                                            cekkelas();
                                                        }
                                                    });

                                                    function cekkelas() {
                                                        let user_nisn = $("#user_nisn").val();

                                                        // Memastikan data dikembalikan sebagai JSON
                                                        $.get("<?= base_url('api/siswa'); ?>", {
                                                                user_nisn: user_nisn
                                                            }, function(data) {
                                                                if (data.kelas_id) {
                                                                    $("#kelas_id").val(data.kelas_id);
                                                                    $("#message").html(data.user_name);
                                                                } else if (data.error) {
                                                                    $("#message").html(data.error);
                                                                }
                                                            }, 'json') // Menentukan tipe data yang diharapkan adalah JSON
                                                            .fail(function(jqXHR, textStatus, errorThrown) {
                                                                $("#message").html(textStatus);
                                                            });
                                                    }
                                                });
                                            </script>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="mpelanggaran_id">Violation:</label>
                                                <div class="col-sm-10">
                                                    <select onchange="isipoint()" class="form-control" id="mpelanggaran_id" name="mpelanggaran_id" value="<?= $mpelanggaran_id; ?>">
                                                        <option data-point="0" value="0" <?= ($mpelanggaran_id == 0) ? "selected" : ""; ?>>Choose Violation</option>
                                                        <?php
                                                        $mpelanggaran = $this->db->order_by("mpelanggaran_name", "ASC")->get("mpelanggaran");
                                                        foreach ($mpelanggaran->result() as $mpelanggaran) { ?>
                                                            <option data-point="<?= $mpelanggaran->mpelanggaran_point; ?>" value="<?= $mpelanggaran->mpelanggaran_id; ?>" <?= ($mpelanggaran_id == $mpelanggaran->mpelanggaran_id) ? "selected" : ""; ?>><?= $mpelanggaran->mpelanggaran_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <script>
                                                        $(document).ready(function() {
                                                            $('#mpelanggaran_id').change(function() {
                                                                var selectedOption = $(this).find('option:selected');
                                                                var pointValue = selectedOption.data('point');
                                                                // alert(pointValue);
                                                                $("#pelanggaran_point").val(pointValue);
                                                            });
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="pelanggaran_point">Point:</label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" id="pelanggaran_point" name="pelanggaran_point" placeholder="Enter Violation" value="<?= $pelanggaran_point; ?>">
                                                </div>
                                            </div>





                                            <input type="hidden" name="kelas_id" id="kelas_id" value="<?= $kelas_id; ?>" />
                                            <input type="hidden" name="sekolah_id" value="<?= $this->session->userdata("sekolah_id"); ?>" />
                                            <input type="hidden" name="pelanggaran_id" value="<?= $pelanggaran_id; ?>" />
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
                                    <?php if (!isset($_GET["type"])) { ?>
                                        <?php if ($this->session->userdata("position_id") != 4) { ?>
                                            <div class="page-header  mb-5">
                                                <div>

                                                    <form class="form-inline ">
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
                                                                // $this->db->where("kelas_guru.user_id", $this->session->userdata("user_id"));
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
                                                                // alert("<?= base_url("api/listsiswakelasnisn"); ?>?kelas_id="+kelas_id+"&user_nisn=<?= $user_nisn; ?>");
                                                                if (kelas_id > 0) {
                                                                    $.get("<?= base_url("api/listsiswakelasnisn"); ?>", {
                                                                            kelas_id: kelas_id,
                                                                            user_nisn: '<?= $user_nisn; ?>'
                                                                        })
                                                                        .done(function(data) {
                                                                            $("#user_nisn").html(data);
                                                                        });
                                                                } else {
                                                                    $("#user_nisn").html('');
                                                                }
                                                            }

                                                            listsiswasekolah();
                                                        </script>


                                                        <div class="form-group">
                                                            <label for="user_nisn">Student:</label>
                                                            <select name="user_nisn" id="user_nisn" class="form-control">

                                                            </select>
                                                        </div>

                                                        <button type="submit" class="btn btn-default">Submit</button>
                                                        <a href="<?= base_url("pelanggaran") ?>?type=rangkuman" class="btn btn-warning">Rangkuman</a>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="box">
                                            <div id="collapse4" class="body table-responsive">
                                                <table id="dataTable" class="table table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <?php if (!isset($_GET["laporan"])) { ?>
                                                                <th class="col-md-1">Action</th>
                                                            <?php } ?>
                                                            <th>Date</th>
                                                            <th>School</th>
                                                            <th>Class</th>
                                                            <th>NISN</th>
                                                            <th>Student</th>
                                                            <th>Violation</th>
                                                            <th>Point</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $kelasguru = $this->db->where("user_id", $this->session->userdata("user_id"))->get("kelas_guru");
                                                        $arrkelguru = array();
                                                        foreach ($kelasguru->result() as $row) {
                                                            $arrkelguru[] = $row->kelas_id;
                                                        }

                                                        if ($this->session->userdata("sekolah_id") > 0) {
                                                            $this->db->where("pelanggaran.sekolah_id", $this->session->userdata("sekolah_id"));
                                                        }


                                                        if (isset($_GET['kelas_id']) && $_GET['kelas_id'] > 0) {
                                                            $this->db->where("pelanggaran.kelas_id", $_GET['kelas_id']);
                                                        } else {
                                                            if (!empty($arrkelguru)) {
                                                                $this->db->where_in("pelanggaran.kelas_id", $arrkelguru);
                                                            }
                                                        }
                                                        if (isset($_GET['user_nisn']) && $_GET['user_nisn'] > 0) {
                                                            $this->db->where("pelanggaran.user_nisn", $_GET['user_nisn']);
                                                        }
                                                        if ($this->session->userdata("position_id") == 4) {
                                                            $this->db->where("pelanggaran.user_nisn", $this->session->userdata("user_nisn"));
                                                        }
                                                        $this->db->where("pelanggaran.pelanggaran_date >=", $from);
                                                        $this->db->where("pelanggaran.pelanggaran_date <=", $to);
                                                        $usr = $this->db
                                                            ->join("user", "user.user_nisn=pelanggaran.user_nisn", "left")
                                                            ->join("kelas", "kelas.kelas_id=user.kelas_id", "left")
                                                            ->join("sekolah", "sekolah.sekolah_id=pelanggaran.sekolah_id", "left")
                                                            ->join("mpelanggaran", "mpelanggaran.mpelanggaran_id=pelanggaran.mpelanggaran_id", "left")
                                                            ->where("pelanggaran.pelanggaran_year", date("Y"))
                                                            ->get("pelanggaran");
                                                        // echo $this->db->last_query();
                                                        foreach ($usr->result() as $pelanggaran) { ?>
                                                            <tr>
                                                                <?php if (!isset($_GET["laporan"])) { ?>
                                                                    <td style="padding-left:0px; padding-right:0px;">
                                                                        <form method="post" class="col-md-6" style="padding:0px;">
                                                                            <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                                            <input type="hidden" name="pelanggaran_id" value="<?= $pelanggaran->pelanggaran_id; ?>" />
                                                                        </form>

                                                                        <form method="post" class="col-md-6" style="padding:0px;">
                                                                            <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                                            <input type="hidden" name="pelanggaran_id" value="<?= $pelanggaran->pelanggaran_id; ?>" />
                                                                        </form>
                                                                    </td>
                                                                <?php } ?>
                                                                <td><?= $pelanggaran->pelanggaran_date; ?></td>
                                                                <td><?= $pelanggaran->sekolah_name; ?></td>
                                                                <td><?= $pelanggaran->kelas_name; ?></td>
                                                                <td><?= $pelanggaran->user_nisn; ?></td>
                                                                <td><?= $pelanggaran->user_name; ?></td>
                                                                <td><?= $pelanggaran->mpelanggaran_name; ?></td>
                                                                <td><?= $pelanggaran->pelanggaran_point; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <?php if ($this->session->userdata("position_id") != 4) { ?>
                                            <div class="page-header  mb-5">
                                                <div>

                                                    <form class="form-inline ">
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
                                                                // $this->db->where("kelas_guru.user_id", $this->session->userdata("user_id"));
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
                                                                // alert("<?= base_url("api/listsiswakelasnisn"); ?>?kelas_id="+kelas_id+"&user_nisn=<?= $user_nisn; ?>");
                                                                if (kelas_id > 0) {
                                                                    $.get("<?= base_url("api/listsiswakelasnisn"); ?>", {
                                                                            kelas_id: kelas_id,
                                                                            user_nisn: '<?= $user_nisn; ?>'
                                                                        })
                                                                        .done(function(data) {
                                                                            $("#user_nisn").html(data);
                                                                        });
                                                                } else {
                                                                    $("#user_nisn").html('');
                                                                }
                                                            }

                                                            listsiswasekolah();
                                                        </script>


                                                        <div class="form-group">
                                                            <label for="user_nisn">Student:</label>
                                                            <select name="user_nisn" id="user_nisn" class="form-control">

                                                            </select>
                                                        </div>
                                                        <input type="hidden" name="type" value="rangkuman" />
                                                        <button type="submit" class="btn btn-default">Submit</button>
                                                        <a href="<?= base_url("pelanggaran") ?>" class="btn btn-warning">Detail</a>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="box">
                                            <div id="collapse4" class="body table-responsive">
                                                <table id="dataTable" class="table table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <?php if (!isset($_GET["laporan"])) { ?>
                                                                <th class="col-md-1">Action</th>
                                                            <?php } ?>
                                                            <th>Class</th>
                                                            <th>NISN</th>
                                                            <th>Student</th>
                                                            <th>Point</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $kelasguru = $this->db->where("user_id", $this->session->userdata("user_id"))->get("kelas_guru");
                                                        $arrkelguru = array();
                                                        foreach ($kelasguru->result() as $row) {
                                                            $arrkelguru[] = $row->kelas_id;
                                                        }

                                                        if ($this->session->userdata("sekolah_id") > 0) {
                                                            $this->db->where("pelanggaran.sekolah_id", $this->session->userdata("sekolah_id"));
                                                        }


                                                        if (isset($_GET['kelas_id']) && $_GET['kelas_id'] > 0) {
                                                            $this->db->where("pelanggaran.kelas_id", $_GET['kelas_id']);
                                                        } else {
                                                            if (!empty($arrkelguru)) {
                                                                $this->db->where_in("pelanggaran.kelas_id", $arrkelguru);
                                                            }
                                                        }
                                                        if (isset($_GET['user_nisn']) && $_GET['user_nisn'] > 0) {
                                                            $this->db->where("pelanggaran.user_nisn", $_GET['user_nisn']);
                                                        }
                                                        if ($this->session->userdata("position_id") == 4) {
                                                            $this->db->where("pelanggaran.user_nisn", $this->session->userdata("user_nisn"));
                                                        }
                                                        $this->db->select("
                                                            user.user_token,
                                                            user.user_tokenortu,
                                                            user.user_tokenguru,
                                                            user.user_nisn,
                                                            user.user_nik,
                                                            user.user_name,
                                                            kelas.kelas_name,
                                                            SUM(mpelanggaran.mpelanggaran_point) AS total_point
                                                        ");

                                                        $this->db->from("pelanggaran");
                                                        $this->db->join("user", "user.user_nisn=pelanggaran.user_nisn", "left");
                                                        $this->db->join("kelas", "kelas.kelas_id=user.kelas_id", "left");
                                                        $this->db->join("sekolah", "sekolah.sekolah_id=pelanggaran.sekolah_id", "left");
                                                        $this->db->join("mpelanggaran", "mpelanggaran.mpelanggaran_id=pelanggaran.mpelanggaran_id", "left");

                                                        $this->db->where("pelanggaran.pelanggaran_date >=", $from);
                                                        $this->db->where("pelanggaran.pelanggaran_date <=", $to);
                                                        $this->db->where("pelanggaran.pelanggaran_year", date("Y"));

                                                        $this->db->group_by("pelanggaran.user_nisn");

                                                        $usr = $this->db->get();
                                                        echo $this->db->last_query();
                                                        $status = "";
                                                        foreach ($usr->result() as $pelanggaran) {
                                                            $tpoint = $pelanggaran->total_point;
                                                            if ($tpoint >= 100) {
                                                                $status = "Peringatan Siswa/i dikembalikan pada Orang Tua";
                                                                $btnstatus = "btn-danger";
                                                                $token = $pelanggaran->user_tokenortu;
                                                                $nama = "Wali Murid " . $pelanggaran->user_name;
                                                                $tipe = "walimurid";
                                                            } elseif ($tpoint >= 90) {
                                                                $status = "Peringatan Siswa/i akan dikembalikan pada Orang Tua";
                                                                $btnstatus = "btn-warning";
                                                                $token = $pelanggaran->user_tokenortu;
                                                                $nama = "Wali Murid " . $pelanggaran->user_name;
                                                                $tipe = "walimurid";
                                                            } elseif ($tpoint >= 75) {
                                                                $status = "Peringatan Kedua Wali Murid";
                                                                $btnstatus = "btn-info";
                                                                $token = $pelanggaran->user_tokenortu;
                                                                $nama = "Wali Murid " . $pelanggaran->user_name;
                                                                $tipe = "walimurid";
                                                            } elseif ($tpoint >= 50) {
                                                                $status = "Peringatan Pertama Wali Murid";
                                                                $btnstatus = "btn-primary";
                                                                $token = $pelanggaran->user_tokenortu;
                                                                $nama = "Wali Murid " . $pelanggaran->user_name;
                                                                $tipe = "walimurid";
                                                            } elseif ($tpoint >= 25) {
                                                                $status = "Panggilan untuk Murid";
                                                                $btnstatus = "btn-success";
                                                                $token = $pelanggaran->user_token;
                                                                $nama = $pelanggaran->user_name;
                                                                $tipe = "siswa";
                                                            } else {
                                                                $status = "";
                                                                $btnstatus = "btn-default";
                                                                $token = "";
                                                                $nama = "";
                                                                $tipe = "";
                                                            }
                                                        ?>
                                                            <tr>
                                                                <?php if (!isset($_GET["laporan"])) { ?>
                                                                    <td style="padding-left:0px; padding-right:0px;">
                                                                        <form method="post" class="col-md-12" style="padding:0px;">
                                                                            <button
                                                                                type="submit"
                                                                                class="btn btn-danger"
                                                                                name="deletepoint"
                                                                                value="OK"
                                                                                data-toggle="tooltip"
                                                                                data-placement="top"
                                                                                title="Kosongkan Point">
                                                                                Kosongkan Point
                                                                            </button>

                                                                            <input type="hidden" name="user_nisn" value="<?= $pelanggaran->user_nisn; ?>" />
                                                                        </form>
                                                                    </td>
                                                                <?php } ?>
                                                                <td><?= $pelanggaran->kelas_name; ?></td>
                                                                <td><?= $pelanggaran->user_nisn; ?></td>
                                                                <td><?= $pelanggaran->user_name; ?></td>
                                                                <td><?= $tpoint; ?></td>
                                                                <td>
                                                                    <?php if ($tpoint >= 25) { ?>
                                                                        <button
                                                                            type="button"
                                                                            class="btn btn-sm <?= $btnstatus; ?>"
                                                                            data-toggle="modal"
                                                                            data-target="#modalStatus"
                                                                            data-status="<?= $status; ?>"
                                                                            data-name="<?= $nama; ?>"
                                                                            data-nisn="<?= $pelanggaran->user_nisn; ?>"
                                                                            data-nik="<?= $pelanggaran->user_nik; ?>"
                                                                            data-token="<?= $token; ?>"
                                                                            data-tipe="<?= $tipe; ?>"
                                                                            data-code="1"
                                                                            data-point="<?= $pelanggaran->total_point; ?>">
                                                                            <?= $status; ?>
                                                                        </button>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <div class="modal fade" id="modalStatus" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Kirim Notifikasi</h5>
                                                                <button type="button" class="close" data-dismiss="modal">
                                                                    <span>&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <p><strong>Penerima :</strong> <span id="penerima"></span></p>
                                                                <p><strong>Total Point Siswa/i:</strong> <span id="modal_point"></span></p>
                                                                <p><strong>Pesan :</strong>
                                                                    <span>
                                                                        <textarea id="modal_pesan" class="form-control" rows="5"></textarea>
                                                                    </span>
                                                                </p>
                                                                <p><strong>Pesan :</strong>
                                                                    <span>
                                                                        <input type="hidden" id="modal_nisn">
                                                                        <input type="hidden" id="modal_nik">
                                                                        <input type="hidden" id="modal_token">
                                                                        <input type="hidden" id="modal_tipe">
                                                                        <input type="hidden" id="modal_code">
                                                                        <button
                                                                            id="modal_kirim"
                                                                            type="button"
                                                                            class="btn btn-primary"
                                                                            onclick="sendNotification()">
                                                                            Kirim Notifikasi
                                                                        </button>
                                                                    </span>
                                                                </p>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button onclick="kosongkanmodal();" type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    function kosongkanmodal() {
                                                        $("#modal_kirim")
                                                            .prop("disabled", false)
                                                            .text("Kirim Notifikasi");
                                                        $("#modalStatus").modal("hide");
                                                        $("#modal_nisn").val("");
                                                        $("#modal_nik").val("");
                                                        $("#modal_token").val("");
                                                        $("#modal_tipe").val("");
                                                        $("#modal_pesan").val("");
                                                        $("#modal_code").val("");
                                                    }

                                                    function sendNotification() {

                                                        var nisn = $("#modal_nisn").val();
                                                        var nik = $("#modal_nik").val();
                                                        var token = $("#modal_token").val();
                                                        var tipe = $("#modal_tipe").val();
                                                        var pesan = $("#modal_pesan").val();
                                                        var code = $("#modal_code").val();

                                                        $.ajax({
                                                            url: "<?= base_url('api/kirimnotifikasiandroid'); ?>",
                                                            type: "GET",
                                                            data: {
                                                                nisn: nisn,
                                                                nik: nik,
                                                                token: token,
                                                                tipe: tipe,
                                                                pesan: pesan,
                                                                code: code
                                                            },
                                                            beforeSend: function() {
                                                                $("#modal_kirim")
                                                                    .prop("disabled", true)
                                                                    .text("Mengirim...");
                                                            },
                                                            success: function(res) {
                                                                console.log(res);
                                                                alert("Notifikasi berhasil.");
                                                                $("#modal_kirim")
                                                                    .prop("disabled", false)
                                                                    .text("Kirim Notifikasi");
                                                                kosongkanmodal();
                                                            },
                                                            error: function() {
                                                                alert("Gagal mengirim notifikasi.");
                                                                $("#modal_kirim")
                                                                    .prop("disabled", false)
                                                                    .text("Kirim Notifikasi");
                                                            }
                                                        });

                                                    }
                                                    $('#modalStatus').on('show.bs.modal', function(event) {
                                                        var button = $(event.relatedTarget);
                                                        var token = button.data('token');
                                                        var name = button.data('name');
                                                        var point = button.data('point');
                                                        var status = button.data('status');
                                                        var nisn = button.data('nisn');
                                                        var nik = button.data('nik');
                                                        var tipe = button.data('tipe');
                                                        var code = button.data('code');

                                                        $('#modal_nisn').val(nisn);
                                                        $('#modal_nik').val(nik);
                                                        $('#modal_token').val(token);
                                                        $('#modal_tipe').val(tipe);
                                                        $('#modal_code').val(code);

                                                        $('#penerima').text(name);
                                                        $('#modal_point').text(point);

                                                        $('#modal_pesan').val(
                                                            "Yth. " + name +
                                                            ", total point pelanggaran siswa/i saat ini adalah " +
                                                            point +
                                                            " point.\n\nStatus : " +
                                                            status
                                                        );
                                                        $('#modal_pesan').focus();
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    <?php } ?>
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