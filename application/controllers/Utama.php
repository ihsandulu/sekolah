<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utama extends CI_Controller {


	public function index()
	{
		$this->load->model('utama_m');
		$data=$this->utama_m->data();
		$this->parser->parse('utama_v', $data);
	}
}
