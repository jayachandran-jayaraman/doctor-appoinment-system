<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(['form_validation', 'email', 'session']);
        $this->load->model(['patient_model', 'user_model']);
        $this->load->database();
    }

   

    // 📤 Submit appointment
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

        $data = [
            'doctor'     => $this->input->post('doctor', TRUE),
            'date'       => $this->input->post('date', TRUE),
            'time'       => $this->input->post('time', TRUE),
            'reason'     => $this->input->post('reason', TRUE),
            'user_id'    => $this->session->userdata('id'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->patient_model->store_appointment($data)) {
            $this->session->set_flashdata('success', 'Appointment booked successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to book appointment.');
        }

        redirect('index/appointments_by_id/' . $data['doctor']);
    }

    // ✅ Date validation
    public function validate_date($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        if ($d && $d->format('Y-m-d') === $date && $d >= new DateTime('today')) {
            return TRUE;
        }
        $this->form_validation->set_message('validate_date', 'Invalid or past date.');
        return FALSE;
    }

    // 🔍 Doctor search (autocomplete)
    public function doctor_search() {
        if ($this->input->get('action') === 'search_doctor') {
            $term = trim($this->input->get('term', TRUE));
            $results = $this->patient_model->search_doctors_by_specialist($term);

            $formatted = [];
            foreach ($results as $row) {
                $text = $row['firstname'];
                if (!empty($row['specialist'])) {
                    $text .= " ({$row['specialist']})";
                }
                $formatted[] = [
                    'id' => $row['id'],
                    'text' => $text,
                    'name' => $row['firstname'],
                    'specialist' => $row['specialist']
                ];
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['results' => $formatted]));
        }
    }

    // 🔎 Doctor details by ID
    public function get_doctor_details() {
        header('Content-Type: application/json');
        $id = $this->input->post('id', TRUE);

        if (!empty($id) && is_numeric($id)) {
            $doctor = $this->patient_model->get_doctor_by_id($id);
            if ($doctor) {
                echo json_encode([
                    'success' => true,
                    'id' => $doctor->id,
                    'firstname' => $doctor->firstname,
                    'specialist' => $doctor->specialist
                ]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Doctor not found']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid ID']);
        }
    }
    

    // 🔧 Helper: get user data from session
    // private function get_user_data() {
    //     return [
    //         'id'        => $this->session->userdata('id'),
    //         'firstname' => $this->session->userdata('firstname'),
    //         'email'     => $this->session->userdata('email')
    //     ];
    // }
}
?>