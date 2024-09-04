<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class matpelguru extends CI_Controller {


	public function index()
	{
		$this->load->model('matpelguru_m');
		$data=$this->matpelguru_m->data();
		$this->parser->parse('matpelguru_v',$data);
		
	}
}
