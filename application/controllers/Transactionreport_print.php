<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class transactionreport_print extends CI_Controller {


	public function index()
	{	
		$this->load->view('transactionreport_print_v');
		
	}
}
