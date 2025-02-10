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
                        <span style="color:blue ;">Whatsapp Tagihan Pelunasan</span>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12" style="padding:50px;">
                        <div class="col-md-12" style="padding:50px;">
                            <form method="post" class="" action="">
                                <style>
                                    .toggle-container {
                                        display: flex;
                                        align-items: center;
                                        font-family: Arial, sans-serif;
                                        font-size: 16px;
                                    }

                                    .switch {
                                        position: relative;
                                        display: inline-block;
                                        width: 60px;
                                        height: 34px;
                                        margin: 0 10px;
                                    }

                                    .switch input {
                                        opacity: 0;
                                        width: 0;
                                        height: 0;
                                    }

                                    .slider {
                                        position: absolute;
                                        cursor: pointer;
                                        top: 0;
                                        left: 0;
                                        right: 0;
                                        bottom: 0;
                                        background-color: red;
                                        transition: 0.4s;
                                        border-radius: 34px;
                                    }

                                    .slider:before {
                                        position: absolute;
                                        content: "";
                                        height: 26px;
                                        width: 26px;
                                        left: 4px;
                                        bottom: 4px;
                                        background-color: white;
                                        transition: 0.4s;
                                        border-radius: 50%;
                                    }

                                    input:checked+.slider {
                                        background-color: green;
                                    }

                                    input:checked+.slider:before {
                                        transform: translateX(26px);
                                    }
                                </style>

                                <div class="toggle-container">
                                    <label class="switch">
                                        <input type="checkbox" id="toggleSwitch">
                                        <span class="slider"></span>
                                    </label>
                                    <span id="toggleLabel">Tidak Aktif</span>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        // Cek status awal berdasarkan PHP
                                        <?php 
                                        $timewa=$this->db->get("timewa");
                                        $aktif=0;
                                        foreach($timewa->result() as $timewa){
                                            $aktif=$timewa->timewa_status;
                                        }
                                        if ($aktif) { ?>
                                            $("#toggleSwitch").prop("checked", true);
                                            $("#toggleLabel").text("Aktif");
                                        <?php } else { ?>
                                            $("#toggleSwitch").prop("checked", false);
                                            $("#toggleLabel").text("Tidak Aktif");
                                        <?php } ?>

                                        // Ubah teks saat toggle digeser
                                        $("#toggleSwitch").change(function() {
                                            if($(this).is(":checked")){
                                                $("#toggleLabel").text("Aktif");
                                                $.get("<?= base_url("api/statusblast"); ?>", {
                                                    status: 1
                                                });
                                            }else{
                                                $("#toggleLabel").text("Tidak Aktif");
                                                $.get("<?= base_url("api/statusblast"); ?>", {
                                                    status: 0
                                                });
                                            }
                                        });
                                    });
                                </script>

                                <br />
                                <div class="form-group">
                                    <label for="timewa_time">Jam Dijalankan:</label>
                                    <input autofocus type="time" class="form-control" id="timewa_time" name="timewa_time" value="<?= $timewa_time; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="timewa_day">Berapa Hari Sekali:</label>
                                    <input type="number" class="form-control" id="timewa_day" name="timewa_day" value="<?= $timewa_day; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="timewa_message">Isi Pesan:</label>
                                    <input type="text" class="form-control" id="timewa_message" name="timewa_message" value="<?= $timewa_message; ?>">
                                    <span style="color:red; font-style:italic;">#siswa= nama siswa. #nominal = nominal tagihan.</span>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="sekolah_id" name="sekolah_id" value="<?= $this->session->userdata("sekolah_id"); ?>">
                                    <input type="hidden" class="form-control" id="timewa_id" name="timewa_id" value="<?= $timewa_id; ?>">
                                </div>
                                <button type="submit" name="change" value="OK" class="btn btn-default">Submit</button>
                            </form>
                            <div id="statuswa" align="center" style="font-size:30px; margin-top:15px;" class="alert alert-block alert-warning row"></div>
                        </div>
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
                <h4><strong><i class="fa fa-users" style="color:#0000CC;"></i> :. Log pesan <?= date("d M Y"); ?></strong></h4>
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
                            <div id="tablepelunasanwa" class="panel-body" style="padding-bottom:40px;">



                            </div>
                            <script>
                                function refreshwa() {
                                    $.get("<?= base_url("api/tablepelunasanwa"); ?>")
                                        .done(function(data) {
                                            $("#tablepelunasanwa").html(data);
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
                                    // alert("<?= base_url("api/tagihpelunasan"); ?>?filter=0");
                                    $.get("<?= base_url("api/tagihpelunasan"); ?>", {
                                            filter: 0
                                        })
                                        .done(function(data) {
                                            let notel = 1;
                                            const tetap = 2;
                                            $.each(data, function(key, value) {
                                                // alert(value.message+','+value.number+','+value.server+','+value.nominal);
                                                if (notel < 4) {
                                                    if (value.user_id > 0) {
                                                        setTimeout(function() {
                                                            dikirimpesan(value.message, value.number, value.server, value.nominal, value.user_id);
                                                        }, <?= rand(10000, 15000); ?>);
                                                        notel++;
                                                    }
                                                } else {
                                                    setTimeout(function() {
                                                        if (value.user_id > 0) {
                                                            dikirimpesan(value.message, value.number, value.server, value.nominal, value.user_id);
                                                            notel = 1;
                                                        }
                                                    }, <?= rand(15000, 18000); ?>);
                                                }
                                            });
                                        });
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