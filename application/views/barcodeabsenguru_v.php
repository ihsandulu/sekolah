<?php
$barcode_width = 37.8 * 4; // 1cm in pixels
$barcode_height = 37.8 * 4;
function truncateString($string, $length = 9)
{
    // Check if the string needs to be truncated
    if (strlen($string) > $length) {
        // Truncate the string and append ellipsis
        return substr($string, 0, $length) . '..';
    }
    // Return the original string if no truncation is needed
    return $string;
}
?>
<style>
    img {
        width: 100%;
        height: 100%;
    }

    .barc {
        height: 9.2cm;
        width: 9.2cm;
        margin: 1px;
        padding: 5px;
        border: black solid 1px;
        float: left;
    }

    .nama {
        position: relative;
        top: -30px;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
    }
</style>
<?php

if ($_GET['kelas_id'] > 0 || $_GET['kelas_id'] == -1) {
    $this->db->where("kelas_sekolah.kelas_id", $_GET['kelas_id']);
}

if (!isset($_GET["kelas_id"])) {
    $this->db->where("kelas_sekolah.kelas_id", "-1");
}

$userd = $this->db->from("kelas_sekolah")
    ->join("kelas", "kelas.kelas_id=kelas_sekolah.kelas_id", "left")
    ->order_by("kelas_name", "ASC")
    ->get();
// echo $this->db->last_query();die;
foreach ($userd->result() as $row) {
    $kode_barcode = base_url("scanabsenguru?k=" . $row->kelas_id . "&s=".$this->session->userdata("sekolah_id"));
    $file_gambar = base_url("Qrcodes?text=" . $kode_barcode . "&print=false&size=65");
?>
    <div class="barc">
        <img src="<?php echo $file_gambar; ?>">
        <div class="nama">(<?= $row->kelas_name; ?>)</div>
    </div>
<?php } ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
    });
</script>