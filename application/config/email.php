<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Add custom values by settings them to the $config array.
// Example: $config['smtp_host'] = 'smtp.gmail.com';
// @link https://codeigniter.com/user_guide/libraries/email.html

$config['useragent'] = 'Easy!Appointments';
$config['protocol'] = 'sendmail'; // or 'mail' smtp
$config['mailtype'] = 'html'; // or 'text'
$config['charset'] = 'utf-8';
$config['from_address'] = 'kevin@kevinp.net';
// $config['smtp_debug'] = '0'; // or '1'
// $config['smtp_auth'] = TRUE; //or FALSE for anonymous relay.
// $config['smtp_host'] = 'localhost';
// $config['smtp_user'] = '';
// $config['smtp_pass'] = '';
// $config['smtp_crypto'] = 'ssl'; // or 'tls'
// $config['smtp_port'] = 26;
// $config['smtp_timeout'] = 60;
// $config['smtp_auth'] = false;
// $config['from_name'] = '';
// $config['from_address'] = '';
// $config['reply_to'] = '';
$config['crlf'] = "\r\n";
$config['newline'] = "\r\n";
