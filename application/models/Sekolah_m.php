<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Sekolah_M extends CI_Model
{

	public function data()
	{
		$data = array();
		$data["message"] = "";
		session_write_close();
		//cek sekolah
		$sekolahd["sekolah.sekolah_id"] = $this->input->post("sekolah_id");
		$us = $this->db
			->join("server", "server.sekolah_id=sekolah.sekolah_id", "left")
			->get_where('sekolah', $sekolahd);
		//echo $this->db->last_query();die;	
		if ($us->num_rows() > 0) {
			foreach ($us->result() as $sekolah) {
				foreach ($this->db->list_fields('sekolah') as $field) {
					$data[$field] = $sekolah->$field;
				}
				foreach ($this->db->list_fields('server') as $field) {
					$data[$field] = $sekolah->$field;
				}
			}
		} else {
			foreach ($this->db->list_fields('sekolah') as $field) {
				$data[$field] = "";
			}
			foreach ($this->db->list_fields('server') as $field) {
				$data[$field] = "";
			}
		}


		
		$this->load->library('upload');
		
		//upload image
		$data['uploadsekolah_picture'] = "";
		if (isset($_FILES['sekolah_picture']) && $_FILES['sekolah_picture']['name'] != "") {
			$sekolah_picture = str_replace(' ', '_', $_FILES['sekolah_picture']['name']);
			$sekolah_picture = date("H_i_s_") . $sekolah_picture;
			if (file_exists('assets/images/sekolah_picture/' . $sekolah_picture)) {
				unlink('assets/images/sekolah_picture/' . $sekolah_picture);
			}
			$config['file_name'] = $sekolah_picture;
			$config['upload_path'] = 'assets/images/sekolah_picture/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '3000000000';
			$config['max_width']  = '5000000000';
			$config['max_height']  = '3000000000';


			$this->upload->initialize($config);
			if (! $this->upload->do_upload('sekolah_picture')) {
				$data['uploadsekolah_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
			} else {
				$data['uploadsekolah_picture'] = "Upload Success !";
				$input['sekolah_picture'] = $sekolah_picture;
			}
		}

		//upload image
		$data['uploadsekolah_picture2'] = "";
		if (isset($_FILES['sekolah_picture2']) && $_FILES['sekolah_picture2']['name'] != "") {
			$sekolah_picture2 = str_replace(' ', '_', $_FILES['sekolah_picture2']['name']);
			$sekolah_picture2 = date("H_i_s_") . $sekolah_picture2;
			if (file_exists('assets/images/sekolah_picture2/' . $sekolah_picture2)) {
				unlink('assets/images/sekolah_picture2/' . $sekolah_picture2);
			}
			$config2['file_name'] = $sekolah_picture2;
			$config2['upload_path'] = 'assets/images/sekolah_picture2/';
			$config2['allowed_types'] = 'gif|jpg|png';
			$config2['max_size']	= '3000000000';
			$config2['max_width']  = '5000000000';
			$config2['max_height']  = '3000000000';

			$this->upload->initialize($config2);
			if (! $this->upload->do_upload('sekolah_picture2')) {
				$data['uploadsekolah_picture2'] = "Upload Gagal !<br/>" . $config2['upload_path'] . $this->upload->display_errors();
			} else {
				$data['uploadsekolah_picture2'] = "Upload Success !";
				$input['sekolah_picture2'] = $sekolah_picture2;
			}
		}

		//delete
		if ($this->input->post("delete") == "OK") {
			$this->db->delete("sekolah", array("sekolah_id" => $this->input->post("sekolah_id")));
			$data["message"] = "Delete Success";
		}

		//insert
		if ($this->input->post("create") == "OK") {
			foreach ($this->input->post() as $e => $f) {
				if ($e != 'create') {
					$input[$e] = $this->input->post($e);
				}
			}
			$this->db->insert("sekolah", $input);
			$insert_id = $this->db->insert_id();
			if ($insert_id > 0) {
				$data["message"] = "Insert Data Success";
				$inputadmin["user_name"] = "admin";
				$inputadmin["user_password"] = "password";
				$inputadmin["sekolah_id"] = $insert_id;
				$this->db->insert("user", $inputadmin);
				redirect(site_url("logout"));
			} else {
				$data["message"] = "Insert Failed" . $this->db->last_query();
			}
		}
		//echo $_POST["create"];die;
		//update
		if ($this->input->post("change") == "OK") {
			foreach ($this->input->post() as $e => $f) {
				if ($e != 'change' && $e != 'sekolah_picture' && $e != 'server_name') {
					$input[$e] = $this->input->post($e);
				}
			}
			$this->db->update("sekolah", $input, array("sekolah_id" => $this->input->post("sekolah_id")));
			$data["message"] = "Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
}
