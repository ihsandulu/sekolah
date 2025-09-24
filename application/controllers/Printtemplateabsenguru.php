<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class printtemplateabsenguru extends CI_Controller {


	public function index()
	{
        $data=array();
        $data["message"]="";
		$this->parser->parse('printtemplateabsenguru_v',$data);
		
	}
}
