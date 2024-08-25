<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class kelas_M extends CI_Model
{

    public function data()
    {
        $data = array();
        $data["message"] = "";
        session_write_close();



        //upload image
        $data['uploadkelas_picture'] = "";
        if (isset($_FILES['kelas_picture']) && $_FILES['kelas_picture']['name'] != "") {
            $kelas_picture = str_replace(' ', '_', $_FILES['kelas_picture']['name']);
            $kelas_picture = date("H_i_s_") . $kelas_picture;
            if (file_exists('assets/images/kelas_picture/' . $kelas_picture)) {
                unlink('assets/images/kelas_picture/' . $kelas_picture);
            }
            $config['file_name'] = $kelas_picture;
            $config['upload_path'] = 'assets/images/kelas_picture/';
            $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
            $config['max_size']    = '3000000000';
            $config['max_width']  = '5000000000';
            $config['max_height']  = '3000000000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('kelas_picture')) {
                $data['uploadkelas_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
            } else {
                $data['uploadkelas_picture'] = "Upload Success !";
                $input['kelas_picture'] = $kelas_picture;
            }
        }

        //delete
        if ($this->input->post("delete") == "OK") {
            $cekkelassekolah = $this->db->where("kelas_id", $this->input->post("kelas_id"))->get("kelas_sekolah");
            if ($cekkelassekolah->num_rows() > 0) {
                $data["message"] = "Delete gagal! Kelas dipakai oleh sekolah.";
            } else {
                $this->db->delete("kelas", array("kelas_id" => $this->input->post("kelas_id")));
                $data["message"] = "Delete Success";
            }
        }

        //insert
        if ($this->input->post("create") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'create') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $this->db->insert("kelas", $input);
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->input->post("change") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'change' && $e != 'kelas_picture') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $this->db->update("kelas", $input, array("kelas_id" => $this->input->post("kelas_id")));
            $data["message"] = "Update Success";
            // echo $this->db->last_query();
        }

        //cek kelas
        $kelasd["kelas.kelas_id"] = $this->input->post("kelas_id");
        $mater = $this->db
            ->select("kelas.*,user.user_name")
            ->join("user", "user.user_id=kelas.kelas_wali", "left")
            ->get_where('kelas', $kelasd);
        // echo $this->db->last_query();	
        if ($mater->num_rows() > 0) {
            foreach ($mater->result() as $kelas) {
                foreach ($this->db->list_fields('kelas') as $field) {
                    $data[$field] = $kelas->$field;
                }
                $data["user_name"] = $kelas->user_name;
            }
        } else {
            foreach ($this->db->list_fields('kelas') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->list_fields('user') as $field) {
                $data[$field] = "";
                $data["user_name"] = "";
            }
        }
        return $data;
    }
}
