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
          <li class="active">Savings Officer (Petugas Tabungan)</li>
        </ul><!-- /.breadcrumb -->


      </div>
      <div class="page-content">

        <div class="page-header">
          <h1>Savings Officer (Petugas Tabungan)</h1>
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
                      $judul = "Update Savings Officer (Petugas Tabungan)";
                    } else {
                      $namabutton = 'name="create"';
                      $judul = "New Savings Officer (Petugas Tabungan)";
                    } ?>
                    <div class="lead">
                      <h3><?= $judul; ?></h3>
                    </div>
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">

                      <div class="form-group">
                        <label class="control-label col-sm-2" for="user_nik">NIK:</label>
                        <div class="col-sm-10">
                          <input type="user_name" class="form-control" id="user_nik" name="user_nik" placeholder="Enter NIK" value="<?= $user_nik; ?>">
                        </div>
                      </div>
                      <div class="col-md-offset-2 col-md-10 alert alert-danger alert-dismissable fade in" id="cekuser" style="display:none;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Attention!</strong> NIK has been used.
                      </div>

                      <script>
                        $("#user_nik").keyup(function() {
                          $.get("<?= site_url("api/cekuser"); ?>", {
                              user: 'user_nik',
                              isi: $("#user_nik").val(),
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
                          <input type="user_name" class="form-control" id="user_name" name="user_name" placeholder="Enter Username" value="<?= $user_name; ?>">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-sm-2" for="user_password">Password:</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Enter password" value="<?= $user_password; ?>">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-sm-2" for="user_borndate">Tgl Lahir:</label>
                        <div class="col-sm-10">
                          <input type="date" class="form-control" id="user_borndate" name="user_borndate" placeholder="Enter Born Date" value="<?= $user_borndate; ?>">
                        </div>
                      </div>
                      <?php if ($position_id == "3") { ?>
                        <div class="form-group">
                          <label class="control-label col-sm-2" for="user_golongan">Golongan:</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="user_golongan" name="user_golongan" placeholder="" value="<?= $user_golongan; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-sm-2" for="user_sertifikasi">Sertifikasi:</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="user_sertifikasi" name="user_sertifikasi" placeholder="" value="<?= $user_sertifikasi; ?>">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-sm-2" for="user_pendidikan">Pedidikan Terakhir:</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="user_pendidikan" name="user_pendidikan" placeholder="" value="<?= $user_pendidikan; ?>">
                          </div>
                        </div>
                      <?php } ?>

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
                      <input type="hidden" name="position_id" value="5" />
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
                    <div id="collapse4" class="body table-responsive">
                      <table id="dataTable" class="table table-condensed table-hover">
                        <thead>
                          <tr>
                          <th class="col-md-2">Action</th>
                            <th>School</th>
                            <th>NIK</th>
                            <th>Name</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if ($this->session->userdata("sekolah_id") > 0) {
                            $this->db->where("user.sekolah_id", $this->session->userdata("sekolah_id"));
                          }
                          $usr = $this->db
                            ->join("sekolah", "sekolah.sekolah_id=user.sekolah_id", "left")
                            ->join("position", "position.position_id=user.position_id", "left")
                            ->where("user.position_id", "5")
                            ->get("user");
                          //echo $this->db->last_query();
                          foreach ($usr->result() as $user) { ?>
                            <tr>
                              <td style="padding-left:0px; padding-right:0px;">
                                <form method="post" class="col-md-3" style="padding:0px;">
                                  <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                  <input type="hidden" name="user_id" value="<?= $user->user_id; ?>" />
                                </form>
                                <form method="post" class="col-md-3" style="padding:0px;">
                                  <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                  <input type="hidden" name="user_id" value="<?= $user->user_id; ?>" />
                                </form>
                              </td>
                              <td><?= $user->sekolah_name; ?></td>
                              <td><?= $user->user_nik; ?></td>
                              <td><?= $user->user_name; ?></td>
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