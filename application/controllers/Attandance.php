<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attandance extends CI_Controller {


	public function index()
	{
		$this->load->model('attandance_m');
		$data=$this->attandance_m->data();
		$this->parser->parse('attandance_v',$data);
		
	}
}
