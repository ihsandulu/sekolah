<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class printtemplatetabungan extends CI_Controller {


	public function index()
	{
		$this->load->model('printtemplatetabungan_m');
		$data=$this->printtemplatetabungan_m->data();
		$this->parser->parse('printtemplatetabungan_v',$data);
		
	}
}
