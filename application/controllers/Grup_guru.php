<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class grup_guru extends CI_Controller {


	public function index()
	{
		$this->load->model('grup_guru_m');
		$data=$this->grup_guru_m->data();
		$this->parser->parse('grup_guru_v',$data);
		
	}
}
