<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class grupt_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek grup
		$grupd["grup_id"]=$this->input->post("grup_id");
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
		$data['uploadgrup_picture']="";
		if(isset($_FILES['grup_picture'])&&$_FILES['grup_picture']['name']!=""){
		$grup_picture=str_replace(' ', '_',$_FILES['grup_picture']['name']);
		$grup_picture = date("H_i_s_").$grup_picture;
		if(file_exists ('assets/images/grup_picture/'.$grup_picture)){
		unlink('assets/images/grup_picture/'.$grup_picture);
		}
		$config['file_name'] = $grup_picture;
		$config['upload_path'] = 'assets/images/grup_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('grup_picture'))
		{
			$data['uploadgrup_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadgrup_picture']="Upload Success !";
			$input['grup_picture']=$grup_picture;
		}
	
	}
	 
		//sign out
		if($this->input->post("signout")=="OK"){
			if($this->session->userdata("position_id")==4){
				$this->db->delete("grup_siswa",array("grup_id"=>$this->input->post("grup_id")));	
			}
			if($this->session->userdata("position_id")==3){
				$this->db->delete("grup_guru",array("grup_id"=>$this->input->post("grup_id")));			
			}
			if($this->db->affected_rows()>0){
				$data["message"]="Sign Out Success";
			}else{
				$data["message"]="Sign Out Failed";
			}
			
		}
		
		//delete
		if($this->input->post("delete")=="OK"){
			if($this->session->userdata("position_id")==4){
				$this->db->delete("grup_siswa",array("grup_id"=>$this->input->post("grup_id")));
				$this->db->delete("grup",array("grup_id"=>$this->input->post("grup_id")));
			}elseif($this->session->userdata("position_id")==3){				
				$this->db->delete("grup_guru",array("grup_id"=>$this->input->post("grup_id")));
				$this->db->delete("grup",array("grup_id"=>$this->input->post("grup_id")));
		
			}else{
				$this->db->delete("grup_siswa",array("grup_id"=>$this->input->post("grup_id")));
				$this->db->delete("grup_guru",array("grup_id"=>$this->input->post("grup_id")));
				$this->db->delete("grup",array("grup_id"=>$this->input->post("grup_id")));
			}
			if($this->db->affected_rows()>0){
				$data["message"]="Delete Success";
			}else{
				$data["message"]="Delete Failed";
			}
			
		}
		
		//sign in group
		if($this->input->post("grup_no")!=""){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->where("grup_no",$input["grup_no"]);
			if($this->session->userdata("position_id")==4){
				if($this->session->userdata("sekolah_id")!=""){
					$this->db->where("grup_siswa.sekolah_id",$this->session->userdata("sekolah_id"));
				}
				if($this->session->userdata("user_id")!=""){
					$this->db->where("grup_guru.user_id",$this->session->userdata("user_id"));
				}
				$this->db->join("grup","grup.grup_id=grup_siswa.grup_id","left");
				$double=$this->db->get("grup_siswa");
			}
			if($this->session->userdata("position_id")==3){
				if($this->session->userdata("sekolah_id")!=""){
					$this->db->where("grup_guru.sekolah_id",$this->session->userdata("sekolah_id"));
				}
				if($this->session->userdata("user_id")!=""){
					$this->db->where("grup_guru.user_id",$this->session->userdata("user_id"));
				}
				$this->db->join("grup","grup.grup_id=grup_guru.grup_id","left");
				$double=$this->db->get("grup_guru");
			}
			//echo $this->db->last_query();
			if($double->num_rows()==0){
				$gr=$this->db->get_where("grup",$input);
				if($gr->num_rows()>0){
					foreach($gr->result() as $gru){
						$inputdata["sekolah_id"]=$gru->sekolah_id;
						$inputdata["kelas_id"]=$gru->kelas_id;
						$inputdata["grup_id"]=$gru->grup_id;
						$inputdata["user_id"]=$this->session->userdata("user_id");
					}
					if($this->session->userdata("position_id")==4){
						$this->db->insert("grup_siswa",$inputdata);
					}
					if($this->session->userdata("position_id")==3){
						$this->db->insert("grup_guru",$inputdata);
					}
					$insertdata_id=$this->db->insert_id();
					if($insertdata_id>0){
						$data["message"]="Insert Data Success";
					}else{
						$data["message"]="Insert Data Failed";
					}
				}else{
					$data["message"]="Group Not Found";
				}
			}else{
				$data["message"]="Group already exists!";			
			}
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){
				if($e!="create" && $e!="grup_id" && $e!="user_id"){$inputgrup[$e]=$this->input->post($e);}
				if($e!="create" && $e!="grup_name" && $e!="matpel_id"){$inputgrupguru[$e]=$this->input->post($e);}
			}
			$double=$this->db
			->where("grup_name",$inputgrup["grup_name"])
			->get("grup");
			if($double->num_rows()==0){
				$this->db->insert("grup",$inputgrup);
				$insert_id=$this->db->insert_id();
				if($insert_id>0){
					$data["message"]="Insert Grup Success";
					$input["grup_no"]=$inputgrup["sekolah_id"]."-".$insert_id;
					$this->db->update("grup",$input,array("grup_id"=>$insert_id));
					$inputgrupguru["grup_id"]=$insert_id;	
					$this->db->insert("grup_guru",$inputgrupguru);
					$insertgrup_id=$this->db->insert_id();
					if($insert_id>0){
						$data["message"]="Insert Grup Success";
					}else{
						$data["message"]="Insert Failed";
					}
				}else{
					$data["message"]="Insert Failed";
				}
			}else{
				$data["message"]="Group already exists!";			
			}			
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='user_id'){$input[$e]=$this->input->post($e);}}
			$this->db->update("grup",$input,array("grup_id"=>$this->input->post("grup_id")));
			if($this->db->affected_rows()>0){
				$data["message"]="Update Success";
			}else{
				$data["message"]="Update Failed";
				//echo $this->db->last_query();
			}
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
