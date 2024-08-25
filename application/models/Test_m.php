<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class test_M extends CI_Model
{

    public function data()
    {
        $data = array();
        $data["message"] = "";
        session_write_close();
        //cek test
        $testd["test_id"] = $this->input->get("test_id");
        $gr = $this->db
            ->get_where('test', $testd);
        //echo $this->db->last_query();die;	
        if ($gr->num_rows() > 0) {
            foreach ($gr->result() as $test) {
                foreach ($this->db->list_fields('test') as $field) {
                    $data[$field] = $test->$field;
                }
            }
        } else {

            foreach ($this->db->list_fields('test') as $field) {
                $data[$field] = "";
            }
        }



        //upload image
        $data['uploadtest_picture'] = "";
        if (isset($_FILES['test_picture']) && $_FILES['test_picture']['name'] != "") {
            $test_picture = str_replace(' ', '_', $_FILES['test_picture']['name']);
            $test_picture = date("H_i_s_") . $test_picture;
            if (file_exists('assets/images/test_picture/' . $test_picture)) {
                unlink('assets/images/test_picture/' . $test_picture);
            }
            $config['file_name'] = $test_picture;
            $config['upload_path'] = 'assets/images/test_picture/';
            $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
            $config['max_size']    = '3000000000';
            $config['max_width']  = '5000000000';
            $config['max_height']  = '3000000000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('test_picture')) {
                $data['uploadtest_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
            } else {
                $data['uploadtest_picture'] = "Upload Success !";
                $input['test_picture'] = $test_picture;
            }
        }

        //delete
        if ($this->input->post("delete") == "OK") {
            $cektestsekolah = $this->db->where("test_id", $this->input->post("test_id"))->get("test_sekolah");
            if ($cektestsekolah->num_rows() > 0) {
                $data["message"] = "Delete gagal! test dipakai oleh sekolah.";
            } else {
                $this->db->delete("test", array("test_id" => $this->input->post("test_id")));
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
            $this->db->insert("test", $input);
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->input->post("change") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'change' && $e != 'test_picture') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $this->db->update("test", $input, array("test_id" => $this->input->post("test_id")));
            $data["message"] = "Update Success";
            //echo $this->db->last_query();die;
        }

        //cek test
        $testd["test_id"] = $this->input->post("test_id");
        $mater = $this->db
            ->get_where('test', $testd);
        //echo $this->db->last_query();die;	
        if ($mater->num_rows() > 0) {
            foreach ($mater->result() as $test) {
                foreach ($this->db->list_fields('test') as $field) {
                    $data[$field] = $test->$field;
                }
            }
        } else {

            foreach ($this->db->list_fields('test') as $field) {
                $data[$field] = "";
            }
        }
        $data["test_id"] = $testd["test_id"];
        return $data;
    }
}
