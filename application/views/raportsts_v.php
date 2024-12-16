<!doctype html>
<html>

<head>
    <?php
    require_once("meta.php");
    $user_id = $this->session->userdata("user_id");
    ?>
    <style>
        .mt-3 {
            margin-top: 10px !important;
        }

        .mt-5 {
            margin-top: 20px !important;
        }

        .mb-5 {
            margin-bottom: 20px !important;
        }

        .tengah {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        td {
            text-align: center;
        }
    </style>
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
                    <li class="active">Score</li>
                </ul><!-- /.breadcrumb -->


            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>Raport STS <?= $_GET["matpel_name"]; ?></h1>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?php
                                if (isset($_GET['kelas_id']) && $_GET['kelas_id'] > 0) {
                                    $this->db->where("nilai.kelas_id", $_GET['kelas_id']);
                                }
                                if (isset($_GET['user_id']) && $_GET['user_id'] > 0) {
                                    $this->db->where("nilai.user_id", $_GET['user_id']);
                                }
                                $nilai = $this->db->from("nilai")
                                    ->where("matpel_id", $this->input->get("matpel_id"))
                                    ->get();
                                $nilaiarray = array();
                                foreach ($nilai->result() as $nilai) {
                                    $nilaiarray[$nilai->user_id][$nilai->sumatif_id] = $nilai->nilai_score;
                                }
                                ?>
                                <div class="box">
                                    <div id="collapse4" class="body table-responsive">

                                        <button class="btn btn-success fa fa-file-excel-o" onclick="exportTableToExcel('myTable', 'Raport STS <?= $_GET["matpel_name"]; ?>')"> Export to Excel</button>
                                        <button class="btn btn-danger fa fa-close" onclick="window.close();"> Close</button>

                                        <table border="1" id="myTable" class="table table-condensed table-hover mt-3">
                                            <thead>
                                                <tr>
                                                    <th rowspan="3">No.U</th>
                                                    <th rowspan="3">NISN</th>
                                                    <th rowspan="3">Nama Siswa</th>
                                                    <th colspan="6"></th>
                                                    <th rowspan="3">SUMATIF TENGAH SEMESTER</th>
                                                    <th rowspan="3">SUMATIF AKHIR SEMESTER</th>
                                                    <th rowspan="3">NILAI RAPOR</th>
                                                    <th rowspan="3">NILAI RAPOR PEMBULATAN UNTUK DI COPY KE FORMAT EXCEL IMPORT E-RAPOR</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="6">SUMATIF / FORMATIF HARIAN</th>
                                                </tr>
                                                <tr>
                                                    <th>1</th>
                                                    <th>2</th>
                                                    <th>3</th>
                                                    <th>4</th>
                                                    <th>5</th>
                                                    <th>RERATA</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //jumlah sumatif guru
                                                $sumatifn = 0;
                                                $matpelguru = $this->db
                                                    ->where("sekolah_id", $this->session->userdata("sekolah_id"))
                                                    ->where("matpel_id", $this->input->get("matpel_id"))
                                                    ->where("user_id", $this->input->get("guru_id"))
                                                    ->get("matpelguru");
                                                // echo $this->db->last_query();
                                                foreach ($matpelguru->result() as $matpelguru) {
                                                    $sumatifn = $matpelguru->matpelguru_sumatif;
                                                }

                                                //jumlah sumatif sekolah
                                                $sumatif = $this->db
                                                    ->where("sekolah_id", $this->session->userdata("sekolah_id"))
                                                    ->order_by("sumatif_name", "ASC")
                                                    ->get("sumatif");
                                                $sumarray = array();
                                                foreach ($sumatif->result() as  $sumatif) {
                                                    $sumarray[] = $sumatif->sumatif_id;
                                                }
                                               
                                                // print_r($sumarray);die;


                                                if ($this->session->userdata("sekolah_id") > 0) {
                                                    $this->db->where("user.sekolah_id", $this->session->userdata("sekolah_id"));
                                                }

                                                if ($this->session->userdata("position_id") == 4) {
                                                    $this->db->where("user.user_id", $this->session->userdata("user_id"));
                                                }
                                                if (isset($_GET['kelas_id']) && $_GET['kelas_id'] > 0) {
                                                    $this->db->where("user.kelas_id", $_GET['kelas_id']);
                                                }
                                                if (isset($_GET['user_id']) && $_GET['user_id'] > 0) {
                                                    $this->db->where("user.user_id", $_GET['user_id']);
                                                }
                                                $usr = $this->db
                                                    ->where("position_id", "4")
                                                    ->order_by("user_name")
                                                    ->get("user");
                                                // echo $this->db->last_query();
                                                $no = 1;
                                                foreach ($usr->result() as $user) {
                                                ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td class="text-left"><?= $user->user_nisn; ?></td>
                                                        <td class="text-left"><?= $user->user_name; ?></td>
                                                        <?php

                                                        $n = 0;
                                                        $tnsumatif = 0;
                                                        $rerata = 0;
                                                        foreach ($sumarray as $key => $value) {
                                                            if ($n <= $sumatifn) {
                                                                $n++;
                                                                if (isset($nilaiarray[$user->user_id][$value])) {
                                                                    $nsumatif = $nilaiarray[$user->user_id][$value];
                                                                } else {
                                                                    $nsumatif = "0";
                                                                }
                                                                $tnsumatif += $nsumatif;
                                                            }

                                                        ?>
                                                            <td>
                                                                <?= number_format($nsumatif, 0, ",", "."); ?>
                                                            </td>

                                                        <?php } ?>
                                                        <td><?php
                                                            $rerata = $tnsumatif / $sumatifn;
                                                            if ($rerata > 0) {
                                                                $rer = number_format($rerata, 1, ",", ".");
                                                            } else {
                                                                $rer = 0;
                                                            }
                                                            echo $rer;
                                                            ?></td>
                                                        <td>
                                                            <?php
                                                            if (isset($nilaiarray[$user->user_id][100])) {
                                                                $tsemester = $nilaiarray[$user->user_id][100];
                                                                echo number_format($tsemester, 0, ",", ".");
                                                            } else {
                                                                echo $tsemester = 0;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if (isset($nilaiarray[$user->user_id][101])) {
                                                                $asemester = $nilaiarray[$user->user_id][101];
                                                                echo number_format($asemester, 0, ",", ".");
                                                            } else {
                                                                echo $asemester = 0;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $rapor = (75 / 100 * $rerata) + ($tsemester * 12.5 / 100) + ($asemester * 12.5 / 100);
                                                            if ($rapor > 0) {
                                                                echo number_format($rapor, 3, ",", ".");
                                                            } else {
                                                                echo $rapor = 0;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?= round($rapor); ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>

                                        <script>
                                            function exportTableToExcel(tableID, filename = '') {
                                                var downloadLink;
                                                var dataType = 'application/vnd.ms-excel';
                                                var tableSelect = document.getElementById(tableID);
                                                var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

                                                // Tentukan nama file
                                                filename = filename ? filename + '.xls' : 'excel_data.xls';

                                                // Buat elemen download
                                                downloadLink = document.createElement("a");

                                                document.body.appendChild(downloadLink);

                                                if (navigator.msSaveOrOpenBlob) {
                                                    var blob = new Blob(['\ufeff', tableHTML], {
                                                        type: dataType
                                                    });
                                                    navigator.msSaveOrOpenBlob(blob, filename);
                                                } else {
                                                    // Buat link download
                                                    downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                                                    // Tentukan nama file
                                                    downloadLink.download = filename;

                                                    // Eksekusi download
                                                    downloadLink.click();
                                                }
                                            }
                                        </script>
                                    </div>
                                </div>
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