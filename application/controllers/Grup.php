<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class grup extends CI_Controller {


	public function index()
	{
		$this->load->model('grup_m');
		$data=$this->grup_m->data();
		$this->parser->parse('grup_v',$data);
		
	}
}
