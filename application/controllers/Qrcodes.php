<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Qrcodes extends CI_Controller
{

    public function index()
    {
        // load file phpqrcode
        require_once APPPATH . 'third_party/phpqrcode/qrlib.php';

        // teks yang mau diubah jadi QR Code
        if (isset($_GET["text"])) {
            $text = $_GET["text"];
        } else {
            $text = "Schools Server";
        }

        // langsung output QR ke browser
        header("Content-Type: image/png");
        \QRcode::png($text);
    }

    public function save()
    {
        require_once APPPATH . 'third_party/phpqrcode/qrlib.php';

        $text = "Save me to file";
        $file = FCPATH . "qrcode.png"; // simpan di root project

        \QRcode::png($text, $file, QR_ECLEVEL_L, 6);

        echo "QR Code sudah disimpan: <img src='" . base_url("qrcode.png") . "'>";
    }
}
