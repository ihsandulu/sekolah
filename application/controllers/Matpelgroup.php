<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class matpelgroup extends CI_Controller {


	public function index()
	{
		$this->load->model('matpelgroup_m');
		$data=$this->matpelgroup_m->data();
		$this->parser->parse('matpelgroup_v',$data);
		
	}
}
