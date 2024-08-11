<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class absen extends CI_Controller {


	public function index()
	{
		$this->load->model('absen_m');
		$data=$this->absen_m->data();
		$this->parser->parse('absen_v',$data);
		
	}
}
