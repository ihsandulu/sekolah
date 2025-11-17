<!doctype html>
<html>

<head>
    <?php
    require_once("meta.php"); ?>

    <?php
    $jam_absen = $this->db->where("sekolah_id", $this->session->userdata("sekolah_id"))->get("jamabsen");
    // echo $this->db->last_query();
    $arjam = array();
    foreach ($jam_absen->result() as $usr) {
        $arjam[$usr->jamabsen_id]["masuk"] = $usr->jamabsen_masuk;
        $arjam[$usr->jamabsen_id]["pulang"] = $usr->jamabsen_pulang;
        $arjam[$usr->jamabsen_id]["name"] = $usr->jamabsen_name;
    }
    ?>
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
                    <li class="active">Class</li>
                </ul><!-- /.breadcrumb -->


            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>Jam Absen</h1>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="alert alert-info alert-dismissable" id="status">
                                </div>
                                <div class="page-header  mb-5">
                                    <div>

                                        <form class="form-inline" method="post">
                                            <?php
                                            if (isset($_GET["jamabsen_name"]) && $_GET["jamabsen_name"] != "") {
                                                $jamabsen_name = $_GET["jamabsen_name"];
                                            } else {
                                                $jamabsen_name = "";
                                            }
                                            if (isset($_GET["jamabsen_masuk"]) && $_GET["jamabsen_masuk"] != "") {
                                                $jamabsen_masuk = $_GET["jamabsen_masuk"];
                                            } else {
                                                $jamabsen_masuk = null;
                                            }
                                            if (isset($_GET["jamabsen_pulang"]) && $_GET["jamabsen_pulang"] != "") {
                                                $jamabsen_pulang = $_GET["jamabsen_pulang"];
                                            } else {
                                                $jamabsen_pulang = null;
                                            }
                                            ?>
                                            <div class="form-group">
                                                <label for="jamabsen_name">Nama Jam:</label>
                                                <input type="text" name="jamabsen_name" id="jamabsen_name" class="form-control" value="<?= $jamabsen_name; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="jamabsen_masuk">Masuk:</label>
                                                <input type="time" name="jamabsen_masuk" id="jamabsen_masuk" class="form-control" value="<?= $jamabsen_masuk; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="jamabsen_pulang">Pulang:</label>
                                                <input type="time" name="jamabsen_pulang" id="jamabsen_pulang" class="form-control" value="<?= $jamabsen_pulang; ?>">
                                            </div>
                                            <input type="hidden" name="sekolah_id" value="<?= $this->session->userdata("sekolah_id"); ?>" />
                                            <button type="submit" name="create" value="OK" class="btn btn-default">Submit</button>
                                        </form>
                                        <?php foreach ($arjam as $a => $b) { ?>
                                            <form class="form-inline" method="post" style="float: left; margin-right:20px;">
                                                <button type="submit" name="delete" value="OK" class="fa fa-times btn btn-xs btn-danger"></button>
                                                <label class="label label-success">Nama Jam = "<?= $b["name"]; ?>", Masuk = <?= $b["masuk"]; ?>, Pulang = <?= $b["pulang"]; ?></label>
                                                <input type="hidden" name="jamabsen_id" value="<?= $a; ?>" />
                                            </form>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php //print_r($arjam); ?>
                                <div class="box">
                                    <div id="collapse4" class="body table-responsive">
                                        <table id="dt1" class="table table-condensed table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Kelas</th>
                                                    <th>Jam</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($this->session->userdata("sekolah_id") > 0) {
                                                    $this->db->where("kelas.sekolah_id", $this->session->userdata("sekolah_id"));
                                                }
                                                $usr = $this->db
                                                    ->select("kelas.kelas_id as kelas_id, kelas.kelas_name as kelas_name, jamkelas.jamabsen_id, jamkelas.jamkelas_id")
                                                    ->join("jamkelas", "kelas.kelas_id=jamkelas.kelas_id", "left")
                                                    ->order_by("kelas.kelas_name", "asc")
                                                    ->get("kelas");
                                                // echo $this->db->last_query();
                                                foreach ($usr->result() as $kelas) { ?>
                                                    <tr>
                                                        <td><?= $kelas->kelas_name; ?></td>
                                                        <td>
                                                            <select id="jamabsen<?= $kelas->kelas_id; ?>" onchange="rubah('<?= $kelas->kelas_id; ?>','<?= $kelas->jamkelas_id; ?>')">
                                                                    <option value="0" <?= ($a == '0') ? "selected" : ""; ?>>Pilih Jam</option> ?>
                                                                <?php foreach ($arjam as $a => $b) { ?>
                                                                    <option value="<?= $a; ?>" <?= ($a == $kelas->jamabsen_id) ? "selected" : ""; ?>><?= $b["name"]; ?></option> ?>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#wrap -->
    <?php require_once("footer.php"); ?>
    <script>
        $(document).ready(function() {
            $("#status").hide();
            $('#dt1').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'pdf',
                        className: 'btn-danger text-white',
                        exportOptions: {
                            columns: ':not(:first-child)'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-warning text-white',
                        exportOptions: {
                            columns: ':not(:first-child)'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn-success text-white',
                        exportOptions: {
                            columns: ':not(:first-child)'
                        }
                    }
                ],
                "order": [], // tidak mengatur ascending/descending
                "iDisplayLength": -1 // menampilkan semua row
            });
        });

        function rubah(kelas_id, jamkelas_id) {
            let jamabsen_id = $("#jamabsen" + kelas_id).val();
            // alert("<?= base_url('api/rubahjam'); ?>?kelas_id=" + kelas_id + "&jamabsen_id=" + jamabsen_id + "&jamkelas_id=" + jamkelas_id);
            $.get("<?= base_url('api/rubahjam'); ?>", {
                    kelas_id: kelas_id,
                    jamabsen_id: jamabsen_id,
                    jamkelas_id: jamkelas_id
                })
                .done(function(data) {
                    // tampilkan status
                    $("#status").html(data).show();

                    // hilangkan setelah 3 detik
                    setTimeout(function() {
                        $("#status").fadeOut('fast'); // bisa diganti .html('') jika tidak ingin animasi
                    }, 1000);
                });
        }
    </script>
</body>

</html>