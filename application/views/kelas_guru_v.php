<!doctype html>
<html>

<head>
    <?php
    require_once("meta.php"); ?>
    <script>
        function isi_kelas_sekolah_guru() {
            $.get("<?= site_url("api/isi_kelas_sekolah_guru"); ?>", {
                    sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>',
                    user_id: '<?= $user_id; ?>'
                })
                .done(function(data) {
                    $("#kelas_sekolah_id").html(data);
                });
        }

        function isi_kelas_guru() {
            $.get("<?= site_url("api/isi_kelas_guru"); ?>", {
                    sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>',
                    user_id: '<?= $user_id; ?>'
                })
                .done(function(data) {
                    $("#kelas_guru_id").html(data);
                });
        }

        function inputkelasguru() {
            $.get("<?= site_url("api/inputkelasguru"); ?>", {
                    sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>',
                    kelas_id: $("#kelas_sekolah_id").val(),
                    user_id: '<?= $user_id; ?>'
                })
                .done(function(data) {
                    isi_kelas_sekolah_guru();
                    isi_kelas_guru();
                });
        }

        function deletekelasguru() {
            $.get("<?= site_url("api/deletekelasguru"); ?>", {
                    sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>',
                    kelas_guru_id: $("#kelas_guru_id").val()
                })
                .done(function(data) {
                    isi_kelas_sekolah_guru();
                    isi_kelas_guru();
                });
        }
    </script>

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
                    <li class="active">Teacher Class</li>
                </ul><!-- /.breadcrumb -->


            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>
                        Teacher Class : <?= $user_name; ?>
                    </h1>

                    <form method="post" class="col-md-2" style="margin-top:-30px; float:right;">

                        <a type="button" href="<?= site_url("guru"); ?>" class="btn btn-warning btn-block btn-sm fa fa-mail-reply"> Back</a>

                    </form>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">

                        <div class="box">
                            <div id="collapse4" class="body table-responsive">

                                <div class="col-md-12">
                                    <div class="panel panel-info" style="">
                                        <div class="panel-heading">
                                            <span style="font-size:20px; font-weight:bold;">Class</span>
                                            (Press CTRL to select more than one)
                                        </div>
                                        <?php
                                        $kel = $this->db
                                        ->select("kelas_sekolah.kelas_id as kelas_id, kelas_sekolah.sekolah_id as sekolah_id, kelas.*")
                                            ->join("kelas", "kelas.kelas_id=kelas_sekolah.kelas_id", "left")
                                            ->join("kelas_guru", "kelas_guru.kelas_id=kelas_sekolah.kelas_id", "left")
                                            ->where("kelas_sekolah.sekolah_id", $this->session->userdata("sekolah_id"))
                                            ->where("kelas_guru.sekolah_id", NULL)
                                            ->get("kelas_sekolah");
                                        $a = $this->db->last_query();
                                        // echo $a; ?>
                                        <div class="panel-body">
                                            <div class="col-md-5">
                                                <select id="kelas_sekolah_id" name="kelas_sekolah_id" multiple class="form-control" style="height:350px;">
                                                    <?php
                                                    foreach ($kel->result() as $kelas) {
                                                        $kelasguru = $this->db
                                                            ->where("user_id", $user_id)
                                                            ->where("kelas_id", $kelas->kelas_id)
                                                            ->where("sekolah_id", $this->session->userdata("sekolah_id"))
                                                            ->get("kelas_guru")->num_rows();
                                                        if ($kelasguru == 0) {
                                                    ?>
                                                            <option value="<?= $kelas->kelas_id; ?>"><?= $kelas->kelas_name; ?></option>
                                                    <?php }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2" style="height:350px;" align="center">
                                                <div style="position:relative; left:50%; top:50%; transform:translate(-50%,-50%);">
                                                    <div class="col-md-12 ">
                                                        <button type="button" onClick="inputkelasguru()" class="btn btn-success fa fa-arrow-right"></button>
                                                    </div>
                                                    <br />
                                                    <br />
                                                    <br />
                                                    <br />
                                                    <div class="col-md-12 ">
                                                        <button type="button" onClick="deletekelasguru()" class="btn btn-warning fa fa-arrow-left"></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <select id="kelas_guru_id" name="kelas_guru_id" multiple class="form-control" style="height:350px;">
                                                    <?php $kela = $this->db
                                                        ->join("kelas", "kelas.kelas_id=kelas_guru.kelas_id", "left")
                                                        ->where("kelas_guru.user_id", $this->input->get("user_id"))
                                                        ->get("kelas_guru");
                                                    $a = $this->db->last_query();
                                                    foreach ($kela->result() as $kelasguru) {
                                                    ?>
                                                        <option value="<?= $kelasguru->kelas_guru_id; ?>"><?= $kelasguru->kelas_name; ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
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
</body>

</html>