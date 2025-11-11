<!doctype html>
<html>

<head>
    <?php
    require_once("meta.php"); ?>
    <style>
        .pelunasanwasi {
            border-radius: 5px;
            border: #FFCCCC solid 3px !important;
            background-color: #EDE2EF !important;
            color: #000 !important;
            padding: 10px;
            text-align: center;
            height: 100px;
        }

        .pelunasanwasi:hover {
            border: #FFCCCC solid 3px !important;
            background-color: #BB93C8 !important;
            color: #000 !important;
            text-decoration: none;
        }

        .upelunasanwasi {
            border-radius: 5px;
            border: #EBEBEB solid 3px !important;
            background-color: #CCCCCC !important;
            color: #000 !important;
            padding: 10px;
            text-align: center;
            height: 100px;
        }

        .uwpelunasanwasi {
            border-radius: 5px;
            border: #EBEBEB solid 3px !important;
            background-color: #CCCCCC !important;
            color: #000 !important;
            padding: 10px;
            text-align: center;
        }

        .upelunasanwasi:hover {
            border: #EBEBEB solid 3px !important;
            background-color: #666666 !important;
            color: #FFF !important;
            text-decoration: none;
        }

        .pelunasanwasiisi {
            font-size: 18px;
            font-weight: bold;
            text-shadow: white 1px 1px;
            text-decoration: none;
            position: relative;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .wpelunasanwasiisi {
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
    </style>
</head>

<body class="no-skin">
    <?php
    require_once("header.php");
    ?>
    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="<?= site_url(); ?>">Home</a>
                    </li>
                    <li class="active">Attendance</li>
                </ul><!-- /.breadcrumb -->


            </div>
            <div class="page-content">

                <div class="page-header">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="font-size:18px; font-weight:bold;">
                        <span style="color:blue ;">Data Ketidakhadiran</span>
                    </div>
                </div>

                <div class="alert alert-block alert-success row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-block btn-success" onclick="kirimsekarang()">
                            Kirim Pesan Sekarang!
                        </button>
                    </div>
                </div>
                <hr />
                <h4><strong><i class="fa fa-users" style="color:#0000CC;"></i> :. Data Ketidak Hadiran <?= date("d M Y"); ?></strong></h4>
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
                            <div id="tabletidakhadir" class="panel-body" style="padding-bottom:40px;">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Pilih</th>
                                            <th>Sekolah</th>
                                            <th>Kelas</th>
                                            <th>NISN</th>
                                            <th>Siswa</th>
                                            <th>Telpon</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //masukin data tidak hadir
                                        $absen = $this->db
                                            ->where("absen_date", date("Y-m-d"))
                                            ->order_by("user_id", "ASC")
                                            ->get("absen");
                                        $userid = array();
                                        foreach ($absen->result() as $absen) {
                                            $userid[] = $absen->user_id;
                                        }
                                        $userid1 = implode(",", $userid);
                                        $userid2 = explode(",", $userid1);
                                        $user = $this->db
                                            ->select("*,user.user_id AS user_id")
                                            ->join("sekolah", "sekolah.sekolah_id=user.sekolah_id", "left")
                                            ->join("kelas", "kelas.kelas_id=user.kelas_id", "left")
                                            ->join("telpon", "telpon.user_id=user.user_id", "left")
                                            ->where_not_in("user.user_id", $userid2)
                                            ->where("telpon.user_id IS NOT NULL", null)
                                            ->where("telpon.telpon_type", "1")
                                            ->order_by("user.kelas_id", "ASC")
                                            ->order_by("user_name", "ASC")
                                            ->get("user");
                                        // echo $this->db->last_query();die;
                                        foreach ($user->result() as $user) {
                                            $message = "Siswa " . $user->user_name . " tidak hadir di sekolah pada tgl " . date("Y-m-d");
                                            $input["telpon_number"] = $user->telpon_number;
                                            $input["sekolah_id"] = $user->sekolah_id;
                                            $input["user_id"] = $user->user_id;
                                            $input["kelas_id"] = $user->kelas_id;
                                            $input["tidakhadir_date"] = date("Y-m-d");
                                            $cektidakhadir = $this->db->get_where("tidakhadir", array("user_id" => $user->user_id, "tidakhadir_date" => date("Y-m-d")));
                                            // echo $this->db->last_query();die;
                                            if ($cektidakhadir->num_rows() == 0) {
                                                $this->db->insert("tidakhadir", $input);
                                            }
                                        }

                                        //ambil data tidak hadir
                                        $absen = $this->db
                                            ->join("sekolah", "sekolah.sekolah_id=tidakhadir.sekolah_id", "left")
                                            ->join("kelas", "kelas.kelas_id=tidakhadir.kelas_id", "left")
                                            ->join("user", "user.user_id=tidakhadir.user_id", "left")
                                            ->join("telpon", "telpon.user_id=user.user_id", "left")
                                            ->where("tidakhadir_date", date("Y-m-d"))
                                            ->order_by("kelas.kelas_name", "ASC")
                                            ->order_by("user.user_name", "ASC")
                                            ->get("tidakhadir");

                                        foreach ($absen->result() as $absen) {
                                            $status = array("0" => "", "1" => "Dipilih", "2" => "Terkirim");
                                            if ($absen->tidakhadir_status == 1) {
                                                $cheked = "checked";
                                            } else {
                                                $cheked = "";
                                            }
                                        ?>
                                            <tr>
                                                <td><input id="cek<?= $absen->tidakhadir_id; ?>" <?= $cheked; ?> onclick="isiid(<?= $absen->tidakhadir_id; ?>)" type="checkbox" /></td>
                                                <td><?= $absen->sekolah_name; ?></td>
                                                <td><?= $absen->kelas_name; ?></td>
                                                <td><?= $absen->user_nisn; ?></td>
                                                <td><?= $absen->user_name; ?></td>
                                                <td><?= $absen->telpon_number; ?></td>
                                                <td id="status<?= $absen->tidakhadir_id; ?>"><?= $status[$absen->tidakhadir_status]; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <script>
                                    function isiid(id) {
                                        let cek = $("#cek" + id).prop("checked") ? 1 : 0;
                                        $.get("<?= base_url("api/isiid"); ?>", {
                                            id: id,
                                            cek: cek
                                        }).done(function(data) {
                                            if (cek == 1) {
                                                $("#status" + id).html("Dipilih");
                                            } else {
                                                $("#status" + id).html("");
                                            }
                                        });
                                    }
                                </script>

                            </div>
                            <script>
                                function refreshwa() {
                                    $.get("<?= base_url("api/tabletidakhadir"); ?>")
                                        .done(function(data) {
                                            $("#tabletidakhadir").html(data);
                                        });
                                }
                                setInterval(() => {
                                    refreshwa();
                                }, 15000);
                                refreshwa();
                            </script>
                            <script>
                                //kirim sekarang
                                function kirimsekarang() {
                                    // alert("<?= base_url("api/kirimnotiftidakhadir"); ?>?filter=0");
                                    $.get("<?= base_url("api/kirimnotiftidakhadir"); ?>", {
                                            filter: 0
                                        })
                                        .done(function(data) {
                                            let notel = 1;
                                            const tetap = 2;
                                            $("#loading").show();
                                            let totalPesan = data.length;
                                            let pesanSelesai = 0;
                                            $.each(data, function(key, value) {
                                                // alert(value.message+','+value.number+','+value.server+','+value.email+','+value.password);
                                                if (notel == 1) {
                                                    kirimpesantidakhadir(value.message, value.number, value.server, value.email, value.password, value.tidakhadir_id);
                                                    notel++;
                                                } else if (notel < 4) {
                                                    setTimeout(function() {
                                                        kirimpesantidakhadir(value.message, value.number, value.server, value.email, value.password, value.tidakhadir_id);
                                                    }, <?= rand(10000, 15000); ?>);
                                                    notel++;
                                                } else {
                                                    setTimeout(function() {
                                                        kirimpesantidakhadir(value.message, value.number, value.server, value.email, value.password, value.tidakhadir_id);
                                                        notel = 1;
                                                    }, <?= rand(15000, 18000); ?>);
                                                }
                                                pesanSelesai++;
                                                if (pesanSelesai === totalPesan) {
                                                    $("#loading").hide();
                                                }
                                            });
                                        });
                                }

                                function updatesiswatidakhadir(tidakhadir_id) {
                                    // alert(tidakhadir_id);
                                    $.get("<?= base_url("api/updatesiswatidakhadir"); ?>", {
                                        tidakhadir_id: tidakhadir_id
                                    }).done(function(data) {
                                        $("#status" + tidakhadir_id).html("Terkirim"); // alert(data);
                                    });
                                }

                                function kirimpesantidakhadir(message, number, server, email, password, tidakhadir_id) {
                                    let pesankirim = '';
                                    setTimeout(() => {
                                        alert("https://qithy.my.id/api/token?email="+email+"&password="+password);
                                        $.get("https://qithy.my.id/api/token", {
                                                email: email,
                                                password: password
                                            })
                                            .done(function(data) {
                                                let token = data.token;
                                                alert("https://qithy.my.id:8000/send-message?email="+email+"&token="+token+"&message="+message+"&number="+number+"&id="+server);
                                                $.get("https://qithy.my.id:8000/send-message", {
                                                        email: email,
                                                        'token': token,
                                                        message: message,
                                                        number: number,
                                                        id: server
                                                    })
                                                    .done(function(data) {
                                                        pesankirim = "Pesan terkirim pada ".number;
                                                        // alert(pesankirim);
                                                    });
                                            });

                                        updatesiswatidakhadir(tidakhadir_id);
                                        return pesankirim;
                                    }, 1000);

                                }
                            </script>
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