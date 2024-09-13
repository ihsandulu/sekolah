<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Mpelanggaran_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek mpelanggaran
		$mpelanggarand["mpelanggaran_id"]=$this->input->post("mpelanggaran_id");
		$us=$this->db
		->get_where('mpelanggaran',$mpelanggarand);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $mpelanggaran){		
			foreach($this->db->list_fields('mpelanggaran') as $field)
			{
				$data[$field]=$mpelanggaran->$field;
			}		
		}
		}else{	
			 		
			foreach($this->db->list_fields('mpelanggaran') as $field)
			{
				$data[$field]="";
			}	
			
		}
		
		//upload image
		$data['uploadmpelanggaran_picture']="";
		if(isset($_FILES['mpelanggaran_picture'])&&$_FILES['mpelanggaran_picture']['name']!=""){
		$mpelanggaran_picture=str_replace(' ', '_',$_FILES['mpelanggaran_picture']['name']);
		$mpelanggaran_picture = date("H_i_s_").$mpelanggaran_picture;
		if(file_exists ('assets/images/mpelanggaran_picture/'.$mpelanggaran_picture)){
		unlink('assets/images/mpelanggaran_picture/'.$mpelanggaran_picture);
		}
		$config['file_name'] = $mpelanggaran_picture;
		$config['upload_path'] = 'assets/images/mpelanggaran_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('mpelanggaran_picture'))
		{
			$data['uploadmpelanggaran_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadmpelanggaran_picture']="Upload Success !";
			$input['mpelanggaran_picture']=$mpelanggaran_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("mpelanggaran",array("mpelanggaran_id"=>$this->input->post("mpelanggaran_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$input["mpelanggaran_name"]=htmlentities($input["mpelanggaran_name"], ENT_QUOTES);
			$double=$this->db
			->where("mpelanggaran_name",$input["mpelanggaran_name"])
			->get("mpelanggaran");
			if($double->num_rows()==0){
				$this->db->insert("mpelanggaran",$input);
				$data["message"]="Insert Data Success";
			}else{
				$data["message"]="mpelanggaran sudah ada!";			
			}
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='mpelanggaran_picture'){$input[$e]=$this->input->post($e);}}
			$input["mpelanggaran_name"]=htmlentities($input["mpelanggaran_name"], ENT_QUOTES);
			$this->db->update("mpelanggaran",$input,array("mpelanggaran_id"=>$this->input->post("mpelanggaran_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
