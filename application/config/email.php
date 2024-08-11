<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
/* 
| ------------------------------------------------------------------- 
| EMAIL CONFIG 
| ------------------------------------------------------------------- 
| Konfigurasi email keluar melalui mail server
| */  

/*$config['protocol']='smtp';  
$config['smtp_host']='smtp.gmail.com';  
$config['smtp_port']='465';  
$config['smtp_timeout']='30';  
$config['smtp_user']='ihsan.dulu@gmail.com';  
$config['smtp_pass']='5okelahkalo6';  
$config['charset']='utf-8';  
$config['newline']="\r\n"; */  
/*
$config['smtp_host'] = 'mail.cudocomm.com';
$config['smtp_user'] = 'ibadi.ichsan@cudocomm.com';
$config['smtp_pass'] = 'ichsan!@#';
$config['smpt_port'] = '465';
$config['protocol']  = 'smtp';
$config['mailtype']  = 'html';*/
$config['useragent']    = 'CodeIgniter';
$config['protocol']     = 'email';
$config['mailpath']     = 'C:\wamp64\sendmail\sendmail.exe -t -i';
$config['smtp_host']    = 'mail.cudocomm.com';
$config['smtp_user']    = 'ibadi.ichsan@cudocomm.com'; // Your gmail id
$config['smtp_pass']    = 'ichsan!@#'; // Your gmail Password
$config['smtp_port']    = 465;
$config['wordwrap']     = TRUE;    
$config['wrapchars']    = 76;
$config['mailtype']     = 'html';
$config['charset']      = 'iso-8859-1';
$config['validate']     = FALSE;
$config['priority']     = 3;
$config['newline']      = "\r\n";
$config['crlf']         = "\r\n";

   
/* End of file email.php */ 
/* Location: ./system/application/config/email.php */