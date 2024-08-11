<!doctype html>
<html>

<head>
    <?php
    require_once("meta.php"); ?>
    <script>
        function isi_kelas_sekolah() {
            $.get("<?= site_url("api/isi_kelas_sekolah"); ?>", {
                    sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>'
                })
                .done(function(data) {
                    $("#kelas_sekolah_id").html(data);
                });
        }

        function isi_kelas() {
            $.get("<?= site_url("api/isi_kelas"); ?>", {
                    sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>'
                })
                .done(function(data) {
                    $("#kelas_id").html(data);
                });
        }

        function inputkelas() {
            $.get("<?= site_url("api/inputkelas"); ?>", {
                    sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>',
                    kelas_id: $("#kelas_id").val()
                })
                .done(function(data) {
                    isi_kelas_sekolah();
                    isi_kelas();
                });
        }

        function deletekelas() {
            let sekolah_id = '<?= $this->session->userdata("sekolah_id"); ?>';
            let kelas_sekolah_id = $("#kelas_sekolah_id").val();
            // alert('<?= site_url("api/deletekelas"); ?>?sekolah_id='+sekolah_id+'&kelas_sekolah_id='+kelas_sekolah_id);
            if (Array.isArray(kelas_sekolah_id)) {
                kelas_sekolah_id = kelas_sekolah_id.join(',');
            }
            $.get("<?= site_url("api/deletekelas"); ?>", {
                    sekolah_id: sekolah_id,
                    kelas_sekolah_id: kelas_sekolah_id
                })
                .done(function(data) {
                    if (data != 1) {
                        alert(data);
                    }
                    isi_kelas_sekolah();
                    isi_kelas();
                });
        }
    </script>
    <script>
        function isi_matpel_sekolah() {
            $.get("<?= site_url("api/isi_matpel_sekolah"); ?>", {
                    sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>'
                })
                .done(function(data) {
                    $("#matpel_sekolah_id").html(data);
                });
        }

        function isi_matpel() {
            $.get("<?= site_url("api/isi_matpel"); ?>", {
                    sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>'
                })
                .done(function(data) {
                    $("#matpel_id").html(data);
                });
        }

        function inputmatpel() {
            $.get("<?= site_url("api/inputmatpel"); ?>", {
                    sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>',
                    matpel_id: $("#matpel_id").val()
                })
                .done(function(data) {
                    isi_matpel_sekolah();
                    isi_matpel();
                });
        }

        function deletematpel() {
            // alert("<?= site_url("api/deletematpel"); ?>?sekolah_id=<?= $this->session->userdata("sekolah_id"); ?>&matpel_sekolah_id="+$("#matpel_sekolah_id").val());
            $.get("<?= site_url("api/deletematpel"); ?>", {
                    sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>',
                    matpel_sekolah_id: $("#matpel_sekolah_id").val().join(',')
                })
                .done(function(data) {
                    if (data != "") {
                        alert(data);
                    }
                    isi_matpel_sekolah();
                    isi_matpel();
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
                    <li class="active">School</li>
                </ul><!-- /.breadcrumb -->


            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>School</h1>
                    <?php if (isset($this->session->userdata['sekolah_id']) && $this->session->userdata['sekolah_id'] == 0) { ?>

                        <form method="post" class="col-md-2" style="margin-top:-30px; float:right;">

                            <button name="new" class="btn btn-info btn-block btn-sm" value="OK" style="">New</button>
                            <input type="hidden" name="sekolah_id" />

                        </form>

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
                                            $judul = "Update School";
                                        } else {
                                            $namabutton = 'name="create"';
                                            $judul = "New School";
                                        } ?>
                                        <div class="lead">
                                            <h3><?= $judul; ?></h3>
                                        </div>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <?php if (isset($_POST['new'])) {
                                                $readonly = "";
                                            } else {
                                                $readonly = "readonly";
                                            } ?>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="sekolah_id">Kode:</label>
                                                <div class="col-sm-10">
                                                    <input type="sekolah_name" class="form-control" <?= $readonly; ?> id="sekolah_id" name="sekolah_id" placeholder="Enter Code" value="<?= $sekolah_id; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="sekolah_name">School:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="sekolah_name" name="sekolah_name" placeholder="Enter School" value="<?= $sekolah_name; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="sekolah_address">Address:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="sekolah_address" name="sekolah_address" placeholder="Enter Address" value="<?= $sekolah_address; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="sekolah_serverwa">Server Whatsapp:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="sekolah_serverwa" name="sekolah_serverwa" placeholder="Enter Server" value="<?= $sekolah_serverwa; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="sekolah_emailwa">Email Whatsapp:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="sekolah_emailwa" name="sekolah_emailwa" placeholder="Enter Server" value="<?= $sekolah_emailwa; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="sekolah_passwordwa">Password Whatsapp:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="sekolah_passwordwa" name="sekolah_passwordwa" placeholder="Enter Server" value="<?= $sekolah_passwordwa; ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="sekolah_picture">Picture:</label>
                                                <div class="col-sm-10" align="left">
                                                    <input type="file" id="sekolah_picture" name="sekolah_picture"><br />
                                                    <?php if ($sekolah_picture != "") {
                                                        $sekolah_image = "assets/images/sekolah_picture/" . $sekolah_picture;
                                                    } else {
                                                        $sekolah_image = "assets/images/sekolah_picture/putar.gif";
                                                    } ?>
                                                    <img id="sekolah_picture_image" width="100" height="100" src="<?= base_url($sekolah_image); ?>" />
                                                    <script>
                                                        function readURL(input) {
                                                            if (input.files && input.files[0]) {
                                                                var reader = new FileReader();

                                                                reader.onload = function(e) {
                                                                    $('#sekolah_picture_image').attr('src', e.target.result);
                                                                }

                                                                reader.readAsDataURL(input.files[0]);
                                                            }
                                                        }

                                                        $("#sekolah_picture").change(function() {
                                                            readURL(this);
                                                        });
                                                    </script>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
                                                    <button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("sekolah"); ?>">Back</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php } else { ?>
                                    <?php if ($message != "") { ?>
                                        <div class="alert alert-info alert-dismissable">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong><?= $message; ?></strong><br /><?= $uploadsekolah_picture; ?>
                                        </div>
                                    <?php } ?>
                                    <div class="box">
                                        <div id="collapse4" class="body table-responsive">
                                            <table id="dataTable" class="table table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>School</th>
                                                        <th>Address</th>
                                                        <th class="col-md-1">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($this->session->userdata("sekolah_id") > 0) {
                                                        $this->db->where("sekolah.sekolah_id", $this->session->userdata("sekolah_id"));
                                                    }
                                                    $usr = $this->db
                                                        ->get("sekolah");
                                                    //echo $this->db->last_query();
                                                    foreach ($usr->result() as $sekolah) { ?>
                                                        <tr>
                                                            <td><?= $sekolah->sekolah_name; ?></td>
                                                            <td><?= $sekolah->sekolah_address; ?></td>
                                                            <td style="padding-left:0px; padding-right:0px;">
                                                                <form method="post" class="col-md-6" style="padding:0px;">
                                                                    <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                                    <input type="hidden" name="sekolah_id" value="<?= $sekolah->sekolah_id; ?>" />
                                                                </form>
                                                                <?php if ($this->session->userdata("position_id") == "1") { ?>
                                                                    <form method="post" class="col-md-6" style="padding:0px;">
                                                                        <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                                        <input type="hidden" name="sekolah_id" value="<?= $sekolah->sekolah_id; ?>" />
                                                                    </form>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <?php if (isset($_SESSION['sekolah_id'])) { ?>
                                                <div class="col-md-6">
                                                    <div class="panel panel-info" style="margin-top:50px;">
                                                        <div class="panel-heading"><span style="font-size:20px; font-weight:bold;">Class</span> (Press CTRL to select more than one)</div>
                                                        <div class="panel-body">
                                                            <div class="col-md-5">
                                                                <select id="kelas_id" name="kelas_id" multiple class="form-control" style="height:350px;">
                                                                    <?php $kel = $this->db->get("kelas");
                                                                    foreach ($kel->result() as $kelas) {
                                                                        $kelassekolah = $this->db
                                                                            ->where("kelas_id", $kelas->kelas_id)
                                                                            ->where("sekolah_id", $this->session->userdata("sekolah_id"))
                                                                            ->get("kelas_sekolah")->num_rows();
                                                                        if ($kelassekolah == 0) {
                                                                    ?>
                                                                            <option value="<?= $kelas->kelas_id; ?>"><?= $kelas->kelas_name; ?></option>
                                                                    <?php }
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2" style="height:350px;" align="center">
                                                                <div style="position:relative; left:50%; top:50%; transform:translate(-50%,-50%);">
                                                                    <div class="col-md-12 ">
                                                                        <button type="button" onClick="inputkelas()" class="btn btn-success fa fa-arrow-right"></button>
                                                                    </div>
                                                                    <br />
                                                                    <br />
                                                                    <br />
                                                                    <br />
                                                                    <div class="col-md-12">
                                                                        <button type="button" onClick="deletekelas()" class="btn btn-warning fa fa-arrow-left"></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <select id="kelas_sekolah_id" name="kelas_sekolah_id" multiple class="form-control" style="height:350px;">
                                                                    <?php $kela = $this->db
                                                                        ->join("kelas", "kelas.kelas_id=kelas_sekolah.kelas_id", "left")
                                                                        ->where("kelas_sekolah.sekolah_id", $this->session->userdata("sekolah_id"))
                                                                        ->get("kelas_sekolah");
                                                                    foreach ($kela->result() as $kelassekolah) {
                                                                    ?>
                                                                        <option value="<?= $kelassekolah->kelas_sekolah_id; ?>"><?= $kelassekolah->kelas_name; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class=" col-md-6">
                                                    <div class="panel panel-info" style="margin-top:50px;">
                                                        <div class="panel-heading"><span style="font-size:20px; font-weight:bold;">Subjects</span> (Press CTRL to select more than one)</div>
                                                        <div class="panel-body">
                                                            <div class="col-md-5">
                                                                <select id="matpel_id" name="matpel_id" multiple class="form-control" style="height:350px;">
                                                                    <?php $mat = $this->db->get("matpel");
                                                                    foreach ($mat->result() as $matpel) {
                                                                        $matpelsekolah = $this->db
                                                                            ->where("matpel_id", $matpel->matpel_id)
                                                                            ->where("sekolah_id", $this->session->userdata("sekolah_id"))
                                                                            ->get("matpel_sekolah")->num_rows();
                                                                        if ($matpelsekolah == 0) {
                                                                    ?>
                                                                            <option value="<?= $matpel->matpel_id; ?>"><?= $matpel->matpel_name; ?></option>
                                                                    <?php }
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2" style="height:350px;" align="center">
                                                                <div style="position:relative; left:50%; top:50%; transform:translate(-50%,-50%);">
                                                                    <div class="col-md-12 ">
                                                                        <button type="button" onClick="inputmatpel()" class="btn btn-success fa fa-arrow-right"></button>
                                                                    </div>
                                                                    <br />
                                                                    <br />
                                                                    <br />
                                                                    <br />
                                                                    <div class="col-md-12">
                                                                        <button type="button" onClick="deletematpel()" class="btn btn-warning fa fa-arrow-left"></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <select id="matpel_sekolah_id" name="matpel_sekolah_id" multiple class="form-control" style="height:350px;">
                                                                    <?php $matp = $this->db
                                                                        ->join("matpel", "matpel.matpel_id=matpel_sekolah.matpel_id", "left")
                                                                        ->where("matpel_sekolah.sekolah_id", $this->session->userdata("sekolah_id"))
                                                                        ->get("matpel_sekolah");
                                                                    echo $this->db->last_query();
                                                                    foreach ($matp->result() as $matpelsekolah) {
                                                                    ?>
                                                                        <option value="<?= $matpelsekolah->matpel_sekolah_id; ?>"><?= $matpelsekolah->matpel_name; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
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