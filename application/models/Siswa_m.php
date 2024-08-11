<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Siswa_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek user
		$userd["user_id"]=$this->input->post("user_id");
		$us=$this->db
		->join("position","position.position_id=user.position_id","left")
		->get_where('user',$userd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $user){		
			foreach($this->db->list_fields('user') as $field)
			{
				$data[$field]=$user->$field;
			}	
			foreach($this->db->list_fields('position') as $field)
			{
				$data[$field]=$user->$field;
			}		
		}
		}else{	
			 		
			foreach($this->db->list_fields('user') as $field)
			{
				$data[$field]="";
			}
			foreach($this->db->list_fields('position') as $field)
			{
				$data[$field]="";
			}		
			
		}

		if(isset($_POST['import'])){
				 
			// jika kosongkan data dicentang jalankan kode berikut
			if(isset($_POST["drop"])){
			 $this->db->delete("user",array("position_id"=>"4"));
			};			
			
			if($_FILES['filesiswa']['name']!="")	{
				$file = $_FILES['filesiswa']['tmp_name'];
				//load the excel library
				$this->load->library('excel');
				//read file from path
				$objPHPExcel = PHPExcel_IOFactory::load($file);
				//get only the Cell Collection
				$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
				//extract to a PHP readable array format
				$row=0;
				$column=0;
				foreach ($cell_collection as $cell) {
					 $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
					 $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
					 $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
									
					 //header will/should be in row 1 only. 
					 if ($row == 1) {
						$header[$row][$column] = $data_value;
					 } else {
						$arr_data[$row][$column] = $data_value;		
					 }
				}
				
				// import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
				$gagal=0;
				$sukses=0;
				//echo $row." ".$column;die;
				// uraikan
				for($x=2;$x<=$row;$x++){
								
					$input["sekolah_id"] = $arr_data[$x]["A"];
					$input["user_nisn"] = $arr_data[$x]["B"];
					$input["user_name"] = $arr_data[$x]["C"];
					$input["kelas_id"] = $arr_data[$x]["D"];
					$input["user_password"] = $arr_data[$x]["E"];
					$input["user_tahunajaran"] = $arr_data[$x]["F"];
					$input["position_id"] = "4";
			 
					// setelah data dibaca, masukkan ke tabel siswa sql
					$this->db->insert("user",$input);
					if($this->db->insert_id()>0){$sukses++;}else{$gagal++;}	
								
				}
				$data["sukses"]=$sukses;
				$data["gagal"]=$gagal;
			}
		}
		
		
		
		
		
		
		
		//upload image
		$data['uploaduser_picture']="";
		if(isset($_FILES['user_picture'])&&$_FILES['user_picture']['name']!=""){
		$user_picture=str_replace(' ', '_',$_FILES['user_picture']['name']);
		$user_picture = date("H_i_s_").$user_picture;
		if(file_exists ('assets/images/user_picture/'.$user_picture)){
		unlink('assets/images/user_picture/'.$user_picture);
		}
		$config['file_name'] = $user_picture;
		$config['upload_path'] = 'assets/images/user_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('user_picture'))
		{
			$data['uploaduser_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploaduser_picture']="Upload Success !";
			$input['user_picture']=$user_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("user",array("user_id"=>$this->input->post("user_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$double=$this->db
			->where("user_nisn",$input["user_nisn"])
			->get("user");
			if($double->num_rows()==0){
				$this->db->insert("user",$input);
				$data["message"]="Insert Data Success";
			}else{
				$data["message"]="User sudah ada!";			
			}
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='user_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("user",$input,array("user_id"=>$this->input->post("user_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}

		//repair tahuan ajaran menyesuaikan kelas
		if($this->input->post("repair_tahun_ajaran")=="OK"){
			$us=$this->db
			->join("transaction","transaction.kelas_id=user.kelas_id","left")
			->where("user_tahunajaran","0")
			->where("user.kelas_id >","0")
			->limit(5000)
			->get('user');	
			// echo $this->db->last_query();die;	
			$data["message"]="Process ".$us->num_rows()." data";
			foreach($us->result() as $user){
				$input["user_tahunajaran"]=	$user->transaction_tahun;	
				$this->db->update("user",$input,array("user_id"=>$user->user_id));
				// $data["message"]="Update Success";
				// echo $this->db->last_query();die;
			}
			
		}

		return $data;
	}
	
}
