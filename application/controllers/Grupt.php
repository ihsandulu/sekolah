<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class grupt extends CI_Controller {


	public function index()
	{
		$this->load->model('grupt_m');
		$data=$this->grupt_m->data();
		$this->parser->parse('grupt_v',$data);
		
	}
}
