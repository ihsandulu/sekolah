<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class matpelgroup_M extends CI_Model {
	
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
		$data['uploadmatpelgroup_picture']="";
		if(isset($_FILES['matpelgroup_picture'])&&$_FILES['matpelgroup_picture']['name']!=""){
		$matpelgroup_picture=str_replace(' ', '_',$_FILES['matpelgroup_picture']['name']);
		$matpelgroup_picture = date("H_i_s_").$matpelgroup_picture;
		if(file_exists ('assets/images/matpelgroup_picture/'.$matpelgroup_picture)){
		unlink('assets/images/matpelgroup_picture/'.$matpelgroup_picture);
		}
		$config['file_name'] = $matpelgroup_picture;
		$config['upload_path'] = 'assets/images/matpelgroup_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('matpelgroup_picture'))
		{
			$data['uploadmatpelgroup_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadmatpelgroup_picture']="Upload Success !";
			$input['matpelgroup_picture']=$matpelgroup_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("matpelgroup",array("matpelgroup_id"=>$this->input->post("matpelgroup_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
				$this->db->insert("matpelgroup",$input);
				$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='matpelgroup_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("matpelgroup",$input,array("matpelgroup_id"=>$this->input->post("matpelgroup_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		
		//cek matpelgroup
		$matpelgroupd["matpelgroup_id"]=$this->input->post("matpelgroup_id");
		$mater=$this->db
		->get_where('matpelgroup',$matpelgroupd);	
		//echo $this->db->last_query();die;	
		if($mater->num_rows()>0)
		{
			foreach($mater->result() as $matpelgroup){		
				foreach($this->db->list_fields('matpelgroup') as $field)
				{
					$data[$field]=$matpelgroup->$field;
				}		
			}
		}else{	
			 		
			foreach($this->db->list_fields('matpelgroup') as $field)
			{
				$data[$field]="";
			}	
			
		}
		$data["grup_id"]=$grupd["grup_id"];
		return $data;
	}
	
}
