<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin extends CI_Controller {


	public function index()
	{
		$this->load->model('admin_m');
		$data=$this->admin_m->data();
		$this->parser->parse('admin_v',$data);
		
	}
}
