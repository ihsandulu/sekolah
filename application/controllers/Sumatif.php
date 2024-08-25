<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sumatif extends CI_Controller {


	public function index()
	{
		$this->load->model('sumatif_m');
		$data=$this->sumatif_m->data();
		$this->parser->parse('sumatif_v',$data);
		
	}
}
