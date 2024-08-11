<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class utama_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();

		
		
		if(isset($_POST["kelas_sekolah_notifabsen"])){
			$this->db
			->where("sekolah_id",$this->session->userdata("sekolah_id"))
			->where("kelas_sekolah_id",$this->input->post("kelas_sekolah_id"))
			->set("kelas_sekolah_notifabsen",$this->input->post("kelas_sekolah_notifabsen"))
			->update("kelas_sekolah");
			// echo $this->db->last_query();die;
		}


		//cek sekolah
		$us=$this->db
		->where("sekolah_id",$this->session->userdata("sekolah_id"))
		->get('sekolah');	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $sekolah){		
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
