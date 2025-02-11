<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tidakhadir extends CI_Controller {


	public function index()
	{
		$this->load->model('tidakhadir_m');
		$data=$this->tidakhadir_m->data();
		$this->parser->parse('tidakhadir_v',$data);
		
	}
}
