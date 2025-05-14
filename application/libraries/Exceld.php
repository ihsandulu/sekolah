<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load PHPExcel library
require_once APPPATH.'third_party/PHPExcel.php';

class Exceld {
    public $excel;

    public function __construct() {
        $this->excel = new PHPExcel();
    }
}
