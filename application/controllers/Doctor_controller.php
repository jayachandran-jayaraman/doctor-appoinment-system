<?php
class Doctor_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['doctor_model', 'user_model', 'patient_model']);
        $this->load->library(['form_validation', 'session', 'email']);
        $this->load->helper(['url', 'form']);
        $this->load->database();
    }

    public function viewAppointments() {
    // Get doctor ID from session
    $doctor_id = $this->session->userdata('doctor_id');

    // Check if doctor is logged in
    if (!$doctor_id) {
        // Redirect to login or show error
        redirect('login'); // or show_error('Unauthorized access');
        return;
    }

    // Fetch appointments for the logged-in doctor
    $data['appointments'] = $this->doctor_model->getDoctorAppointments($doctor_id);

    // Load the dashboard view
    $this->load->view('doctor/dashbord', $data);
}
    // Update appointment status
    public function updateStatus() {
        $appointment_id = $this->input->post('appointment_id');
        $status_code = $this->input->post('status');

        // Convert numeric status to readable text
        $status_map = [
            '1' => '1',
            '2' => '2',
            '3' => '3'
        ];
        $status = isset($status_map[$status_code]) ? $status_map[$status_code] : 'Pending';

        $updated = $this->doctor_model->updateAppointmentStatus($appointment_id, $status);

        if ($updated) {
            $this->session->set_flashdata('success', 'Status updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update status.');
        }

        redirect('admin/doctor_dashbord');
    }
}
?>