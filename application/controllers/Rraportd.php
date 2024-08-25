<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rraportd extends CI_Controller {


	public function index()
	{
		$this->load->model('rraportd_m');
		$data=$this->rraportd_m->data();
		$this->parser->parse('rraportd_v',$data);
		
	}
}
