<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabungankode extends CI_Controller {


	public function index()
	{
		$this->load->model('tabungankode_m');
		$data=$this->tabungankode_m->data();
		$this->parser->parse('tabungankode_v',$data);
		
	}
}
