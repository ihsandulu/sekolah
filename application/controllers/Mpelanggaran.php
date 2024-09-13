<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mpelanggaran extends CI_Controller {


	public function index()
	{
		$this->load->model('mpelanggaran_m');
		$data=$this->mpelanggaran_m->data();
		$this->parser->parse('mpelanggaran_v',$data);
		
	}
}
