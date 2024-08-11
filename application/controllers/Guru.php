<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class guru extends CI_Controller {


	public function index()
	{
		$this->load->model('guru_m');
		$data=$this->guru_m->data();
		$this->parser->parse('guru_v',$data);
		
	}
}
