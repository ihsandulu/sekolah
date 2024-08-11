<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tabungan extends CI_Controller {


	public function index()
	{
		$this->load->model('tabungan_m');
		$data=$this->tabungan_m->data();
		$this->parser->parse('tabungan_v',$data);
		
	}
}
