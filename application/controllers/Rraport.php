<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class rraport extends CI_Controller {


	public function index()
	{
		$this->load->model('rraport_m');
		$data=$this->rraport_m->data();
		$this->parser->parse('rraport_v',$data);
		
	}
}
