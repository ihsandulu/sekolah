<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class transaction_M extends CI_Model
{

	public function data()
	{
		$data = array();
		$data["message"] = "";
		session_write_close();
		//cek transaction
		$transactiond["transaction_id"] = $this->input->post("transaction_id");
		$us = $this->db
			->get_where('transaction', $transactiond);
		//echo $this->db->last_query();die;	
		if ($us->num_rows() > 0) {
			foreach ($us->result() as $transaction) {
				foreach ($this->db->list_fields('transaction') as $field) {
					$data[$field] = $transaction->$field;
				}
			}
		} else {

			foreach ($this->db->list_fields('transaction') as $field) {
				$data[$field] = "";
			}
			$data["transaction_amount"] = 0;
		}

		//upload image
		$data['uploadtransaction_picture'] = "";
		if (isset($_FILES['transaction_picture']) && $_FILES['transaction_picture']['name'] != "") {
			$transaction_picture = str_replace(' ', '_', $_FILES['transaction_picture']['name']);
			$transaction_picture = date("H_i_s_") . $transaction_picture;
			if (file_exists('assets/images/transaction_picture/' . $transaction_picture)) {
				unlink('assets/images/transaction_picture/' . $transaction_picture);
			}
			$config['file_name'] = $transaction_picture;
			$config['upload_path'] = 'assets/images/transaction_picture/';
			$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
			$config['max_size']	= '3000000000';
			$config['max_width']  = '5000000000';
			$config['max_height']  = '3000000000';

			$this->load->library('upload', $config);

			if (! $this->upload->do_upload('transaction_picture')) {
				$data['uploadtransaction_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
			} else {
				$data['uploadtransaction_picture'] = "Upload Success !";
				$input['transaction_picture'] = $transaction_picture;
			}
		}

		//delete
		if ($this->input->post("delete") == "OK") {
			$this->db->delete("transaction", array("transaction_id" => $this->input->post("transaction_id")));
			$data["message"] = "Delete Success";
		}

		$data["s"] = 0;
		$data["tahun"] = 0;
		//insert
		if ($this->input->post("create") == "OK") {
			foreach ($this->input->post() as $e => $f) {
				if ($e != 'create') {
					$input[$e] = trim($this->input->post($e));
				}
			}
			if ($input["transaction_type"] == "Kredit") {
				$data["s"] = 0;
				$double = $this->db
					->where("transaction_name", $input["transaction_name"])
					->get("transaction");

				if ($double->num_rows() == 0) {
					$this->db->insert("transaction", $input);
					$data["message"] = "Insert Data Success";
				} else {
					$data["message"] = "<span style='color:red;'>Insert Data Failed</span><br/>The transaction already exists!";
				}
			} else {
				$this->db->insert("transaction", $input);
				$data["message"] = "Insert Data Success";
				$data["s"] = $this->db->insert_id();

				//tahunajaran
				$whereuser["user.user_nisn"] = $input["user_nisn"];
				$whereuser["user.sekolah_id"] = $input["sekolah_id"];
				$user = $this->db
				->select("user.*, GROUP_CONCAT(telpon.telpon_number SEPARATOR ',') as nomor_telepon")
				->join("telpon","telpon.user_id=user.user_id","left")
					->get_where("user", $whereuser);
				// echo $this->db->last_query();die;
				if ($user->num_rows() > 0) {
					$datatahun = $user->row()->user_tahunajaran;
					$telp = $user->row()->nomor_telepon ? explode(',', $user->row()->nomor_telepon) : array();
				} else {
					$datatahun = 0;
					$telp = array();
				}
				$data["tahun"] = $datatahun;

				$sekolah = $this->db->where("sekolah_id", $this->session->userdata("sekolah_id"))->get("sekolah");
				// echo $this->db->last_query();die;
				foreach ($sekolah->result() as $row) {
					$user_name=$user->row()->user_name;
					$server=$row->sekolah_serverwa;
					$email=$row->sekolah_emailwa;
					$password=$row->sekolah_passwordwa;
					// **Mengirim Pesan Text**
					$uri = "https://qithy.my.id/api/token?email=".$email."&password=".$password."";
					// echo $uri;die;
					$user = json_decode(
						file_get_contents($uri)
					);
					$token = $user->token;
					$transaction_amount=$this->input->post("transaction_amount");
					$transaction_name=$this->input->post("transaction_name");
					$pesan = "Siswa/i ".$user_name." telah membayar tagihan ".$transaction_name." sejumlah: ".number_format($transaction_amount,0,",",".").",-";
					foreach($telp as $telepon){
						$urimessage = "https://qithy.my.id:8000/send-message?email=".$email."&token=" . $token . "&id=".$server."&message=" . urlencode($pesan) . "&number=".$telepon."";
						$uripesan = file_get_contents($urimessage);
						// echo $urimessage;die;
					}
				}
			}
		}
		//echo $_POST["create"];die;
		//update
		if ($this->input->post("change") == "OK") {
			foreach ($this->input->post() as $e => $f) {
				if ($e != 'change' && $e != 'transaction_picture') {
					$input[$e] = trim($this->input->post($e));
				}
			}
			$this->db->update("transaction", $input, array("transaction_id" => $this->input->post("transaction_id")));
			$data["message"] = "Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
}
