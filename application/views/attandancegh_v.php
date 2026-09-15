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
                    <li class="active">Teacher Attendance Daily</li>
                </ul><!-- /.breadcrumb -->


            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>Teacher Attendance Daily</h1>
                    <?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>

                        <form method="post" class="col-md-2" style="margin-top:-30px; float:right;">

                            <button name="new" class="btn btn-info btn-block btn-sm" value="OK" style="">New</button>
                            <input type="hidden" name="user_id" />

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
                                            $judul = "Update Attandance";
                                        } else {
                                            $namabutton = 'name="create"';
                                            $judul = "New Attandance";
                                        } ?>
                                        <div class="lead">
                                            <h3><?= $judul; ?></h3>
                                        </div>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">

                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="absengh_date">Date:</label>
                                                <div class="col-sm-10">
                                                    <input type="date" class="form-control" id="absengh_date" name="absengh_date" value="<?= $absengh_date; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="user_id">Guru:</label>
                                                <div class="col-sm-10">
                                                    <select onchange="isinik()" class="form-control select2" id="user_id" name="user_id">

                                                    </select>
                                                    <input id="absengh_nik" name="absengh_nik" type="hidden" />
                                                    <script>
                                                        function isinik() {
                                                            let absengh_nik = $("#user_id option:selected").attr("absengh_nik");
                                                            $("#absengh_nik").val(absengh_nik);
                                                        }
                                                    </script>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="absengh_type">Attandance:</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="absengh_type" name="absengh_type">
                                                        <option value="0" <?= ($absengh_type == "0") ? "selected" : ""; ?>>ALPHA</option>
                                                        <option value="1" <?= ($absengh_type == "1") ? "selected" : ""; ?>>IN</option>
                                                        <option value="2" <?= ($absengh_type == "2") ? "selected" : ""; ?>>OUT</option>
                                                        <option value="3" <?= ($absengh_type == "3") ? "selected" : ""; ?>>SICK</option>
                                                        <option value="4" <?= ($absengh_type == "4") ? "selected" : ""; ?>>PERMISSION</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="absengh_remarks">Remarks:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="absengh_remarks" name="absengh_remarks" value="<?= $absengh_remarks; ?>">
                                                </div>
                                            </div>

                                            <script>
                                                function cariabsengh() {
                                                    // alert('<?= site_url("api/listguru"); ?>?user_id=<?= $user_id; ?>;');

                                                        //siswa
                                                        $.get("<?= site_url("api/listguru"); ?>", {
                                                            user_id: '<?= $user_id; ?>'
                                                        })
                                                        .done(function(data) {
                                                            $('#user_id').html(data);
                                                        });


                                                    }
                                                    cariabsengh();
                                            </script>

                                            <input type="hidden" name="sekolah_id" value="<?= $this->session->userdata("sekolah_id"); ?>" />
                                            <input type="hidden" name="absengh_id" value="<?= $absengh_id; ?>" />

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
                                    <div class="page-header  mb-5">
                                        <div>

                                            <form class="form-inline ">
                                                <?php
                                                if (isset($_GET["from"]) && $_GET["from"] != "") {
                                                    $from = $_GET["from"];
                                                } else {
                                                    $from = date("Y-m-d");
                                                }
                                                if (isset($_GET["to"]) && $_GET["to"] != "") {
                                                    $to = $_GET["to"];
                                                } else {
                                                    $to = date("Y-m-d");
                                                }
                                                ?>
                                                <div class="form-group">
                                                    <label for="from">From:</label>
                                                    <input type="date" name="from" id="from" class="form-control" value="<?= $from; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="to">To:</label>
                                                    <input type="date" name="to" id="to" class="form-control" value="<?= $to; ?>">
                                                </div>

                                                <script>
                                                    function listguru() {
                                                        // alert("<?= base_url("api/listguru"); ?>?user_id=<?= $user_id; ?>");
                                                        $.get("<?= base_url("api/listguru"); ?>", {
                                                                user_id: '<?= $user_id; ?>'
                                                            })
                                                            .done(function(data) {
                                                                $("#user_id").html(data);
                                                            });
                                                    }
                                                    $(document).ready(function() {
                                                        listguru();
                                                    });
                                                </script>


                                                <div class="form-group">
                                                    <label for="user_id">Guru:</label>
                                                    <select name="user_id" id="user_id" class="form-control">

                                                    </select>
                                                </div>
                                                <input type="hidden" name="report" value="<?= isset($_GET['report']) ? $_GET['report'] : ''; ?>" />
                                                <button type="submit" class="btn btn-default">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="box">
                                        <div id="collapse4" class="body table-responsive">
                                            <table id="dataTable" class="table table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <?php if (!isset($_GET['report']) || (isset($_GET['report']) && $_GET['report'] != 'ok')) { ?>
                                                            <th class="col-md-2">Action</th>
                                                        <?php } ?>
                                                        <th>Datetime</th>
                                                        <th>Attandance</th>
                                                        <th>Remarks</th>
                                                        <th>School</th>
                                                        <th>NIK</th>
                                                        <th>Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php


                                                    if ($this->session->userdata("sekolah_id") > 0) {
                                                        $this->db->where("absengh.sekolah_id", $this->session->userdata("sekolah_id"));
                                                    }

                                                    if (isset($_GET['user_id']) && $_GET['user_id'] > 0) {
                                                        $this->db->where("absengh.user_id", $_GET['user_id']);
                                                    }
                                                    $this->db->where("absengh.absengh_date >=", $from);
                                                    $this->db->where("absengh.absengh_date <=", $to);
                                                    $usr = $this->db
                                                        ->join("sekolah", "sekolah.sekolah_id=absengh.sekolah_id", "left")
                                                        ->join("user", "user.user_id=absengh.user_id", "left")
                                                        // ->where("absengh_year", date("Y"))
                                                        ->order_by("user.user_name", "ASC")
                                                        ->get("absengh");
                                                    // echo $this->db->last_query();
                                                    foreach ($usr->result() as $absengh) {
                                                        $type = array("Alpha", "In", "Out", "Sick", "Permission")
                                                    ?>
                                                        <tr>
                                                            <?php if (!isset($_GET['report']) || (isset($_GET['report']) && $_GET['report'] != 'ok')) { ?>
                                                                <td style="padding-left:0px; padding-right:0px;">
                                                                    <form method="post" class="col-md-3" style="padding:0px;">
                                                                        <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                                        <input type="hidden" name="absengh_id" value="<?= $absengh->absengh_id; ?>" />
                                                                    </form>
                                                                    <form method="post" class="col-md-3" style="padding:0px;">
                                                                        <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                                        <input type="hidden" name="absengh_id" value="<?= $absengh->absengh_id; ?>" />
                                                                    </form>
                                                                </td>
                                                            <?php } ?>
                                                            <td><?= $absengh->absengh_datetime; ?></td>
                                                            <td><?= $type[$absengh->absengh_type]; ?></td>
                                                            <td><?= $absengh->absengh_remarks; ?></td>
                                                            <td><?= $absengh->sekolah_name; ?></td>
                                                            <td><?= $absengh->user_nik; ?></td>
                                                            <td><?= $absengh->user_name; ?></td>
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