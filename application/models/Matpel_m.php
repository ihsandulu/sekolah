<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class matpel_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek grup
		$grupd["grup_id"]=$this->input->get("grup_id");
		$gr=$this->db
		->get_where('grup',$grupd);	
		//echo $this->db->last_query();die;	
		if($gr->num_rows()>0)
		{
			foreach($gr->result() as $grup){		
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
		$data['uploadmatpel_picture']="";
		if(isset($_FILES['matpel_picture'])&&$_FILES['matpel_picture']['name']!=""){
		$matpel_picture=str_replace(' ', '_',$_FILES['matpel_picture']['name']);
		$matpel_picture = date("H_i_s_").$matpel_picture;
		if(file_exists ('assets/images/matpel_picture/'.$matpel_picture)){
		unlink('assets/images/matpel_picture/'.$matpel_picture);
		}
		$config['file_name'] = $matpel_picture;
		$config['upload_path'] = 'assets/images/matpel_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('matpel_picture'))
		{
			$data['uploadmatpel_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadmatpel_picture']="Upload Success !";
			$input['matpel_picture']=$matpel_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("matpel",array("matpel_id"=>$this->input->post("matpel_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
				$this->db->insert("matpel",$input);
				$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='matpel_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("matpel",$input,array("matpel_id"=>$this->input->post("matpel_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		
		//cek matpel
		$matpeld["matpel_id"]=$this->input->post("matpel_id");
		$mater=$this->db
		->get_where('matpel',$matpeld);	
		//echo $this->db->last_query();die;	
		if($mater->num_rows()>0)
		{
			foreach($mater->result() as $matpel){		
				foreach($this->db->list_fields('matpel') as $field)
				{
					$data[$field]=$matpel->$field;
				}		
			}
		}else{	
			 		
			foreach($this->db->list_fields('matpel') as $field)
			{
				$data[$field]="";
			}	
			
		}
		$data["grup_id"]=$grupd["grup_id"];
		return $data;
	}
	
}
