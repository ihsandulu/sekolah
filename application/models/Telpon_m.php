<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class telpon_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek telpon
		$telpond["telpon_id"]=$this->input->post("telpon_id");
		$us=$this->db
		->join("user","user.user_id=telpon.user_id","left")
		->get_where('telpon',$telpond);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $telpon){		
			foreach($this->db->list_fields('telpon') as $field)
			{
				$data[$field]=$telpon->$field;
			}	
			foreach($this->db->list_fields('user') as $field)
			{
				$data[$field]=$telpon->$field;
			}		
		}
		}else{	
			 		
			foreach($this->db->list_fields('telpon') as $field)
			{
				$data[$field]="";
			}
			foreach($this->db->list_fields('user') as $field)
			{
				$data[$field]="";
			}		
			
		}

		if(isset($_POST['import'])){
				 
			// jika kosongkan data dicentang jalankan kode berikut
			if(isset($_POST["drop"])){
			 $this->db->delete("telpon",array("user_id"=>"4"));
			};			
			
			if($_FILES['filetelpon']['name']!="")	{
				$file = $_FILES['filetelpon']['tmp_name'];
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
                    $nisn = $arr_data[$x]["B"];
                    $user=$this->db
                    ->where("user_nisn",$nisn)
                    ->get("user");
                    foreach($user->result() as $user){								
                        $input["sekolah_id"] = $arr_data[$x]["A"];
                        $input["user_id"] = $user->user_id;
                        $input["telpon_number"] = $arr_data[$x]["C"];
                        $input["telpon_type"] = $arr_data[$x]["D"];//1=ortu,2=murid
                
                        // setelah data dibaca, masukkan ke tabel telpon sql
                        $this->db->insert("telpon",$input);
                        if($this->db->insert_id()>0){$sukses++;}else{$gagal++;}	
                    }
								
				}
				$data["sukses"]=$sukses;
				$data["gagal"]=$gagal;
			}
		}
		
		
		
		
		
		
		
		//upload image
		$data['uploadtelpon_picture']="";
		if(isset($_FILES['telpon_picture'])&&$_FILES['telpon_picture']['name']!=""){
		$telpon_picture=str_replace(' ', '_',$_FILES['telpon_picture']['name']);
		$telpon_picture = date("H_i_s_").$telpon_picture;
		if(file_exists ('assets/images/telpon_picture/'.$telpon_picture)){
		unlink('assets/images/telpon_picture/'.$telpon_picture);
		}
		$config['file_name'] = $telpon_picture;
		$config['upload_path'] = 'assets/images/telpon_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('telpon_picture'))
		{
			$data['uploadtelpon_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadtelpon_picture']="Upload Success !";
			$input['telpon_picture']=$telpon_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("telpon",array("telpon_id"=>$this->input->post("telpon_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'&&$e!='user_nisn'){$input[$e]=$this->input->post($e);}}
            $nisn = $_POST["user_nisn"];
            $user=$this->db
            ->where("user_nisn",$nisn)
            ->get("user");
            $data["message"]="Data Siswa Tidak Ditemukan!";	
            foreach($user->result() as $user){
                $double=$this->db
                ->where("user_id",$user->user_id)
                ->where("telpon_number",$input["telpon_number"])
                ->get("telpon");
                if($double->num_rows()==0){
                    $input["user_id"]=$user->user_id;
                    $this->db->insert("telpon",$input);
                    // echo $this->db->last_query();
                    $data["message"]="Insert Data Success";
                }else{
                    $data["message"]="Telpon sudah terdaftar sebelumnya!";			
                }
            }
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='telpon_picture'&&$e!='user_nisn'){$input[$e]=$this->input->post($e);}}
            $nisn = $_POST["user_nisn"];
            $user=$this->db
            ->where("user_nisn",$nisn)
            ->get("user");
            $data["message"]="Data Siswa Tidak Ditemukan!";	
            foreach($user->result() as $user){
                $double=$this->db
                ->where("user_id",$user->user_id)
                ->where("telpon_number",$input["telpon_number"])
                ->get("telpon");
                if($double->num_rows()==0){
                    $input["user_id"]=$user->user_id;
                    $this->db->update("telpon",$input,array("telpon_id"=>$this->input->post("telpon_id")));
                    // echo $this->db->last_query();
			        $data["message"]="Update Success";
                }else{
                    $data["message"]="Telpon sudah terdaftar sebelumnya!";			
                }
            }
			
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
