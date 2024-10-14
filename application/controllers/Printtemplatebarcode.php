<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class printtemplatebarcode extends CI_Controller {


	public function index()
	{
        $data=array();
        $data["message"]="";
		$this->parser->parse('printtemplatebarcode_v',$data);
		
	}
}
