<?php
$barcode_width = 37.8 * 4; // 1cm in pixels
$barcode_height = 37.8 * 1.5;
function truncateString($string, $length = 9) {
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
        height: 80%;
    }

    .barc {
        height: <?= $barcode_height; ?>px;
        width: <?= $barcode_width; ?>px;
        margin: 1px;
        padding: 5px;
        border: black solid 1px;
        float:left;
    }

    .nama {

        text-align: center;
    }
</style>
<?php

if ($_GET['kelas_id'] > 0||$_GET['kelas_id'] == -1) {
    $this->db->where("kelas.kelas_id", $_GET['kelas_id']);
}
if (isset($_GET['user_id']) && $_GET['user_id'] > 0) {
    $this->db->where("user.user_id", $_GET['user_id']);
}

if(!isset($_GET["kelas_id"])){
    $this->db->where("user.kelas_id","-1");
}

$userd = $this->db->from("user")
->join("kelas", "kelas.kelas_id=user.kelas_id","left")
->where("position_id", "4")
->order_by("kelas_name", "ASC")
->order_by("user_name", "ASC")
->get();
// echo $this->db->last_query();die;
foreach ($userd->result() as $row) {
    $kode_barcode = $row->user_nisn;
    $user_name = truncateString($row->user_name);
    $file_gambar = base_url("barcode?text=" . $kode_barcode . "&print=false&size=65");
?>
    <div class="barc">
        <img src="<?php echo $file_gambar; ?>">
        <div class="nama"><?= $user_name; ?> (<?= $row->kelas_name; ?>)</div>
    </div>
<?php } ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
    });
</script>