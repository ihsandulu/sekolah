<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Rraportd_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek user
		$userd["user_id"]=$this->input->get("user_id");
		$gr=$this->db
		->join("kelas","kelas.kelas_id=user.kelas_id","left")
		->join("(SELECT user_id AS usid, user_name as guru FROM user)user","user.usid=kelas.kelas_wali","left")
		->get_where('user',$userd);	
		// echo $this->db->last_query();die;	
		if($gr->num_rows()>0)
		{
			foreach($gr->result() as $user){		
				foreach($this->db->list_fields('user') as $field)
				{
					$data[$field]=$user->$field;
				}			
				foreach($this->db->list_fields('kelas') as $field)
				{
					$data[$field]=$user->$field;
				}	
				$data["guru"]=$user->guru;	
			}
		}else{	
			 		
			foreach($this->db->list_fields('user') as $field)
			{
				$data[$field]="";
			}	
			foreach($this->db->list_fields('kelas') as $field)
			{
				$data[$field]="";
			}	
			$data["guru"]="";
			
		}
		
		
		
		//upload image
		$data['uploadabsensi_picture']="";
		if(isset($_FILES['absensi_picture'])&&$_FILES['absensi_picture']['name']!=""){
		$absensi_picture=str_replace(' ', '_',$_FILES['absensi_picture']['name']);
		$absensi_picture = date("H_i_s_").$absensi_picture;
		if(file_exists ('assets/images/absensi_picture/'.$absensi_picture)){
		unlink('assets/images/absensi_picture/'.$absensi_picture);
		}
		$config['file_name'] = $absensi_picture;
		$config['upload_path'] = 'assets/images/absensi_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('absensi_picture'))
		{
			$data['uploadabsensi_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadabsensi_picture']="Upload Success !";
			$input['absensi_picture']=$absensi_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("absensi",array("absensi_id"=>$this->input->post("absensi_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
				$this->db->insert("absensi",$input);
				$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='absensi_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("absensi",$input,array("absensi_id"=>$this->input->post("absensi_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		
		//cek sekolah
		$sekolahd["sekolah_id"]=$this->session->userdata("sekolah_id");
		$mater=$this->db
		->get_where('sekolah',$sekolahd);	
		//echo $this->db->last_query();die;	
		if($mater->num_rows()>0)
		{
			foreach($mater->result() as $sekolah){		
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
