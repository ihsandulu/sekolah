<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class grup_siswa_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		
		//cek grup_siswa
		$grupd["grup_id"]=$this->input->get("grup_id");
		$us=$this->db
		->get_where('grup',$grupd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $grup){		
				foreach($this->db->list_fields('grup') as $field)
				{
					$data[$field]=$grup->$field;
				}	
			}
		}else{		
			foreach($this->db->list_fields('grup') as $field)
			{
				$data[$field]="";
			}
			
		}
		
		
		
		//upload image
		$data['uploadgrup_siswa_picture']="";
		if(isset($_FILES['grup_siswa_picture'])&&$_FILES['grup_siswa_picture']['name']!=""){
		$grup_siswa_picture=str_replace(' ', '_',$_FILES['grup_siswa_picture']['name']);
		$grup_siswa_picture = date("H_i_s_").$grup_siswa_picture;
		if(file_exists ('assets/images/grup_siswa_picture/'.$grup_siswa_picture)){
		unlink('assets/images/grup_siswa_picture/'.$grup_siswa_picture);
		}
		$config['file_name'] = $grup_siswa_picture;
		$config['upload_path'] = 'assets/images/grup_siswa_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('grup_siswa_picture'))
		{
			$data['uploadgrup_siswa_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadgrup_siswa_picture']="Upload Success !";
			$input['grup_siswa_picture']=$grup_siswa_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("grup_siswa",array("grup_siswa_id"=>$this->input->post("grup_siswa_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
				$this->db->insert("grup_siswa",$input);
				$insert_id=$this->db->insert_id();
				if($insert_id>0){
					$data["message"]="Insert Data Success";
					$inputadmin["user_name"]="admin";
					$inputadmin["user_password"]="password";
					$inputadmin["grup_siswa_id"]=$insert_id;
					$this->db->insert("user",$inputadmin);
					$this->session->sess_destroy();
					redirect(site_url("login"));
				}else{
					$data["message"]="Insert Failed".$this->db->last_query();
				}
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='grup_siswa_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("grup_siswa",$input,array("grup_siswa_id"=>$this->input->post("grup_siswa_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
