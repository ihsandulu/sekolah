<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pelunasanwa extends CI_Controller {


	public function index()
	{
		$this->load->model('pelunasanwa_m');
		$data=$this->pelunasanwa_m->data();
		$this->parser->parse('pelunasanwa_v',$data);
		
	}
}
