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
          <li class="active">Position</li>
        </ul><!-- /.breadcrumb -->


      </div>
      <div class="page-content">

        <div class="page-header">
          <h1>
            Position

          </h1>
          <?php if (!isset($_POST['new']) && !isset($_POST['edit'])) { ?>

            <form method="post" class="col-md-2" style="margin-top:-30px; float:right;">

              <button name="new" class="btn btn-info btn-block btn-sm" value="OK" style="">New</button>
              <input type="hidden" name="position_id" />

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
                      $judul = "Update Position";
                    } else {
                      $namabutton = 'name="create"';
                      $judul = "New Position";
                    } ?>
                    <div class="lead">
                      <h3><?= $judul; ?></h3>
                    </div>
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">

                      <div class="form-group">
                        <label class="control-label col-sm-2" for="position_name">Position:</label>
                        <div class="col-sm-10">
                          <input type="user_name" class="form-control" id="position_name" name="position_name" placeholder="Enter Position" value="<?= $position_name; ?>">
                        </div>
                      </div>


                      <input type="hidden" name="position_id" value="<?= $position_id; ?>" />
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
                            <th class="col-md-2">Action</th>
                            <th>Position</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $usr = $this->db
                            ->get("position");
                          //echo $this->db->last_query();
                          foreach ($usr->result() as $user) { ?>
                            <tr>
                              <td style="padding-left:0px; padding-right:0px;">

                                <form method="get" class="col-md-4" style="padding:0px;" action="<?=base_url("positionpages");?>">
                                  <button class="btn btn-primary " value="OK"><span class="fa fa-check" style="color:white;"></span> </button>
                                  <input type="hidden" name="position_id" value="<?= $user->position_id; ?>" />
                                </form>

                                <form method="post" class="col-md-4" style="padding:0px;">
                                  <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                  <input type="hidden" name="position_id" value="<?= $user->position_id; ?>" />
                                </form>

                                <?php if (!isset($_GET["id"])) { ?>
                                  <form method="post" class="col-md-4" style="padding:0px;">
                                    <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                    <input type="hidden" name="position_id" value="<?= $user->position_id; ?>" />
                                  </form>
                                <?php } ?>
                              </td>
                              <td><?= $user->position_name; ?></td>
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