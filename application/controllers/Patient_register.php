<?php
class Patient_register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(['form_validation', 'email', 'session']);
        $this->load->model('patient_model');
        $this->load->model('user_model');
        $this->load->database();
    }

    // Submit appointment details
    public function submit_details_patient() {
        if (!$this->input->post()) {
            show_error('Invalid request method', 400);
            return;
        }

        $this->form_validation->set_rules('doctor', 'Doctor', 'required|numeric');
        $this->form_validation->set_rules('date', 'Date', 'required|callback_validate_date');
        $this->form_validation->set_rules('time', 'Time', 'required');
        $this->form_validation->set_rules('reason', 'Reason', 'max_length[500]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('index/appointment_form');
            return;
        }

        $data = array(
            'doctor'     => $this->input->post('doctor', TRUE),
            'date'       => $this->input->post('date', TRUE),
            'time'       => $this->input->post('time', TRUE),
            'reason'     => $this->input->post('reason', TRUE),
            'user_id'    => $this->session->userdata('id'),
            'created_at' => date('Y-m-d H:i:s')
        );

        if ($this->patient_model->store_doctor($data)) {
            $this->session->set_flashdata('success', 'Appointment booked successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to book appointment. Please try again.');
        }

        redirect('patient_register/appointments');
    }

    // Custom date validation
    public function validate_date($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        if ($d && $d->format('Y-m-d') === $date) {
            if ($d >= new DateTime('today')) {
                return TRUE;
            }
            $this->form_validation->set_message('validate_date', 'The {field} cannot be in the past.');
        } else {
            $this->form_validation->set_message('validate_date', 'The {field} must be a valid date in YYYY-MM-DD format.');
        }
        return FALSE;
    }

    // Show appointments for logged-in user
    public function appointments() {
        $user_id = $this->session->userdata('id');
        $user_data = $this->user_model->getUser_by_id($user_id);

        $data = array();
        if ($user_data) {
            $data['firstname'] = $user_data->firstname;
            $data['id'] = $user_data->id;
            $data['user'] = $user_data;
        } else {
            $data['firstname'] = 'User';
            $data['id'] = 'Unknown';
            $data['user'] = null;
        }

        $this->load->view('template/header', $data);
        $this->load->view('user/appoinment', $data);
        $this->load->view('template/footer');
    }

    // Search appointments by doctor ID
    public function appointments_by_id($doctor_id) {
        $user_id = $this->session->userdata('id');
        $user_data = $this->user_model->getUser_by_id($user_id);

        $data = array();
        if ($user_data) {
            $data['firstname'] = $user_data->firstname;
            $data['id'] = $user_data->id;
            $data['user'] = $user_data;
        } else {
            $data['firstname'] = 'User';
            $data['id'] = 'Unknown';
            $data['user'] = null;
        }

        // Get appointments for the given doctor ID
        $appointments = $this->patient_model->get_appointments_by_doctor_id($doctor_id);
        $data['appointments'] = $appointments;

        $this->load->view('template/header', $data);
        $this->load->view('user/appointment_list', $data); // Create this view to display results
        $this->load->view('template/footer');
    }
}
?>