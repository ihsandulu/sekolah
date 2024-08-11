<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class kelas_guru_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek kelas_guru
		$kelas_gurud["user_id"]=$this->input->get("user_id");
		$us=$this->db
		->where("position_id","3")
		->get_where('user',$kelas_gurud);	
		//echo $this->db->last_query();die;	
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
		$data['uploadkelas_guru_picture']="";
		if(isset($_FILES['kelas_guru_picture'])&&$_FILES['kelas_guru_picture']['name']!=""){
		$kelas_guru_picture=str_replace(' ', '_',$_FILES['kelas_guru_picture']['name']);
		$kelas_guru_picture = date("H_i_s_").$kelas_guru_picture;
		if(file_exists ('assets/images/kelas_guru_picture/'.$kelas_guru_picture)){
		unlink('assets/images/kelas_guru_picture/'.$kelas_guru_picture);
		}
		$config['file_name'] = $kelas_guru_picture;
		$config['upload_path'] = 'assets/images/kelas_guru_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('kelas_guru_picture'))
		{
			$data['uploadkelas_guru_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadkelas_guru_picture']="Upload Success !";
			$input['kelas_guru_picture']=$kelas_guru_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("kelas_guru",array("kelas_guru_id"=>$this->input->post("kelas_guru_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$double=$this->db
			->where("kelas_guru_name",$input["kelas_guru_name"])
			->get("kelas_guru");
			if($double->num_rows()==0){
				$this->db->insert("kelas_guru",$input);
				$data["message"]="Insert Data Success";
			}else{
				$data["message"]="kelas_guru sudah ada!";			
			}
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='kelas_guru_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("kelas_guru",$input,array("kelas_guru_id"=>$this->input->post("kelas_guru_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
