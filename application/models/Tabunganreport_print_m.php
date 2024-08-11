<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class tabunganreport_print_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek tabungan
		$tabungand["tabungan_id"]=$this->input->post("tabungan_id");
		$us=$this->db
		->get_where('tabungan',$tabungand);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $tabungan){		
			foreach($this->db->list_fields('tabungan') as $field)
			{
				$data[$field]=$tabungan->$field;
			}		
		}
		}else{	
			 		
			foreach($this->db->list_fields('tabungan') as $field)
			{
				$data[$field]="";
			}
			$data["tabungan_amount"]=0;	
			
		}
		
		//upload image
		$data['uploadtabungan_picture']="";
		if(isset($_FILES['tabungan_picture'])&&$_FILES['tabungan_picture']['name']!=""){
		$tabungan_picture=str_replace(' ', '_',$_FILES['tabungan_picture']['name']);
		$tabungan_picture = date("H_i_s_").$tabungan_picture;
		if(file_exists ('assets/images/tabungan_picture/'.$tabungan_picture)){
		unlink('assets/images/tabungan_picture/'.$tabungan_picture);
		}
		$config['file_name'] = $tabungan_picture;
		$config['upload_path'] = 'assets/images/tabungan_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('tabungan_picture'))
		{
			$data['uploadtabungan_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadtabungan_picture']="Upload Success !";
			$input['tabungan_picture']=$tabungan_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("tabungan",array("tabungan_id"=>$this->input->post("tabungan_id")));
			$data["message"]="Delete Success";
		}
		
		$data["s"]=0;
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			if($input["tabungan_type"]=="Kredit"){
				$data["s"]=0;
				$double=$this->db
				->where("tabungan_name",$input["tabungan_name"])
				->get("tabungan");
				if($double->num_rows()==0){
					$this->db->insert("tabungan",$input);
					$data["message"]="Insert Data Success";		
				}else{
					$data["message"]="<span style='color:red;'>Insert Data Failed</span><br/>The tabungan already exists!";
				}
			}else{
					$this->db->insert("tabungan",$input);
					$data["message"]="Insert Data Success";	
					$data["s"]=$this->db->insert_id();						
			}
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='tabungan_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("tabungan",$input,array("tabungan_id"=>$this->input->post("tabungan_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
