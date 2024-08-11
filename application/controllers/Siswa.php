<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class siswa extends CI_Controller {


	public function index()
	{
		$this->load->model('siswa_m');
		$data=$this->siswa_m->data();
		$this->parser->parse('siswa_v',$data);
		
	}
}
