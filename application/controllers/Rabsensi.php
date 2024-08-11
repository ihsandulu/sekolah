<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class rabsensi extends CI_Controller {


	public function index()
	{
		$this->load->model('rabsensi_m');
		$data=$this->rabsensi_m->data();
		$this->parser->parse('rabsensi_v',$data);
		
	}
}
