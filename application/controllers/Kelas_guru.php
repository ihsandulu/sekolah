<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kelas_guru extends CI_Controller {


	public function index()
	{
		$this->load->model('kelas_guru_m');
		$data=$this->kelas_guru_m->data();
		$this->parser->parse('kelas_guru_v',$data);
		
	}
}
