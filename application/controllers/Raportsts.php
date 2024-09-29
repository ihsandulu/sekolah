<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class raportsts extends CI_Controller {


	public function index()
	{
		$data=array();
		$this->parser->parse('raportsts_v',$data);
		
	}
}
