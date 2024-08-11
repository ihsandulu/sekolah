<!doctype html>
<html>

<head>
    <?php
    require_once("meta.php"); ?>
    <script>
        function isi_grup_id_guru() {
            $.get("<?= site_url("api/isi_grup_id_guru"); ?>", {
                    sekolah_id: '<?= $sekolah_id; ?>',
                    user_id: '<?= $user_id; ?>'
                })
                .done(function(data) {
                    $("#grup_id").html(data);
                });
        }

        function isi_grup_guru() {
            $.get("<?= site_url("api/isi_grup_guru"); ?>", {
                    sekolah_id: '<?= $sekolah_id; ?>',
                    user_id: '<?= $user_id; ?>'
                })
                .done(function(data) {
                    $("#grup_guru_id").html(data);
                });
        }

        function inputgrupguru() {
            $.get("<?= site_url("api/inputgrupguru"); ?>", {
                    sekolah_id: '<?= $sekolah_id; ?>',
                    grup_id: $("#grup_id").val(),
                    user_id: '<?= $user_id; ?>'
                })
                .done(function(data) {
                    isi_grup_id_guru();
                    isi_grup_guru();
                });
        }

        function deletegrupguru() {
            $.get("<?= site_url("api/deletegrupguru"); ?>", {
                    sekolah_id: '<?= $sekolah_id; ?>',
                    grup_guru_id: $("#grup_guru_id").val()
                })
                .done(function(data) {
                    isi_grup_id_guru();
                    isi_grup_guru();
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
                    <li class="active">Teacher Group</li>
                </ul><!-- /.breadcrumb -->


            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>
                        Teacher Group: <?= $user_name; ?>
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
                                            <span style="font-size:20px; font-weight:bold;">Group</span>
                                            (Press CTRL to select more than one)
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-5">
                                            <?php $gru = $this->db
                                                        ->join("kelas_guru", "kelas_guru.kelas_id=grup.kelas_id", "inner")
                                                        ->where("grup.sekolah_id", $sekolah_id)
                                                        ->where("kelas_guru.user_id", $user_id)
                                                        ->get("grup");
                                                    // echo $this->db->last_query();
                                                    ?>
                                                <select id="grup_id" name="grup_id" multiple class="form-control" style="height:350px;">
                                                    <?php
                                                    foreach ($gru->result() as $grup) {
                                                        $gurugrup = $this->db
                                                            ->where("user_id", $user_id)
                                                            ->where("grup_id", $grup->grup_id)
                                                            ->where("sekolah_id", $sekolah_id)
                                                            ->get("grup_guru")->num_rows();
                                                        if ($gurugrup == 0) {
                                                    ?>
                                                            <option value="<?= $grup->grup_id; ?>"><?= $grup->grup_name; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2" style="height:350px;" align="center">
                                                <div style="position:relative; left:50%; top:50%; transform:translate(-50%,-50%);">
                                                    <div class="col-md-12 ">
                                                        <button type="button" onClick="inputgrupguru()" class="btn btn-success fa fa-arrow-right"></button>
                                                    </div>
                                                    <br />
                                                    <br />
                                                    <br />
                                                    <br />
                                                    <div class="col-md-12 ">
                                                        <button type="button" onClick="deletegrupguru()" class="btn btn-warning fa fa-arrow-left"></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <select id="grup_guru_id" name="grup_guru_id" multiple class="form-control" style="height:350px;">
                                                    <?php $sisa = $this->db
                                                        ->join("grup", "grup.grup_id=grup_guru.grup_id", "left")
                                                        ->where("grup_guru.sekolah_id", $sekolah_id)
                                                        ->where("grup_guru.user_id", $user_id)
                                                        ->get("grup_guru");
                                                    //$a = $this->db->last_query();
                                                    foreach ($sisa->result() as $gurugrup) {
                                                    ?>
                                                        <option value="<?= $gurugrup->grup_guru_id; ?>"><?= $gurugrup->grup_name; ?></option>
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