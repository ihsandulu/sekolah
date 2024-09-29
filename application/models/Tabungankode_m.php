<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Tabungankode_M extends CI_Model
{

    public function data()
    {
        $data = array();
        $data["message"] = "";
        session_write_close();
        //cek tabungankode
        $tabungankoded["tabungankode_id"] = $this->input->get("tabungankode_id");
        $gr = $this->db
            ->get_where('tabungankode', $tabungankoded);
        //echo $this->db->last_query();die;	
        if ($gr->num_rows() > 0) {
            foreach ($gr->result() as $tabungankode) {
                foreach ($this->db->list_fields('tabungankode') as $field) {
                    $data[$field] = $tabungankode->$field;
                }
            }
        } else {

            foreach ($this->db->list_fields('tabungankode') as $field) {
                $data[$field] = "";
            }
        }



        //upload image
        $data['uploadtabungankode_picture'] = "";
        if (isset($_FILES['tabungankode_picture']) && $_FILES['tabungankode_picture']['name'] != "") {
            $tabungankode_picture = str_replace(' ', '_', $_FILES['tabungankode_picture']['name']);
            $tabungankode_picture = date("H_i_s_") . $tabungankode_picture;
            if (file_exists('assets/images/tabungankode_picture/' . $tabungankode_picture)) {
                unlink('assets/images/tabungankode_picture/' . $tabungankode_picture);
            }
            $config['file_name'] = $tabungankode_picture;
            $config['upload_path'] = 'assets/images/tabungankode_picture/';
            $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
            $config['max_size']    = '3000000000';
            $config['max_width']  = '5000000000';
            $config['max_height']  = '3000000000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('tabungankode_picture')) {
                $data['uploadtabungankode_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
            } else {
                $data['uploadtabungankode_picture'] = "Upload Success !";
                $input['tabungankode_picture'] = $tabungankode_picture;
            }
        }

        //delete
        if ($this->input->post("delete") == "OK") {
           
            $this->db->delete("tabungankode", array("tabungankode_id" => $this->input->post("tabungankode_id")));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->input->post("create") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'create') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $this->db->insert("tabungankode", $input);
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->input->post("change") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'change' && $e != 'tabungankode_picture') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $this->db->update("tabungankode", $input, array("tabungankode_id" => $this->input->post("tabungankode_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }

        //cek tabungankode
        $tabungankoded["tabungankode_id"] = $this->input->post("tabungankode_id");
        $mater = $this->db
            ->get_where('tabungankode', $tabungankoded);
        //echo $this->db->last_query();die;	
        if ($mater->num_rows() > 0) {
            foreach ($mater->result() as $tabungankode) {
                foreach ($this->db->list_fields('tabungankode') as $field) {
                    $data[$field] = $tabungankode->$field;
                }
            }
        } else {

            foreach ($this->db->list_fields('tabungankode') as $field) {
                $data[$field] = "";
            }
        }
        $data["tabungankode_id"] = $tabungankoded["tabungankode_id"];
        return $data;
    }
}
