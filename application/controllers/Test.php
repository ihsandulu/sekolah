<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class test extends CI_Controller {


	public function index()
	{
		$this->load->model('test_m');
		$data=$this->test_m->data();
		$this->parser->parse('test_v',$data);
		
	}
}
