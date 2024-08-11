<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kelas extends CI_Controller {


	public function index()
	{
		$this->load->model('kelas_m');
		$data=$this->kelas_m->data();
		$this->parser->parse('kelas_v',$data);
		
	}
}
