<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class restore extends CI_Controller {


	public function index()
	{
		if(isset($_FILES['file'])&&$_FILES['file']['name']!=""){
			$isi_file = file_get_contents($_FILES["file"]["tmp_name"]);
			$string_query = rtrim( $isi_file, "\n;" );
			$array_query = explode(";", $string_query);
			foreach($array_query as $query)
			{
				$this->db->query($query);
			} 
			$data["messages"]='<div class="alert alert-success">
						  <strong>Restore Success!</strong>.
						</div>';
		}else{
			$data["messages"]="No file selected!";
		}
		
		$this->load->view("restore_v",$data);
	}
}
