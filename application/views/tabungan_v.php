<!doctype html>
<html>

<head>
	<?php require_once("meta.php"); ?>
	<?php
	if ($s > 0) {
	?>
		<script>
			$(document).ready(function() {
				line('<?= $s; ?>');
			});
		</script>
	<?php } ?>
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
				var win = window.open('<?= site_url("tabunganprint?print=OK&tabungan_id="); ?>' + a + '&line=' + line, '_blank');
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
					<li class="active">Account</li>
				</ul><!-- /.breadcrumb -->


			</div>
			<div class="page-content">

				<div class="page-header">
					<h1>
						Account

					</h1>
					<?php if (!isset($_POST['new']) && !isset($_POST['edit']) && !isset($_GET['laporan'])) { ?>

						<form method="post" class="col-md-2" style="margin-top:-30px; float:right;">

							<button name="new" class="btn btn-warning btn-block btn-sm fa fa-unlink" value="OK" style=""> Withdrawal</button>
							<input type="hidden" name="tabungan_id" />
							<input type="hidden" name="type" value="Kredit" />

						</form>

						<form method="post" class="col-md-2" style="margin-top:-30px; float:right;">

							<button name="new" class="btn btn-success btn-block btn-sm fa fa-money" value="OK" style=""> Deposit</button>
							<input type="hidden" name="tabungan_id" />
							<input type="hidden" name="type" value="Debet" />

						</form>

					<?php } ?>
				</div>

				<div class="row">
					<div class="col-xs-12 col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-body">
								<?php if (isset($_POST['new']) || isset($_POST['edit'])) {
									if (isset($_POST['new'])) {
										$tipe = $this->input->post("type");
									}
									if (isset($_POST['edit'])) {
										$tipe = $tabungan_type;
									}
								?>
									<div class="">
										<?php if (isset($_POST['edit'])) {
											$namabutton = 'name="change"';
											$judul = "Update " . $tipe;
										} else {
											$namabutton = 'name="create"';
											$judul = "New " . $tipe;
										} ?>
										<div class="lead">
											<h3><?= $judul; ?></h3>
										</div>
										<form class="form-horizontal" method="post" enctype="multipart/form-data">

											<div class="form-group">
												<label class="control-label col-sm-2" for="user_nisn">NISN:</label>
												<div class="col-sm-10">
													<input autofocus type="text" class="form-control" id="user_nisn" name="user_nisn" placeholder="Enter NISN" value="<?= $user_nisn; ?>" required>
													<input type="hidden" class="form-control" id="tabungan_type" name="tabungan_type" placeholder="Enter Type" value="<?= $tipe; ?>">
													<div id="profil" style="color:#000066;"></div>
													<script>
														function profil() {
															$.get("<?= site_url("api/datasiswa"); ?>", {
																	user_nisn: $("#user_nisn").val(),
																	sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>'
																})
																.done(function(data) {
																	$("#profil").html(data);
																});
														}
													</script>
												</div>
											</div>


											<div class="form-group">
												<label class="control-label col-sm-2" for="tabungan_remarks">Remarks:</label>
												<div class="col-sm-10">
													<input tabindex="2" type="tabungan_remarks" class="form-control" id="tabungan_remarks" name="tabungan_remarks" placeholder="Notes" value="<?= $tabungan_remarks; ?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="tabungan_amount">Amount:</label>
												<div class="col-sm-10">
													<input tabindex="3" onKeyUp="uang(this)" type="number" class="form-control" id="tabungan_amount" name="tabungan_amount" placeholder="Enter Amount" value="<?= $tabungan_amount; ?>" required min="1">
													<div style="color:#BB0000; font-weight:bold; margin-top:5px;">Rp <span id="uang"><?= number_format($tabungan_amount, 0, ",", "."); ?></span></div>
													<script>
														function uang(a) {
															$("#uang").text(a.value);
															setTimeout(function() {
																pemisah("#uang", "text");
															}, 50);
														}
													</script>
												</div>
											</div>




											<input type="hidden" name="sekolah_id" value="<?= $this->session->userdata("sekolah_id"); ?>" />
											<input type="hidden" name="tabungan_id" value="<?= $tabungan_id; ?>" />
											<input type="hidden" name="user_id" value="<?= $this->session->userdata("user_id"); ?>" />
											<div class="form-group">
												<div class="col-sm-offset-2 col-sm-10">
													<button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
													<a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= site_url("tabungan"); ?>">Back</a>
												</div>
											</div>
										</form>
									</div>
								<?php } else { ?>
									<?php if ($message != "") { ?>
										<div class="alert alert-info alert-dismissable">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
											<strong><?= $message; ?></strong><br /><?= $uploadtabungan_picture; ?>
										</div>
									<?php } ?>
									<div class="box">
										<div id="collapse4" class="body table-responsive">
											<?php if (isset($_GET['laporan'])) { ?>
												<div class="col-md-12" style="border:#FDDABB dashed 1px; margin-bottom:30px; padding:10px;">
													<form id="sp" method="post" target="_blank" class="form-inline" action="<?= site_url("tabunganreport_print"); ?>">
														<div class="form-group">
															<label for="type">Type:</label>
															<select id="type" name="type" onChange="lihatkelas()">
																<option value="">All</option>
																<option value="Debet" <?= ($this->input->post("type") == "Debet") ? "selected" : ""; ?>>Debet</option>
																<option value="Kredit" <?= ($this->input->post("type") == "Kredit") ? "selected" : ""; ?>>Kredit</option>
															</select>
															<script>
																function lihatkelas() {
																	var tipe = $("#type").val();
																	if (tipe == "Kredit") {
																		$("#divkelas").show();
																	} else {
																		$("#divkelas").hide();
																	}
																}
															</script>
														</div>


														<div class="form-group">
															<label for="from">From:</label>
															<input id="from" name="from" type="date" value="<?= $this->input->post("from"); ?>" />
														</div>
														<div class="form-group">
															<label for="from">To:</label>
															<input id="to" name="to" type="date" value="<?= $this->input->post("to"); ?>" />
														</div>
														<button type="submit" class="btn btn-success fa fa-search" onMouseOver="search()"> Search</button>
														<button type="submit" class="btn btn-info fa fa-print" onMouseOver="print()"> Print</button>
														<script>
															function search() {
																$("#sp").attr({
																	"action": "<?= site_url("tabungan?laporan=OK"); ?>",
																	"target": "_self"
																});
															}

															function print() {
																$("#sp").attr({
																	"action": "<?= site_url("tabunganreport_print"); ?>",
																	"target": "_blank"
																});
															}
														</script>
													</form>
												</div>
											<?php } ?>
											<table id="dataTable" class="table table-condensed table-hover">
												<thead>
													<tr>
														<th>Date</th>
														<th>School</th>
														<th>User</th>
														<th>NISN/NIK</th>
														<th>Remarks</th>
														<th>Amount</th>
														<th>Type</th>
														<?php if (isset($_GET['laporan'])) {
															$colact = "col-md-1";
															$colbtn = "col-md-12";
														} else {
															$colact = "col-md-2";
															$colbtn = "col-md-4";
														} ?>
														<th class="<?= $colact; ?>">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
													if (isset($_POST['from']) && $_POST['from'] != "") {
														$this->db->where("SUBSTR(tabungan_datetime,1,10) >=", $this->input->post("from"));
													}
													if (isset($_POST['to']) && $_POST['to'] != "") {
														$this->db->where("SUBSTR(tabungan_datetime,1,10) <=", $this->input->post("to"));
													}
													if (isset($_POST['type']) && $_POST['type'] != "") {
														$this->db->where("tabungan_type", $this->input->post("type"));
													}
													if ($this->session->userdata("sekolah_id") > 0) {
														$this->db->where("tabungan.sekolah_id", $this->session->userdata("sekolah_id"));
													}

													if ($this->session->userdata("position_id") == 4) {
														$this->db->where("tabungan.user_id", $this->session->userdata("user_id"));
													}

													$usr = $this->db
														->join("sekolah", "sekolah.sekolah_id=tabungan.sekolah_id", "left")
														->join("user", "user.user_nisn=tabungan.user_nisn", "left")->order_by("tabungan_datetime", "desc")
														->get("tabungan");
													//echo $this->db->last_query();
													foreach ($usr->result() as $tabungan) {
														if ($tabungan->user_nisn == "") {
															$back = "background-color:#FEDCC5";
														} else {
															$back = "";
														} ?>
														<tr style="<?= $back; ?>">
															<td><?= $tabungan->tabungan_datetime; ?></td>
															<td><?= $tabungan->sekolah_name; ?></td>
															<td><?= $tabungan->user_name; ?></td>
															<td><?= $tabungan->user_nisn; ?></td>
															<td><?= $tabungan->tabungan_remarks; ?></td>
															<td align="right"><?= number_format($tabungan->tabungan_amount, 0, ",", "."); ?></td>
															<td><?= $tabungan->tabungan_type; ?></td>
															<td style="padding-left:0px; padding-right:0px;" align="center">
																<form target="_blank" action="<?= site_url("tabunganprint"); ?>" method="get" class="<?= $colbtn; ?>" style="padding:0px;">
																	<button type="button" onClick="line('<?= $tabungan->tabungan_id; ?>')" class="btn btn-success btn-xs btn-block" name="print" value="OK"><span class="fa fa-print" style="color:white;"></span> </button>
																	<input type="hidden" name="tabungan_id" value="<?= $tabungan->tabungan_id; ?>" />
																</form>

																<?php if (!isset($_GET['laporan'])) { ?>
																	<form method="post" class="col-md-4" style="padding:0px;">
																		<button class="btn btn-warning  btn-xs btn-block" name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
																		<input type="hidden" name="tabungan_id" value="<?= $tabungan->tabungan_id; ?>" />
																		<?php if ($tabungan->tabungan_type == "Kredit") { ?>
																			<input type="hidden" name="type" value="Kredit" />
																		<?php } else { ?>
																			<input type="hidden" name="type" value="Debet" />
																		<?php } ?>
																	</form>

																	<form method="post" class="col-md-4" style="padding:0px;">
																		<button class="btn btn-danger delete btn-xs btn-block" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
																		<input type="hidden" name="tabungan_id" value="<?= $tabungan->tabungan_id; ?>" />
																	</form>
																<?php } ?>
															</td>
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