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
                    <li class="active">Absensi Guru</li>
                </ul><!-- /.breadcrumb -->


            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>Absensi Guru</h1>
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
                                            $judul = "Update Absensi Guru";
                                        } else {
                                            $namabutton = 'name="create"';
                                            $judul = "New Absensi Guru";
                                        } ?>
                                        <div class="lead">
                                            <h3><?= $judul; ?></h3>
                                        </div>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">

                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="abseng_date">Date:</label>
                                                <div class="col-sm-10">
                                                    <input type="date" class="form-control" id="abseng_date" name="abseng_date" value="<?= $abseng_date; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="abseng_time">Time:</label>
                                                <div class="col-sm-10">
                                                    <input type="time" class="form-control" id="abseng_time" name="abseng_time" value="<?= $abseng_time; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="kelas_id">Class:</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control select2" id="kelas_id" name="kelas_id">
                                                        <option value="" <?= ($kelas_id == "") ? "selected" : ""; ?>>Choose Class</option>
                                                        <?php
                                                        $kelas = $this->db
                                                            ->join("kelas", "kelas.kelas_id=kelas_sekolah.kelas_id", "left")
                                                            ->where("kelas.sekolah_id", $this->session->userdata("sekolah_id"))
                                                            ->group_by("kelas.kelas_name")
                                                            ->get("kelas_sekolah");
                                                        foreach ($kelas->result() as $row) { ?>
                                                            <option value="<?= $row->kelas_id; ?>" <?= ($kelas_id == $row->kelas_id) ? "selected" : ""; ?>><?= $row->kelas_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="user_nik">Guru:</label>
                                                <div class="col-sm-10">
                                                    <select onchange="isinisn()" class="form-control" id="user_nik" name="user_nik">
                                                        <option value="0" <?= ($user_nik == 0) ? "selected" : ""; ?>>Pilih Guru</option>
                                                        <?php $user = $this->db                                                        
                                                        ->where("sekolah_id", $this->session->userdata("sekolah_id"))
                                                        ->where("user_nik !=", "")
                                                        ->order_by("user_name", "asc")
                                                        ->get("user");
                                                        foreach ($user->result() as $row) { ?>
                                                            <option value="<?= $row->user_nik; ?>" <?= ($user_nik == $row->user_nik) ? "selected" : ""; ?>><?= $row->user_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" name="sekolah_id" value="<?= $this->session->userdata("sekolah_id"); ?>" />
                                            <input type="hidden" name="abseng_id" value="<?= $abseng_id; ?>" />
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
                                                <div class="form-group">
                                                    <label for="kelas_id">Class:</label>
                                                    <?php
                                                    if (isset($_GET["kelas_id"])) {
                                                        $kelas_id = $this->input->get("kelas_id");
                                                    } else {
                                                        $kelas_id = 0;
                                                    }
                                                    $gru = $this->db
                                                        ->join("kelas", "kelas.kelas_id=kelas_sekolah.kelas_id", "left")
                                                        ->where("kelas.sekolah_id", $this->session->userdata("sekolah_id"))
                                                        ->group_by("kelas.kelas_name")
                                                        ->get("kelas_sekolah");
                                                    // echo $this->db->last_query();
                                                    // echo $this->session->userdata("position_id");
                                                    ?>
                                                    <select name="kelas_id" id="kelas_id" class="form-control" onChange="cari_user(this.value)">
                                                        <option value="0" <?= ($kelas_id == 0) ? 'selected="selected"' : ""; ?>>Choose Class</option>
                                                        <?php
                                                        foreach ($gru->result() as $kelas) { ?>
                                                            <option value="<?= $kelas->kelas_id; ?>" <?= ($kelas_id == $kelas->kelas_id) ? 'selected="selected"' : ""; ?>><?= $kelas->kelas_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="user_nik">Guru:</label>
                                                    <?php
                                                    if (isset($_GET["user_nik"])) {
                                                        $user_nik = $this->input->get("user_nik");
                                                    } else {
                                                        $user_nik = 0;
                                                    }
                                                    ?>
                                                    <select name="user_nik" id="user_nik" class="form-control">
                                                        <option value="0" <?= ($user_nik == 0) ? "selected" : ""; ?>>Pilih Guru</option>
                                                        <?php $user = $this->db
                                                        ->where("sekolah_id", $this->session->userdata("sekolah_id"))
                                                        ->where("user_nik !=", "")
                                                        ->order_by("user_name", "asc")->get("user");
                                                        foreach ($user->result() as $row) { ?>
                                                            <option value="<?= $row->user_nik; ?>" <?= ($user_nik == $row->user_nik) ? "selected" : ""; ?>><?= $row->user_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <button type="submit" class="btn btn-default">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="box">
                                        <div id="collapse4" class="body table-responsive">
                                            <table id="dataTable" class="table table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="col-md-2">Action</th>
                                                        <th>School</th>
                                                        <th>Date</th>
                                                        <th>Name</th>
                                                        <th>Class</th>
                                                        <th>Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($this->session->userdata("sekolah_id") > 0) {
                                                        $this->db->where("abseng.sekolah_id", $this->session->userdata("sekolah_id"));
                                                    }
                                                    if (isset($_GET['user_nik']) && $_GET['user_nik'] > 0) {
                                                        $this->db->where("abseng.user_nik", $_GET['user_nik']);
                                                    }
                                                    if (isset($_GET['sekolah_id']) && $_GET['sekolah_id'] > 0) {
                                                        $this->db->where("abseng.sekolah_id", $_GET['sekolah_id']);
                                                    }
                                                    if (isset($_GET['kelas_id']) && $_GET['kelas_id'] > 0) {
                                                        $this->db->where("abseng.kelas_id", $_GET['kelas_id']);
                                                    }
                                                    $this->db->where("abseng.abseng_date >=", $from);
                                                    $this->db->where("abseng.abseng_date <=", $to);
                                                    $usr = $this->db
                                                        ->join("sekolah", "sekolah.sekolah_id=abseng.sekolah_id", "left")
                                                        ->join("kelas", "kelas.kelas_id=abseng.kelas_id", "left")
                                                        ->join("user", "user.user_nik=abseng.user_nik", "left")
                                                        ->get("abseng");
                                                    // echo $this->db->last_query();
                                                    foreach ($usr->result() as $abseng) {
                                                    ?>
                                                        <tr>
                                                            <td style="padding-left:0px; padding-right:0px;">
                                                                <form method="post" class="col-md-3" style="padding:0px;">
                                                                    <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                                    <input type="hidden" name="abseng_id" value="<?= $abseng->abseng_id; ?>" />
                                                                </form>
                                                                <form method="post" class="col-md-3" style="padding:0px;">
                                                                    <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                                    <input type="hidden" name="abseng_id" value="<?= $abseng->abseng_id; ?>" />
                                                                </form>
                                                            </td>
                                                            <td><?= $abseng->sekolah_name; ?></td>
                                                            <td><?= $abseng->abseng_date; ?></td>
                                                            <td><?= $abseng->user_name; ?></td>
                                                            <td><?= $abseng->kelas_name; ?></td>
                                                            <td><?= date("H:i",strtotime($abseng->abseng_time)); ?></td>
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