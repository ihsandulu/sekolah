<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Attandance_M extends CI_Model
{

    public function data()
    {
        $data = array();
        $data["message"] = "";
        session_write_close();
        //cek absen
        $absend["absen_id"] = $this->input->post("absen_id");
        $us = $this->db
            ->get_where('absen', $absend);
        //echo $this->db->last_query();die;	
        if ($us->num_rows() > 0) {
            foreach ($us->result() as $absen) {
                foreach ($this->db->list_fields('absen') as $field) {
                    $data[$field] = $absen->$field;
                }
            }
        } else {
            foreach ($this->db->list_fields('absen') as $field) {
                $data[$field] = "";
            }
        }

        //upload image
        $data['uploadabsen_picture'] = "";
        if (isset($_FILES['absen_picture']) && $_FILES['absen_picture']['name'] != "") {
            $absen_picture = str_replace(' ', '_', $_FILES['absen_picture']['name']);
            $absen_picture = date("H_i_s_") . $absen_picture;
            if (file_exists('assets/images/absen_picture/' . $absen_picture)) {
                unlink('assets/images/absen_picture/' . $absen_picture);
            }
            $config['file_name'] = $absen_picture;
            $config['upload_path'] = 'assets/images/absen_picture/';
            $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
            $config['max_size']    = '3000000000';
            $config['max_width']  = '5000000000';
            $config['max_height']  = '3000000000';

            $this->load->library('upload', $config);

            if (! $this->upload->do_upload('absen_picture')) {
                $data['uploadabsen_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
            } else {
                $data['uploadabsen_picture'] = "Upload Success !";
                $input['absen_picture'] = $absen_picture;
            }
        }

        //delete
        if ($this->input->post("delete") == "OK") {
            $this->db->delete("absen", array("absen_id" => $this->input->post("absen_id")));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->input->post("create") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'create') {
                    $input[$e] = $this->input->post($e);
                }
            }
            if($input["absen_type"]==1||$input["absen_type"]==2){
                $this->db->group_start()
                ->where("absen_type", "0")
                ->or_where("absen_type", "3")
                ->or_where("absen_type", "4")
                ->or_where("absen_type", $input["absen_type"])
                ->group_end();
            }else{
                $this->db->group_start()
                ->where("absen_type", "0")
                ->or_where("absen_type", "3")
                ->or_where("absen_type", "4")
                ->or_where("absen_type", "1")
                ->or_where("absen_type", "2")
                ->group_end();
            }
            $double = $this->db
            ->where("user_id", $input["user_id"])
            ->where("absen_date", $input["absen_date"])			
			->get("absen");
		// echo $this->db->last_query();
            if ($double->num_rows() == 0) {
                $input["absen_year"] = date("Y");	
                $input["absen_datetime"] = date("Y-m-d H:i:s");
                $this->db->insert("absen", $input);
                // echo $this->db->last_query();
                $data["message"] = "Insert Data Success";
            } else {
                $data["message"] = "absen sudah ada!";
            }
        }
        //echo $_POST["create"];die;
        //update
        if ($this->input->post("change") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'change' && $e != 'absen_picture') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $this->db->update("absen", $input, array("absen_id" => $this->input->post("absen_id")));
            $data["message"] = "Update Success";
            // echo $this->db->last_query();die;
        }
        return $data;
    }
}
