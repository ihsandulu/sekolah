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
                        <?php if (isset($_GET["laporan"]) && $_GET["laporan"] == "OK") { ?>

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
                                    <div class="box">
                                        <div id="collapse4" class="body table-responsive">
                                            <table id="dataTable" class="table table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <?php if (isset($_GET["laporan"]) && $_GET["laporan"] == "OK") { ?>
                                                            <th class="col-md-1">Action</th>
                                                        <?php } ?>
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
                                                    if ($this->session->userdata("sekolah_id") > 0) {
                                                        $this->db->where("pelanggaran.sekolah_id", $this->session->userdata("sekolah_id"));
                                                    }
                                                    $usr = $this->db
                                                        ->join("user", "user.user_nisn=pelanggaran.user_nisn", "left")
                                                        ->join("kelas", "kelas.kelas_id=user.kelas_id", "left")
                                                        ->join("sekolah", "sekolah.sekolah_id=pelanggaran.sekolah_id", "left")
                                                        ->join("mpelanggaran", "mpelanggaran.mpelanggaran_id=pelanggaran.mpelanggaran_id", "left")
                                                        ->get("pelanggaran");
                                                    //echo $this->db->last_query();
                                                    foreach ($usr->result() as $pelanggaran) { ?>
                                                        <tr>
                                                            <?php if (isset($_GET["laporan"]) && $_GET["laporan"] == "OK") { ?>
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