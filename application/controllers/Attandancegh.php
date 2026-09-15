<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class attandancegh extends CI_Controller {


	public function index()
	{
		$this->load->model('attandancegh_m');
		$data=$this->attandancegh_m->data();
		$this->parser->parse('attandancegh_v',$data);
		
	}
}
