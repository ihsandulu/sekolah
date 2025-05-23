<!doctype html>
<html>

<head>
    <?php require_once("meta.php"); ?>   
    <script>
        $(document).ready(function() {
            $("#user_nisn").keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    profil();
                    return false;
                }
            });
        });
    </script>
    <script>
        function line(a) {
            var txt;
            var line = prompt("Enter the line:", "");
            if (line == null || line == "") {
                alert("Line cannot empty");
            } else {
                var win = window.open('<?= site_url("userprint?print=OK&user_id="); ?>' + a + '&line=' + line, '_blank');
                win.focus();
            }
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
                    <li class="active">Barcode</li>
                </ul><!-- /.breadcrumb -->


            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>
                        Barcode

                    </h1>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">

                                <?php if ($message != "") { ?>
                                    <div class="alert alert-info alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong><?= $message; ?></strong><br /><?= $uploaduser_picture; ?>
                                    </div>
                                <?php } ?>
                                <div class="box">

                                    <div id="collapse4" class="body table-responsive">

                                        <div class="col-md-12" style="border:#FDDABB dashed 1px; margin-bottom:30px; padding:10px;">
                                            <form id="sp" method="get" class="form-inline" action="">
                                                
                                               

                                                <?php if ($this->session->userdata("position_id") != 4) { ?>
                                                    <div class="form-group hideclass">
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

                                                        $gru = $this->db->group_by("kelas_guru.kelas_id")
                                                            ->get("kelas_guru");
                                                        // echo $this->db->last_query();
                                                        // echo $this->session->userdata("position_id");
                                                        ?>
                                                        <select onchange="listsiswasekolah();" name="kelas_id" id="kelas_id" class="form-control" onChange="cari_user(this.value)">
                                                        <option value="-1" <?= ($kelas_id == -1) ? 'selected="selected"' : ""; ?>>Choose Class</option>
                                                        <option value="0" <?= ($kelas_id == 0) ? 'selected="selected"' : ""; ?>>All Class</option>
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


                                                    <div class="form-group hideclass">
                                                        <label for="user_id">Student:</label>
                                                        <select name="user_id" id="user_id" class="form-control">

                                                        </select>
                                                    </div>
                                                <?php } ?>
                                                <button name="search" type="submit" class="btn btn-success fa fa-search"> Search</button>
                                                <button type="button" class="btn btn-info fa fa-print" onclick="print()"> Print</button>
													<script>
														function print() {
															let type = $("#type").val();
															let from = $("#from").val();
															let to = $("#to").val();
															let kelas_id = $("#kelas_id").val();
															let user_id = $("#user_id").val();
															var url = "<?= site_url("barcodecetak"); ?>?kelas_id=" + kelas_id + "&user_id=" + user_id;
															window.open(url, '_blank');
														}
													</script>
                                            </form>
                                        </div>
                                        <?php //} 
                                        ?>
                                        <table id="dataTable" class="table table-condensed table-hover">
                                            <thead>
                                                <tr>
                                                    <?php if (isset($_GET['laporan'])) {
                                                        $colact = "col-md-1";
                                                        $colbtn = "col-md-12";
                                                    } else {
                                                        $colact = "col-md-3";
                                                        $colbtn = "col-md-3";
                                                    } ?>
                                                    <?php
                                                    if ($this->session->userdata("position_id") != 4) { ?>
                                                        <th class="<?= $colact; ?>">Action</th>
                                                    <?php } ?>
                                                    <th>School</th>
                                                    <th>Class</th>
                                                    <th>User</th>
                                                    <th>NISN/NIK</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                if (isset($_GET['search']) && ($_GET['kelas_id'] > 0||$_GET['kelas_id'] == -1)) {
                                                    $this->db->where("kelas.kelas_id", $kelas_id);
                                                }
                                                if (isset($_GET['search']) && isset($_GET['user_id']) && $_GET['user_id'] > 0) {
                                                    $this->db->where("user.user_id", $_GET['user_id']);
                                                }

                                                if ($this->session->userdata("position_id") == 4) {
                                                    $this->db->where("user.user_nisn", $this->session->userdata("user_nisn"));
                                                }
                                                if(!isset($_GET["kelas_id"])){
                                                    $this->db->where("user.kelas_id","-1");
                                                }

                                                $usr = $this->db
                                                    ->select("*,kelas.kelas_name as kelas_name")
                                                    ->join("sekolah", "sekolah.sekolah_id=user.sekolah_id", "left")
                                                    ->join("kelas", "kelas.kelas_id=user.kelas_id", "left")
                                                    ->where("user.position_id", "4")
                                                    ->order_by("sekolah_name", "asc")
                                                    ->order_by("kelas_name", "asc")
                                                    ->order_by("user_name", "asc")
                                                    ->get("user");
                                                // echo $this->db->last_query();
                                                foreach ($usr->result() as $user) {
                                                    if ($user->user_nisn == "") {
                                                        $back = "background-color:#FEDCC5";
                                                    } else {
                                                        $back = "";
                                                    } ?>
                                                    <tr style="<?= $back; ?>">
                                                        <td style="padding-left:0px; padding-right:0px;" align="center">
                                                            <?php if ($this->session->userdata("position_id") != 4) { ?>
                                                                <form title="Print Barcode" target="_blank" action="<?= base_url('barcodecetak'); ?>" method="get" class="<?= $colbtn; ?>" style="padding:0px;">
                                                                    <button type="submit" class="btn btn-info btn-xs btn-block" name="print" value="OK"><span class="fa fa-print" style="color:white;"></span> </button>
                                                                    <input type="hidden" name="user_id" value="<?= $user->user_id; ?>" />
                                                                    <input type="hidden" name="kelas_id" value="<?= $user->kelas_id; ?>" />
                                                                </form>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?= $user->sekolah_name; ?></td>
                                                        <td><?= $user->kelas_name; ?></td>
                                                        <td><?= $user->user_name; ?></td>
                                                        <td><?= $user->user_nisn; ?></td>
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
</body>

</html>