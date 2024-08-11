<!doctype html>
<html>

<head>
	<?php
	require_once("meta.php"); ?>
	<style>
		.materi {
			border-radius: 5px;
			border: #FFCCCC solid 3px !important;
			background-color: #EDE2EF !important;
			color: #000 !important;
			padding: 10px;
			margin-bottom: 5px;
		}

		.materi:hover {
			border: #FFCCCC solid 3px !important;
			background-color: #BB93C8 !important;
			color: #000 !important;
			text-decoration: none;
		}

		.umateri {
			border-radius: 5px;
			border: #EBEBEB solid 3px !important;
			background-color: #CCCCCC !important;
			color: #000 !important;
			padding: 10px;
			margin-bottom: 5px;
		}

		.umateri:hover {
			border: #EBEBEB solid 3px !important;
			background-color: #666666 !important;
			color: #FFF !important;
			text-decoration: none;
		}

		.action {
			position: absolute;
			left: -11px;
			bottom: 0px;
			height: 35%;
			text-align: right;
		}

		.displaynone {
			display: none;
		}

		.displayinline {
			display: block;
		}

		.belummulai {
			border-radius: 5px;
			border: #FFCCCC solid 3px !important;
			background-color: #EBEBEB !important;
			color: #999999 !important;
			padding: 10px;
			margin-bottom: 5px;
		}

		.belummulai:hover {
			border: #FFCCCC solid 3px !important;
			background-color: #D6D6D6 !important;
			color: #999999 !important;
			text-decoration: none;
		}

		.mulai {
			border-radius: 5px;
			border: #FFCCCC solid 3px !important;
			background-color: #EDE2EF !important;
			color: #000 !important;
			padding: 10px;
			margin-bottom: 5px;
		}

		.mulai:hover {
			border: #FFCCCC solid 3px !important;
			background-color: #BB93C8 !important;
			color: #000 !important;
			text-decoration: none;
		}

		.selesai {
			border-radius: 5px;
			border: #EBEBEB solid 3px !important;
			background-color: #CCCCCC !important;
			color: #000 !important;
			padding: 10px;
			margin-bottom: 5px;
		}

		.selesai:hover {
			border: #EBEBEB solid 3px !important;
			background-color: #666666 !important;
			color: #FFF !important;
			text-decoration: none;
		}
	</style>
	<script>
		$(document).ready(function() {
			<?php if ($soal_status == 2) { ?>
				$(".jawabannya").css("background-color", "pink");
			<?php } ?>

			<?php
			if ($this->session->userdata("position_id") != "4") {
			?>
				$.get("<?= site_url("api/update_refresh"); ?>", {
						position_id: '4',
						refresh_status: '1'
					})
					.done(function(data) {});
			<?php } ?>
		});
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
					<li class="active">Lesson and Test</li>
				</ul><!-- /.breadcrumb -->


			</div>
			<div class="page-content">

				<div class="page-header">
					<div class="col-md-11 col-sm-12 col-xs-12" style="font-size:18px; font-weight:bold;">
						Lesson : <?= $materi_title; ?>
					</div>
					<?php if (!isset($_POST['new']) && !isset($_POST['edit']) && $this->session->userdata("position") != "4") { ?>
						<form method="post" class="col-md-1 col-sm-12 col-xs-12" style="">

							<a href="<?= site_url("materi?grup_id=" . $this->input->get("grup_id")); ?>" class="btn btn-warning btn-block btn-sm fa fa-mail-reply"> Back</a>

						</form>
					<?php } ?>
				</div>

				<div class="row">
					<div class="col-xs-12 col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-body">
								<?php if (isset($_POST['new']) || isset($_POST['edit'])) { ?>
									<?php if ($this->session->userdata("sekolah_id") != "0") { ?>
										<div id="soalinternet" style="margin-top:20px;"></div>
										<script>
											$("#loading").show();
											$.get("<?= $identity->identity_server; ?>/api/tampil_soal", {
													sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>',
													materi_id: '<?= $materi_server; ?>'
												})
												.done(function(data) {
													$("#soalinternet").html(data);
													$("#loading").hide();
												});
										</script>
										<script>
											function masukin_soal(a, b, c, d, e, f, g, h) {
												$.get("<?= site_url("api/masukin_soal"); ?>", {
														soal_question: $("#soal_question" + a).html(),
														soal_solution: $("#soal_solution" + a).html(),
														soal_answer1: b,
														soal_answer2: c,
														soal_answer3: d,
														soal_answer4: e,
														soal_picture: f,
														soal_key: g,
														sekolah_id: h,
														materi_id: '<?= $materi_id; ?>'
													})
													.done(function(data) {
														window.location.href = window.location.href;
													});
											}
										</script>
									<?php } else { ?>
										<div class="">
											<?php if (isset($_POST['edit'])) {
												$namabutton = 'name="change"';
												$judul = "Update Question";
											} else {
												$namabutton = 'name="create"';
												$judul = "New Question";
											} ?>
											<div class="lead">
												<h3><?= $judul; ?></h3>
											</div>
											<form class="form-horizontal" method="post" enctype="multipart/form-data">
												<div class="form-group">
													<label class="control-label col-sm-2" for="soal_picture">Picture:</label>
													<div class="col-sm-10">
														<input type="file" id="soal_picture" name="soal_picture"><br />
														<?php if ($soal_picture != "") {
															$soal_image = "assets/images/soal_picture/" . $soal_picture;
														} else {
															$soal_image = "assets/images/soal_picture/soal.gif";
														} ?>
														<img id="soal_picture_image" width="100" height="100" src="<?= base_url($soal_image); ?>" />
														<script>
															function readURL(input) {
																if (input.files && input.files[0]) {
																	var reader = new FileReader();

																	reader.onload = function(e) {
																		$('#soal_picture_image').attr('src', e.target.result);
																	}

																	reader.readAsDataURL(input.files[0]);
																}
															}

															$("#soal_picture").change(function() {
																readURL(this);
															});
														</script>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for="soal_question">Question:</label>
													<div class="col-sm-10">
														<textarea id="soal_question" name="soal_question"><?= $soal_question; ?></textarea>
														<script>
															var roxyFileman = '<?= site_url("fileman/index.html"); ?>';
															CKEDITOR.replace(
																'soal_question', {
																	filebrowserBrowseUrl: roxyFileman,
																	filebrowserImageBrowseUrl: roxyFileman + '?type=image',
																	removeDialogTabs: 'link:upload;image:upload',
																	height: '100px',
																	stylesSet: 'my_custom_style'
																}
															);
														</script>

													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for="soal_solution">Solution:</label>
													<div class="col-sm-10">
														<textarea id="soal_solution" name="soal_solution"><?= $soal_solution; ?></textarea>
														<script>
															var roxyFileman = '<?= site_url("fileman/index.html"); ?>';
															CKEDITOR.replace(
																'soal_solution', {
																	filebrowserBrowseUrl: roxyFileman,
																	filebrowserImageBrowseUrl: roxyFileman + '?type=image',
																	removeDialogTabs: 'link:upload;image:upload',
																	height: '100px',
																	stylesSet: 'my_custom_style'
																}
															);
														</script>
													</div>
												</div>
												<hr />
												<h3>Answer</h3>
												<div class="form-group">
													<label class="control-label col-sm-2" for="soal_answer1">A:
														<input <?= ($soal_key == "A") ? 'checked="checked"' : ""; ?> type="radio" name="soal_key" id="A" value="A" />
													</label>
													<div class="col-sm-10">
														<input type="text" class="form-control" id="soal_answer1" name="soal_answer1" value="<?= $soal_answer1; ?>">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for="soal_answer2">B:
														<input <?= ($soal_key == "B") ? 'checked="checked"' : ""; ?> type="radio" name="soal_key" id="B" value="B" />
													</label>
													<div class="col-sm-10">
														<input type="text" class="form-control" id="soal_answer2" name="soal_answer2" value="<?= $soal_answer2; ?>">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for="soal_answer3">C:
														<input <?= ($soal_key == "C") ? 'checked="checked"' : ""; ?> type="radio" name="soal_key" id="C" value="C" />
													</label>
													<div class="col-sm-10">
														<input type="text" class="form-control" id="soal_answer3" name="soal_answer3" value="<?= $soal_answer3; ?>">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for="soal_answer4">D:
														<input <?= ($soal_key == "D") ? 'checked="checked"' : ""; ?> type="radio" name="soal_key" id="D" value="D" />
													</label>
													<div class="col-sm-10">
														<input type="text" class="form-control" id="soal_answer4" name="soal_answer4" value="<?= $soal_answer4; ?>">
													</div>
												</div>



												<input type="hidden" name="sekolah_id" value="<?= $this->session->userdata("sekolah_id"); ?>" />
												<input type="hidden" name="materi_id" value="<?= $materi_id; ?>" />
												<input type="hidden" name="soal_id" value="<?= $soal_id; ?>" />
												<div class="form-group">
													<div class="col-sm-offset-2 col-sm-10">
														<button type="submit" id="submit" class="btn btn-primary col-md-5" <?= $namabutton; ?> value="OK">Submit</button>
														<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?= site_url("user"); ?>">Back</button>
													</div>
												</div>
											</form>
										</div>
									<?php } ?>
								<?php } else { ?>
									<?php if ($message != "") { ?>
										<div class="alert alert-info alert-dismissable">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
											<strong><?= $message; ?></strong>
										</div>
									<?php } ?>
									<?php

									if ($this->session->userdata("sekolah_id") > 0) {
										$this->db->where("sekolah_id", $this->session->userdata("sekolah_id"));
									}

									$mate = $this->db
										->where("materi_id", $materi_id)
										->get("materi");
									//echo $this->db->last_query();
									foreach ($mate->result() as $materi) { ?>


										<div class="panel panel-info">
											<div class="panel-heading">
												<h3><?= $materi->materi_title; ?>
													<?php
													$where["materi_id"] = $materi_id;
													$jumlahsoal = $this->db->get_where("soal", $where)->num_rows();

													$nil = $this->db
														->select("test_detail.*,soal.soal_key as jwb")
														->join("soal", "soal.soal_id=test_detail.soal_id", "left")
														->where("test_detail.sekolah_id", $this->session->userdata("sekolah_id"))
														->where("test_detail.user_id", $this->session->userdata("user_id"))
														->where("test_detail.materi_id", $materi_id)
														->get("test_detail");
													$tnilai = 0;
													// echo $this->db->last_query();
													foreach ($nil->result() as $nilai) {
														if ($nilai->jwb == $nilai->test_detail_answer) {
															$tnilai++;
														}
													}
													if ($jumlahsoal > 0) {
														$nilai_akhir = $tnilai / $jumlahsoal * 100;
													} else {
														$nilai_akhir = 0;
													}
													if ($nilai_akhir < 50) {
														$alert = "alert alert-danger";
													} elseif ($nilai_akhir >= 50 && $nilai_akhir < 80) {
														$alert = "alert alert-warning";
													} else {
														$alert = "alert alert-success";
													}
													?>
													<span id="alert_nilai" style="float:right;" class="<?= $alert; ?>">Value : <?= $nilai_akhir; ?></span>
												</h3>
											</div>
											<div class="panel-body">
												<?= $materi->materi_content; ?>

												<?php
												if ($materi->soal_publish == 0) {
													$faeye = "fa-eye-slash";
													$btn = "btn-default";
													$title = "Unpublish";
													$matr = "umateri";
													$disabled = "disabled";
													$sembunyi = "displayinline";
												} else {
													$faeye = "fa-eye";
													$btn = "btn-success";
													$title = "Publish";
													if ($materi->soal_status == 0) {
														$matr = "belummulai";
														$disabled = "disabled";
														$sembunyi = "displaynone";
													}
													if ($materi->soal_status == 1) {
														$matr = "mulai";
														$disabled = "";
														$sembunyi = "displaynone";
													}
													if ($materi->soal_status == 2) {
														$matr = "selesai";
														$disabled = "disabled";
														$sembunyi = "displayinline";
													}
												}

												if ($this->session->userdata("position_id") == 4) {
													if ($materi->soal_publish == 0) {
														$display = "displaynone";
													} else {
														$display = "displayinline";
													}
												} else {
													$display = "";
												}
												?>

												<?php if ($this->session->userdata("position_id") != 4) { ?>
													<div class="col-md-12" style="padding:0px; margin-top:20px; margin-bottom:20px;">
														<form method="post" class="col-md-2 col-sm-12 col-xs-12" style="padding:0px;">

															<button name="new" class="btn btn-info btn-block fa fa-bullseye col-md-12 col-sm-12 col-xs-12" value="OK" style=""> New Question</button>
															<input type="hidden" name="user_id" />

														</form>
														<form method="post" class="col-md-2 col-sm-12 col-xs-12" style="padding:0px;">
															<?php
															if ($materi->soal_publish != 0) {
															?>
																<script>
																	$(document).ready(function() {
																		noltest();
																	});
																</script>
															<?php
															}
															?>

															<button type="button" onClick="publishsoal('<?= $materi->materi_id; ?>',this.value,'<?= $materi->soal_status; ?>')" data-toggle="tooltip" title="<?= $title; ?>" class="btn <?= $btn; ?> fa <?= $faeye; ?>   col-md-12 col-sm-12 col-xs-12" id="soal_publish<?= $materi->materi_id; ?>" name="publish" value="<?= $materi->soal_publish; ?>"> <?= $title; ?></button>

														</form>
														<div class="col-md-1 col-sm-12 col-xs-12">&nbsp;</div>
														<?php
														if ($materi->soal_publish == 0) {
															$displaybtn = "displaynone";
														} else {
															$displaybtn = "displayinline";
														}
														?>
														<button onClick="status('<?= $materi->materi_id; ?>','0')" data-toggle="tooltip" title="Not Started Yet" class="btn btn-default fa fa-eye-slash col-md-2 col-sm-12 col-xs-12 <?= $displaybtn; ?> status" id="belummulai" name="status" value="0"> Not Started Yet</button>

														<button onClick="status('<?= $materi->materi_id; ?>','1')" data-toggle="tooltip" title="Start" class="btn btn-warning fa fa-check col-md-2 col-sm-12 col-xs-12 <?= $displaybtn; ?> status" id="belummulai" name="status" value="0"> Start</button>

														<button onClick="status('<?= $materi->materi_id; ?>','2')" data-toggle="tooltip" title="Done" class="btn btn-primary fa fa-remove col-md-2 col-sm-12 col-xs-12  <?= $displaybtn; ?> status" id="belummulai" name="status" value="0"> Done</button>

													</div>
												<?php } ?>

												<div id="soalnya">
													<?php
													$soa = $this->db
														->select("soal.*, test_detail.user_id,test_detail.test_detail_answer")
														->join("(SELECT * FROM test_detail WHERE user_id='" . $this->session->userdata("user_id") . "')AS test_detail", "test_detail.soal_id=soal.soal_id", "left")
														->where("soal.materi_id", $materi_id)
														//->where("test_detail.user_id IS NULL")
														->order_by('soal_id', 'RANDOM')
														->get("soal");
													//echo $this->db->last_query();
													$no = 1;
													foreach ($soa->result() as $soal) {
													?>
														<div class="soal <?= $matr; ?> <?= $display; ?> col-md-12 col-sm-12 col-xs-12" style="clear:both;">
															<?= $no; ?>. <?= $soal->soal_question; ?>
															<?php if ($soal->soal_picture != "") {
																$soal_image = "assets/images/soal_picture/" . $soal->soal_picture; ?>
																<br />
																<img style="cursor:pointer;" onClick="modalimage(this)" id="soal_picture_image" width="100" height="100" src="<?= base_url($soal_image); ?>" />

															<?php } ?>
															<br />
															<?php if ($soal->soal_solution != "") { ?>
																<div class="well solusi <?= $sembunyi; ?>">
																	<strong>Solution : </strong><br /><br /><?= $soal->soal_solution; ?>
																</div>
															<?php } ?>
															<br />
															<span class="<?= ($soal->soal_key == "A") ? "jawabannya" : ""; ?> col-md-12">
																<input <?= ($soal->test_detail_answer == "A") ? 'checked="checked"' : ""; ?> class="soal_key" <?= $disabled; ?> onClick="cek_jawaban('A','<?= $soal->soal_key; ?>','<?= $soal->soal_id; ?>')" type="radio" name="soal_key<?= $soal->soal_id; ?>" id="A" value="A" /> A. <?= $soal->soal_answer1; ?>
															</span>
															<br />
															<span class="<?= ($soal->soal_key == "B") ? "jawabannya" : ""; ?> col-md-12">
																<input <?= ($soal->test_detail_answer == "B") ? 'checked="checked"' : ""; ?> class="soal_key" <?= $disabled; ?> onClick="cek_jawaban('B','<?= $soal->soal_key; ?>','<?= $soal->soal_id; ?>')" type="radio" name="soal_key<?= $soal->soal_id; ?>" id="B" value="B" /> B. <?= $soal->soal_answer2; ?>
															</span>
															<br />
															<span class="<?= ($soal->soal_key == "C") ? "jawabannya" : ""; ?> col-md-12">
																<input <?= ($soal->test_detail_answer == "C") ? 'checked="checked"' : ""; ?> class="soal_key" <?= $disabled; ?> onClick="cek_jawaban('C','<?= $soal->soal_key; ?>','<?= $soal->soal_id; ?>')" type="radio" name="soal_key<?= $soal->soal_id; ?>" id="C" value="C" /> C. <?= $soal->soal_answer3; ?>
															</span>
															<br />
															<span class="<?= ($soal->soal_key == "D") ? "jawabannya" : ""; ?> col-md-12">
																<input <?= ($soal->test_detail_answer == "D") ? 'checked="checked"' : ""; ?> class="soal_key" <?= $disabled; ?> onClick="cek_jawaban('D','<?= $soal->soal_key; ?>','<?= $soal->soal_id; ?>')" type="radio" name="soal_key<?= $soal->soal_id; ?>" id="D" value="D" /> D. <?= $soal->soal_answer4; ?>
															</span>
															<?php if ($this->session->userdata("position_id") != 4) { ?>
																<?php if ($this->session->userdata("sekolah_id") == 0) { ?>
																	<form method="post" style="position:relative; right:0px; float:right;">
																		<button class="btn btn-warning" name="edit" value="OK">Update</button>
																		<input type="hidden" name="soal_id" value="<?= $soal->soal_id; ?>">
																	</form>
																<?php } ?>
																<form method="post" style="position:relative; right:0px; float:right;">
																	<button class="btn btn-danger" name="delete" value="OK">Delete</button>
																	<input type="hidden" name="soal_id" value="<?= $soal->soal_id; ?>">
																</form>
															<?php } ?>

														</div>
													<?php $no++;
													} ?>
												</div>
											</div>
										</div>


									<?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<input name="test_id" id="test_id" value="" type="hidden">
	<div id="test"></div>
	<!-- /#wrap -->
	<?php require_once("footer.php"); ?>
	<script>
		function modalimage(src) {
			$("#imgmodal").attr("src", $(src).attr("src"));
			$("#iModal").modal();
		}
	</script>
	<script>
		var tsoal = 0;

		function publish(materi_id, status) {
			var statusnya = "";
			$("#soal_publish" + materi_id).val("1").attr("title", "Publish").removeClass("fa-eye-slash").addClass("fa-eye").removeClass("btn-default").addClass("btn-success");
			if (status == 0) {
				$(".soal").removeClass("umateri").removeClass("mulai").removeClass("selesai").addClass("belummulai");
				statusnya = "Not started yet";
				$(".soal_key").attr("disabled", "disabled");
				$(".solusi").hide();
			}
			if (status == 1) {
				$(".soal").removeClass("umateri").removeClass("belummulai").removeClass("selesai").addClass("mulai");
				statusnya = "Start";
				$(".soal_key").removeAttr("disabled");
				$(".solusi").hide();
			}
			if (status == 2) {
				$(".soal").removeClass("umateri").removeClass("mulai").removeClass("belummulai").addClass("selesai");
				statusnya = "Done";
				$(".soal_key").attr("disabled", "disabled");
				$(".solusi").show();
			}
			$(".status").removeClass("displaynone").addClass("displayinline");
			<?php if ($this->session->userdata("position_id") != 4) { ?>
				$(".modal-header").html("Publish");
				$(".modal-body").html("Publish Success<br/>Status : " + statusnya);
				$("#myModal").modal();
			<?php } ?>
		}

		function unpublish(materi_id, status) {
			$("#soal_publish" + materi_id).val("0").attr("title", "Unpublish").removeClass("fa-eye").addClass("fa-eye-slash").removeClass("btn-success").addClass("btn-default");
			$(".soal").removeClass("belummulai").removeClass("mulai").removeClass("selesai").addClass("umateri");
			$(".soal_key").attr("disabled", "disabled");
			$(".status").removeClass("displayinline").addClass("displaynone");
			<?php if ($this->session->userdata("position_id") != 4) { ?>
				$(".modal-header").html("Publish");
				$(".modal-body").html("Unpublish Success");
				$("#myModal").modal();
			<?php } ?>
		}

		function publishsoal(materi_id, soal_publish, status) {
			$.get("<?= site_url("api/publishsoal"); ?>", {
					sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>',
					materi_id: materi_id,
					soal_publish: soal_publish
				})
				.done(function(data) {
					if (data == "Publish") {
						publish(materi_id, status);
					} else {
						unpublish(materi_id, status);
					}
				});
		}

		function cek_publish_soal() {
			$.get("<?= site_url("api/cek_publish_soal"); ?>", {
					sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>',
					materi_id: '<?= $this->input->get("materi_id"); ?>'
				})
				.done(function(data) {
					var stat, publik;
					$.each(data, function(data1, hasil1) {
						if (data1 == "publish") {
							publik = hasil1;
						} else {
							stat = hasil1;
						}
					});
					if (publik == 1) {
						publish('<?= $this->input->get("materi_id"); ?>', stat);
						$(".soal").removeClass("displaynone").addClass("displayinline");
						if ($("#soal_publish<?= $materi_id; ?>").val() == "0") {
							noltest();
						}
					}
					if (publik == 0) {
						unpublish('<?= $this->input->get("materi_id"); ?>', stat);
						$(".soal").removeClass("displayinline").addClass("displaynone");
					}

					status('<?= $this->input->get("materi_id"); ?>', stat);
				});
		}

		<?php if ($this->session->userdata("position_id") == 4) { ?>
			setInterval(function() { //alert();
				cek_publish_soal();
				$.get("<?= site_url("api/get_refresh"); ?>", {
						position_id: '4'
					})
					.done(function(data) {
						if (data == 1) {
							$.get("<?= site_url("api/update_refresh"); ?>", {
									position_id: '4',
									refresh_status: '0'
								})
								.done(function(data) {
									window.location.href = window.location.href;
								});
						}
					});

			}, 1000);
		<?php } ?>
	</script>
	<script>
		function noltest() {
			$.get("<?= site_url("api/noltest"); ?>", {
					sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>',
					materi_id: '<?= $materi_id; ?>',
					user_id: '<?= $this->session->userdata("user_id"); ?>'
				})
				.done(function(data) {
					$("#test_id").val(data);
				});
		}

		function cek_jawaban(jawaban, key, soal_id) {
			$.get("<?= site_url("api/cek_jawaban"); ?>", {
					sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>',
					materi_id: '<?= $materi_id; ?>',
					jawaban: jawaban,
					key: key,
					user_id: '<?= $this->session->userdata("user_id"); ?>',
					soal_id: soal_id,
					test_id: $("#test_id").val()
				})
				.done(function(data) {
					//alert(data);
					//$("#test").html(data);
				});
		}

		function status(materi_id, soal_status) {
			$.get("<?= site_url("api/status"); ?>", {
					sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>',
					materi_id: materi_id,
					soal_status: soal_status
				})
				.done(function(data) {
					//alert(data);
					publish(materi_id, soal_status);
					if (soal_status == 2) {
						$(".jawabannya").css("background-color", "pink");
						hitung_nilai();
						$(".solusi").show();
					}
					if (soal_status == 1) {
						$(".jawabannya").css("background-color", "");
						hitung_nilai();
						$(".solusi").hide();
					}
					if (soal_status == 0) {
						$(".jawabannya").css("background-color", "");
						hitung_nilai();
						$(".solusi").hide();
					}
				});
		}

		function hitung_nilai() {
			var alertn = "";
			$.get("<?= site_url("api/hitung_nilai"); ?>", {
					sekolah_id: '<?= $this->session->userdata("sekolah_id"); ?>',
					materi_id: '<?= $materi_id; ?>',
					user_id: '<?= $this->session->userdata("user_id"); ?>'
				})
				.done(function(data) { //alert(data);
					if (data < 50) {
						alertn = "alert alert-danger";
					}
					if (data >= 50 && data < 80) {
						alertn = "alert alert-warning";
					}
					if (data >= 80) {
						alertn = "alert alert-success";
					}
					$("#alert_nilai").removeClass().addClass(alertn).html("Value : " + data);
				});
		}
	</script>
</body>

</html>