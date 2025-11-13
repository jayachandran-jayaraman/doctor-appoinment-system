<?php
class Admincontriller extends CI_controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->helper('url');
}

 public function merged_doctor_view_signup() {
        $this->load->model('user_model');
        $data['signups'] = $this->user_model->get_all_signups();
        $this->load->view('admin/pages/dashbord', $data);
    }
public function showDoctors() {
    $this->load->model('user_model');
    $data['doctors'] = $this->user_model->getAllDoctors();
    $this->load->view('admin/pages/dashbord', $data);
}
public function merged_doctor_view_doc_db() {
        $this->load->model('user_model');
        $data['patients'] = $this->user_model->doc_db();
        $this->load->view('admin/pages/dashbord', $data);
    }

}




?>