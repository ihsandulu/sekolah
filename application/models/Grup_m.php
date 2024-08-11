<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class grup_M extends CI_Model {
	
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
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("grup",array("grup_id"=>$this->input->post("grup_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$double=$this->db
			->where("grup_name",$input["grup_name"])
			->get("grup");
			if($double->num_rows()==0){
				$this->db->insert("grup",$input);
				$data["message"]="Insert Data Success";
				$input["grup_no"]=$input["sekolah_id"]."-".$this->db->insert_id();
				$this->db->update("grup",$input,array("grup_id"=>$this->db->insert_id()));
			}else{
				$data["message"]="grup sudah ada!";			
			}
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='grup_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("grup",$input,array("grup_id"=>$this->input->post("grup_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
