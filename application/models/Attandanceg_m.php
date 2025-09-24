<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Attandanceg_M extends CI_Model
{

    public function data()
    {
        $data = array();
        $data["message"] = "";
        session_write_close();
        //cek abseng
        $absengd["abseng_id"] = $this->input->post("abseng_id");
        $us = $this->db
            ->get_where('abseng', $absengd);
        //echo $this->db->last_query();die;	
        if ($us->num_rows() > 0) {
            foreach ($us->result() as $abseng) {
                foreach ($this->db->list_fields('abseng') as $field) {
                    $data[$field] = $abseng->$field;
                }
            }
        } else {
            foreach ($this->db->list_fields('abseng') as $field) {
                $data[$field] = "";
            }
            $data["abseng_date"] = date("Y-m-d");
            $data["abseng_time"] = date("H:i");
        }

        //upload image
        $data['uploadabseng_picture'] = "";
        if (isset($_FILES['abseng_picture']) && $_FILES['abseng_picture']['name'] != "") {
            $abseng_picture = str_replace(' ', '_', $_FILES['abseng_picture']['name']);
            $abseng_picture = date("H_i_s_") . $abseng_picture;
            if (file_exists('assets/images/abseng_picture/' . $abseng_picture)) {
                unlink('assets/images/abseng_picture/' . $abseng_picture);
            }
            $config['file_name'] = $abseng_picture;
            $config['upload_path'] = 'assets/images/abseng_picture/';
            $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
            $config['max_size']    = '3000000000';
            $config['max_width']  = '5000000000';
            $config['max_height']  = '3000000000';

            $this->load->library('upload', $config);

            if (! $this->upload->do_upload('abseng_picture')) {
                $data['uploadabseng_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
            } else {
                $data['uploadabseng_picture'] = "Upload Success !";
                $input['abseng_picture'] = $abseng_picture;
            }
        }

        //delete
        if ($this->input->post("delete") == "OK") {
            $this->db->delete("abseng", array("abseng_id" => $this->input->post("abseng_id")));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->input->post("create") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'create') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $this->db->insert("abseng", $input);
            // echo $this->db->last_query();
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;
        //update
        if ($this->input->post("change") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'change' && $e != 'abseng_picture') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $this->db->update("abseng", $input, array("abseng_id" => $this->input->post("abseng_id")));
            $data["message"] = "Update Success";
            // echo $this->db->last_query();die;
        }
        return $data;
    }
}
