<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pelanggaran extends CI_Controller {


	public function index()
	{
		$this->load->model('pelanggaran_m');
		$data=$this->pelanggaran_m->data();
		$this->parser->parse('pelanggaran_v',$data);
		
	}
}
