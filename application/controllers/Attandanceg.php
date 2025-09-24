<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attandanceg extends CI_Controller {


	public function index()
	{
		$this->load->model('attandanceg_m');
		$data=$this->attandanceg_m->data();
		$this->parser->parse('attandanceg_v',$data);
		
	}
}
