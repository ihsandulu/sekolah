<!doctype html>
<html>

<head>
    <?php
    require_once("meta.php");
    $status = array("1" => "Masuk", "Sakit", "Izin", "Alpha");
    if (isset($_GET['user_date'])) {
        $user_date = $_GET['user_date'];
    } else {
        $user_date = date("Y-m-d");
    }
    if (isset($_GET['kelas_id'])) {
        $kelas_id = $_GET['kelas_id'];
    } else {
        $kelas_id = 0;
    }
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
    } else {
        $user_id = 0;
    }
    ?>
    <style>
        .user {
            border-radius: 5px;
            border: #FFCCCC solid 3px !important;
            background-color: #EDE2EF !important;
            color: #000 !important;
            padding: 10px;
            text-align: center;
            height: 100px;
        }

        .user:hover {
            border: #FFCCCC solid 3px !important;
            background-color: #BB93C8 !important;
            color: #000 !important;
            text-decoration: none;
        }

        .uuser {
            border-radius: 5px;
            border: #EBEBEB solid 3px !important;
            background-color: #CCCCCC !important;
            color: #000 !important;
            padding: 10px;
            text-align: center;
            height: 100px;
        }

        .uwuser {
            border-radius: 5px;
            border: #EBEBEB solid 3px !important;
            background-color: #CCCCCC !important;
            color: #000 !important;
            padding: 10px;
            text-align: center;
        }

        .uuser:hover {
            border: #EBEBEB solid 3px !important;
            background-color: #666666 !important;
            color: #FFF !important;
            text-decoration: none;
        }

        .userisi {
            font-size: 18px;
            font-weight: bold;
            text-shadow: white 1px 1px;
            text-decoration: none;
            position: relative;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .wuserisi {
            font-size: 18px;
            font-weight: bold;
            text-shadow: white 1px 1px;
            text-decoration: none;
            position: relative;
        }

        .action {
            position: absolute;
            left: -0px;
            bottom: 0px;
            height: 35%;
            /*text-align:right;*/
        }

        .displaynone {
            display: none;
        }

        .displayinline {
            display: inline;
        }

        .mt-5 {
            margin-top: 20px !important;
        }

        .mb-5 {
            margin-bottom: 50px !important;
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
                    <li class="active">Raport</li>
                </ul><!-- /.breadcrumb -->


            </div>
            <div class="page-content">

                <div class="page-header  mb-5">

                    <div>
                        <form class="form-inline col-md-6">
                            <div class="form-group">
                                <label for="nilai_semester">Semester:</label>
                                <?php
                                if (isset($_GET["nilai_semester"])) {
                                    $nilai_semester = $this->input->get("nilai_semester");
                                } else {
                                    $nilai_semester = 0;
                                }
                                ?>
                                <select name="nilai_semester" id="nilai_semester" class="form-control">
                                    <option value="0" <?= ($nilai_semester == 0) ? 'selected="selected"' : ""; ?>>Choose Semester</option>
                                    <option value="1" <?= ($nilai_semester == 1) ? 'selected="selected"' : ""; ?>>Semester 1</option>
                                    <option value="2" <?= ($nilai_semester == 2) ? 'selected="selected"' : ""; ?>>Semester 2</option>
                                </select>
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
                        <form method="post" class="form-inline  col-md-6">

                            <div class="form-group">
                                <label for="sekolah_raportdate">Raport Date:</label>
                                <input type="date" name="sekolah_raportdate" id="sekolah_raportdate" class="form-control" value="<?= $sekolah_raportdate; ?>">
                            </div>
                            <button name="change" value="OK" type="submit" class="btn btn-default">Submit</button>
                            <script>
                                <?php if (isset($_POST["change"])) { ?>
                                    $(document).ready(function() {
                                        showToast("Report Date Changed!");
                                    });
                                <?php } ?>
                            </script>
                        </form>
                    </div>
                </div>
                <?php
                if (isset($_GET["kelas_id"]) && $_GET["kelas_id"] > 0) {
                ?>
                    <table id="dataTable" class="table table-hovered table-condensed">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>School</th>
                                <th>Class</th>
                                <th>Student</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($this->session->userdata("sekolah_id") > 0) {
                                $this->db->where("user.sekolah_id", $this->session->userdata("sekolah_id"));
                            }
                            if (isset($_GET['kelas_id']) && $_GET['kelas_id'] > 0) {
                                $this->db->where("kelas.kelas_id", $kelas_id);
                            }
                            if (isset($_GET['user_id']) && $_GET['user_id'] > 0) {
                                $this->db->where("user.user_id", $_GET['user_id']);
                            }
                            $tdetail = $this->db
                                ->select("sekolah.sekolah_name, kelas.kelas_name, user.user_name, user.user_id")
                                ->join("kelas", "kelas.kelas_id=user.kelas_id", "left")
                                ->join("sekolah", "sekolah.sekolah_id=user.sekolah_id", "left")
                                ->where("user.position_id", "4")
                                ->group_by("user.user_id")
                                ->order_by("kelas_name","ASC")
                                ->order_by("user_name","ASC")
                                ->get("user");
                            // echo $this->db->last_query();
                            foreach ($tdetail->result() as $user) {
                            ?>
                                <tr>
                                    <td>
                                        <div class="col-md-12">
                                            <a target="_blank" href="<?= base_url("rraportd?user_id=" . $user->user_id."&nilai_semester=".$nilai_semester); ?>" type="button" onClick="raport()" class="btn btn-warning">Raport</a>
                                        </div>
                                    </td>
                                    <td><?= $user->sekolah_name; ?></td>
                                    <td><?= $user->kelas_name; ?></td>
                                    <td><?= $user->user_name; ?></td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <div class="tengah">
                        <h1><b>Choose Class First!</b></h1>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
    <!-- /#wrap -->
    <?php require_once("footer.php"); ?>
    <script>
        function cari_user(a) {
            $.get("<?= site_url("api/cari_user"); ?>", {
                    kelas_id: a,
                    user_id: '0'
                })
                .done(function(data) {
                    $("#user_id").html(data);
                });
        }
    </script>

</body>

</html>