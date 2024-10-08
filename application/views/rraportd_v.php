<!DOCTYPE html>
<html lang="en">

<head>
    <title>Smart School's System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            font-size: 11px;
        }

        .img {
            width: 100%;
            height: auto;
        }

        @media print {

            .judul {
                font-size: 15px;
                font-weight: bold;
            }

            .judul2 {
                font-size: 12px;
                padding-left: 20px;
                padding-right: 20px;
            }

            .mt-5 {
                margin-top: 20px;
            }

            .tengah2 {
                vertical-align: middle !important;
            }

            .thead-light {
                background-color: #C0C0C0 !important;
                -webkit-print-color-adjust: exact;
            }

            .thead-light2 {
                background-color: #e8f1fc !important;
                -webkit-print-color-adjust: exact;
            }

            .text-tengah {
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <?php
    $sekolah = $this->db->where("sekolah_id", $this->session->userdata("sekolah_id"))->get("sekolah");
    // echo $this->db->last_query();
    $sekolah_picture = "";
    $sekolah_picture2 = "";
    foreach ($sekolah->result() as $row) {
        $sekolah_picture = $row->sekolah_picture;
        $sekolah_picture2 = $row->sekolah_picture2;
        $alamat = $row->sekolah_address;
        $sekolah = $row->sekolah_name;
        $kota = $row->sekolah_kota;
        $telp = $row->sekolah_telp;
        $email = $row->sekolah_email;
        $website = $row->sekolah_website;
        $npsn = $row->sekolah_npsn;
        $nss = $row->sekolah_nss;
    }
    ?>

    <div class="text-center mt-5">
        <div class="col-md-2 col-sm-2 col-xs-2"><img
                src="<?= base_url("assets/images/sekolah_picture/" . $sekolah_picture); ?>" class="img" /></div>
        <div class="col-md-8 col-sm-8 col-xs-8">
            <div class="judul">PEMERINTAH <?= $kota; ?></div>
            <div class="judul">DINAS PENDIDIKAN</div>
            <div class="judul">UNIT PELAKSANA TEKNIK DINAS</div>
            <div class="judul"><?= $sekolah; ?></div>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-2"><img
                src="<?= base_url("assets/images/sekolah_picture2/" . $sekolah_picture2); ?>" class="img" /></div>
    </div>
    <div class="text-center mt-5 row">
        <div class="judul2 col-md-12 col-sm-12 col-xs-12"><?= $alamat; ?> Telp. <?= $telp; ?></div>
        <div class="judul2 col-md-12 col-sm-12 col-xs-12">
            <Email: ?=$email; ?> Website: <?= $website; ?>, NPSN: <?= $npsn; ?>, NSS: <?= $nss; ?>
        </div>
    </div>


    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <?php $sumatif = $this->db
                            ->where("sekolah_id", $this->session->userdata("sekolah_id"))
                            ->order_by("sumatif_name", "ASC")
                            ->get("sumatif");
                        $sumatifno = $sumatif->num_rows();
                        ?>
                        <tr>
                            <th rowspan="2" class="text-center tengah2">MATA PELAJARAN</th>
                            <th colspan="<?= $sumatifno; ?>" class="text-center tengah2">REKAPITULASI NILAI ASESMEN SUMATIF</th>
                            <th rowspan="2" class="text-center tengah2">KETERANGAN <br> (Jumlah Tugas yang belum
                                dikerjakan)</th>
                        </tr>
                        <tr>
                            <?php foreach ($sumatif->result() as $row) { ?>
                                <th class="text-center"><?= $row->sumatif_name; ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $matapelajaran = $this->db->from("kelas_guru")
                            ->where("kelas_id", $kelas_id)
                            ->join("matpelguru", "matpelguru.user_id=kelas_guru.user_id")
                            ->get();
                        $matperarray = array();
                        foreach ($matapelajaran->result() as $matapelajaran) {
                            $matperarray[$matapelajaran->matpel_id] = $matapelajaran->matpelguru_sumatif;
                        }

                        $nilai = $this->db
                            ->where("sekolah_id", $this->session->userdata("sekolah_id"))
                            ->where("user_id", $this->input->get("user_id"))
                            ->order_by("matpel_id", "ASC")
                            ->order_by("sumatif_id", "ASC")
                            ->get("nilai");
                        $nilaiuser = array();
                        // echo $this->db->last_query();
                        foreach ($nilai->result() as $row) {
                            $nilaiuser[$row->matpel_id][$row->sumatif_id] = $row->nilai_score;
                        }
                        // print_r($nilaiuser);
                        $matpelgroup = $this->db
                            ->where("sekolah_id", $this->session->userdata("sekolah_id"))
                            ->order_by("matpelgroup_name", "ASC")
                            ->get("matpelgroup");
                        foreach ($matpelgroup->result() as $row) { ?>
                            <tr class="bg-light font-weight-bold">
                                <td colspan="<?= $sumatifno + 2; ?>" class="thead-light2"><?= $row->matpelgroup_name; ?></td>
                            </tr>
                            <?php
                            $matpel = $this->db
                                ->where("sekolah_id", $this->session->userdata("sekolah_id"))
                                ->where("matpelgroup_id", $row->matpelgroup_id)
                                ->order_by("matpel_name", "ASC")
                                ->get("matpel");
                            foreach ($matpel->result() as $rowm) {
                                // $no = $sumatifno; 
                                if (isset($matperarray[$rowm->matpel_id])) {
                                    $no = $matperarray[$rowm->matpel_id];
                                } else {
                                    $no = $sumatifno;
                                }
                            ?>
                                <tr>
                                    <td><?= $rowm->matpel_name; ?></td>
                                    <?php foreach ($sumatif->result() as $rows) { ?>
                                        <td class="text-center">
                                            <?php
                                            if (isset($nilaiuser[$rowm->matpel_id][$rows->sumatif_id])) {
                                                echo $nilaiuser[$rowm->matpel_id][$rows->sumatif_id];
                                                $no--;
                                            } else {
                                                echo "-";
                                            } ?>
                                        </td>
                                    <?php } ?>
                                    <td class="text-center">
                                        <?= $no; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-12">
                <table class="table table-bordered">
                    <?php
                    $absen = $this->db
                        ->select("SUM(CASE WHEN absen_type = 0 THEN 1 ELSE 0 END) AS alpha, 
                                SUM(CASE WHEN absen_type = 1 THEN 1 ELSE 0 END) AS masuk, 
                              SUM(CASE WHEN absen_type = 2 THEN 1 ELSE 0 END) AS pulang, 
                              SUM(CASE WHEN absen_type = 3 THEN 1 ELSE 0 END) AS sakit, 
                              SUM(CASE WHEN absen_type = 4 THEN 1 ELSE 0 END) AS izin")
                        ->where("sekolah_id", $this->session->userdata("sekolah_id"))
                        ->where("user_id", $this->input->get("user_id"))
                        ->group_by("user_id")
                        ->get("absen");
                    $hadir = 0;
                    $sakit = 0;
                    $izin = 0;
                    $alpha = 0;
                    foreach ($absen->result() as $rowabsen) {
                        $masuk = $rowabsen->masuk;
                        $pulang = $rowabsen->pulang;
                        $sakit = $rowabsen->sakit;
                        $izin = $rowabsen->izin;
                        $alpha = $rowabsen->alpha;
                    }
                    ?>
                    <thead>
                        <tr>
                            <th colspan="3">KEHADIRAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>SAKIT</td>
                            <td><?= $sakit; ?></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>IZIN</td>
                            <td><?= $izin; ?></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>ALFA</td>
                            <td><?= $alpha; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Catatan Wali Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php
                                $catatan = $this->db
                                    ->where("sekolah_id", $this->session->userdata("sekolah_id"))
                                    ->where("user_id", $this->input->get("user_id"))
                                    ->get("catatan");
                                foreach ($catatan->result() as $rowcatatan) {
                                    echo $rowcatatan->catatan_note;
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 text-tengah">
                Mengetahui<br>
                Orang Tua / Wali Murid<br><br><br><br><br>


                ______________________
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 text-tengah">
                Depok, <?= date("d-m-Y", strtotime($sekolah_raportdate)); ?><br>
                Wali Kelas <?= $kelas_name; ?><br><br><br><br><br>


                <?= $guru; ?>

            </div>
        </div>
    </div>
    <script>
        $("document").ready(function() {
            window.print();
            setTimeout(function(){
                window.close();
            },5000);
        });
    </script>

</body>

</html>