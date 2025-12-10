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
                /* foreach ($this->db->list_fields('sekolah') as $field) {
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
                } */
            }
        } else {
            foreach ($this->db->list_fields('nilai') as $field) {
                $data[$field] = "";
            }
            /* foreach ($this->db->list_fields('sekolah') as $field) {
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
            } */
        }


        if (isset($_POST['import'])) {


            if ($_FILES['filesiswa']['name'] != "") {
                $file = $_FILES['filesiswa']['tmp_name'];
                //load the excel library
                $this->load->library('excel');
                //read file from path
                $objPHPExcel = PHPExcel_IOFactory::load($file);
                //get only the Cell Collection
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                //extract to a PHP readable array format
                $row = 0;
                $column = 0;
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

                    //header will/should be in row 1 only. 
                    if ($row == 1) {
                        $header[$row][$column] = $data_value;
                    } else {
                        $arr_data[$row][$column] = $data_value;
                    }
                }

                // import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
                $gagal = 0;
                $sukses = 0;
                //echo $row." ".$column;die;

                // ambil token
                $email = $this->session->userdata("sekolah_emailwa");
                $password = $this->session->userdata("sekolah_passwordwa");
                $server = $this->session->userdata("sekolah_serverwa");
                $uri = "https://qithy.my.id/4p1.php?action=token&email=" . $email . "&password=" . $password . "";
                $user = json_decode(
                    file_get_contents($uri)
                );
                $token = $user->token;

                $sumatif = $this->db->from("sumatif")
                    ->where("sumatif_id", $this->input->post("sumatif_id"))
                    ->get();
                $sumatif_name = "";
                foreach ($sumatif->result() as $sumatif) {
                    $sumatif_name = $sumatif->sumatif_name;
                }
                if ($this->input->post("sumatif_id") == "100") {
                    $sumatif_name = "Sumatif Tengah Semester";
                }
                if ($this->input->post("sumatif_id") == "101") {
                    $sumatif_name = "Sumatif Akhir Semester";
                }

                $matpel = $this->db->from("matpel")
                    ->where("matpel_id", $this->input->post("matpel_id"))
                    ->get();
                $matpel_name = "";
                foreach ($matpel->result() as $matpel) {
                    $matpel_name = $matpel->matpel_name;
                }

                for ($x = 2; $x <= $row; $x++) {
                    //cek data

                    if ($arr_data[$x]["C"] > $this->session->userdata("sekolah_kkm")) {
                        $userrows = $this->db
                            ->select("*,user.user_id as user_id")
                            ->join("telpon", "telpon.user_id=user.user_id", "left")
                            ->where("user_nisn", $arr_data[$x]["A"])
                            ->where("kelas_id", $this->input->post("kelas_id"))
                            ->get("user");
                        if ($userrows->num_rows() > 0) {
                            foreach ($userrows->result() as $urow) {
                                $nilai = $this->db
                                    ->where("nilai.sekolah_id", $this->session->userdata("sekolah_id"))
                                    ->where("nilai.user_id", $urow->user_id)
                                    ->where("nilai.kelas_id", $this->input->post("kelas_id"))
                                    ->where("nilai.sumatif_id", $this->input->post("sumatif_id"))
                                    ->where("nilai.matpel_id", $this->input->post("matpel_id"))
                                    ->where("nilai.nilai_semester", $this->input->post("nilai_semester"))
                                    ->where("nilai.nilai_year", date("Y"))
                                    ->get("nilai");
                                // echo $this->db->last_query();
                                $nilai_id = 0;
                                $nilainumrows = $nilai->num_rows();
                                // echo  $nilainumrows;
                                foreach ($nilai->result() as $nilai) {
                                    $nilai_id = $nilai->nilai_id;
                                }
                                $user_name = $urow->user_name;
                                $nilai_score = $arr_data[$x]["C"];
                                $telpon_number = $urow->telpon_number;
                                if ($nilainumrows > 0) {


                                    $where1["nilai_id"] = $nilai_id;
                                    $input1["nilai_score"] = $arr_data[$x]["C"];
                                    $input1["nilaigagal_temporary"] = $this->input->post("nilaigagal_temporary");
                                    $this->db->update("nilai", $input1, $where1);
                                    // echo $this->db->last_query();
                                    $sukses++;

                                    $message = "Siswa " . $user_name . " telah mengikuti " . $sumatif_name . " Mapel " . $matpel_name . " dengan nilai " . $nilai_score;
                                    $urimessage = "https://qithy.my.id:8000/send-message?email=" . $email . "&token=" . $token . "&id=" . $server . "&message=" . urlencode($message) . "&number=" . $telpon_number;
                                    $options = [
                                        "http" => [
                                            "header" => "User-Agent: PHP\r\n",
                                            "timeout" => 30
                                        ]
                                    ];
                                    $context = stream_context_create($options);

                                    // Nonaktifkan error reporting sementara
                                    error_reporting(0);
                                    $uripesan = file_get_contents($urimessage, false, $context);
                                    if ($uripesan === false) {
                                        $wapesan = "Gagal mengirim pesan.";
                                    } else {
                                        $wapesan = "Pesan berhasil dikirim.";
                                    }
                                    // Aktifkan kembali error reporting
                                    error_reporting(E_ALL);
                                    
                                } else {
                                    $input2["nilaigagal_temporary"] = $this->input->post("nilaigagal_temporary");
                                    $input2["kelas_id"] = $this->input->post("kelas_id");
                                    $input2["sumatif_id"] = $this->input->post("sumatif_id");
                                    $input2["matpel_id"] = $this->input->post("matpel_id");
                                    $input2["nilai_semester"] = $this->input->post("nilai_semester");
                                    $input2["nilai_year"] = date("Y");
                                    $input2["user_id"] = $urow->user_id;
                                    $input2["sekolah_id"] = $this->session->userdata("sekolah_id");
                                    $input2["nilai_score"] = $arr_data[$x]["C"];
                                    $this->db->insert("nilai", $input2);
                                    $user_id = $this->db->insert_id();
                                    $sukses++;
                                    // echo $this->db->last_query();

                                    $message = "Siswa " . $user_name . " telah mengikuti " . $sumatif_name . " Mapel " . $matpel_name . " dengan nilai " . $nilai_score;
                                    $urimessage = "https://qithy.my.id:8000/send-message?email=" . $email . "&token=" . $token . "&id=" . $server . "&message=" . urlencode($message) . "&number=" . $telpon_number;
                                    $options = [
                                        "http" => [
                                            "header" => "User-Agent: PHP\r\n",
                                            "timeout" => 30
                                        ]
                                    ];
                                    $context = stream_context_create($options);
                                    
                                    // Nonaktifkan error reporting sementara
                                    error_reporting(0);
                                    $uripesan = file_get_contents($urimessage, false, $context);
                                    if ($uripesan === false) {
                                        $wapesan = "Gagal mengirim pesan.";
                                    } else {
                                        $wapesan = "Pesan berhasil dikirim.";
                                    }                                    
                                    // Aktifkan kembali error reporting
                                    error_reporting(E_ALL);
                                }
                            }
                        } else {
                            $input3["nilaigagal_remarks"] = "Student Not Found";
                            $input3["nilaigagal_temporary"] = $this->input->post("nilaigagal_temporary");
                            $input3["user_nisn"] = $arr_data[$x]["A"];
                            $input3["user_name"] = $arr_data[$x]["B"];
                            $input3["nilaigagal_score"] = $arr_data[$x]["C"];
                            $this->db->insert("nilaigagal", $input3);
                            $gagal++;
                        }
                    } else {
                        $input4["nilaigagal_remarks"] = "Value below KKM";
                        $input4["nilaigagal_temporary"] = $this->input->post("nilaigagal_temporary");
                        $input4["user_nisn"] = $arr_data[$x]["A"];
                        $input4["user_name"] = $arr_data[$x]["B"];
                        $input4["nilaigagal_score"] = $arr_data[$x]["C"];
                        $this->db->insert("nilaigagal", $input4);
                        $gagal++;
                    }
                }
                $data["sukses"] = $sukses;
                $data["gagal"] = $gagal;
                $data["message"] = "Import Excel Success = " . $sukses . ", Failed = " . $gagal;
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
                if ($e != 'create' && $e != 'kelas_name' && $e != 'matpel_name' && $e != 'user_name' && $e != 'sumatif_name') {
                    $input[$e] = $this->input->post($e);
                }
            }
            $double = $this->db
                ->where("user_id", $input["user_id"])
                ->where("sumatif_id", $input["sumatif_id"])
                ->where("matpel_id", $input["matpel_id"])
                ->where("nilai_semester", $input["nilai_semester"])
                ->get("nilai");
            if ($double->num_rows() == 0) {
                $input["nilai_year"] = date("Y");
                $this->db->insert("nilai", $input);
                // echo $this->db->last_query();
                $email = $this->session->userdata("sekolah_emailwa");
                $password = $this->session->userdata("sekolah_passwordwa");
                $server = $this->session->userdata("sekolah_serverwa");
                $uri = "https://qithy.my.id/4p1.php?action=token&email=" . $email . "&password=" . $password . "";
                $user = json_decode(
                    file_get_contents($uri)
                );
                $token = $user->token;

                $siswa = $this->db->from("telpon")->where("user_id", $input["user_id"])->get();
                foreach ($siswa->result() as $siswa) {

                    $kelas_name = $this->input->post("kelas_name");
                    $user_name = $this->input->post("user_name");
                    $matpel_name = $this->input->post("matpel_name");
                    $sumatif_name = $this->input->post("sumatif_name");

                    // Pesan yang akan dikirim
                    $message = "Siswa " . $user_name . " telah mengikuti " . $sumatif_name . " Mapel " . $matpel_name . " dengan nilai " . $input["nilai_score"];

                    // URL untuk mengirim pesan
                    $urimessage = "https://qithy.my.id:8000/send-message?email=" . $email . "&token=" . $token . "&id=" . $server . "&message=" . urlencode($message) . "&number=" . $siswa->telpon_number;

                    // Opsi untuk file_get_contents
                    $options = [
                        "http" => [
                            "header" => "User-Agent: PHP\r\n", // Menambahkan User-Agent ke header
                            "timeout" => 30                     // Timeout 30 detik
                        ]
                    ];

                    $context = stream_context_create($options);

                    $uripesan = file_get_contents($urimessage, false, $context);

                    if ($uripesan === false) {
                        $wapesan = "Gagal mengirim pesan.";
                    } else {
                        $wapesan = "Pesan berhasil dikirim.";
                    }

                    $data["message"] = "Insert Data Success. " . $wapesan;
                }
            } else {
                $data["message"] = "Nilai sudah ada!";
            }
        }
        //echo $_POST["create"];die;
        //update
        if ($this->input->post("change") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'change' && $e != 'nilai_picture' && $e != 'kelas_name' && $e != 'matpel_name' && $e != 'user_name' && $e != 'sumatif_name') {
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
