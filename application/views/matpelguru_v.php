<!doctype html>
<html>

<head>
    <?php
    require_once("meta.php"); ?>
    <script>
        function isi_matpel_id_guru() {
            $.get("<?= site_url("api/isi_matpel_id_guru"); ?>", {
                    sekolah_id: '<?= $sekolah_id; ?>',
                    user_id: '<?= $user_id; ?>'
                })
                .done(function(data) {
                    $("#matpel_id").html(data);
                });
        }

        function isi_matpelguru() {
            $.get("<?= site_url("api/isi_matpelguru"); ?>", {
                    sekolah_id: '<?= $sekolah_id; ?>',
                    user_id: '<?= $user_id; ?>'
                })
                .done(function(data) {
                    $("#matpelguru_id").html(data);
                });
        }

        function inputmatpelguru() {
            $.get("<?= site_url("api/inputmatpelguru"); ?>", {
                    sekolah_id: '<?= $sekolah_id; ?>',
                    matpel_id: $("#matpel_id").val(),
                    user_id: '<?= $user_id; ?>',
                    matpelguru_sumatif: $("#matpelguru_sumatif").val()
                })
                .done(function(data) {
                    isi_matpel_id_guru();
                    isi_matpelguru();
                    $("#matpelguru_sumatif").val("");
                });
        }

        function deletematpelguru() {
            $.get("<?= site_url("api/deletematpelguru"); ?>", {
                    sekolah_id: '<?= $sekolah_id; ?>',
                    matpelguru_id: $("#matpelguru_id").val()
                })
                .done(function(data) {
                    isi_matpel_id_guru();
                    isi_matpelguru();
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
                                            <span style="font-size:20px; font-weight:bold;">Matpel</span>
                                            (Press CTRL to select more than one)
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-5">
                                            <?php $gru = $this->db
                                                        ->where("matpel.sekolah_id", $sekolah_id)
                                                        ->get("matpel");
                                                    // echo $this->db->last_query();
                                                    ?>
                                                <select id="matpel_id" name="matpel_id" multiple class="form-control" style="height:350px;">
                                                    <?php
                                                    foreach ($gru->result() as $matpel) {
                                                        $matpelguru = $this->db
                                                            ->where("user_id", $user_id)
                                                            ->where("matpel_id", $matpel->matpel_id)
                                                            ->where("sekolah_id", $sekolah_id)
                                                            ->get("matpelguru")->num_rows();
                                                        if ($matpelguru == 0) {
                                                    ?>
                                                            <option value="<?= $matpel->matpel_id; ?>"><?= $matpel->matpel_name; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2" style="height:350px;" align="center">
                                                <div style="position:relative; left:50%; top:50%; transform:translate(-50%,-50%);">
                                                    <div class="col-md-12 ">
                                                        <label>Sumatif Count : </label>
                                                        <input type="number" id="matpelguru_sumatif" style="width:50px;"/>
                                                    </div>
                                                    <br />
                                                    <br />
                                                    <br />
                                                    <div class="col-md-12 ">
                                                        <button type="button" onClick="inputmatpelguru()" class="btn btn-success fa fa-arrow-right"></button>
                                                    </div>
                                                    <br />
                                                    <br />
                                                    <br />
                                                    <br />
                                                    <div class="col-md-12 ">
                                                        <button type="button" onClick="deletematpelguru()" class="btn btn-warning fa fa-arrow-left"></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <?php $sisa = $this->db
                                                        ->join("matpel", "matpel.matpel_id=matpelguru.matpel_id", "left")
                                                        ->where("matpelguru.sekolah_id", $sekolah_id)
                                                        ->where("matpelguru.user_id", $user_id)
                                                        ->get("matpelguru");
                                                    // echo $this->db->last_query();
                                                    ?>
                                                <select id="matpelguru_id" name="matpelguru_id" multiple class="form-control" style="height:350px;">
                                                    <?php
                                                    foreach ($sisa->result() as $gurumatpelguru) {
                                                    ?>
                                                        <option value="<?= $gurumatpelguru->matpelguru_id; ?>"><?= $gurumatpelguru->matpel_name; ?></option>
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