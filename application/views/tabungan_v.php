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
					<?php if (!isset($_POST['new']) && !isset($_POST['edit']) && !isset($_GET['laporan']) && $this->session->userdata("position_id") != 4) { ?>
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
															// alert("<?= site_url("api/datasiswa"); ?>?user_nisn="+$("#user_nisn").val()+"&sekolah_id=<?= $this->session->userdata("sekolah_id"); ?>");
															$.get("<?= site_url("api/datasiswa"); ?>", {
																	user_nisn: $("#user_nisn").val(),
																	sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>'
																})
																.done(function(data) {
																	$("#profil").html(data.profil);
																	$("#kelas_id").val(data.kelas_id);
																});
														}
													</script>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-sm-2" for="tabungankode_id">Type:</label>
												<div class="col-sm-10">
													<select tabindex="2" class="form-control" id="tabungankode_id" name="tabungankode_id" placeholder="Notes">
														<option value="0" <?= ($tabungankode_id == "0") ? "selected" : ""; ?>>Choose Type</option>
														<?php
														$tabungankode = $this->db
															->where("tabungankode_type", $tipe)
															->order_by("tabungankode_name")
															->get("tabungankode");
														foreach ($tabungankode->result() as $tabungankode) { ?>
															<option value="<?= $tabungankode->tabungankode_id; ?>" <?= ($tabungankode_id == $tabungankode->tabungankode_id) ? "selected" : ""; ?>><?= $tabungankode->tabungankode_kode; ?> - <?= $tabungankode->tabungankode_name; ?></option>
														<?php } ?>
													</select>
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
											<div class="form-group">
												<label class="control-label col-sm-2" for="tabungan_remarks">Wajib Terisi:</label>
												<div class="col-sm-10">
													<input type="text" required class="form-control" id="kelas_id" name="kelas_id" value="<?= $kelas_id; ?>">
												</div>
											</div>



											<input type="hidden" name="sekolah_id" value="<?= $this->session->userdata("sekolah_id"); ?>" />
											<input type="hidden" name="tabungan_id" value="<?= $tabungan_id; ?>" />
											<input type="hidden" name="user_id" value="<?= $this->session->userdata("user_id"); ?>" />
											<div class="form-group">
												<div class="col-sm-offset-2 col-sm-10">
													<button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
													<?php
													$full_url = current_url() . '?' . $_SERVER['QUERY_STRING'];
													?>
													<a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= $full_url; ?>">Back</a>
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

											<?php if ($this->session->userdata("position_id") != 4) { ?>
												<form id="importn" method="post" class="col-md-12 form well" enctype="multipart/form-data">
													<div class="form-group">
														<label>Import Excel : </label>
														<input class="form-control" name="filesiswa" type="file" />
													</div>
													<div class="form-group">
														<input id="drop" class="" name="drop" type="checkbox" value="1" />
														<label for="drop"> Delete All Transaction</label>
													</div>
													<div class="form-group">
														<button class="btn btn-primary" type="submit" name="import">Import</button>
														<button class="btn btn-danger" type="button" onclick="tutupimport()">Close</button>
													</div>
												</form>
												<?php
												if (isset($_GET["kelas_id"]) && $_GET["kelas_id"] != "") {
													$kelas_id = $_GET["kelas_id"];
												} else {
													$kelas_id = "";
												}
												?>
												<form target="_blank" action="<?= base_url("excel/exceltabungan"); ?>" id="importd" method="get" class="col-md-12 form well form-inline" enctype="multipart/form-data">
													<div class="form-group">
														<label class="control-label " for="kelas_id">Class:</label>
														<select onchange="kelasnamet()" class="form-control" id="kelas_idd" name="kelas_id">
															<option value="" <?= ($kelas_id == "") ? "selected" : ""; ?>>Semua Kelas</option>
															<?php
															$kelas = $this->db->from("kelas")
																->order_by("kelas_name", "ASC")
																->get();
															foreach ($kelas->result() as $row) { ?>
																<option kelas_namet="<?= $row->kelas_name; ?>" value="<?= $row->kelas_id; ?>" <?= ($kelas_id == $row->kelas_id) ? "selected" : ""; ?>><?= $row->kelas_name; ?></option>
															<?php } ?>
														</select>
														<input type="hidden" id="kelas_namet" name="kelas_name" />
														<input type="hidden" name="sekolah_id" value="<?= $this->session->userdata("sekolah_id"); ?>" />
														<script>
															function kelasnamet() {
																let kelas_namet = $("#kelas_idd option:selected").attr("kelas_namet");
																$("#kelas_namet").val(kelas_namet);
															}
														</script>
													</div>
													<button class="btn btn-primary" type="submit" name="import">Download Excel Template</button>
													<button class="btn btn-danger" type="button" onclick="tutupimportd()">Close</button>
												</form>
												<button id="btnimport" class="btn btn-primary" type="button" onclick="bukaimport()">Import From Another Application</button>
												<button id="btntemplatep" class="btn btn-warning" type="button" onclick="printtemplate()"><i class="fa fa-print"></i> Print Template</button>
												<button id="btntemplate" class="btn btn-success" type="button" onclick="bukaimportd()"><i class="fa fa-print"></i> Download Excel Template</button>
												<script>
													function tutupimport() {
														$("#importn").hide();
														$("#btnimport").show();
													}

													function bukaimport() {
														$("#importn").show();
														$("#btnimport").hide();
													}

													function tutupimportd() {
														$("#importd").hide();
														$("#btntemplate").show();
													}

													function bukaimportd() {
														$("#importd").show();
														$("#btntemplate").hide();
														tutupimport();
													}
													tutupimport();
													tutupimportd();

													function downloadtemplate() {
														window.open("<?= base_url("score.xlsx"); ?>", '_self');
													}


													function printtemplate() {
														// window.open("<?= base_url('printtabungan?kosongan=OK'); ?>", '_blank');
														window.open("<?= base_url('printtemplatetabungan'); ?>", '_blank');
													}
												</script>
												<br />
												<br />
											<?php } ?>
											<?php //if ($this->session->userdata("position_id") != 4) { 
											?>
											<div class="col-md-12" style="border:#FDDABB dashed 1px; margin-bottom:30px; padding:10px;">
												<?php
												if (isset($_GET["laporan"])) {
													$url = site_url("tabungan?laporan=OK");
												} else {
													$url = site_url("tabungan");
												}
												?>
												<form id="sp" method="get" class="form-inline" action="<?= $url; ?>">
													<div class="form-group">
														<label for="type">Type:</label>
														<select id="type" name="type" onChange="lihatkelas()">
															<?php if ($this->session->userdata("position_id") == 4) { ?>
																<option value="current" <?= ($this->input->get("type") == "current") ? "selected" : ""; ?>>Current Class</option>
															<?php } else { ?>
																<option value="detail" <?= ($this->input->get("type") == "detail") ? "selected" : ""; ?>>Detail</option>
																<option value="all" <?= ($this->input->get("type") == "all") ? "selected" : ""; ?>>All Class</option>
																<option value="current" <?= ($this->input->get("type") == "current") ? "selected" : ""; ?>>Current Class</option>
																<option value="Debet" <?= ($this->input->get("type") == "Debet") ? "selected" : ""; ?>>Debet</option>
																<option value="Kredit" <?= ($this->input->get("type") == "Kredit") ? "selected" : ""; ?>>Kredit</option>
															<?php } ?>
														</select>
														<script>
															function lihatkelas() {
																var tipe = $("#type").val();
																/* if (tipe == "Kredit") {
																	$("#divkelas").show();
																} else {
																	$("#divkelas").hide();
																} */
																if (tipe != "detail") {
																	// $("#from").val("<?= date("Y-") . substr($this->session->userdata("sekolah_tglajar"), 5); ?>");
																}

																if (tipe == "all") {
																	$(".hideclass").hide();
																} else {
																	$(".hideclass").show();
																}
															}
															$(document).ready(function() {
																lihatkelas();
															});
														</script>
													</div>
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
														<input id="from" name="from" type="date" value="<?= $from; ?>" />
													</div>
													<div class="form-group">
														<label for="from">To:</label>
														<input id="to" name="to" type="date" value="<?= $to; ?>" />
													</div>
													<?php if ($this->session->userdata("position_id") != 4) { ?>
														<div class="form-group hideclass">
															<label for="kelas_id">Class:</label>
															<?php
															if (isset($_GET["kelas_id"])) {
																$kelas_id = $this->input->get("kelas_id");
															} else {
																$kelas_id = 0;
															}
															if (isset($_GET["user_nisn"])) {
																$user_nisn = $this->input->get("user_nisn");
															} else {
																$user_nisn = 0;
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
																<option value="0" <?= ($kelas_id == 0) ? 'selected="selected"' : ""; ?>>Choose Class</option>
																<?php

																foreach ($gru->result() as $kelas) { ?>
																	<option value="<?= $kelas->kelas_id; ?>" <?= ($kelas_id == $kelas->kelas_id) ? 'selected="selected"' : ""; ?>><?= $kelas->kelas_name; ?></option>
																<?php } ?>
															</select>
														</div>

														<script>
															function listsiswasekolah() {
																let kelas_id = $("#kelas_id").val();
																// alert("<?= base_url("api/listsiswakelasb"); ?>?kelas_id="+kelas_id+"&user_nisn=<?= $user_nisn; ?>");
																if (kelas_id > 0) {
																	$.get("<?= base_url("api/listsiswakelasb"); ?>", {
																			kelas_id: kelas_id,
																			user_nisn: '<?= $user_nisn; ?>'
																		})
																		.done(function(data) {
																			$("#user_nisn").html(data);
																		});
																} else {
																	$("#user_nisn").html('');
																}
															}

															listsiswasekolah();
														</script>


														<div class="form-group hideclass">
															<label for="user_nisn">Student:</label>
															<select name="user_nisn" id="user_nisn" class="form-control select">

															</select>
														</div>
													<?php } ?>
													<button name="search" type="submit" class="btn btn-success fa fa-search"> Search</button>
													<!-- <button type="button" class="btn btn-info fa fa-print" onclick="print()"> Print</button>
													<script>
														function print() {
															let type = $("#type").val();
															let from = $("#from").val();
															let to = $("#to").val();
															let kelas_id = $("#kelas_id").val();
															let user_id = $("#user_id").val();
															var url = "<?= site_url("tabunganreport_print"); ?>?type=" + type + "&from=" + from + "&to=" + to + "&kelas_id=" + kelas_id + "&user_id=" + user_id;
															window.open(url, '_blank');
														}
													</script> -->
												</form>
											</div>
											<?php //} 
											?>

											<!-- Detail, Debet, Kredit -->
											<?php if (
												isset($_GET["type"]) &&
												($_GET["type"] == "detail" || $_GET["type"] == "Debet" || $_GET["type"] == "Kredit")
											) { ?>
												<table id="dataTable2" class="table table-condensed table-hover">
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
															<th>Date</th>
															<th>School</th>
															<th>Class</th>
															<th>User</th>
															<th>NISN/NIK</th>
															<th>Remarks</th>
															<th>Amount</th>
															<th>Type</th>
														</tr>
													</thead>
													<tbody>
														<?php
														if (isset($_GET['from']) && $_GET['from'] != "") {
															$from = $this->input->get("from");
														} else {
															$from = date("Y-m-d");
														}
														if (isset($_GET['to']) && $_GET['to'] != "") {
															$to = $this->input->get("to");
														} else {
															$to = date("Y-m-d");
														}

														$this->db->where("SUBSTR(tabungan_datetime,1,10) >=", $from);
														$this->db->where("SUBSTR(tabungan_datetime,1,10) <=", $to);
														if (isset($_GET['type']) && ($_GET['type'] == "Debet" || $_GET['type'] == "Kredit")) {
															$this->db->where("tabungan_type", $this->input->get("type"));
														}
														if ($this->session->userdata("sekolah_id") > 0) {
															$this->db->where("tabungan.sekolah_id", $this->session->userdata("sekolah_id"));
														}

														if (isset($_GET['search']) && $_GET['kelas_id'] > 0) {
															$this->db->where("kelas.kelas_id", $kelas_id);
														}
														if (isset($_GET['search']) && isset($_GET['user_nisn']) && $_GET['user_nisn'] > 0) {
															$this->db->where("user.user_nisn", $_GET['user_nisn']);
														}

														if ($this->session->userdata("position_id") == 4) {
															$this->db->where("tabungan.user_nisn", $this->session->userdata("user_nisn"));
														}

														$usr = $this->db
															->join("sekolah", "sekolah.sekolah_id=tabungan.sekolah_id", "left")
															->join("user", "user.user_nisn=tabungan.user_nisn", "left")
															->join("kelas", "kelas.kelas_id=tabungan.kelas_id", "left")
															->join("tabungankode", "tabungankode.tabungankode_id=tabungan.tabungankode_id", "left")
															->order_by("tabungan_datetime", "desc")
															->get("tabungan");
														// echo $this->db->last_query();
														foreach ($usr->result() as $tabungan) {
															if ($tabungan->user_nisn == "") {
																$back = "background-color:#FEDCC5";
															} else {
																$back = "";
															} ?>
															<tr style="<?= $back; ?>">
																<?php if ($this->session->userdata("position_id") != 4) { ?>
																	<td style="padding-left:0px; padding-right:0px;" align="center">
																		<form title="Print Template" target="_blank" action="<?= base_url('printtabungan'); ?>" method="get" class="<?= $colbtn; ?>" style="padding:0px;">
																			<button type="submit" class="btn btn-info btn-xs btn-block" name="print" value="OK"><span class="fa fa-print" style="color:white;"></span> </button>
																			<input type="hidden" name="user_id" value="<?= $tabungan->user_id; ?>" />
																		</form>
																		<form title="Print Tabungan" target="_blank" action="<?= site_url("tabunganprint"); ?>" method="get" class="<?= $colbtn; ?>" style="padding:0px;">
																			<button type="button" onClick="line('<?= $tabungan->tabungan_id; ?>')" class="btn btn-success btn-xs btn-block" name="print" value="OK"><span class="fa fa-print" style="color:white;"></span> </button>
																			<input type="hidden" name="tabungan_id" value="<?= $tabungan->tabungan_id; ?>" />
																		</form>

																		<?php if (!isset($_GET['laporan'])) { ?>
																			<form method="post" class="<?= $colbtn; ?>" style="padding:0px;">
																				<button class="btn btn-warning  btn-xs btn-block" name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
																				<input type="hidden" name="tabungan_id" value="<?= $tabungan->tabungan_id; ?>" />
																				<?php if ($tabungan->tabungan_type == "Kredit") { ?>
																					<input type="hidden" name="type" value="Kredit" />
																				<?php } else { ?>
																					<input type="hidden" name="type" value="Debet" />
																				<?php } ?>
																			</form>

																			<form method="post" class="<?= $colbtn; ?>" style="padding:0px;">
																				<button class="btn btn-danger delete btn-xs btn-block" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
																				<input type="hidden" name="tabungan_id" value="<?= $tabungan->tabungan_id; ?>" />
																			</form>
																		<?php } ?>
																	</td>
																<?php } ?>
																<td><?= $tabungan->tabungan_datetime; ?></td>
																<td><?= $tabungan->sekolah_name; ?></td>
																<td><?= $tabungan->kelas_name; ?></td>
																<td><?= $tabungan->user_name; ?></td>
																<td><?= $tabungan->user_nisn; ?></td>
																<td><?= $tabungan->tabungan_remarks; ?></td>
																<td align="right"><?= number_format($tabungan->tabungan_amount, 0, ",", "."); ?></td>
																<td><?= $tabungan->tabungankode_kode; ?></td>
															</tr>
														<?php } ?>
													</tbody>
												</table>
											<?php } ?>

											<!-- Current Class -->
											<?php if (
												isset($_GET["type"]) &&
												($_GET["type"] == "current")
											) { ?>
												<table id="dataTable2" class="table table-condensed table-hover">
													<thead>
														<tr>
															<th>School</th>
															<th>Class</th>
															<th>User</th>
															<th>NISN/NIK</th>
															<th>Debet</th>
															<th>Kredit</th>
															<th>Balance</th>
														</tr>
													</thead>
													<tbody>
														<?php
														if (isset($_GET['from']) && $_GET['from'] != "") {
															$from = $this->input->get("from");
														} else {
															$from = date("Y-m-d");
														}
														if (isset($_GET['to']) && $_GET['to'] != "") {
															$to = $this->input->get("to");
														} else {
															$to = date("Y-m-d");
														}

														$this->db->where("SUBSTR(tabungan_datetime,1,10) >=", $from);
														$this->db->where("SUBSTR(tabungan_datetime,1,10) <=", $to);
														if (isset($_GET['type']) && ($_GET['type'] == "Debet" || $_GET['type'] == "Kredit")) {
															$this->db->where("tabungan_type", $this->input->get("type"));
														}
														if ($this->session->userdata("sekolah_id") > 0) {
															$this->db->where("tabungan.sekolah_id", $this->session->userdata("sekolah_id"));
														}

														if (isset($_GET['search']) && isset($_GET['kelas_id']) && $_GET['kelas_id'] > 0) {
															$this->db->where("kelas.kelas_id", $kelas_id);
														}
														if (isset($_GET['search']) && isset($_GET['user_nisn']) && $_GET['user_nisn'] > 0) {
															$this->db->where("user.user_nisn", $_GET['user_nisn']);
														}

														if ($this->session->userdata("position_id") == 4) {
															$this->db->where("tabungan.user_nisn", $this->session->userdata("user_nisn"));
														}

														$usr = $this->db
															->select("user.user_nisn, user.user_name, kelas.kelas_name, sekolah.sekolah_name,
															SUM(CASE WHEN tabungan.tabungan_type = 'debet' THEN tabungan.tabungan_amount ELSE 0 END) AS total_debet,
															SUM(CASE WHEN tabungan.tabungan_type = 'kredit' THEN tabungan.tabungan_amount ELSE 0 END) AS total_kredit,
															(SUM(CASE WHEN tabungan.tabungan_type = 'debet' THEN tabungan.tabungan_amount ELSE 0 END) -
															SUM(CASE WHEN tabungan.tabungan_type = 'kredit' THEN tabungan.tabungan_amount ELSE 0 END)) AS saldo")
															->from("tabungan")
															->join("sekolah", "sekolah.sekolah_id = tabungan.sekolah_id", "left")
															->join("user", "user.user_nisn = tabungan.user_nisn", "left")
															->join("kelas", "kelas.kelas_id = tabungan.kelas_id", "left")
															->join("tabungankode", "tabungankode.tabungankode_id = tabungan.tabungankode_id", "left")
															->group_by("user.user_nisn, user.user_name, kelas.kelas_name, sekolah.sekolah_name") // Mengelompokkan berdasarkan NISN dan nama siswa
															->order_by("tabungan.tabungan_datetime", "desc")
															->get();
														// echo $this->db->last_query();
														foreach ($usr->result() as $tabungan) {
															if ($tabungan->user_nisn == "") {
																$back = "background-color:#FEDCC5";
															} else {
																$back = "";
															} ?>
															<tr style="<?= $back; ?>">
																<td><?= $tabungan->sekolah_name; ?></td>
																<td><?= $tabungan->kelas_name; ?></td>
																<td><?= $tabungan->user_name; ?></td>
																<td><?= $tabungan->user_nisn; ?></td>
																<td align="right"><?= number_format($tabungan->total_debet, 0, ",", "."); ?></td>
																<td align="right"><?= number_format($tabungan->total_kredit, 0, ",", "."); ?></td>
																<td align="right"><?= number_format($tabungan->saldo, 0, ",", "."); ?></td>
															</tr>
														<?php } ?>
													</tbody>
												</table>
											<?php } ?>

											<!-- All -->
											<?php if (
												isset($_GET["type"]) &&
												($_GET["type"] == "all")
											) { ?>
												<table id="dataTable2" class="table table-condensed table-hover">
													<thead>
														<tr>
															<th>School</th>
															<th>Class</th>
															<th>Debet</th>
															<th>Kredit</th>
															<th>Balance</th>
														</tr>
													</thead>
													<tbody>
														<?php
														if (isset($_GET['from']) && $_GET['from'] != "") {
															$from = $this->input->get("from");
														} else {
															$from = date("Y-m-d");
														}
														if (isset($_GET['to']) && $_GET['to'] != "") {
															$to = $this->input->get("to");
														} else {
															$to = date("Y-m-d");
														}

														$this->db->where("SUBSTR(tabungan_datetime,1,10) >=", $from);
														$this->db->where("SUBSTR(tabungan_datetime,1,10) <=", $to);
														if (isset($_GET['type']) && ($_GET['type'] == "Debet" || $_GET['type'] == "Kredit")) {
															$this->db->where("tabungan_type", $this->input->get("type"));
														}
														if ($this->session->userdata("sekolah_id") > 0) {
															$this->db->where("tabungan.sekolah_id", $this->session->userdata("sekolah_id"));
														}

														if (isset($_GET['search']) && $_GET['kelas_id'] > 0) {
															$this->db->where("kelas.kelas_id", $kelas_id);
														}
														if (isset($_GET['search']) && isset($_GET['user_nisn']) && $_GET['user_nisn'] > 0) {
															$this->db->where("user.user_nisn", $_GET['user_nisn']);
														}

														if ($this->session->userdata("position_id") == 4) {
															$this->db->where("tabungan.user_nisn", $this->session->userdata("user_nisn"));
														}

														// Query untuk mendapatkan saldo per kelas
														$usr = $this->db
															->select("kelas.kelas_name,sekolah.sekolah_name, 
															SUM(CASE WHEN tabungan.tabungan_type = 'debet' THEN tabungan.tabungan_amount ELSE 0 END) AS total_debet,
															SUM(CASE WHEN tabungan.tabungan_type = 'kredit' THEN tabungan.tabungan_amount ELSE 0 END) AS total_kredit,
															(SUM(CASE WHEN tabungan.tabungan_type = 'debet' THEN tabungan.tabungan_amount ELSE 0 END) -
															SUM(CASE WHEN tabungan.tabungan_type = 'kredit' THEN tabungan.tabungan_amount ELSE 0 END)) AS saldo")
															->from("tabungan")
															->join("sekolah", "sekolah.sekolah_id = tabungan.sekolah_id", "left")
															->join("kelas", "kelas.kelas_id = tabungan.kelas_id", "left")
															->where("kelas.kelas_name !=", "") // Mengabaikan kelas tanpa nama
															->group_by("kelas.kelas_name, sekolah.sekolah_name") // Mengelompokkan berdasarkan kelas
															->order_by("tabungan.tabungan_datetime", "desc")
															->get();



														// echo $this->db->last_query();
														foreach ($usr->result() as $tabungan) {
														?>
															<tr style="">
																<td><?= $tabungan->sekolah_name; ?></td>
																<td><?= $tabungan->kelas_name; ?></td>
																<td align="right"><?= number_format($tabungan->total_debet, 0, ",", "."); ?></td>
																<td align="right"><?= number_format($tabungan->total_kredit, 0, ",", "."); ?></td>
																<td align="right"><?= number_format($tabungan->saldo, 0, ",", "."); ?></td>
															</tr>
														<?php } ?>
													</tbody>
												</table>
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
	<script>
		$(document).ready(function() {
			$('#dataTable2').DataTable({
				dom: 'Bfrtip',
				buttons: [{
						extend: 'excelHtml5',
						text: 'Export ke Excel',
						className: 'btn btn-success btn-sm',
						exportOptions: {
							columns: ':visible',
							format: {
								body: function(data) {
									// Hapus titik (.) agar Excel tidak salah anggap sebagai koma
									return data.replace(/\./g, '').replace(/\s/g, '');
								}
							}
						}
					},
					{
						extend: 'pdfHtml5',
						text: 'Export ke PDF',
						className: 'btn btn-danger btn-sm',
						orientation: 'landscape',
						pageSize: 'A4',
						exportOptions: {
							columns: ':visible',
							format: {
								body: function(data) {
									// PDF: biarkan titik tetap ada
									return data;
								}
							}
						}
					},
					{
						extend: 'print',
						text: 'Print',
						className: 'btn btn-primary btn-sm',
						exportOptions: {
							columns: ':visible'
						}
					}
				]
			});
		});
	</script>
</body>

</html>