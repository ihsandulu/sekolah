<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class jamabsen extends CI_Controller {


	public function index()
	{
		$this->load->model('jamabsen_m');
		$data=$this->jamabsen_m->data();
		$this->parser->parse('jamabsen_v',$data);
		
	}
}
