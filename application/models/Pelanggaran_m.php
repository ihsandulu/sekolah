<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class pelanggaran_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek pelanggaran
		$pelanggarand["pelanggaran_id"]=$this->input->post("pelanggaran_id");
		$us=$this->db
		->get_where('pelanggaran',$pelanggarand);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $pelanggaran){		
			foreach($this->db->list_fields('pelanggaran') as $field)
			{
				$data[$field]=$pelanggaran->$field;
			}		
		}
		}else{	
			 		
			foreach($this->db->list_fields('pelanggaran') as $field)
			{
				$data[$field]="";
			}	
			
		}
		
		//upload image
		$data['uploadpelanggaran_picture']="";
		if(isset($_FILES['pelanggaran_picture'])&&$_FILES['pelanggaran_picture']['name']!=""){
		$pelanggaran_picture=str_replace(' ', '_',$_FILES['pelanggaran_picture']['name']);
		$pelanggaran_picture = date("H_i_s_").$pelanggaran_picture;
		if(file_exists ('assets/images/pelanggaran_picture/'.$pelanggaran_picture)){
		unlink('assets/images/pelanggaran_picture/'.$pelanggaran_picture);
		}
		$config['file_name'] = $pelanggaran_picture;
		$config['upload_path'] = 'assets/images/pelanggaran_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('pelanggaran_picture'))
		{
			$data['uploadpelanggaran_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadpelanggaran_picture']="Upload Success !";
			$input['pelanggaran_picture']=$pelanggaran_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("pelanggaran",array("pelanggaran_id"=>$this->input->post("pelanggaran_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("pelanggaran",$input);
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='pelanggaran_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("pelanggaran",$input,array("pelanggaran_id"=>$this->input->post("pelanggaran_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
