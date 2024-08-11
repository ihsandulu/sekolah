<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pabsensi extends CI_Controller {


	public function index()
	{
		$this->load->model('pabsensi_m');
		$data=$this->pabsensi_m->data();
		$this->parser->parse('pabsensi_v',$data);
		
	}
}
