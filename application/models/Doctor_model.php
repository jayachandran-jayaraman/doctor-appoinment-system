<?php
class Doctor_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Get doctor by ID
    public function get_doctor_by_id($doctor_id)
    {
        $this->db->select('*');
        $this->db->from('doctors');
        $this->db->where('id', $doctor_id);
        $query = $this->db->get();
        return $query->row();
    }

    // Get appointments by doctor ID
    public function get_appointments_by_doctor_id($doctor_id)
    {
        $this->db->select('a.*, u.firstname as patient_name, u.lastname as patient_lastname, u.email as patient_email, u.phone as patient_phone');
        $this->db->from('appointments a');
        $this->db->join('users u', 'a.user_id = u.id', 'left');
        $this->db->where('a.doctor', $doctor_id);
        $this->db->where('a.status !=', 2); // Exclude cancelled appointments
        $this->db->order_by('a.date', 'ASC');
        $this->db->order_by('a.time', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get all appointments by doctor ID (including cancelled)
    public function get_all_appointments_by_doctor_id($doctor_id)
    {
        $this->db->select('a.*, u.firstname as patient_name, u.lastname as patient_lastname, u.email as patient_email, u.phone as patient_phone');
        $this->db->from('appointments a');
        $this->db->join('users u', 'a.user_id = u.id', 'left');
        $this->db->where('a.doctor', $doctor_id);
        $this->db->order_by('a.date', 'DESC');
        $this->db->order_by('a.time', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get appointment by ID
    public function get_appointment_by_id($appointment_id)
    {
        $this->db->select('*');
        $this->db->from('appointments');
        $this->db->where('id', $appointment_id);
        $query = $this->db->get();
        return $query->row();
    }

    // Get detailed appointment information
    public function get_appointment_details($appointment_id)
    {
        $this->db->select('a.*, u.firstname as patient_name, u.lastname as patient_lastname, u.email as patient_email, u.phone as patient_phone, d.firstname as doctor_name, d.specialist');
        $this->db->from('appointments a');
        $this->db->join('users u', 'a.user_id = u.id', 'left');
        $this->db->join('doctors d', 'a.doctor = d.id', 'left');
        $this->db->where('a.id', $appointment_id);
        $query = $this->db->get();
        return $query->row();
    }

    // Update appointment status
    public function update_appointment_status($appointment_id, $status)
    {
        $this->db->where('id', $appointment_id);
        return $this->db->update('appointments', array(
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ));
    }

    // Cancel appointment
    public function cancel_appointment($appointment_id)
    {
        $this->db->where('id', $appointment_id);
        return $this->db->update('appointments', array(
            'status' => 2, // 2 = cancelled
            'updated_at' => date('Y-m-d H:i:s')
        ));
    }

    // Get today's appointments count
    public function get_today_appointments_count($doctor_id)
    {
        $this->db->where('doctor', $doctor_id);
        $this->db->where('date', date('Y-m-d'));
        $this->db->where('status !=', 2); // Exclude cancelled
        return $this->db->count_all_results('appointments');
    }

    // Get confirmed appointments count
    public function get_confirmed_appointments_count($doctor_id)
    {
        $this->db->where('doctor', $doctor_id);
        $this->db->where('status', 1); // 1 = confirmed
        return $this->db->count_all_results('appointments');
    }

    // Get pending appointments count
    public function get_pending_appointments_count($doctor_id)
    {
        $this->db->where('doctor', $doctor_id);
        $this->db->where('status', 0); // 0 = pending
        return $this->db->count_all_results('appointments');
    }

    // Get total patients count (unique patients)
    public function get_total_patients_count($doctor_id)
    {
        $this->db->select('COUNT(DISTINCT user_id) as total_patients');
        $this->db->from('appointments');
        $this->db->where('doctor', $doctor_id);
        $this->db->where('status !=', 2); // Exclude cancelled appointments
        $query = $this->db->get();
        return $query->row()->total_patients;
    }

    // Get appointments by status
    public function get_appointments_by_status($doctor_id, $status)
    {
        $this->db->select('a.*, u.firstname as patient_name, u.lastname as patient_lastname, u.email as patient_email');
        $this->db->from('appointments a');
        $this->db->join('users u', 'a.user_id = u.id', 'left');
        $this->db->where('a.doctor', $doctor_id);
        $this->db->where('a.status', $status);
        $this->db->order_by('a.date', 'ASC');
        $this->db->order_by('a.time', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Update appointment details
    public function update_appointment($appointment_id, $data)
    {
        $this->db->where('id', $appointment_id);
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update('appointments', $data);
    }

    // Check if time slot is available
    public function is_time_slot_available($doctor_id, $date, $time)
    {
        $this->db->where('doctor', $doctor_id);
        $this->db->where('date', $date);
        $this->db->where('time', $time);
        $this->db->where('status !=', 2); // Exclude cancelled
        return $this->db->count_all_results('appointments') == 0;
    }

    // Get doctor's schedule
    public function get_doctor_schedule($doctor_id)
    {
        $this->db->select('*');
        $this->db->from('doctor_schedules');
        $this->db->where('doctor_id', $doctor_id);
        $query = $this->db->get();
        return $query->result();
    }

    // Get upcoming appointments (next 7 days)
    public function get_upcoming_appointments($doctor_id, $limit = 10)
    {
        $this->db->select('a.*, u.firstname as patient_name, u.lastname as patient_lastname, u.email as patient_email');
        $this->db->from('appointments a');
        $this->db->join('users u', 'a.user_id = u.id', 'left');
        $this->db->where('a.doctor', $doctor_id);
        $this->db->where('a.date >=', date('Y-m-d'));
        $this->db->where('a.status !=', 2); // Exclude cancelled
        $this->db->order_by('a.date', 'ASC');
        $this->db->order_by('a.time', 'ASC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    // Get appointment statistics for dashboard
    public function get_appointment_statistics($doctor_id)
    {
        $stats = array();
        
        // Total appointments
        $this->db->where('doctor', $doctor_id);
        $stats['total'] = $this->db->count_all_results('appointments');
        
        // This month appointments
        $this->db->where('doctor', $doctor_id);
        $this->db->where('MONTH(date)', date('m'));
        $this->db->where('YEAR(date)', date('Y'));
        $stats['this_month'] = $this->db->count_all_results('appointments');
        
        // Last month appointments
        $this->db->where('doctor', $doctor_id);
        $this->db->where('MONTH(date)', date('m', strtotime('last month')));
        $this->db->where('YEAR(date)', date('Y', strtotime('last month')));
        $stats['last_month'] = $this->db->count_all_results('appointments');
        
        return $stats;
    }
}
?>