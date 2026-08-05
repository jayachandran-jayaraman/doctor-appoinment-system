<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['doctor_model', 'user_model']);
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
        $this->load->database();
    }

    public function updateStatus() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 2) {
            redirect('admin/login');
            return;
        }

        $appointment_id = $this->input->post('appointment_id');
        $status = $this->input->post('status');

        $allowed = ['0', '1', '2', '3'];
        if (!in_array($status, $allowed, true)) {
            $status = '0';
        }

        $updated = $this->doctor_model->updateAppointmentStatus($appointment_id, $status);

        if ($updated) {
            $this->session->set_flashdata('success', 'Status updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update status.');
        }

        redirect('admin/doctor_dashbord');
    }
}
