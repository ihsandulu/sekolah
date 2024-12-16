<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Sumatif_M extends CI_Model
{

    public function data()
    {
        $data = array();
        $data["message"] = "";
        session_write_close();
        //cek sumatif
        $sumatifd["sumatif_id"] = $this->input->get("sumatif_id");
        $gr = $this->db
            ->get_where('sumatif', $sumatifd);
        //echo $this->db->last_query();die;	
        if ($gr->num_rows() > 0) {
            foreach ($gr->result() as $sumatif) {
                foreach ($this->db->list_fields('sumatif') as $field) {
                    $data[$field] = $sumatif->$field;
                }
            }
        } else {

            foreach ($this->db->list_fields('sumatif') as $field) {
                $data[$field] = "";
            }
        }



        //upload image
        $data['uploadsumatif_picture'] = "";
        if (isset($_FILES['sumatif_picture']) && $_FILES['sumatif_picture']['name'] != "") {
            $sumatif_picture = str_replace(' ', '_', $_FILES['sumatif_picture']['name']);
            $sumatif_picture = date("H_i_s_") . $sumatif_picture;
            if (file_exists('assets/images/sumatif_picture/' . $sumatif_picture)) {
                unlink('assets/images/sumatif_picture/' . $sumatif_picture);
            }
            $config['file_name'] = $sumatif_picture;
            $config['upload_path'] = 'assets/images/sumatif_picture/';
            $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
            $config['max_size']    = '3000000000';
            $config['max_width']  = '5000000000';
            $config['max_height']  = '3000000000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('sumatif_picture')) {
                $data['uploadsumatif_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
            } else {
                $data['uploadsumatif_picture'] = "Upload Success !";
                $input['sumatif_picture'] = $sumatif_picture;
            }
        }

        //delete
        if ($this->input->post("delete") == "OK") {
            /* $ceksumatifsekolah = $this->db->where("sumatif_id", $this->input->post("sumatif_id"))->get("sumatif_sekolah");            
            if ($ceksumatifsekolah->num_rows() > 0) {
                $data["message"] = "Delete gagal! sumatif dipakai oleh sekolah.";
            } else {
                $this->db->delete("sumatif", array("sumatif_id" => $this->input->post("sumatif_id")));
                $data["message"] = "Delete Success";
            } */
            $this->db->delete("sumatif", array("sumatif_id" => $this->input->post("sumatif_id")));
                $data["message"] = "Delete Success";
        }

        //insert
        if ($this->input->post("create") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'create') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $this->db->insert("sumatif", $input);
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->input->post("change") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'change' && $e != 'sumatif_picture') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $this->db->update("sumatif", $input, array("sumatif_id" => $this->input->post("sumatif_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }

        //cek sumatif
        $sumatifd["sumatif_id"] = $this->input->post("sumatif_id");
        $mater = $this->db
            ->get_where('sumatif', $sumatifd);
        //echo $this->db->last_query();die;	
        if ($mater->num_rows() > 0) {
            foreach ($mater->result() as $sumatif) {
                foreach ($this->db->list_fields('sumatif') as $field) {
                    $data[$field] = $sumatif->$field;
                }
            }
        } else {

            foreach ($this->db->list_fields('sumatif') as $field) {
                $data[$field] = "";
            }
        }
        $data["sumatif_id"] = $sumatifd["sumatif_id"];
        return $data;
    }
}
