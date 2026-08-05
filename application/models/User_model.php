<?php
class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function store($data)
    {
        return $this->db->insert('signup', $data);
    }

    public function getUser($email)
    {
        return $this->db->where('email', $email)->get('signup')->row();
    }

    public function getUserByEmail($email)
    {
        return $this->getUser($email);
    }

    public function getUser_by_id($id)
    {
        return $this->db->get_where('signup', ['id' => $id])->row();
    }

    public function store_doctor($data)
    {
        return $this->db->insert('doctor', $data);
    }

    public function getUser_admin($email)
    {
        return $this->db->where('email', $email)->get('doctor')->row();
    }

    public function getUser_by_id_admin($id)
    {
        return $this->db->get_where('doctor', ['id' => $id])->row();
    }

    public function get_all_signups()
    {
        return $this->db->get('signup')->result();
    }

    public function getAllDoctors($order_by = 'id', $direction = 'ASC')
    {
        $this->db->order_by($order_by, $direction);
        return $this->db->get('doctor')->result_array();
    }

    public function doc_db()
    {
        $this->db->select('doc_db.*, signup.firstname AS patient_name, doctor.firstname AS doctor_name');
        $this->db->from('doc_db');
        $this->db->join('signup', 'signup.id = doc_db.user_id', 'left');
        $this->db->join('doctor', 'doctor.id = doc_db.doctor', 'left');
        $this->db->order_by('doc_db.date', 'DESC');
        return $this->db->get()->result();
    }
}
