<?php
class Patient_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function store_appointment($data) {
        if (!isset($data['status'])) {
            $data['status'] = '0';
        }
        return $this->db->insert('doc_db', $data);
    }

    public function get_all_doctors() {
        return $this->db->select('id, firstname, specialist')
                        ->from('doctor')
                        ->where('role', 2)
                        ->get()
                        ->result();
    }

    public function search_doctors_by_specialist($term) {
        return $this->db->select('id, firstname, specialist')
                        ->from('doctor')
                        ->where('role', 2)
                        ->group_start()
                        ->like('specialist', $term)
                        ->or_like('firstname', $term)
                        ->group_end()
                        ->limit(10)
                        ->get()
                        ->result_array();
    }

    public function get_appointments_by_doctor_id($doctor_id) {
        return $this->db->select('doc_db.*, doctor.firstname AS doctor_name, doctor.specialist')
                        ->from('doc_db')
                        ->join('doctor', 'doc_db.doctor = doctor.id', 'left')
                        ->where('doc_db.doctor', $doctor_id)
                        ->get()
                        ->result();
    }

    public function get_appointments_by_user_id($user_id) {
        return $this->db->select('doc_db.id AS record_id, doc_db.reason, doc_db.date, doc_db.time, doc_db.status, doctor.firstname AS doctor_name, doctor.specialist')
                        ->from('doc_db')
                        ->join('doctor', 'doc_db.doctor = doctor.id', 'left')
                        ->where('doc_db.user_id', $user_id)
                        ->order_by('doc_db.date', 'DESC')
                        ->get()
                        ->result();
    }

    public function get_doctor_by_id($id) {
        return $this->db->select('id, firstname, specialist')
                        ->from('doctor')
                        ->where('id', $id)
                        ->get()
                        ->row();
    }
}
