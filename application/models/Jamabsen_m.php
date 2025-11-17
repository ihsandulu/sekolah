<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class jamabsen_M extends CI_Model
{

    public function data()
    {
        $data = array();
        $data["message"] = "";
        session_write_close();



        //upload image
        $data['uploadjamabsen_picture'] = "";
        if (isset($_FILES['jamabsen_picture']) && $_FILES['jamabsen_picture']['name'] != "") {
            $jamabsen_picture = str_replace(' ', '_', $_FILES['jamabsen_picture']['name']);
            $jamabsen_picture = date("H_i_s_") . $jamabsen_picture;
            if (file_exists('assets/images/jamabsen_picture/' . $jamabsen_picture)) {
                unlink('assets/images/jamabsen_picture/' . $jamabsen_picture);
            }
            $config['file_name'] = $jamabsen_picture;
            $config['upload_path'] = 'assets/images/jamabsen_picture/';
            $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
            $config['max_size']    = '3000000000';
            $config['max_width']  = '5000000000';
            $config['max_height']  = '3000000000';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('jamabsen_picture')) {
                $data['uploadjamabsen_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
            } else {
                $data['uploadjamabsen_picture'] = "Upload Success !";
                $input['jamabsen_picture'] = $jamabsen_picture;
            }
        }

        //delete
        if ($this->input->post("delete") == "OK") {
            $cekjamabsensekolah = $this->db->where("jamabsen_id", $this->input->post("jamabsen_id"))->get("jamabsen_sekolah");
            $this->db->delete("jamabsen", array("jamabsen_id" => $this->input->post("jamabsen_id")));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->input->post("create") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'create') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $this->db->insert("jamabsen", $input);
            $data["message"] = "Insert Data Success";
        }
        //echo $_POST["create"];die;

        //update
        if ($this->input->post("change") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'change' && $e != 'jamabsen_picture') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $this->db->update("jamabsen", $input, array("jamabsen_id" => $this->input->post("jamabsen_id")));
            $data["message"] = "Update Success";
            // echo $this->db->last_query();
        }

        //cek jamabsen
        $jamabsend["jamabsen.jamabsen_id"] = $this->input->post("jamabsen_id");
        $mater = $this->db
            ->get_where('jamabsen', $jamabsend);
        // echo $this->db->last_query();	
        if ($mater->num_rows() > 0) {
            foreach ($mater->result() as $jamabsen) {
                foreach ($this->db->list_fields('jamabsen') as $field) {
                    $data[$field] = $jamabsen->$field;
                }
            }
        } else {
            foreach ($this->db->list_fields('jamabsen') as $field) {
                $data[$field] = "";
            }
        }
        return $data;
    }
}
