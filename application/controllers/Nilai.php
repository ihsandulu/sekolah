<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class nilai extends CI_Controller {


	public function index()
	{
		$this->load->model('nilai_m');
		$data=$this->nilai_m->data();
		$this->parser->parse('nilai_v',$data);
		
	}
}
