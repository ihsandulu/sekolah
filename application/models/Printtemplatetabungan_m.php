<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class printtemplatetabungan_M extends CI_Model
{


	function saldo($type, $nisn)
	{
		$uang = $this->db
			->select("SUM(tabungan_amount)as saldo")
			->where("user_nisn", $nisn)
			->where("tabungan_type", $type)
			->get("tabungan");
		$uangn = 0;
		// $uangn=$this->db->last_query();
		foreach ($uang->result() as $uang) {
			if (!is_null($uang->saldo)) {
				$uangn = $uang->saldo;
			}
		}
		return $uangn;
	}


	function validasi($tarikan, $nisn)
	{
		$saldo = $this->saldo("Debet", $nisn) - $this->saldo("Kredit", $nisn);
		if ($saldo >= $tarikan) {
			$hasil = TRUE;
		} else {
			$hasil = FALSE;
		}
		return $hasil;
	}

	function validasikreditupdate($tarikan, $nisn, $tabungan_id)
	{
		$uang = $this->db
			->select("SUM(tabungan_amount)as saldo")
			->where("user_nisn", $nisn)
			->where("tabungan_id !=", $tabungan_id)
			->where("tabungan_type", "Kredit")
			->get("tabungan");
		$uangn = 0;
		// $uangn=$this->db->last_query();
		foreach ($uang->result() as $uang) {
			if (!is_null($uang->saldo)) {
				$uangn = $uang->saldo;
			}
		}
		$awal = $this->saldo("Debet", $nisn);
		$saldo = $awal - $uangn;
		if ($saldo >= $tarikan) {
			$hasil = TRUE;
		} else {
			$hasil = FALSE;
		}
		// $hasil = $saldo . ">= ". $tarikan."||".$awal."||".$uangn;
		return $hasil;
	}

	public function data()
	{
		$data = array();
		$data["message"] = "";
		session_write_close();

		//cek tabungan
		if (isset($_POST['new']) || isset($_POST['edit'])) {
			$tabungand["tabungan_id"] = $this->input->post("tabungan_id");
			$us = $this->db
				->get_where('tabungan', $tabungand);
			//echo $this->db->last_query();die;	
			if ($us->num_rows() > 0) {
				foreach ($us->result() as $tabungan) {
					foreach ($this->db->list_fields('tabungan') as $field) {
						$data[$field] = $tabungan->$field;
					}
				}
			} else {

				foreach ($this->db->list_fields('tabungan') as $field) {
					$data[$field] = "";
				}
				$data["tabungan_amount"] = 0;
			}
		}


		if (isset($_POST['import'])) {

			// jika kosongkan data dicentang jalankan kode berikut
			if (isset($_POST["drop"])) {
				if ($_POST["drop"] == 1) {
					//delete data tabungan semua
					$this->db->delete("tabungan", array("sekolah_id" => $this->session->userdata("sekolah_id")));

					//import excel
					if ($_FILES['filesiswa']['name'] != "") {
						$file = $_FILES['filesiswa']['tmp_name'];
						//load the excel library
						$this->load->library('excel');
						//read file from path
						$objPHPExcel = PHPExcel_IOFactory::load($file);
						//get only the Cell Collection
						$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
						//extract to a PHP readable array format
						$row = 0;
						$column = 0;
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
						$gagal = 0;
						$sukses = 0;
						//echo $row." ".$column;die;
						// uraikan
						for ($x = 2; $x <= $row; $x++) {
							if (isset($arr_data[$x]["H"])) {
								if ($arr_data[$x]["H"] == "T" || $arr_data[$x]["H"] == "") {
									$type = "Debet";
									$typ = "T";
								} else {
									$type = "Kredit";
									$typ = $arr_data[$x]["H"];
								}								
							} else {
								// Nilai default jika indeks "H" tidak ada
								$type = "Debet";
								$typ = "T";
							}

							//tabungankode_id
							$tabungankode_id = 0;
							$tabungankode = $this->db->where("tabungankode_kode",$typ)->get("tabungankode");
							foreach($tabungankode->result() as $tabungankode){
								$tabungankode_id = $tabungankode->tabungankode_id;
							}

							$dateValue = $arr_data[$x]["E"];
							if (is_numeric($dateValue)) {
								$timestamp = PHPExcel_Shared_Date::ExcelToPHP($dateValue);
								$tabungan_datetime = date("Y-m-d 00:00:00", $timestamp);
							} else {
								$dateString = explode("/", $dateValue);
								if (count($dateString) === 3) {
									$tabungan_datetime = $dateString[2] . "-" . $dateString[1] . "-" . $dateString[0] . " 00:00:00";
								} else {
									$tabungan_datetime = "1970-01-01 00:00:00";
								}
							}


							$user = $this->db->where("user_nisn", $arr_data[$x]["B"])->get("user");
							if ($user->num_rows() > 0) {
								foreach ($user->result() as $user) {
									$input["user_nisn"] = $arr_data[$x]["B"];
									$input["tabungan_datetime"] = $tabungan_datetime;
									$input["tabungan_amount"] = $arr_data[$x]["F"];
									$input["user_id"] = $user->user_id;
									$input["tabungan_type"] = $type;
									$input["tabungan_remarks"] = "Hasil Import";
									$input["sekolah_id"] = $this->session->userdata("sekolah_id");
									$input["tabungan_tahun"] = $user->user_tahunajaran;
									$input["kelas_id"] = $user->kelas_id;
									$input["tabungankode_id"] = $tabungankode_id;
									$this->db->insert("tabungan", $input);
									
									$user_id = $this->db->insert_id();
									$sukses++;
								}
							} else {
								$gagal++;
							}
						}
						$data["message"] = "Keterangan Import Data Tabungan : Sukses=" . $sukses . ", Gagal=" . $gagal;
					}
				} else {
					$data["message"] = "Import gagal karena pilihan 'Delete All Transaction' tidak di pilih!";
				}
			} else {
				$data["message"] = "Import gagal karena pilihan 'Delete All Transaction' tidak di pilih!";
			}
		}

		//upload image
		$data['uploadtabungan_picture'] = "";
		if (isset($_FILES['tabungan_picture']) && $_FILES['tabungan_picture']['name'] != "") {
			$tabungan_picture = str_replace(' ', '_', $_FILES['tabungan_picture']['name']);
			$tabungan_picture = date("H_i_s_") . $tabungan_picture;
			if (file_exists('assets/images/tabungan_picture/' . $tabungan_picture)) {
				unlink('assets/images/tabungan_picture/' . $tabungan_picture);
			}
			$config['file_name'] = $tabungan_picture;
			$config['upload_path'] = 'assets/images/tabungan_picture/';
			$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
			$config['max_size']	= '3000000000';
			$config['max_width']  = '5000000000';
			$config['max_height']  = '3000000000';

			$this->load->library('upload', $config);

			if (! $this->upload->do_upload('tabungan_picture')) {
				$data['uploadtabungan_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
			} else {
				$data['uploadtabungan_picture'] = "Upload Success !";
				$input['tabungan_picture'] = $tabungan_picture;
			}
		}

		//delete
		if ($this->input->post("delete") == "OK") {
			$this->db->delete("tabungan", array("tabungan_id" => $this->input->post("tabungan_id")));
			$data["message"] = "Delete Success";
		}

		$data["s"] = 0;
		//insert
		if ($this->input->post("create") == "OK") {
			foreach ($this->input->post() as $e => $f) {
				if ($e != 'create' && $e != 'tipe') {
					$input[$e] = $this->input->post($e);
				}
			}
			$user = $this->db
				->select("user.*, GROUP_CONCAT(telpon.telpon_number SEPARATOR ',') as nomor_telepon")
				->where("user.user_nisn", $this->input->post("user_nisn"))
				->join("telpon", "telpon.user_id=user.user_id", "left")
				->get("user");
			if ($user->num_rows() > 0) {
				$user_name = $user->row()->user_name;
				$telp = $user->row()->nomor_telepon ? explode(',', $user->row()->nomor_telepon) : array();
			} else {
				$user_name = "";
				$telp = array();
			}

			if ($this->input->post("tabungan_type") == "Kredit") {
				// echo $this->saldo("Debet", $input["user_nisn"])."-D<br/>";
				// echo $this->saldo("Kredit", $input["user_nisn"])."-K";
				// echo $this->validasi($input["tabungan_amount"], $input["user_nisn"]);die;

				if ($this->validasi($input["tabungan_amount"], $input["user_nisn"])) {
					$this->db->insert("tabungan", $input);
					$data["s"] = $this->db->insert_id();
					$data["message"] = "Insert Data Success";

					$sekolah = $this->db->where("sekolah_id", $this->session->userdata("sekolah_id"))->get("sekolah");
					// echo $this->db->last_query();die;
					foreach ($sekolah->result() as $row) {
						$server = $row->sekolah_serverwa;
						$email = $row->sekolah_emailwa;
						$password = $row->sekolah_passwordwa;
						// **Mengirim Pesan Text**
						$uri = "https://qithy.my.id/api/token?email=" . $email . "&password=" . $password . "";
						// echo $uri;die;
						$user = json_decode(
							file_get_contents($uri)
						);
						$token = $user->token;
						$tabungan_amount = $this->input->post("tabungan_amount");
						$tabungan_remarks = $this->input->post("tabungan_remarks");
						if ($tabungan_remarks != "") {
							$untuk = " untuk keperluan " . $tabungan_remarks;
						} else {
							$untuk = "";
						}
						$pesan = "Siswa/i " . $user_name . " telah menarik tabungan sejumlah: " . number_format($tabungan_amount, 0, ",", ".") . ",-" . $untuk;
						foreach ($telp as $telepon) {
							$urimessage = "https://qithy.my.id:8000/send-message?email=" . $email . "&token=" . $token . "&id=" . $server . "&message=" . urlencode($pesan) . "&number=" . $telepon . "";
							// $uripesan = file_get_contents($urimessage);
							// echo $urimessage;die;

							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, $urimessage);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36');

							$response = curl_exec($ch);

							if (curl_errno($ch)) {
								echo 'Error:' . curl_error($ch);
							}

							curl_close($ch);
						}
					}
				} else {
					$data["message"] = "<span style='color:red;'>The balance is not sufficient</span>";
				}
			} else {
				$this->db->insert("tabungan", $input);
				$data["s"] = $this->db->insert_id();
				$data["message"] = "Insert Data Success";

				$sekolah = $this->db->where("sekolah_id", $this->session->userdata("sekolah_id"))->get("sekolah");
				// echo $this->db->last_query();die;
				foreach ($sekolah->result() as $row) {
					$server = $row->sekolah_serverwa;
					$email = $row->sekolah_emailwa;
					$password = $row->sekolah_passwordwa;
					// **Mengirim Pesan Text**
					$uri = "https://qithy.my.id/api/token?email=" . $email . "&password=" . $password . "";
					// echo $uri;die;
					$user = json_decode(
						file_get_contents($uri)
					);
					$token = $user->token;
					$tabungan_amount = $this->input->post("tabungan_amount");
					$tabungan_remarks = $this->input->post("tabungan_remarks");
					if ($tabungan_remarks != "") {
						$untuk = " untuk " . $tabungan_remarks;
					} else {
						$untuk = "";
					}
					$pesan = "Siswa/i " . $user_name . " telah menabung sejumlah: " . number_format($tabungan_amount, 0, ",", ".") . ",-" . $untuk;
					foreach ($telp as $telepon) {
						$urimessage = "https://qithy.my.id:8000/send-message?email=" . $email . "&token=" . $token . "&id=" . $server . "&message=" . urlencode($pesan) . "&number=" . $telepon . "";
						// $uripesan = file_get_contents($urimessage);
						// echo $urimessage;die;

						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $urimessage);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36');

						$response = curl_exec($ch);

						if (curl_errno($ch)) {
							echo 'Error:' . curl_error($ch);
						}

						curl_close($ch);
					}
				}
			}
		}
		//echo $_POST["create"];die;
		//update
		if ($this->input->post("change") == "OK") {
			foreach ($this->input->post() as $e => $f) {
				if ($e != 'change' && $e != 'tabungan_picture') {
					$input[$e] = $this->input->post($e);
				}
			}
			$tabungan_id = $this->input->post("tabungan_id");
			// echo $this->validasikreditupdate($input["tabungan_amount"], $input["user_nisn"], $tabungan_id);
			if ($this->validasikreditupdate($input["tabungan_amount"], $input["user_nisn"], $tabungan_id)) {
				$this->db->update("tabungan", $input, array("tabungan_id" => $tabungan_id));
				$data["message"] = "Update Success";
				//echo $this->db->last_query();die;
			} else {
				$data["message"] = "<span style='color:red;'>The balance is not sufficient</span>";
			}
		}
		return $data;
	}
}