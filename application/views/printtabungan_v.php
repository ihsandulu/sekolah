<!DOCTYPE html>
<html lang="en">

<head>
    <title>Print Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
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

        .kartu {
            /* border: black solid 1px; */
            padding: 0px;
            margin: 0px;
        }

        .img {
            height: 60px;
            width: auto;
        }

        #header {
            border-bottom: black double 3px;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        #body {
            border: black solid 1px;
            padding: 0px;
            margin: 0px;
            height: 988px;
        }

        .tabel {
            margin: 0px;
            padding: 0px;
            border: black solid 1px;
            text-align: center;
            font-weight: bold;
        }
        #catatan{
            text-align: right;
            font-size: 10px;
            margin-top: 5px;
        }
        #footer{
            height: 64px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <?php
            $sekolah = $this->db->from("sekolah")
                ->where("sekolah_id", $this->session->userdata("sekolah_id"))
                ->get()->row();

                if(isset($_GET["kosongan"])){
                    $this->db->limit(1);
                }
                if(isset($_GET["user_id"])){
                    $this->db->where("user_id",$_GET["user_id"]);
                }
            $userd = $this->db->from("user")
                ->join("kelas", "kelas.kelas_id=user.kelas_id", "left")
                ->where("user.sekolah_id", $this->session->userdata("sekolah_id"))
                ->where("position_id", "4")
                ->order_by("user_name", "ASC")
                ->get();
                // echo $this->db->last_query();
            foreach ($userd->result() as $row) {
                if(isset($_GET["kosongan"])){
                    $kelas_name = "";
                    $user_name = "";
                    $user_nisn = "";
                }else{
                    $kelas_name = $row->kelas_name;
                    $user_name = $row->user_name;
                    $user_nisn = $row->user_nisn;
                }
            ?>
                <div class="kartu col-xs-12">
                    <div class="col-xs-12" id="header">
                        <div class="col-xs-4 text-right"><img class="img" src="<?= base_url("assets/images/sekolah_picture2/" . $sekolah->sekolah_picture2); ?>" /></div>
                        <div class="col-xs-8 text-left">
                            BUKU TABUNGAN<br />
                            PESERTA DIDIK<br />
                            <?= $sekolah->sekolah_name; ?>
                        </div>
                    </div>
                    <div class="col-xs-2">NIS</div>
                    <div class="col-xs-10">: <?= $user_nisn; ?></div>
                    <div class="col-xs-2">NAMA</div>
                    <div class="col-xs-10">: <?= $user_name; ?></div>
                    <div class="col-xs-2">KELAS</div>
                    <div class="col-xs-10">: <?= $kelas_name; ?></div>
                    <div class="col-xs-12">&nbsp;</div>
                    <div class="col-xs-1 tabel">No.</div>
                    <div class="col-xs-3 tabel">Tanggal</div>
                    <div class="col-xs-5 tabel">Transaksi</div>
                    <div class="col-xs-3 tabel">Saldo</div>
                    <div class="col-xs-12" id="body"></div>
                    <div class="col-xs-12" id="catatan">Tgl Cetak : <?=date("d/m/Y");?></div>
                    <div class="col-xs-12" id="footer">&nbsp;</div>
                </div>
            <?php } ?>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.print();
        });
    </script>
</body>

</html>