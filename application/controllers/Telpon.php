<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class telpon extends CI_Controller {


	public function index()
	{
		$this->load->model('telpon_m');
		$data=$this->telpon_m->data();
		$this->parser->parse('telpon_v',$data);
		
	}
}
