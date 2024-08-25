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
          <li class="active">Student</li>
        </ul><!-- /.breadcrumb -->


      </div>
      <div class="page-content">

        <div class="page-header">
          <h1>Student</h1>
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
                      $judul = "Update Student";
                    } else {
                      $namabutton = 'name="create"';
                      $judul = "New Student";
                    } ?>
                    <div class="lead">
                      <h3><?= $judul; ?></h3>
                    </div>
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">

                      <div class="form-group">
                        <label class="control-label col-sm-2" for="user_tahunajaran">Tahun Ajaran Masuk:</label>
                        <div class="col-sm-10">
                          <select tabindex="2" type="user_tahunajaran" class="form-control" id="user_tahunajaran" name="user_tahunajaran">
                            <option value="<?= date("Y"); ?>" <?= ($user_tahunajaran == "") ? "selected" : ""; ?>>Tahun Ini (<?= date("Y"); ?>)</option>
                            <?php
                            for ($x = (date("Y") - 5); $x <= date("Y"); $x++) { ?>
                              <option value="<?= $x; ?>" <?= ($user_tahunajaran == $x) ? "selected" : ""; ?>>
                                <?= $x; ?>
                              </option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-sm-2" for="user_nisn">NISN:</label>
                        <div class="col-sm-10">
                          <input type="user_name" class="form-control" id="user_nisn" name="user_nisn" placeholder="Enter NISN" value="<?= $user_nisn; ?>">
                        </div>
                      </div>
                      <div class="col-md-offset-2 col-md-10 alert alert-danger alert-dismissable fade in" id="cekuser" style="display:none;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Attention!</strong> NISN has been used.
                      </div>

                      <script>
                        $("#user_nisn").keyup(function() {
                          $.get("<?= site_url("api/cekuser"); ?>", {
                              user: 'user_nisn',
                              isi: $("#user_nisn").val(),
                              sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>'
                            })
                            .done(function(data) {
                              if (data > 0) {
                                $("#cekuser").fadeIn();
                                $("#submit").prop("disabled", "disabled");
                              } else {
                                $("#cekuser").fadeOut();
                                $("#submit").prop("disabled", "");
                              }
                            });
                        });
                      </script>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="user_name">Name:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter Username" value="<?= $user_name; ?>">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-sm-2" for="user_password">Password:</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Enter password" value="<?= $user_password; ?>">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-sm-2" for="user_password">Class:</label>
                        <div class="col-sm-10">
                          <select id="kelas_id" name="kelas_id" class="form-control">
                            <?php $kel = $this->db
                              ->join("kelas", "kelas.kelas_id=kelas_sekolah.kelas_id", "left")
                              ->where("kelas_sekolah.sekolah_id", $this->session->userdata("sekolah_id"))
                              ->get("kelas_sekolah");
                            foreach ($kel->result() as $kelas) { ?>
                              <option <?= ($kelas_id == $kelas->kelas_id) ? 'selected="selected"' : ""; ?> value="<?= $kelas->kelas_id; ?>"><?= $kelas->kelas_name; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-sm-2" for="user_picture">Picture:</label>
                        <div class="col-sm-10" align="left">
                          <input type="file" class="form-control" id="user_picture" name="user_picture"><br />
                          <?php if ($user_picture != "") {
                            $user_image = "assets/images/user_picture/" . $user_picture;
                          } else {
                            $user_image = "assets/images/user_picture/user.gif";
                          } ?>
                          <img id="user_picture_image" width="100" height="100" src="<?= base_url($user_image); ?>" />
                          <script>
                            function readURL(input) {
                              if (input.files && input.files[0]) {
                                var reader = new FileReader();

                                reader.onload = function(e) {
                                  $('#user_picture_image').attr('src', e.target.result);
                                }

                                reader.readAsDataURL(input.files[0]);
                              }
                            }

                            $("#user_picture").change(function() {
                              readURL(this);
                            });
                          </script>
                        </div>
                      </div>

                      <input type="hidden" name="sekolah_id" value="<?= $this->session->userdata("sekolah_id"); ?>" />
                      <input type="hidden" name="position_id" value="4" />
                      <input type="hidden" name="user_id" value="<?= $user_id; ?>" />
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
                      <strong><?= $message; ?></strong><br /><?= $uploaduser_picture; ?>
                    </div>
                  <?php } ?>
                  <div class="box">

                    <form method="post" class="form well col-md-6" enctype="multipart/form-data">
                      <div class="form-group">
                        <label>Import Excel : </label>
                        <input class="form-control" name="filesiswa" type="file" />
                      </div>
                      <div class="form-group">
                        <input checked id="drop" class="" name="drop" type="radio" value="0" />
                        <label for="drop"> Update Student Data</label>
                      </div>
                      <div class="form-group">
                        <input id="drop" class="" name="drop" type="radio" value="1" />
                        <label for="drop"> Delete All Student Data and All Transaction</label>
                      </div>
                      <div class="form-group">
                        <button class="btn btn-primary" type="submit" name="import">Import</button>
                      </div>
                    </form>
                    <div class="well col-md-offset-1 col-md-5" style="padding:30px; height:210px;" align="center">
                      <a target="_blank" href="<?= base_url("siswa1.xlsx"); ?>" class="fa fa-download btn btn-lg btn-success" style="top:50%; position:relative; top:50%; transform:translate(0,-50%);" /> Download Excel Template</a>
                    </div>
                    <form method="post" style="float:right; margin-bottom:20px;">
                      <button name="repair_tahun_ajaran" value="OK">Repair Tahun Ajaran Sesuai Kelas</button>
                    </form>

                    <div id="collapse4" class="body table-responsive col-md-12">
                      <table id="dataTable" class="table table-condensed table-hover">
                        <thead>
                          <tr>
                            <th class="col-md-2">Action</th>
                            <th>School</th>
                            <th>Year</th>
                            <th>NISN</th>
                            <th>Class</th>
                            <th>Name</th>
                            <th>Telephone</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if ($this->session->userdata("sekolah_id") > 0) {
                            $this->db->where("user.sekolah_id", $this->session->userdata("sekolah_id"));
                          }
                          $usr = $this->db
                            ->select("user.*, sekolah.*, kelas.*, position.*, GROUP_CONCAT(telpon.telpon_number SEPARATOR ',') as nomor_telepon")
                            ->join("telpon", "telpon.user_id=user.user_id", "left")
                            ->join("sekolah", "sekolah.sekolah_id=user.sekolah_id", "left")
                            ->join("kelas", "kelas.kelas_id=user.kelas_id", "left")
                            ->join("position", "position.position_id=user.position_id", "left")
                            ->where("user.position_id", "4")
                            ->group_by("user.user_id")
                            ->get("user");

                          // echo $this->db->last_query();
                          foreach ($usr->result() as $user) { ?>
                            <tr>
                              <td style="padding-left:0px; padding-right:0px;">
                                <form method="get" class="col-md-4" style="padding:0px;" action="<?= base_url("telpon"); ?>">
                                  <button class="btn btn-success " value="OK"><span class="fa fa-phone" style="color:white;"></span> </button>
                                  <input type="hidden" name="user_id" value="<?= $user->user_id; ?>" />
                                </form>

                                <form method="post" class="col-md-4" style="padding:0px;">
                                  <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                  <input type="hidden" name="user_id" value="<?= $user->user_id; ?>" />
                                </form>

                                <form method="post" class="col-md-4" style="padding:0px;">
                                  <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                  <input type="hidden" name="user_id" value="<?= $user->user_id; ?>" />
                                </form>
                              </td>
                              <td><?= $user->sekolah_name; ?></td>
                              <td><?= $user->user_tahunajaran; ?></td>
                              <td><?= $user->user_nisn; ?></td>
                              <td><?= $user->kelas_name; ?></td>
                              <td><?= $user->user_name; ?></td>
                              <td><?= $user->nomor_telepon; ?></td>
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