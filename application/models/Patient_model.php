<?php
class Patient_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    // Store patient data
    public function store($data) {
        return $this->db->insert('doc_db', $data);
    }

    // Search doctors by specialist or name
    public function search_doctors_by_specialist($term) {
        $this->db->select('id, firstname, specialist');
        $this->db->from('doctor');
        $this->db->like('specialist', $term);
        $this->db->or_like('firstname', $term);
        $this->db->limit(10);
        return $this->db->get()->result_array();
    }

    // Store appointment data
    public function store_doctor($appointment_data) {
        return $this->db->insert('doc_db', $appointment_data);
    }

    // Get user by ID
    public function getUser_by_id($id) {
        $this->db->select('*');
        $this->db->from('doc_db');
        $this->db->where('id', $id);
        return $this->db->get()->row(); // Return single user object
    }

    // Get appointments by doctor ID
    public function get_appointments_by_doctor_id($doctor_id) {
        $this->db->select('*');
        $this->db->from('doc_db');
        $this->db->where('doctor', $doctor_id);
        return $this->db->get()->result();
    }

    // Get appointments by doctor name (joins doctor table)
    public function get_appointments_by_doctor_name($name) {
        $this->db->select('doc_db.*');
        $this->db->from('doc_db');
        $this->db->join('doctor', 'doc_db.doctor = doctor.id');
        $this->db->like('doctor.firstname', $name);
        return $this->db->get()->result();
    }
}
?>