<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class rraport_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		
		
		
		
		//upload image
		$data['uploadsekolah_picture']="";
		if(isset($_FILES['sekolah_picture'])&&$_FILES['sekolah_picture']['name']!=""){
		$sekolah_picture=str_replace(' ', '_',$_FILES['sekolah_picture']['name']);
		$sekolah_picture = date("H_i_s_").$sekolah_picture;
		if(file_exists ('assets/images/sekolah_picture/'.$sekolah_picture)){
		unlink('assets/images/sekolah_picture/'.$sekolah_picture);
		}
		$config['file_name'] = $sekolah_picture;
		$config['upload_path'] = 'assets/images/sekolah_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('sekolah_picture'))
		{
			$data['uploadsekolah_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadsekolah_picture']="Upload Success !";
			$input['sekolah_picture']=$sekolah_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("sekolah",array("sekolah_id"=>$this->input->post("sekolah_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
				$this->db->insert("sekolah",$input);
				$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='sekolah_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("sekolah",$input,array("sekolah_id"=>$this->session->userdata("sekolah_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		//cek sekolah
		$sekolahd["sekolah_id"]=$this->session->userdata("sekolah_id");
		$gr=$this->db
		->get_where('sekolah',$sekolahd);	
		//echo $this->db->last_query();die;	
		if($gr->num_rows()>0)
		{
			foreach($gr->result() as $sekolah){		
				foreach($this->db->list_fields('sekolah') as $field)
				{
					$data[$field]=$sekolah->$field;
				}		
			}
		}else{	
			 		
			foreach($this->db->list_fields('sekolah') as $field)
			{
				$data[$field]="";
			}	
			
		}
		
		return $data;
	}
	
}
