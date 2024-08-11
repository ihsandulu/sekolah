<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class materi extends CI_Controller {


	public function index()
	{
		$this->load->model('materi_m');
		$data=$this->materi_m->data();
		$this->parser->parse('materi_v',$data);
		
	}
}
