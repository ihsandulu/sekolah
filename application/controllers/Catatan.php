<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catatan extends CI_Controller {


	public function index()
	{
		$this->load->model('catatan_m');
		$data=$this->catatan_m->data();
		$this->parser->parse('catatan_v',$data);
		
	}
}
