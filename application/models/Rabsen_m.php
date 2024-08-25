<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class rabsen_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		
		
		
		
		//upload image
		$data['uploadabsen_picture']="";
		if(isset($_FILES['absen_picture'])&&$_FILES['absen_picture']['name']!=""){
		$absen_picture=str_replace(' ', '_',$_FILES['absen_picture']['name']);
		$absen_picture = date("H_i_s_").$absen_picture;
		if(file_exists ('assets/images/absen_picture/'.$absen_picture)){
		unlink('assets/images/absen_picture/'.$absen_picture);
		}
		$config['file_name'] = $absen_picture;
		$config['upload_path'] = 'assets/images/absen_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('absen_picture'))
		{
			$data['uploadabsen_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadabsen_picture']="Upload Success !";
			$input['absen_picture']=$absen_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("absen",array("absen_id"=>$this->input->post("absen_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
				$this->db->insert("absen",$input);
				$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='absen_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("absen",$input,array("absen_id"=>$this->input->post("absen_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		
		//cek absen
		$absend["absen_id"]=$this->input->post("absen_id");
		$mater=$this->db
        ->join("user","user.user_id=absen.user_id","left")
        ->join("kelas","kelas.kelas_id=user.kelas_id","left")
		->get_where('absen',$absend);	
		//echo $this->db->last_query();die;	
		if($mater->num_rows()>0)
		{
			foreach($mater->result() as $absen){		
				foreach($this->db->list_fields('absen') as $field)
				{
					$data[$field]=$absen->$field;
				}			
				foreach($this->db->list_fields('user') as $field)
				{
					$data[$field]=$absen->$field;
				}				
				foreach($this->db->list_fields('kelas') as $field)
				{
					$data[$field]=$absen->$field;
				}		
			}
		}else{				 		
			foreach($this->db->list_fields('absen') as $field)
			{
				$data[$field]="";
			}				 		
			foreach($this->db->list_fields('user') as $field)
			{
				$data[$field]="";
			}				 		
			foreach($this->db->list_fields('kelas') as $field)
			{
				$data[$field]="";
			}				
		}
		return $data;
	}
	
}
