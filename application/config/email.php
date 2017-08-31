<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// mail, sendmail, or smtp 
// The mail sending protocol.
$config['protocol'] = 'smtp';


$config['charset'] = 'utf-8';

// TRUE or FALSE (boolean) 
// Enable word-wrap.
$config['wordwrap'] = FALSE;

// text or html   Type of mail. 
// If you send HTML email you must send it as a complete web page. 
// Make sure you don’t have any relative links or relative image paths otherwise they will not work.
$config['mailtype'] = 'html';


// TRUE or FALSE (boolean) 
// Whether to validate the email address.
$config['validate'] = FALSE;


// “\r\n” or “\n” or “\r”  
// Newline character. (Use “\r\n” to comply with RFC 822).
$config['newline'] = "\r\n";



// SMTP Port.
$config['smtp_port']      = 587;

// SMTP Timeout (in seconds). 
$config['smtp_timeout']   = '5';

// Enable persistent SMTP connections.
$config['smtp_keepalive'] = FALSE; 

// tls or ssl  
// SMTP Encryption
$config['smtp_crypto']    = 'tls'; 




// SMTP Server Address.
$config['smtp_host']      = 'smtp.gmail.com'; 

// SMTP Username.
$config['smtp_user']      = 'MyEmail'; 

// SMTP Password.
$config['smtp_pass']      = 'MyPassword'; 