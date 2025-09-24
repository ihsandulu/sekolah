<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class scanabsenguru extends CI_Controller {


	public function index()
	{
		$this->load->model('scanabsenguru_m');
		$data=$this->scanabsenguru_m->data();	
		$this->parser->parse('scanabsenguru_v',$data);
		
	}
}
