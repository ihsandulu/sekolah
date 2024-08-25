<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Catatan_M extends CI_Model
{

    public function data()
    {
        $data = array();
        $data["message"] = "";
        session_write_close();
        //cek catatan
        $catatand["catatan_id"] = $this->input->post("catatan_id");
        $us = $this->db
            ->get_where('catatan', $catatand);
        //echo $this->db->last_query();die;	
        if ($us->num_rows() > 0) {
            foreach ($us->result() as $catatan) {
                foreach ($this->db->list_fields('catatan') as $field) {
                    $data[$field] = $catatan->$field;
                }
            }
        } else {
            foreach ($this->db->list_fields('catatan') as $field) {
                $data[$field] = "";
            }
        }

        //upload image
        $data['uploadcatatan_picture'] = "";
        if (isset($_FILES['catatan_picture']) && $_FILES['catatan_picture']['name'] != "") {
            $catatan_picture = str_replace(' ', '_', $_FILES['catatan_picture']['name']);
            $catatan_picture = date("H_i_s_") . $catatan_picture;
            if (file_exists('assets/images/catatan_picture/' . $catatan_picture)) {
                unlink('assets/images/catatan_picture/' . $catatan_picture);
            }
            $config['file_name'] = $catatan_picture;
            $config['upload_path'] = 'assets/images/catatan_picture/';
            $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
            $config['max_size']    = '3000000000';
            $config['max_width']  = '5000000000';
            $config['max_height']  = '3000000000';

            $this->load->library('upload', $config);

            if (! $this->upload->do_upload('catatan_picture')) {
                $data['uploadcatatan_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
            } else {
                $data['uploadcatatan_picture'] = "Upload Success !";
                $input['catatan_picture'] = $catatan_picture;
            }
        }

        //delete
        if ($this->input->post("delete") == "OK") {
            $this->db->delete("catatan", array("catatan_id" => $this->input->post("catatan_id")));
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
                ->get("catatan");
            if ($double->num_rows() == 0) {
                $this->db->insert("catatan", $input);
                // echo $this->db->last_query();
                $data["message"] = "Insert Data Success";
            } else {
                $data["message"] = "catatan sudah ada!";
            }
        }
        //echo $_POST["create"];die;
        //update
        if ($this->input->post("change") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'change' && $e != 'catatan_picture') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $this->db->update("catatan", $input, array("catatan_id" => $this->input->post("catatan_id")));
            $data["message"] = "Update Success";
            // echo $this->db->last_query();die;
        }
        return $data;
    }
}
