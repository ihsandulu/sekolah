<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class tidakhadir_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		
		
		
		
		//upload image
		$data['uploadtimewa_picture']="";
		if(isset($_FILES['timewa_picture'])&&$_FILES['timewa_picture']['name']!=""){
		$timewa_picture=str_replace(' ', '_',$_FILES['timewa_picture']['name']);
		$timewa_picture = date("H_i_s_").$timewa_picture;
		if(file_exists ('assets/images/timewa_picture/'.$timewa_picture)){
		unlink('assets/images/timewa_picture/'.$timewa_picture);
		}
		$config['file_name'] = $timewa_picture;
		$config['upload_path'] = 'assets/images/timewa_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('timewa_picture'))
		{
			$data['uploadtimewa_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadtimewa_picture']="Upload Success !";
			$input['timewa_picture']=$timewa_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("timewa",array("timewa_id"=>$this->input->post("timewa_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
				$this->db->insert("timewa",$input);
				$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='timewa_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("timewa",$input,array("timewa_id"=>$this->input->post("timewa_id")));
			$data["message"]="Update Success";
			// echo $this->db->last_query();die;
		}
        
		//cek timewa
		$timewad["sekolah_id"]=$this->session->userdata("sekolah_id");
		$gr=$this->db
		->get_where('timewa',$timewad);	
		//echo $this->db->last_query();die;	
		if($gr->num_rows()>0)
		{
			foreach($gr->result() as $timewa){		
				foreach($this->db->list_fields('timewa') as $field)
				{
					$data[$field]=$timewa->$field;
				}		
			}
		}else{	
			 		
			foreach($this->db->list_fields('timewa') as $field)
			{
				$data[$field]="";
			}	
			
		}
		
		return $data;
	}
	
}
