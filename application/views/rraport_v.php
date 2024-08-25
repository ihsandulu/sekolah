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
        .mt-5{margin-top: 20px!important;}
        .mb-5{margin-bottom: 50px!important;}
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
                                <label for="kelas_id">Class:</label>
                                <select onchange="listsiswasekolah();" name="kelas_id" id="kelas_id" class="form-control" onChange="cari_user(this.value)">
                                    <option value="0" <?= ($kelas_id == 0) ? 'selected="selected"' : ""; ?>>All</option>
                                    <?php
                                    if ($this->session->userdata("sekolah_id") > 0) {
                                        $this->db->where("kelas.sekolah_id", $this->session->userdata("sekolah_id"));
                                    }
                                    $gru = $this->db
                                        ->join("kelas", "kelas.kelas_id=kelas_sekolah.kelas_id", "left")
                                        ->group_by("kelas_sekolah.kelas_id")
                                        ->get("kelas_sekolah");
                                    foreach ($gru->result() as $kelas) { ?>
                                        <option value="<?= $kelas->kelas_id; ?>" <?= ($kelas_id == $kelas->kelas_id) ? 'selected="selected"' : ""; ?>><?= $kelas->kelas_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <script>
                                function listsiswasekolah() {
                                    let kelas_id = $("#kelas_id").val();
                                    // alert(kelas_id);
                                    $.get("<?= base_url("api/listsiswakelas"); ?>", {
                                            user_id: '<?= $user_id; ?>',
                                            kelas_id: kelas_id
                                        })
                                        .done(function(data) {
                                            $("#user_id").html(data);
                                        });
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
                                <input type="date" name="sekolah_raportdate" id="sekolah_raportdate" class="form-control" value="<?=$sekolah_raportdate;?>">
                            </div>
                            <button name="change" value="OK" type="submit" class="btn btn-default">Submit</button>
                            <script>
                            <?php if(isset($_POST["change"])){?>
                                $(document).ready(function(){
                                    showToast("Report Date Changed!");
                                });
                                <?php }?>
                            </script>
                        </form>
                    </div>
                </div>
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
                        if (isset($_GET["user_id"])) {
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
                                ->get("user");
                            // echo $this->db->last_query();
                            foreach ($tdetail->result() as $user) {
                        ?>
                                <tr>
                                    <td>
                                        <div class="col-md-12">
                                            <a target="_blank" href="<?= base_url("rraportd?user_id=" . $user->user_id); ?>" type="button" onClick="raport()" class="btn btn-warning">Raport</a>
                                        </div>
                                    </td>
                                    <td><?= $user->sekolah_name; ?></td>
                                    <td><?= $user->kelas_name; ?></td>
                                    <td><?= $user->user_name; ?></td>

                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>

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