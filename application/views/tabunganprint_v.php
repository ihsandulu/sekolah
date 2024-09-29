<!DOCTYPE html>
<html>

<head>
	<title>Print Account</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<style type="text/css" media="print">
		@page {
			size: auto;
			/* auto is the initial value */
			margin: 0;
			/* this affects the margin in the printer settings */
		}

		div,
		body {
			margin: 0px;
			padding: 0px;
		}

		th,
		td {
			text-align: center;
			font-size: 12px;
		}
		.tabel{font-size: 10px!important;}
	</style>
</head>

<body style="padding-left:5px; padding-top:100px;">
	<?php
	$line = $this->input->get("line");
	$where["tabungan_id"] = $this->input->get("tabungan_id");
	$print = $this->db
	->join("tabungankode","tabungankode.tabungankode_id=tabungan.tabungankode_id","left")
	->get_where("tabungan", $where);
	//echo $this->db->last_query();
	foreach ($print->result() as $print) { ?>
		<?php for ($x = 1; $x <= $line; $x++) { ?>
			<?php if ($x == 1) { ?>
				<div class="col-xs-1 tabel">&nbsp;</div>
				<div class="col-xs-3 tabel">&nbsp;</div>
				<div class="col-xs-5 tabel">&nbsp;</div>
				<div class="col-xs-3 tabel">&nbsp;</div>
			<?php } ?>
			<?php if ($x == $line) { ?>

				<div class="col-xs-1 tabel"><?= $line; ?></div>
				<div class="col-xs-3 tabel"><?= date("d/m/Y", strtotime($print->tabungan_datetime)); ?></div>
				<div class="col-xs-5 tabel"><?= $print->tabungankode_kode; ?> - <?= number_format($print->tabungan_amount, 0, ",", "."); ?></div>
				<div class="col-xs-3 tabel">
					<?php
					//user
					$whereuser["user_nisn"] = $print->user_nisn;
					$user = $this->db->get_where("user", $whereuser)->row();
					//echo $this->db->last_query();

					//kredit
					$kredit = $this->db
						->select("SUM(tabungan_amount)AS kredit")
						->where("tabungan_type", "kredit")
						->where("user_nisn", $user->user_nisn)
						->where("sekolah_id", $user->sekolah_id)
						->group_by("user_nisn")
						->get("tabungan");
					//echo $this->db->last_query();
					if ($kredit->num_rows() > 0) {
						$kredit = $kredit->row()->kredit;
					} else {
						$kredit = 0;
					}
					//echo $kredit;
					//debet
					$debet = $this->db
						->select("SUM(tabungan_amount)AS debet")
						->where("tabungan_type", "debet")
						->where("user_nisn", $user->user_nisn)
						->where("sekolah_id", $user->sekolah_id)
						->group_by("user_nisn")
						->get("tabungan");
					//echo $this->db->last_query();
					if ($debet->num_rows() > 0) {
						$debet = $debet->row()->debet;
					} else {
						$debet = 0;
					}
					//echo $debet;
					$saldo = $debet - $kredit;

					echo number_format($saldo, 0, ",", ".");
					?></div>
			<?php } else { ?>
				<div class="col-xs-1 tabel">&nbsp;</div>
				<div class="col-xs-3 tabel">&nbsp;</div>
				<div class="col-xs-5 tabel">&nbsp;</div>
				<div class="col-xs-3 tabel">&nbsp;</div>
			<?php } ?>
		<?php } ?>
	<?php } ?>
</body>

</html>
<script>
	window.print();
	setTimeout(function() {
		this.close();
	}, 500);
</script>