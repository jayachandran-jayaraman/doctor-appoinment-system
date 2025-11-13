<?php
class Patient_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function store_appointment($data) {
        return $this->db->insert('doc_db', $data);
    }

    public function get_all_doctors() {
        return $this->db->select('id, firstname, specialist')
                        ->from('doctor')
                        ->get()
                        ->result();
    }

    public function search_doctors_by_specialist($term) {
        return $this->db->select('id, firstname, specialist')
                        ->from('doctor')
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

    public function get_doctor_by_id($id) {
        return $this->db->select('id, firstname, specialist')
                        ->from('doctor')
                        ->where('id', $id)
                        ->get()
                        ->row();
    }
    // public function get_appointments_by_user_id_data($user_id){
    //      return $this->db->select('doc_db.*, doctor.firstname AS doctor_name, doctor.specialist')
    //                     ->from('doc_db')
    //                     ->join('doctor', 'doc_db.doctor = doctor.id', 'left')
    //                     ->where('doc_db.doctor', $user_id)
    //                     ->get()
    //                     ->result();
    // }
    
}
?>