<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Position extends CI_Controller {


	public function index()
	{
		$this->load->model('position_m');
		$data=$this->position_m->data();
		$this->parser->parse('position_v',$data);
		
	}
}
