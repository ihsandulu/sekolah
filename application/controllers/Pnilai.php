<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pnilai extends CI_Controller {


	public function index()
	{
		$this->load->model('pnilai_m');
		$data=$this->pnilai_m->data();
		$this->parser->parse('pnilai_v',$data);
		
	}
}
