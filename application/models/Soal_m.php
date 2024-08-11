<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class soal_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek materi
		$materid["materi_id"]=$this->input->get("materi_id");
		$gr=$this->db
		->get_where('materi',$materid);	
		//echo $this->db->last_query();die;	
		if($gr->num_rows()>0)
		{
			foreach($gr->result() as $materi){		
				foreach($this->db->list_fields('materi') as $field)
				{
					$data[$field]=$materi->$field;
				}		
			}
		}else{	
			 		
			foreach($this->db->list_fields('materi') as $field)
			{
				$data[$field]="";
			}	
			
		}
		
		
		//upload image
		$data['uploadsoal_picture']="";
		if(isset($_FILES['soal_picture'])&&$_FILES['soal_picture']['name']!=""){
		$soal_picture=str_replace(' ', '_',$_FILES['soal_picture']['name']);
		$soal_picture = date("H_i_s_").$soal_picture;
		if(file_exists ('assets/images/soal_picture/'.$soal_picture)){
		unlink('assets/images/soal_picture/'.$soal_picture);
		}
		$config['file_name'] = $soal_picture;
		$config['upload_path'] = 'assets/images/soal_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('soal_picture'))
		{
			$data['uploadsoal_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadsoal_picture']="Upload Success !";
			$input['soal_picture']=$soal_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("soal",array("soal_id"=>$this->input->post("soal_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
				$this->db->insert("soal",$input);
				$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='soal_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("soal",$input,array("soal_id"=>$this->input->post("soal_id")));
			if($this->db->affected_rows()>0){
				$data["message"]="Update Success";
			}else{
				$data["message"]="Update Failed";
			}
			//echo $this->db->last_query();die;
		}
		
		//cek soal
		if(isset($_POST['new'])||isset($_POST['edit'])){
			$soald["soal_id"]=$this->input->post("soal_id");
			$mater=$this->db
			->get_where('soal',$soald);	
			//echo $this->db->last_query();die;	
			if($mater->num_rows()>0)
			{
				foreach($mater->result() as $soal){		
					foreach($this->db->list_fields('soal') as $field)
					{
						$data[$field]=$soal->$field;
					}		
				}
			}else{	
						
				foreach($this->db->list_fields('soal') as $field)
				{
					$data[$field]="";
				}	
				
		}
		}
		$data["materi_id"]=$materid["materi_id"];
		return $data;
	}
	
}
