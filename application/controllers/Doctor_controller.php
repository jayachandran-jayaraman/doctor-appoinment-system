<?php
class Doctor_controller extends CI_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model("doctor_model");
        $this->load->model("user_model");
        $this->load->model("patient_model");
        $this->load->library(["form_validation", "session", "email"]);
        $this->load->helper("url");
        $this->load->database();
    }

    public function dashboard()
    {
        // Get doctor ID from session
        $doctor_id = $this->session->userdata('id');
        $doctor_data = $this->doctor_model->get_doctor_by_id($doctor_id);
        
        // Get appointments for the current doctor
        $appointments = $this->doctor_model->get_appointments_by_doctor_id($doctor_id);

        // Get counts for dashboard stats
        $today_count = $this->doctor_model->get_today_appointments_count($doctor_id);
        $confirmed_count = $this->doctor_model->get_confirmed_appointments_count($doctor_id);
        $pending_count = $this->doctor_model->get_pending_appointments_count($doctor_id);
        $total_patients = $this->doctor_model->get_total_patients_count($doctor_id);

        // Prepare data for view
        $data = array();
        if ($doctor_data) {
            $data['firstname'] = $doctor_data->firstname;
            $data['id'] = $doctor_data->id;
            $data['specialist'] = $doctor_data->specialist;
            $data['user'] = $doctor_data;
        } else {
            $data['firstname'] = 'Doctor';
            $data['id'] = 'Unknown';
            $data['specialist'] = 'Unknown';
            $data['user'] = null;
        }

        // Add appointments and counts data to the view
        $data['appointments'] = $appointments;
        $data['today_count'] = $today_count;
        $data['confirmed_count'] = $confirmed_count;
        $data['pending_count'] = $pending_count;
        $data['total_patients'] = $total_patients;

        $this->load->view('template/doctor_header', $data);
        $this->load->view('doctor/dashboard', $data);
        $this->load->view('template/footer');
    }

    public function update_appointment_status()
    {
        if (!$this->input->post()) {
            show_error('Invalid request method', 400);
            return;
        }

        $appointment_id = $this->input->post('appointment_id');
        $status = $this->input->post('status');
        $doctor_id = $this->session->userdata('id');

        // Verify the appointment belongs to this doctor
        $appointment = $this->doctor_model->get_appointment_by_id($appointment_id);
        
        if ($appointment && $appointment->doctor == $doctor_id) {
            // Convert status to numeric if needed for database consistency
            $statusMap = [
                'pending' => 0,
                'confirmed' => 1,
                'cancelled' => 2
            ];
            
            $dbStatus = isset($statusMap[$status]) ? $statusMap[$status] : $status;
            
            if ($this->doctor_model->update_appointment_status($appointment_id, $dbStatus)) {
                $this->session->set_flashdata('success', 'Appointment status updated successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to update appointment status.');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid appointment or access denied.');
        }

        redirect('doctor_controller/dashboard');
    }

    public function cancel_appointment($appointment_id)
    {
        $doctor_id = $this->session->userdata('id');

        // Verify the appointment belongs to this doctor
        $appointment = $this->doctor_model->get_appointment_by_id($appointment_id);
        
        if ($appointment && $appointment->doctor == $doctor_id) {
            // Use numeric status for cancellation
            if ($this->doctor_model->update_appointment_status($appointment_id, 2)) {
                $this->session->set_flashdata('success', 'Appointment cancelled successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to cancel appointment.');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid appointment or access denied.');
        }

        redirect('doctor_controller/dashboard');
    }

    public function get_appointment_details($appointment_id)
    {
        $doctor_id = $this->session->userdata('id');
        $appointment = $this->doctor_model->get_appointment_details($appointment_id);
        
        // Verify the appointment belongs to this doctor
        if ($appointment && $appointment->doctor == $doctor_id) {
            echo '<div class="row">';
            echo '<div class="col-md-6">';
            echo '<h6>Patient Information</h6>';
            echo '<p><strong>Name:</strong> ' . htmlspecialchars($appointment->patient_name . ' ' . $appointment->patient_lastname) . '</p>';
            echo '<p><strong>Email:</strong> ' . htmlspecialchars($appointment->patient_email) . '</p>';
            if (!empty($appointment->patient_phone)) {
                echo '<p><strong>Phone:</strong> ' . htmlspecialchars($appointment->patient_phone) . '</p>';
            }
            echo '</div>';
            echo '<div class="col-md-6">';
            echo '<h6>Appointment Details</h6>';
            echo '<p><strong>Date:</strong> ' . date('F j, Y', strtotime($appointment->date)) . '</p>';
            echo '<p><strong>Time:</strong> ' . date('g:i A', strtotime($appointment->time)) . '</p>';
            
            // Convert status for display
            $statusMap = [0 => 'pending', 1 => 'confirmed', 2 => 'cancelled'];
            $status = is_numeric($appointment->status) ? $statusMap[$appointment->status] : $appointment->status;
            echo '<p><strong>Status:</strong> <span class="badge bg-primary">' . ucfirst($status) . '</span></p>';
            echo '</div>';
            echo '</div>';
            
            echo '<div class="row mt-3">';
            echo '<div class="col-12">';
            echo '<h6>Medical Information</h6>';
            
            // Check different possible field names for sickness/reason
            $sickness = '';
            $field_used = '';
            
            if (!empty($appointment->sickness)) {
                $sickness = $appointment->sickness;
                $field_used = 'Sickness Description';
            } elseif (!empty($appointment->reason)) {
                $sickness = $appointment->reason;
                $field_used = 'Reason for Visit';
            } elseif (!empty($appointment->symptoms)) {
                $sickness = $appointment->symptoms;
                $field_used = 'Symptoms';
            } elseif (!empty($appointment->description)) {
                $sickness = $appointment->description;
                $field_used = 'Description';
            } elseif (!empty($appointment->medical_condition)) {
                $sickness = $appointment->medical_condition;
                $field_used = 'Medical Condition';
            }
            
            if (!empty($sickness)) {
                echo '<p><strong>' . $field_used . ':</strong></p>';
                echo '<div class="alert alert-info">';
                echo '<p class="mb-0">' . nl2br(htmlspecialchars($sickness)) . '</p>';
                echo '</div>';
            } else {
                echo '<div class="alert alert-warning">';
                echo '<p class="mb-0"><i>No medical information provided by patient.</i></p>';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="alert alert-danger">Appointment not found or access denied.</div>';
        }
    }

    public function all_appointments()
    {
        $doctor_id = $this->session->userdata('id');
        $doctor_data = $this->doctor_model->get_doctor_by_id($doctor_id);
        $all_appointments = $this->doctor_model->get_all_appointments_by_doctor_id($doctor_id);

        $data = array();
        if ($doctor_data) {
            $data['firstname'] = $doctor_data->firstname;
            $data['id'] = $doctor_data->id;
            $data['specialist'] = $doctor_data->specialist;
            $data['user'] = $doctor_data;
        }

        $data['appointments'] = $all_appointments;

        $this->load->view('template/doctor_header', $data);
        $this->load->view('doctor/all_appointments', $data);
        $this->load->view('template/footer');
    }
}
?>