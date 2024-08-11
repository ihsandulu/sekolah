<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class absensi extends CI_Controller {


	public function index()
	{
		$this->load->model('absensi_m');
		$data=$this->absensi_m->data();
		$this->parser->parse('absensi_v',$data);
		
	}
}
