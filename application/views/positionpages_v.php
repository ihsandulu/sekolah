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
                      <table id="datatablenya" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <!-- <table id="dataTable" class="table table-condensed table-hover w-auto dtable"> -->
                        <thead class="">
                            <tr>
                                <!-- <th>No.</th> -->
                                <th>ID.</th>
                                <th>Root</th>
                                <th>Menu</th>
                                <th>View</th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>Delete</th>
                                <th>Approve</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <i class="fa fa-arrow-right text-success"></i>
                                    <i class="fa fa-arrow-right text-success"></i>
                                    <i class="fa fa-arrow-right text-success"></i>
                                </td>
                                <td class="text-center">0</td>
                                <td class="text-left">Isi Semua Field</td>
                                <td><input id="read0" onclick="isisemua('read')" value="1" type="checkbox" > Semua View</td>
                                <td><input id="create0" onclick="isisemua('create')" value="1" type="checkbox" > Semua Create</td>
                                <td><input id="update0" onclick="isisemua('update')" value="1" type="checkbox" > Semua Update</td>
                                <td><input id="delete0" onclick="isisemua('delete')" value="1" type="checkbox" > Semua Delete</td>
                                <td><input id="approve0" onclick="isisemua('approve')" value="1" type="checkbox" > Semua Approve</td>
                            </tr>
                            <script>
                                const pagesid = [];
                            </script>
                            <?php
                            $posid=$this->input->get("position_id");
                            $usr = $this->db
                                ->select("*,pages.pages_id AS pages_id")
                                ->join("(SELECT * FROM positionpages WHERE position_id = '".$posid."')positionpages","positionpages.pages_id=pages.pages_id","left")
                                ->order_by("pages.pages_category", "ASC")
                                ->order_by("pages.pages_name", "ASC")
                                 ->get("pages");
                            // echo $this->db->getLastquery();
                            $no = 1;
                            foreach ($usr->result() as $usr) { ?>
                            <script>
                                pagesid.push("<?= $usr->pages_id; ?>");
                            </script>
                                <tr>
                                    <!-- <td><?= $no++; ?></td> -->
                                    <td><?= $usr->pages_id ?></td>
                                    <td><?= $usr->pages_category ?></td>
                                    <td class="text-left"><?= ucwords($usr->pages_name); ?></td>
                                    <td><input id="read<?= $usr->pages_id; ?>" onclick="isi(<?= $usr->pages_id; ?>,<?= $posid; ?>,'read')" value="1" type="checkbox" <?= ($usr->positionpages_read == "1") ? "checked" : ""; ?>> View</td>
                                    <td><input id="create<?= $usr->pages_id; ?>" onclick="isi(<?= $usr->pages_id; ?>,<?= $posid; ?>,'create')" value="1" type="checkbox" <?= ($usr->positionpages_create == "1") ? "checked" : ""; ?>> Create</td>
                                    <td><input id="update<?= $usr->pages_id; ?>" onclick="isi(<?= $usr->pages_id; ?>,<?= $posid; ?>,'update')" value="1" type="checkbox" <?= ($usr->positionpages_update == "1") ? "checked" : ""; ?>> Update</td>
                                    <td><input id="delete<?= $usr->pages_id; ?>" onclick="isi(<?= $usr->pages_id; ?>,<?= $posid; ?>,'delete')" value="1" type="checkbox" <?= ($usr->positionpages_delete == "1") ? "checked" : ""; ?>> Delete</td>
                                    <td><input id="approve<?= $usr->pages_id; ?>" onclick="isi(<?= $usr->pages_id; ?>,<?= $posid; ?>,'approve')" value="1" type="checkbox" <?= ($usr->positionpages_approve == "1") ? "checked" : ""; ?>> Approve</td>
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