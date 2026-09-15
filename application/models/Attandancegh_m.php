<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class attandancegh_M extends CI_Model
{

    public function data()
    {
        $data = array();
        $data["message"] = "";
        session_write_close();
        //cek absengh
        $absenghd["absengh_id"] = $this->input->post("absengh_id");
        $us = $this->db
            ->get_where('absengh', $absenghd);
        //echo $this->db->last_query();die;	
        if ($us->num_rows() > 0) {
            foreach ($us->result() as $absengh) {
                foreach ($this->db->list_fields('absengh') as $field) {
                    $data[$field] = $absengh->$field;
                }
            }
        } else {
            foreach ($this->db->list_fields('absengh') as $field) {
                $data[$field] = "";
            }
        }

        //upload image
        $data['uploadabsengh_picture'] = "";
        if (isset($_FILES['absengh_picture']) && $_FILES['absengh_picture']['name'] != "") {
            $absengh_picture = str_replace(' ', '_', $_FILES['absengh_picture']['name']);
            $absengh_picture = date("H_i_s_") . $absengh_picture;
            if (file_exists('assets/images/absengh_picture/' . $absengh_picture)) {
                unlink('assets/images/absengh_picture/' . $absengh_picture);
            }
            $config['file_name'] = $absengh_picture;
            $config['upload_path'] = 'assets/images/absengh_picture/';
            $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
            $config['max_size']    = '3000000000';
            $config['max_width']  = '5000000000';
            $config['max_height']  = '3000000000';

            $this->load->library('upload', $config);

            if (! $this->upload->do_upload('absengh_picture')) {
                $data['uploadabsengh_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
            } else {
                $data['uploadabsengh_picture'] = "Upload Success !";
                $input['absengh_picture'] = $absengh_picture;
            }
        }

        //delete
        if ($this->input->post("delete") == "OK") {
            $this->db->delete("absengh", array("absengh_id" => $this->input->post("absengh_id")));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->input->post("create") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'create') {
                    $input[$e] = $this->input->post($e);
                }
            }
            if($input["absengh_type"]==1||$input["absengh_type"]==2){
                $this->db->group_start()
                ->where("absengh_type", "0")
                ->or_where("absengh_type", "3")
                ->or_where("absengh_type", "4")
                ->or_where("absengh_type", $input["absengh_type"])
                ->group_end();
            }else{
                $this->db->group_start()
                ->where("absengh_type", "0")
                ->or_where("absengh_type", "3")
                ->or_where("absengh_type", "4")
                ->or_where("absengh_type", "1")
                ->or_where("absengh_type", "2")
                ->group_end();
            }
            $double = $this->db
            ->where("user_id", $input["user_id"])
            ->where("absengh_date", $input["absengh_date"])			
			->get("absengh");
		// echo $this->db->last_query();
            if ($double->num_rows() == 0) {
                $input["absengh_year"] = date("Y");	
                $input["absengh_datetime"] = date("Y-m-d H:i:s");
                $this->db->insert("absengh", $input);
                // echo $this->db->last_query();
                $data["message"] = "Insert Data Success";
            } else {
                $data["message"] = "absengh sudah ada!";
            }
        }
        //echo $_POST["create"];die;
        //update
        if ($this->input->post("change") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'change' && $e != 'absengh_picture') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $this->db->update("absengh", $input, array("absengh_id" => $this->input->post("absengh_id")));
            $data["message"] = "Update Success";
            // echo $this->db->last_query();die;
        }
        return $data;
    }
}
