<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class transaction extends CI_Controller {


	public function index()
	{
		$this->load->model('transaction_m');
		$data=$this->transaction_m->data();
		$this->parser->parse('transaction_v',$data);
		
	}
}
