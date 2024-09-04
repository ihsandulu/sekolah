<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class petugastabungan extends CI_Controller {


	public function index()
	{
		$this->load->model('petugastabungan_m');
		$data=$this->petugastabungan_m->data();
		$this->parser->parse('petugastabungan_v',$data);
		
	}
}
