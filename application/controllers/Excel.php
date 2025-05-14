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
        $data = $this->db->get_where("user", $whereuser)->result();

        // Set sheet
        $sheet = $excel->getActiveSheet();
        $title = 'Siswa_'. $this->input->get("kelas_name");
        $title = preg_replace('/[\\\\\\/\\:\\?\\*\\[\\]]/', '', $title); // buang karakter terlarang
        $title = substr($title, 0, 31); // potong maksimal 31 karakter
        $sheet->setTitle($title);

        // Header kolom
        $sheet->setCellValue('A1', 'NISN');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Nilai');

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
        header('Content-Disposition: attachment;filename="'.$title.'.xls"');
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
