<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class grup_guru_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		
		//cek grup_guru
		$userd["user_id"]=$this->input->get("user_id");
		$us=$this->db
		->get_where('user',$userd);	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $user){		
				foreach($this->db->list_fields('user') as $field)
				{
					$data[$field]=$user->$field;
				}	
			}
		}else{		
			foreach($this->db->list_fields('user') as $field)
			{
				$data[$field]="";
			}
			
		}
		
		
		
		//upload image
		$data['uploadgrup_guru_picture']="";
		if(isset($_FILES['grup_guru_picture'])&&$_FILES['grup_guru_picture']['name']!=""){
		$grup_guru_picture=str_replace(' ', '_',$_FILES['grup_guru_picture']['name']);
		$grup_guru_picture = date("H_i_s_").$grup_guru_picture;
		if(file_exists ('assets/images/grup_guru_picture/'.$grup_guru_picture)){
		unlink('assets/images/grup_guru_picture/'.$grup_guru_picture);
		}
		$config['file_name'] = $grup_guru_picture;
		$config['upload_path'] = 'assets/images/grup_guru_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('grup_guru_picture'))
		{
			$data['uploadgrup_guru_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadgrup_guru_picture']="Upload Success !";
			$input['grup_guru_picture']=$grup_guru_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("grup_guru",array("grup_guru_id"=>$this->input->post("grup_guru_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
				$this->db->insert("grup_guru",$input);
				$insert_id=$this->db->insert_id();
				if($insert_id>0){
					$data["message"]="Insert Data Success";
					$inputadmin["user_name"]="admin";
					$inputadmin["user_password"]="password";
					$inputadmin["grup_guru_id"]=$insert_id;
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
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='grup_guru_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("grup_guru",$input,array("grup_guru_id"=>$this->input->post("grup_guru_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
