<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class grupt_detail extends CI_Controller {


	public function index()
	{
		$this->load->model('grupt_detail_m');
		$data=$this->grupt_detail_m->data();
		$this->parser->parse('grupt_detail_v',$data);
		
	}
}
