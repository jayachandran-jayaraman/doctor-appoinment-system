<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'index/heropage';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Public routes
$route['login'] = 'admin/login';
$route['signup'] = 'index/signup';
$route['patient/login'] = 'index/login';
$route['patient/signup'] = 'index/signup';
$route['patient/dashboard'] = 'index/dashboard';
$route['patient/appointments'] = 'index/datashow_appoitment';
$route['patient/appointment/(:num)'] = 'index/appointments_by_id/$1';
$route['forgot-password'] = 'index/forgot_password';
$route['send-password'] = 'index/send_password';

// Admin routes
$route['admin'] = 'admin/login';
$route['admin/login'] = 'admin/login';
$route['admin/signup'] = 'admin/doctor_signup';
$route['admin/do_doctor_signup'] = 'admin/do_doctor_signup';
$route['admin/do_login'] = 'admin/do_login';
$route['admin/dashbord_admin'] = 'admin/dashbord_admin';
$route['admin/doctor_dashbord'] = 'admin/doctor_dashbord';
$route['admin/logout'] = 'admin/logout';
$route['admin/patient_list'] = 'Admincontroller/merged_doctor_view_signup';
$route['admin/doctor_list'] = 'Admincontroller/showDoctors';
$route['admin/status_list'] = 'Admincontroller/merged_doctor_view_doc_db';

// Patient registration & AJAX routes
$route['patient_register/submit_details_patient'] = 'Patient_register/submit_details_patient';
$route['patient_register/doctor_search'] = 'Patient_register/doctor_search';
$route['patient_register/get_doctor_details'] = 'Patient_register/get_doctor_details';

// Alias routes for user password reset pages
$route['user/send_password'] = 'index/send_password';
$route['user/login'] = 'index/login';
$route['user/forgot_password'] = 'index/forgot_password';
$route['user/signup'] = 'index/signup';
