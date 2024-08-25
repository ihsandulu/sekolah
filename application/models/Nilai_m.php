<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Nilai_M extends CI_Model
{

    public function data()
    {
        $data = array();
        $data["message"] = "";
        session_write_close();
        //cek nilai
        $nilaid["nilai_id"] = $this->input->post("nilai_id");
        $us = $this->db
            ->join("sekolah", "sekolah.sekolah_id=nilai.sekolah_id", "left")
            ->join("matpel", "matpel.matpel_id=nilai.matpel_id", "left")
            ->join("sumatif", "sumatif.sumatif_id=nilai.sumatif_id", "left")
            ->join("kelas", "kelas.kelas_id=nilai.kelas_id", "left")
            ->join("user", "user.user_id=nilai.user_id", "left")
            ->get_where('nilai', $nilaid);
        //echo $this->db->last_query();die;	
        if ($us->num_rows() > 0) {
            foreach ($us->result() as $nilai) {
                foreach ($this->db->list_fields('nilai') as $field) {
                    $data[$field] = $nilai->$field;
                }
                foreach ($this->db->list_fields('sekolah') as $field) {
                    $data[$field] = $nilai->$field;
                }
                foreach ($this->db->list_fields('matpel') as $field) {
                    $data[$field] = $nilai->$field;
                }
                foreach ($this->db->list_fields('sumatif') as $field) {
                    $data[$field] = $nilai->$field;
                }
                foreach ($this->db->list_fields('kelas') as $field) {
                    $data[$field] = $nilai->$field;
                }
                foreach ($this->db->list_fields('user') as $field) {
                    $data[$field] = $nilai->$field;
                }
            }
        } else {
            foreach ($this->db->list_fields('nilai') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->list_fields('sekolah') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->list_fields('matpel') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->list_fields('sumatif') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->list_fields('kelas') as $field) {
                $data[$field] = "";
            }
            foreach ($this->db->list_fields('user') as $field) {
                $data[$field] = "";
            }
        }

        //upload image
        $data['uploadnilai_picture'] = "";
        if (isset($_FILES['nilai_picture']) && $_FILES['nilai_picture']['name'] != "") {
            $nilai_picture = str_replace(' ', '_', $_FILES['nilai_picture']['name']);
            $nilai_picture = date("H_i_s_") . $nilai_picture;
            if (file_exists('assets/images/nilai_picture/' . $nilai_picture)) {
                unlink('assets/images/nilai_picture/' . $nilai_picture);
            }
            $config['file_name'] = $nilai_picture;
            $config['upload_path'] = 'assets/images/nilai_picture/';
            $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
            $config['max_size']    = '3000000000';
            $config['max_width']  = '5000000000';
            $config['max_height']  = '3000000000';

            $this->load->library('upload', $config);

            if (! $this->upload->do_upload('nilai_picture')) {
                $data['uploadnilai_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
            } else {
                $data['uploadnilai_picture'] = "Upload Success !";
                $input['nilai_picture'] = $nilai_picture;
            }
        }

        //delete
        if ($this->input->post("delete") == "OK") {
            $this->db->delete("nilai", array("nilai_id" => $this->input->post("nilai_id")));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->input->post("create") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'create') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $double = $this->db
                ->where("user_id", $input["user_id"])
                ->where("sumatif_id", $input["sumatif_id"])
                ->where("matpel_id", $input["matpel_id"])
                ->get("nilai");
            if ($double->num_rows() == 0) {
                $this->db->insert("nilai", $input);
                // echo $this->db->last_query();
                $data["message"] = "Insert Data Success";
            } else {
                $data["message"] = "Nilai sudah ada!";
            }
        }
        //echo $_POST["create"];die;
        //update
        if ($this->input->post("change") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'change' && $e != 'nilai_picture') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $this->db->update("nilai", $input, array("nilai_id" => $this->input->post("nilai_id")));
            $data["message"] = "Update Success";
            // echo $this->db->last_query();die;
        }
        return $data;
    }
}