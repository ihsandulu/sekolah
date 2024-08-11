<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class rnilai extends CI_Controller {


	public function index()
	{
		$this->load->model('rnilai_m');
		$data=$this->rnilai_m->data();
		$this->parser->parse('rnilai_v',$data);
		
	}
}
