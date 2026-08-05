<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admincontroller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    private function check_admin_access()
    {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 1) {
            redirect('admin/login');
        }
    }

    private function load_admin_dashboard($data = [])
    {
        $user_id = $this->session->userdata('id');
        $header = $this->user_model->getUser_by_id_admin($user_id);

        $this->load->view('admin/pages/template/header', $header);
        $this->load->view('admin/pages/dashbord', $data);
        $this->load->view('admin/pages/template/footer');
    }

    public function merged_doctor_view_signup()
    {
        $this->check_admin_access();
        $data['signups'] = $this->user_model->get_all_signups();
        $this->load_admin_dashboard($data);
    }

    public function showDoctors()
    {
        $this->check_admin_access();
        $data['doctors'] = $this->user_model->getAllDoctors();
        $this->load_admin_dashboard($data);
    }

    public function merged_doctor_view_doc_db()
    {
        $this->check_admin_access();
        $data['patients'] = $this->user_model->doc_db();
        $this->load_admin_dashboard($data);
    }
}
