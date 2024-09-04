<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class matpelguru_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		
		//cek matpelguru
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
		$data['uploadmatpelguru_picture']="";
		if(isset($_FILES['matpelguru_picture'])&&$_FILES['matpelguru_picture']['name']!=""){
		$matpelguru_picture=str_replace(' ', '_',$_FILES['matpelguru_picture']['name']);
		$matpelguru_picture = date("H_i_s_").$matpelguru_picture;
		if(file_exists ('assets/images/matpelguru_picture/'.$matpelguru_picture)){
		unlink('assets/images/matpelguru_picture/'.$matpelguru_picture);
		}
		$config['file_name'] = $matpelguru_picture;
		$config['upload_path'] = 'assets/images/matpelguru_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('matpelguru_picture'))
		{
			$data['uploadmatpelguru_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadmatpelguru_picture']="Upload Success !";
			$input['matpelguru_picture']=$matpelguru_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("matpelguru",array("matpelguru_id"=>$this->input->post("matpelguru_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
				$this->db->insert("matpelguru",$input);
				$insert_id=$this->db->insert_id();
				if($insert_id>0){
					$data["message"]="Insert Data Success";
					$inputadmin["user_name"]="admin";
					$inputadmin["user_password"]="password";
					$inputadmin["matpelguru_id"]=$insert_id;
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
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='matpelguru_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("matpelguru",$input,array("matpelguru_id"=>$this->input->post("matpelguru_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
