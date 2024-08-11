<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class soal extends CI_Controller {


	public function index()
	{
		$this->load->model('soal_m');
		$data=$this->soal_m->data();
		$this->parser->parse('soal_v',$data);
		
	}
}
