<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class login_M extends CI_Model
{

	public function data()
	{
		$data = array();
		$data["hasil"] = "";
		if (isset($_POST["name"]) && isset($_POST["user_password"])) {
			if ($this->input->post("sekolah_id") == "") {
				$sekolahid = 0;
			} else {
				$sekolahid = $this->input->post("sekolah_id");
			}
			$user1 = $this->db
				->join("server", "server.sekolah_id=user.sekolah_id", "left")
				->join("sekolah", "sekolah.sekolah_id=user.sekolah_id", "left")
				->group_start()
				->where("user_name", $this->input->post("name"))
				->or_where("user_nik", $this->input->post("name"))
				->or_where("user_nisn", $this->input->post("name"))
				->group_end()
				->where("user_password", $this->input->post("user_password"))
				->where("user.sekolah_id", $sekolahid)
				->get('user');
			// echo $this->db->last_query();die;
			if ($user1->num_rows() > 0) {
				foreach ($user1->result() as $user) {
					foreach ($this->db->list_fields('user') as $field) {
						$this->session->set_userdata($field, $user->$field);
						//echo $this->session->userdata($field);
					}
					foreach ($this->db->list_fields('server') as $field) {
						$this->session->set_userdata($field, $user->$field);
						//echo $this->session->userdata($field);
					}
					foreach ($this->db->list_fields('sekolah') as $field) {
						$this->session->set_userdata($field, $user->$field);
						//echo $this->session->userdata($field);
					}

					//tambahkan modul di sini                         
					$pages = $this->db
						->join("pages", "pages.pages_id=positionpages.pages_id", "left")
						->where("position_id", $user->position_id)
						->get("positionpages");
					$halaman = array();
					foreach ($pages->result() as $pages) {
						// $halaman = array(109, 110, 111, 112, 116, 117, 118, 119, 120, 121, 122, 123, 159, 173,187,188,189,190,192,196);
						$halaman[$pages->pages_id]['act_read'] = $pages->positionpages_read;
						$halaman[$pages->pages_id]['act_create'] = $pages->positionpages_create;
						$halaman[$pages->pages_id]['act_update'] = $pages->positionpages_update;
						$halaman[$pages->pages_id]['act_delete'] = $pages->positionpages_delete;
						$halaman[$pages->pages_id]['act_approve'] = $pages->positionpages_approve;
					}
					$this->session->set_userdata("halaman", $halaman);
				}

				//cek login
				$login = $this->db
					->where("sekolah_id", $this->session->userdata("sekolah_id"))
					->where("login_date", date("Y-m-d"))
					->get("login");
				if ($login->num_rows() > 0) {
					if ($user->position_id == 1) {
						$input["login_admin"] = $login->row()->login_admin + 1;
					}
					if ($user->position_id == 2) {
						$input["login_admin"] = $login->row()->login_admin + 1;
					}
					if ($user->position_id == 3) {
						$input["login_guru"] = $login->row()->login_guru + 1;
					}
					if ($user->position_id == 4) {
						$input["login_siswa"] = $login->row()->login_siswa + 1;
					}
					$where["sekolah_id"] = $this->session->userdata("sekolah_id");
					$where["login_date"] = date("Y-m-d");
					$this->db->update("login", $input, $where);
					//echo $this->db->last_query();die;
				} else {
					if ($user->position_id == 2) {
						$input["login_admin"] = 1;
					}
					if ($user->position_id == 3) {
						$input["login_guru"] = 1;
					}
					if ($user->position_id == 4) {
						$input["login_siswa"] = 1;
					}
					$input["sekolah_id"] = $this->session->userdata("sekolah_id");
					$input["login_date"] = date("Y-m-d");
					$this->db->insert("login", $input);
				}

				redirect(site_url("utama"));
			} else {
				$data["hasil"] = " Access Denied !";
			}
		}

		return $data;
	}
}
