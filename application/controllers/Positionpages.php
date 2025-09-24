<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Positionpages extends CI_Controller {


	public function index()
	{
		$this->load->model('positionpages_m');
		$data=$this->positionpages_m->data();
		$this->parser->parse('positionpages_v',$data);
		
	}
}
