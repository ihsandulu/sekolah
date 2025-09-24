<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Position_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek position
		$positiond["position_id"]=$this->input->post("position_id");
		$us=$this->db
		->get_where('position',$positiond);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $position){		
			foreach($this->db->list_fields('position') as $field)
			{
				$data[$field]=$position->$field;
			}	
		}
		}else{	
			 		
			foreach($this->db->list_fields('position') as $field)
			{
				$data[$field]="";
			}
			
		}
		
		//upload image
		$data['uploadposition_picture']="";
		if(isset($_FILES['position_picture'])&&$_FILES['position_picture']['name']!=""){
		$position_picture=str_replace(' ', '_',$_FILES['position_picture']['name']);
		$position_picture = date("H_i_s_").$position_picture;
		if(file_exists ('assets/images/position_picture/'.$position_picture)){
		unlink('assets/images/position_picture/'.$position_picture);
		}
		$config['file_name'] = $position_picture;
		$config['upload_path'] = 'assets/images/position_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('position_picture'))
		{
			$data['uploadposition_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadposition_picture']="Upload Success !";
			$input['position_picture']=$position_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("position",array("position_id"=>$this->input->post("position_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$input["position_name"]=htmlentities($input["position_name"], ENT_QUOTES);
			$double=$this->db
			->where("position_name",$input["position_name"])
			->get("position");
			if($double->num_rows()==0){
				$this->db->insert("position",$input);
				$data["message"]="Insert Data Success";
			}else{
				$data["message"]="Position sudah ada!";			
			}
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='position_picture'){$input[$e]=$this->input->post($e);}}
			$input["position_name"]=htmlentities($input["position_name"], ENT_QUOTES);
			$this->db->update("position",$input,array("position_id"=>$this->input->post("position_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
