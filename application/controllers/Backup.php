<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class backup extends CI_Controller {


	public function index()
	{
		// Load the DB utility class
		$this->load->dbutil();
		
		// Backup your entire database and assign it to a variable
		
		
		$backup =& $this->dbutil->backup(); 
		
		// Load the file helper and write the file to your server
		
		$this->load->helper('file');
		
		write_file('schools'.date("_d_m_Y_H_i_s").'.zip', $backup); 
		
		// Load the download helper and send the file to your desktop
		
		$this->load->helper('download');
		
		force_download('schools'.date("_d_m_Y_H_i_s").'.zip', $backup);
		
	}
}
