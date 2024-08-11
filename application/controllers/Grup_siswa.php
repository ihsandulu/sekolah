<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class grup_siswa extends CI_Controller {


	public function index()
	{
		$this->load->model('grup_siswa_m');
		$data=$this->grup_siswa_m->data();
		$this->parser->parse('grup_siswa_v',$data);
		
	}
}
