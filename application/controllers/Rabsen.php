<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class rabsen extends CI_Controller {


	public function index()
	{
		$this->load->model('rabsen_m');
		$data=$this->rabsen_m->data();
		$this->parser->parse('rabsen_v',$data);
		
	}
}
