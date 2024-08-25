<!doctype html>
<html>

<head>
	<?php require_once("meta.php"); ?>
	<style>
		.halaman {
			margin-top: 5px !important;
			margin-bottom: 5px !important;
		}
	</style>
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
	?>
	<?php
	if ($s > 0) {
	?>
		<script>
			$(document).ready(function() {
				line('<?= $s; ?>', '<?= $tahun; ?>');
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
		function line(a, tahun) {
			var txt;
			var line = prompt("Enter the line:", "");
			if (line == null || line == "") {
				alert("Line cannot empty");
			} else {
				var win = window.open('<?= site_url("transactionprint?print=OK&transaction_id="); ?>' + a + '&line=' + line + '&transaction_tahun=' + tahun, '_blank');
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
					<li class="active">Transaction</li>
				</ul><!-- /.breadcrumb -->


			</div>
			<div class="page-content">

				<div class="page-header">
					<h1>
						Transaction

					</h1>
					<?php if (!isset($_POST['new']) && !isset($_POST['edit']) && !isset($_GET['laporan'])&&$this->session->userdata("position_id") != 4) { ?>

						<form method="post" class="col-md-2" style="margin-top:-30px; float:right;">

							<button name="new" class="btn btn-warning btn-block btn-sm fa fa-unlink" value="OK" style=""> Bill</button>
							<input type="hidden" name="transaction_id" />
							<input type="hidden" name="type" value="Kredit" />

						</form>

						<form method="post" class="col-md-2" style="margin-top:-30px; float:right;">

							<button name="new" class="btn btn-success btn-block btn-sm fa fa-money" value="OK" style=""> Payment</button>
							<input type="hidden" name="transaction_id" />
							<input type="hidden" name="type" value="Debet" />

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
											$judul = "Update Transaction";
										} else {
											$namabutton = 'name="create"';
											$judul = "New Transaction";
										} ?>
										<div class="lead">
											<h3><?= $judul; ?></h3>
										</div>
										<form class="form-horizontal" method="post" enctype="multipart/form-data">
											<?php if ($this->input->post("type") == "Kredit") { ?>
												<div class="form-group">
													<label class="control-label col-sm-2" for="user_nik">NIK:</label>
													<div class="col-sm-10">
														<input type="text" class="form-control" id="user_nik" name="user_nik" placeholder="Enter NIK" value="<?= $this->session->userdata("user_nik"); ?>" required readonly="">
														<input type="hidden" class="form-control" id="transaction_type" name="transaction_type" placeholder="Enter Type" value="Kredit">
													</div>
												</div>

												<!-- <div class="form-group">
                                        <label class="control-label col-sm-2" for="kelas_id">Kelas:</label>
                                        <div class="col-sm-10">
                                          <select tabindex="2" type="kelas_id" class="form-control" id="kelas_id" name="kelas_id">
											  <option value="0">Semua</option>
											  <?php
												$where["sekolah_id"] = $this->session->userdata("sekolah_id");
												$kelas = $this->db
													->join("kelas", "kelas.kelas_id=kelas_sekolah.kelas_id", "left")
													->get("kelas_sekolah");
												foreach ($kelas->result() as $kelas) { ?>
											  <option value="<?= $kelas->kelas_id; ?>" <?= ($kelas_id == $kelas->kelas_id) ? "selected" : ""; ?>>
												<?= $kelas->kelas_name; ?>
											  </option>
											  <?php } ?>
										  </select>
                                        </div>							  
                                    </div> -->
												<div class="form-group">
													<label class="control-label col-sm-2" for="transaction_tahun">Tahun Ajaran Masuk:</label>
													<div class="col-sm-10">
														<select tabindex="2" type="transaction_tahun" class="form-control" id="transaction_tahun" name="transaction_tahun">
															<option value="<?= date("Y"); ?>" <?= ($transaction_tahun == "") ? "selected" : ""; ?>>Tahun Ini (<?= date("Y"); ?>)</option>
															<?php
															for ($x = (date("Y") - 5); $x <= date("Y"); $x++) { ?>
																<option value="<?= $x; ?>" <?= ($transaction_tahun == $x) ? "selected" : ""; ?>>
																	<?= $x; ?>
																</option>
															<?php } ?>
														</select>
													</div>
												</div>
											<?php } else { ?>
												<div class="form-group">
													<label class="control-label col-sm-2" for="user_nisn">NISN:</label>
													<div class="col-sm-10">
														<input autofocus type="text" class="form-control" id="user_nisn" name="user_nisn" placeholder="Enter NISN" value="<?= $user_nisn; ?>" required>
														<input type="hidden" class="form-control" id="transaction_type" name="transaction_type" placeholder="Enter Type" value="Debet">
														<div id="profil" style="color:#000066;"></div>
														<script>
															function profil() {
																// alert('<?= site_url("api/datasiswahutang"); ?>?user_nisn='+$("#user_nisn").val()+'&sekolah_id='+<?= $this->session->userdata("sekolah_id"); ?>);
																$.get("<?= site_url("api/datasiswahutang"); ?>", {
																		user_nisn: $("#user_nisn").val(),
																		sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>'
																	})
																	.done(function(data) {
																		$("#profil").html(data.message);
																		let user_tahunajaran = data.user_tahunajaran;
																		cektagihan(user_tahunajaran);
																		$("#kelas_id").val(data.kelas_id);
																	});
															}
														</script>
													</div>
												</div>
											<?php } ?>

											<div class="form-group">
												<label class="control-label col-sm-2" for="transaction_tahun">Tahun Ajaran Masuk:</label>
												<div class="col-sm-10">
													<input readonly type="text" class="form-control" id="transaction_tahun" name="transaction_tahun" placeholder="Enter NISN" value="<?= $transaction_tahun; ?>" required>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-sm-2" for="transaction_name">Transaction Name:</label>
												<div class="col-sm-10">
													<input tabindex="2" type="text" readonly class="form-control" id="transaction_name" name="transaction_name" placeholder="Enter Transaction Name" value="<?= $transaction_name; ?>">
													<input id="transaction_bill" name="transaction_bill" value="<?= $transaction_bill; ?>" type="hidden">
													<div id="tagihan" style="color:#000066;"></div>
													<script>
														function cektagihan(user_tahunajaran) {
															// alert("<?= site_url("api/datatagihan"); ?>?user_nisn="+$("#user_nisn").val()+"&sekolah_id=<?= $this->session->userdata("sekolah_id"); ?>&user_tahunajaran="+user_tahunajaran);
															$.get("<?= site_url("api/datatagihan"); ?>", {
																	user_nisn: $("#user_nisn").val(),
																	sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>',
																	user_tahunajaran: user_tahunajaran
																})
																.done(function(data) {
																	$("#tagihan").html(data.tagihan);
																});
														}

														function inputtagihan(id, name, tahunajaran, amount, amountnumber) {
															$("#transaction_bill").val(id);
															$("#transaction_name").val(name);
															$("#transaction_tahun").val(tahunajaran);
															$("#transaction_amount").val(amount);
															$("#uang").text(amountnumber);
														}
													</script>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-2" for="transaction_amount">Amount:</label>
												<div class="col-sm-10">
													<input readonly tabindex="3" onKeyUp="uang(this)" type="number" class="form-control" id="transaction_amount" name="transaction_amount" placeholder="Enter Amount" value="<?= $transaction_amount; ?>" required min="1">
													<div style="color:#BB0000; font-weight:bold; margin-top:5px;">Rp <span id="uang"><?= number_format($transaction_amount, 0, ",", "."); ?></span></div>

												</div>
											</div>




											<input type="hidden" id="kelas_id" name="kelas_id" value="<?= $kelas_id; ?>">
											<input type="hidden" name="sekolah_id" value="<?= $this->session->userdata("sekolah_id"); ?>" />
											<input type="hidden" name="transaction_id" value="<?= $transaction_id; ?>" />
											<div class="form-group">
												<div class="col-sm-offset-2 col-sm-10">
													<button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
													<a class="btn btn-warning col-md-offset-1 col-md-5" href="<?= site_url("transaction"); ?>">Back</a>
												</div>
											</div>
										</form>
									</div>
								<?php } else { ?>
									<?php if ($message != "") { ?>
										<div class="alert alert-info alert-dismissable">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
											<strong><?= $message; ?></strong><br /><?= $uploadtransaction_picture; ?>
										</div>
									<?php } ?>
									<div class="box">
										<div id="collapse4" class="body table-responsive">
											<?php //if(isset($_GET['laporan'])){
											?>
											<div class="col-md-12" style="border:#FDDABB dashed 1px; margin-bottom:30px; padding:10px;">
												<form id="sp" method="get" target="_blank" class="form-inline" action="<?= site_url("transactionreport_print"); ?>">
													<div class="form-group">
														<label for="type">Type:</label>
														<select id="type" name="type" onChange="lihatkelas()">
															<option value="">All</option>
															<option value="Debet" <?= ($this->input->get("type") == "Debet") ? "selected" : ""; ?>>Debet</option>
															<option value="Kredit" <?= ($this->input->get("type") == "Kredit") ? "selected" : ""; ?>>Kredit</option>
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
													<?php if (isset($_POST['type']) && $_POST['type'] == "Kredit") {
														$display = "display:inline;";
													} else {
														$display = "display:none;";
													} ?>
													<div class="form-group" style="<?= $display; ?>" id="divkelas">
														<label for="kelas">Class:</label>
														<select id="kelas" name="kelas">
															<option value="" <?= ($this->input->get("kelas") == "") ? "selected" : ""; ?>>All</option>
															<?php $kelas = $this->db
																->join("kelas", "kelas.kelas_id=kelas_sekolah.kelas_id", "left")
																->where("kelas_sekolah.sekolah_id", $this->session->userdata("sekolah_id"))
																->get("kelas_sekolah");
															foreach ($kelas->result() as $kelas) { ?>
																<option value="<?= $kelas->kelas_id; ?>" <?= ($this->input->get("kelas") == $kelas->kelas_id) ? "selected" : ""; ?>><?= $kelas->kelas_name; ?></option>
															<?php } ?>
														</select>
													</div>

													<div class="form-group">
														<label for="from">From:</label>
														<input id="from" name="from" type="date" value="<?= $from; ?>" />
													</div>
													<div class="form-group">
														<label for="to">To:</label>
														<input id="to" name="to" type="date" value="<?= $to; ?>" />
													</div>
													<div class="form-group">
														<label for="nisn">NISN:</label>
														<input id="nisn" name="nisn" type="text" value="<?= $this->input->get("nisn"); ?>" />
													</div>
													<div class="form-group">
														<label for="nama">Nama:</label>
														<input id="nama" name="nama" type="text" value="<?= $this->input->get("nama"); ?>" />
													</div>
													<!--  <button type="submit" class="btn btn-success fa fa-search" onMouseOver="search()"> Search</button> -->
													<?php if (isset($_GET["laporan"])) { ?>
														<input type="hidden" name="laporan" value="<?= $_GET["laporan"]; ?>" />
													<?php } ?>
													<button type="submit" class="btn btn-success fa fa-search" onMouseOver="searchnormal()"> Search</button>
													<button type="submit" class="btn btn-info fa fa-print" onMouseOver="print()"> Print</button>
													<script>
														function search() {
															$("#sp").attr({
																"action": "<?= site_url("transaction?laporan=OK"); ?>",
																"target": "_self"
															});
														}

														function searchnormal() {
															$("#sp").attr({
																"action": "<?= site_url("transaction"); ?>",
																"target": "_self"
															});
														}

														function print() {
															$("#sp").attr({
																"action": "<?= site_url("transactionreport_print"); ?>",
																"target": "_blank"
															});
														}
													</script>
												</form>
											</div>
											<?php //}
											?>
											<?php
											if (isset($_GET['nisn']) && $_GET['nisn'] != "") {
												$this->db->where("transaction.user_nisn", $this->input->get("nisn"));
											}
											if (isset($_GET['nama']) && $_GET['nama'] != "") {
												$this->db->like("user_name", $this->input->get("nama"), "both");
											}
											$this->db->where("SUBSTR(transaction_datetime,1,10) >=", $from);
											$this->db->where("SUBSTR(transaction_datetime,1,10) <=", $to);
											if (isset($_GET['type']) && $_GET['type'] != "") {
												$this->db->where("transaction_type", $this->input->get("type"));
											}
											if (isset($_GET['kelas']) && $_GET['kelas'] != "" && isset($_GET['type']) && $_GET['type'] != "Debet") {
												$this->db->where("transaction.kelas_id", $this->input->get("kelas"));
											}
											if ($this->session->userdata("sekolah_id") > 0) {
												$this->db->where("transaction.sekolah_id", $this->session->userdata("sekolah_id"));
											}
											if ($this->session->userdata("position_id") == 4) {
												$this->db->where("transaction.user_nisn", $this->session->userdata("user_nisn"));
												$this->db->or_where("transaction.transaction_type", "Kredit");
											}

											$halaman = 200; //batasan halaman
											$page = isset($_GET['halaman']) ? (int)$_GET["halaman"] : 1;
											$mulai = ($page > 1) ? ($page * $halaman) - $halaman : 0;
											$totalhalaman = $this->db
												->join("sekolah", "sekolah.sekolah_id=transaction.sekolah_id", "left")
												->join("user", "user.user_nik=transaction.`user_nik` AND user.user_nisn=transaction.user_nisn", "left")
												->order_by("transaction_datetime", "desc")
												// ->limit($halaman,$mulai)
												->get("transaction");
											// echo $this->db->last_query();
											$total = $totalhalaman->num_rows();
											$pages = ceil($total / $halaman);
											if (isset($_GET["type"])) {
												$type = $_GET["type"];
											} else {
												$type = "";
											}
											if (isset($_GET["kelas"])) {
												$kelas = $_GET["kelas"];
											} else {
												$kelas = "";
											}
											/* if (isset($_GET["from"])) {
												$from = $_GET["from"];
											} else {
												$from = "";
											}
											if (isset($_GET["to"])) {
												$to = $_GET["to"];
											} else {
												$to = "";
											} */
											if (isset($_GET["nisn"])) {
												$nisn = $_GET["nisn"];
											} else {
												$nisn = "";
											}
											if (isset($_GET["nama"])) {
												$nama = $_GET["nama"];
											} else {
												$nama = "";
											}
											$url = "?type=" . $type . "&kelas=" . $kelas . "&from=" . $from . "&to=" . $to . "&nisn=" . $nisn . "&nama=" . $nama;
											for ($i = 1; $i <= $pages; $i++) { ?>
												<a class="btn btn-xs btn-default halaman" href="<?= $url; ?>&halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
											<?php } ?>
											<table id="dataTabletransaksi" class="table table-condensed table-hover">
												<thead>
													<tr>
														<?php if (isset($_GET['laporan'])) {
															$colact = "col-md-1";
															$colbtn = "col-md-12";
														} else {
															$colact = "col-md-2";
															$colbtn = "col-md-4";
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
														<th>Transaction Name</th>
														<th>Amount</th>
														<th>Type/<br />Thn.Ajaran</th>
													</tr>
												</thead>
												<tbody>
													<?php
													if (isset($_GET['nisn']) && $_GET['nisn'] != "") {
														$this->db->where("transaction.user_nisn", $this->input->get("nisn"));
													}
													if (isset($_GET['nama']) && $_GET['nama'] != "") {
														$this->db->like("user_name", $this->input->get("nama"), "both");
													}

													$this->db->where("SUBSTR(transaction_datetime,1,10) >=", $from);
													$this->db->where("SUBSTR(transaction_datetime,1,10) <=", $to);

													if (isset($_GET['type']) && $_GET['type'] != "") {
														$this->db->where("transaction_type", $this->input->get("type"));
													}
													if (isset($_GET['kelas']) && $_GET['kelas'] != "" && isset($_GET['type']) && $_GET['type'] != "Debet") {
														$this->db->where("transaction.kelas_id", $this->input->get("kelas"));
													}
													if ($this->session->userdata("sekolah_id") > 0) {
														$this->db->where("transaction.sekolah_id", $this->session->userdata("sekolah_id"));
													}
													if ($this->session->userdata("position_id") == 4) {
														$this->db->where("transaction.user_nisn", $this->session->userdata("user_nisn"));
														$this->db
															->or_where('transaction.transaction_type', 'Kredit')
															->where('transaction.transaction_tahun', '2022');
													}
													$usr = $this->db
														->join("sekolah", "sekolah.sekolah_id=transaction.sekolah_id", "left")
														->join("(SELECT user_nisn as nisn, user_name as siswa FROM user)AS usersiswa", "usersiswa.nisn=transaction.user_nisn AND transaction.transaction_type='Debet'", "left")
														->join("(SELECT user_name as guru, user_nik as nik FROM user)AS userguru", "userguru.nik=transaction.user_nik AND transaction.transaction_type='Kredit'", "left")
														->join("kelas", "kelas.kelas_id=transaction.kelas_id", "left")
														->order_by("transaction_datetime", "desc")
														->limit($halaman, $mulai)
														->get("transaction");
													// echo $this->db->last_query();
													foreach ($usr->result() as $transaction) {
														if ($transaction->user_nisn == "") {
															$back = "background-color:#FEDCC5";
														} else {
															$back = "";
														}
														$tahunajaran = $transaction->transaction_tahun;
														if ($transaction->transaction_type == "Kredit") {
															$user_name = $transaction->guru . " (Guru)";
															$niknisn = $transaction->user_nik;
														} else {
															$user_name = $transaction->siswa . " (Siswa)";
															$niknisn = $transaction->user_nisn;
														}
													?>
														<tr style="<?= $back; ?>">
															<?php
															if ($this->session->userdata("position_id") != 4) { ?>
																<td style="padding-left:0px; padding-right:0px;" align="center">
																	<?php if ($transaction->transaction_type == "Debet") { ?>
																		<form target="_blank" action="<?= site_url("transactionprint"); ?>" method="get" class="<?= $colbtn; ?>" style="padding:0px;">
																			<button type="button" onClick="line('<?= $transaction->transaction_id; ?>','<?= $tahunajaran; ?>')" class="btn btn-success btn-xs btn-block" name="print" value="OK"><span class="fa fa-print" style="color:white;"></span> </button>
																			<input type="hidden" name="transaction_id" value="<?= $transaction->transaction_id; ?>" />
																		</form>
																	<?php $longkap = "";
																	} else {
																		$longkap = "col-md-offset-4";
																	} ?>
																	<?php if (!isset($_GET['laporan'])) { ?>
																		<form method="post" class="<?= $longkap; ?> col-md-4" style="padding:0px;">
																			<button class="btn btn-warning  btn-xs btn-block" name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
																			<input type="hidden" name="transaction_id" value="<?= $transaction->transaction_id; ?>" />
																			<?php if ($transaction->transaction_type == "Kredit") { ?>
																				<input type="hidden" name="type" value="Kredit" />
																			<?php } else { ?>
																				<input type="hidden" name="type" value="Debet" />
																			<?php } ?>
																		</form>

																		<form method="post" class="col-md-4" style="padding:0px;">
																			<button class="btn btn-danger delete btn-xs btn-block" name="delete" value="OK" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-close" style="color:white;"></span> </button>
																			<input type="hidden" name="transaction_id" value="<?= $transaction->transaction_id; ?>" />
																		</form>
																	<?php } ?>
																</td>
															<?php } ?>
															<td><?= $transaction->transaction_datetime; ?></td>
															<td><?= $transaction->sekolah_name; ?></td>
															<td><?= $transaction->kelas_name; ?></td>
															<td><?= $user_name; ?></td>
															<td><?= $niknisn; ?></td>
															<td><?= $transaction->transaction_name; ?></td>
															<td align="right">
																<?= number_format($transaction->transaction_amount, 0, ",", "."); ?>
															</td>
															<td>
																<?= $transaction->transaction_type; ?><br />(<?= $tahunajaran; ?>)
															</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
											<?php
											for ($i = 1; $i <= $pages; $i++) { ?>
												<a class="btn btn-xs btn-default halaman" href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
											<?php } ?>
											<script>
												$(document).ready(function() {
													$('#dataTabletransaksi').DataTable({
														dom: 'Bfrtip',
														buttons: [{
																extend: 'pdf',
																className: 'btn-danger text-white'
															},
															{
																extend: 'print',
																className: 'btn-warning text-white'
															},
															{
																extend: 'excel',
																className: 'btn-success text-white'
															}
														],
														"order": [
															[0, 'desc']
														],
														"lengthMenu": [
															[200, "All", 100, 50, 25],
															[200, "All", 100, 50, 25]
														]
													});
												});
											</script>
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