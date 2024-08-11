<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Admin_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek user
		$userd["user_id"]=$this->input->post("user_id");
		$us=$this->db
		->join("position","position.position_id=user.position_id","left")
		->get_where('user',$userd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $user){		
			foreach($this->db->list_fields('user') as $field)
			{
				$data[$field]=$user->$field;
			}	
			foreach($this->db->list_fields('position') as $field)
			{
				$data[$field]=$user->$field;
			}		
		}
		}else{	
			 		
			foreach($this->db->list_fields('user') as $field)
			{
				$data[$field]="";
			}
			foreach($this->db->list_fields('position') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploaduser_picture']="";
		if(isset($_FILES['user_picture'])&&$_FILES['user_picture']['name']!=""){
		$user_picture=str_replace(' ', '_',$_FILES['user_picture']['name']);
		$user_picture = date("H_i_s_").$user_picture;
		if(file_exists ('assets/images/user_picture/'.$user_picture)){
		unlink('assets/images/user_picture/'.$user_picture);
		}
		$config['file_name'] = $user_picture;
		$config['upload_path'] = 'assets/images/user_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('user_picture'))
		{
			$data['uploaduser_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploaduser_picture']="Upload Success !";
			$input['user_picture']=$user_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("user",array("user_id"=>$this->input->post("user_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$input["user_name"]=htmlentities($input["user_name"], ENT_QUOTES);
			$double=$this->db
			->where("user_name",$input["user_name"])
			->get("user");
			if($double->num_rows()==0){
				$this->db->insert("user",$input);
				$data["message"]="Insert Data Success";
			}else{
				$data["message"]="User sudah ada!";			
			}
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='user_picture'){$input[$e]=$this->input->post($e);}}
			$input["user_name"]=htmlentities($input["user_name"], ENT_QUOTES);
			$this->db->update("user",$input,array("user_id"=>$this->input->post("user_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
