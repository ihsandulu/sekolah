<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sekolah extends CI_Controller {


	public function index()
	{
		$this->load->model('sekolah_m');
		$data=$this->sekolah_m->data();
		$this->parser->parse('sekolah_v',$data);
		
	}
}
