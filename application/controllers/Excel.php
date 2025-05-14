<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set("Asia/Bangkok");

/*
* sebelum update script mohon synch code dulu
*/
class excel extends CI_Controller
{

    function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS, DELETE");
        parent::__construct();
        $identity_server = $this->db->get("identity")->row()->identity_server;
    }

    function index()
    {
        $this->djson(array("connect" => "ok"));
    }

    function excelnilai()
{
    $this->load->library('exceld');
    $excel = $this->exceld->excel;

    // Ambil data dari database
    $whereuser["user.kelas_id"] = trim($this->input->get("kelas_id"));
    $whereuser["user.sekolah_id"] = $this->input->get("sekolah_id");

    $data = $this->db->where($whereuser)
        ->order_by("user_name", "ASC")
        ->get("user")
        ->result();

    // Set sheet
    $sheet = $excel->getActiveSheet();
    $title = 'Siswa_' . $this->input->get("kelas_name");
    $title = preg_replace('/[\\\\\\/\\:\\?\\*\\[\\]]/', '', $title); // hapus karakter terlarang
    $title = substr($title, 0, 31); // maksimal 31 karakter
    $sheet->setTitle($title);

    // Header kolom
    $sheet->setCellValue('A1', 'NISN');
    $sheet->setCellValue('B1', 'Nama');
    $sheet->setCellValue('C1', 'Nilai');

    // Auto height baris 1
    $sheet->getRowDimension(1)->setRowHeight(-1);

    // Auto size kolom A–C
    foreach (range('A', 'C') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Nonaktifkan wrap text agar tidak terpotong
    $sheet->getStyle('A1:C1')->getAlignment()->setWrapText(false);

    // Isi data
    $row = 2;
    foreach ($data as $item) {
        $sheet->setCellValue('A' . $row, $item->user_nisn);
        $sheet->setCellValue('B' . $row, $item->user_name);
        $sheet->setCellValue('C' . $row, '');
        $row++;
    }

    // Export ke browser
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $title . '.xls"');
    header('Cache-Control: max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $writer->save('php://output');
}


    function exceltabungan()
{
    $this->load->library('exceld');
    $excel = $this->exceld->excel;

    // Ambil data dari database
    $kel = "";
    if ($this->input->get("kelas_id") != "") {
        $kel = "_" . $this->input->get("kelas_name");
        $whereuser["user.kelas_id"] = trim($this->input->get("kelas_id"));
    }
    $whereuser["user.sekolah_id"] = $this->input->get("sekolah_id");
    $whereuser["user.position_id"] = "4";

    $data = $this->db
        ->join("kelas", "kelas.kelas_id=user.kelas_id", "left")
        ->where($whereuser)
        ->order_by("kelas_name", "ASC")
        ->order_by("user_name", "ASC")
        ->get("user")
        ->result();

    // Set sheet
    $sheet = $excel->getActiveSheet();
    $title = 'Data_Siswa' . $kel;
    $title = preg_replace('/[\\\\\\/\\:\\?\\*\\[\\]]/', '', $title); // hapus karakter terlarang
    $title = substr($title, 0, 31); // maksimal 31 karakter
    $sheet->setTitle($title);

    // Header kolom
    $headers = [
        'A1' => 'No',
        'B1' => 'TAB_NIS',
        'C1' => 'TAB_NAMA',
        'D1' => 'TAB_KDTRANSAKSI',
        'E1' => 'TAB_TGTRANSAKSI(bln/tgl/thn)',
        'F1' => 'TAB_JMTRANSAKSI',
        'G1' => 'TAB_TgInput',
        'H1' => 'TAB_JNTRANSAKSI(T=Debet,K=Kredit)',
        'I1' => 'Kelas',
    ];
    foreach ($headers as $cell => $value) {
        $sheet->setCellValue($cell, $value);
    }

    // Atur tinggi baris header
    $sheet->getRowDimension(1)->setRowHeight(-1); // auto height

    // Atur auto size untuk semua kolom A–I
    foreach (range('A', 'I') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Hindari teks terpotong
    $sheet->getStyle('A1:I1')->getAlignment()->setWrapText(false);

    // Isi data
    $row = 2;
    $no = 1;
    foreach ($data as $item) {
        $sheet->setCellValue('A' . $row, $no);
        $sheet->setCellValue('B' . $row, $item->user_nisn);
        $sheet->setCellValue('C' . $row, $item->user_name);
        $sheet->setCellValue('D' . $row, '');
        $sheet->setCellValue('E' . $row, '');
        $sheet->setCellValue('F' . $row, '');
        $sheet->setCellValue('G' . $row, '');
        $sheet->setCellValue('H' . $row, '');
        $sheet->setCellValue('I' . $row, $item->kelas_name);
        $row++;
        $no++;
    }

    // Export ke browser
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $title . '.xls"');
    header('Cache-Control: max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $writer->save('php://output');
}



    private function djson($value = array())
    {
        $json = json_encode($value);
        $this->output->set_header("Access-Control-Allow-Origin: *");
        $this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
        $this->output->set_status_header(200);
        $this->output->set_content_type('application/json');
        $this->output->set_output($json);
    }
}
