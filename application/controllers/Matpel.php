<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class matpel extends CI_Controller {


	public function index()
	{
		$this->load->model('matpel_m');
		$data=$this->matpel_m->data();
		$this->parser->parse('matpel_v',$data);
		
	}
}
