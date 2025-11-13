<?php
class Doctor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // 🔍 Get all appointments for a specific doctor
public function getDoctorAppointments($doctor_id) {
    $this->db->select('
        doc_db.id,
        doc_db.status,
        signup.firstname AS patient_name,
        signup.phone,
        doc_db.date,doc_db.reason,
        doc_db.time,
        doctor.specialist
    ');
    $this->db->from('doc_db');
    $this->db->join('signup', 'signup.id = doc_db.user_id');
    $this->db->join('doctor', 'doctor.id = doc_db.doctor'); // assuming doc_db.doctor = doctor.id
    $this->db->where('doc_db.doctor', $doctor_id);
    $query = $this->db->get();
    return $query->num_rows() > 0 ? $query->result() : [];
}
   public function getAllRecords() {
        $this->db->select('
            doc_db.id AS record_id,
            signup.firstname AS patient_name,
            signup.email,
            doctor.firstname AS doctor_name,
            doctor.specialist,
            doc_db.date,doc_db.reason,
            doc_db.time,
            doc_db.status
        ');
        $this->db->from('doc_db');
        $this->db->join('signup', 'doc_db.user_id = signup.id');
        $this->db->join('doctor', 'doc_db.doctor = doctor.id');
        $this->db->order_by('doc_db.date', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // ✅ Update appointment status (used by doctor or admin)
    public function updateAppointmentStatus($appointment_id, $status) {
        $this->db->where('id', $appointment_id);
        $this->db->update('doc_db', ['status' => $status]);
        return $this->db->affected_rows() > 0;
    }

    // ✅ Update appointment status (restricted to patient-owned appointments)
    public function updatePatientAppointmentStatus($appointment_id, $user_id, $status) {
        $this->db->where(['id' => $appointment_id, 'user_id' => $user_id]);
        $this->db->update('doc_db', ['status' => $status]);
        return $this->db->affected_rows() > 0;
    }

    // 🔍 Optional: Get a single appointment by ID (for validation or display)
    public function getAppointmentById($appointment_id) {
        $query = $this->db->get_where('doc_db', ['id' => $appointment_id]);
        return $query->num_rows() > 0 ? $query->row() : null;
    }
}
?>