<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'index/heropage';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'admin/login';
$route['patient/login'] = 'index/login';
$route['patient/signup'] = 'index/signup';

$route['admin'] = 'Admincontroller / merged_doctor_view_doc_db';