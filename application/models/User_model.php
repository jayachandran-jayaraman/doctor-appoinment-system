<?php
class User_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function store($data)
    {
        $this->db->insert('signup', $data);
        return true;

    }
    public function get_all(){
        $this->db->select('*');
        $this->db->from('signup');
    }
    public function getUser($email){
        return $this->db->where('email',$email)->get('signup')->row();
   }
public function getUser_by_id($id)
{
    $this->db->select('*');
    $user = $this->db->get_where('signup', ['id' => $id])->row();

return $user;
}
//doctor and admin

    public function store_doctor($data)
    {
        $this->db->insert('doctor', $data);
        return true;

    }
    public function getUser_admin($email){
        return $this->db->where('email',$email)->get('doctor')->row();
   }
public function getUser_by_id_admin($id)
{
    $this->db->select('*');
    $user = $this->db->get_where('doctor', ['id' => $id])->row();

return $user;
}
public function logout(){
    $this->session->sess_destroy();

}
// public function getMergedAdminData() {
//     $this->db->select('
//         doctor.id AS doctor_id,
//         doctor.firstname AS doctor_name,
//         doctor.phone,
//         doctor.email AS doctor_email,
//         doctor.role,
//         doctor.specialist,
//         signup.id AS signup_id,
//         signup.email AS Patient_email,
//         signup.role,signup.firstname AS Patient_name,
//         doc_db.id AS doc_db_id,
//         doc_db.doctor AS doc_db_doctor_id,
//         doc_db.user_id,
//         doc_db.reason,doc_db.status
//     ');
//     $this->db->from('doc_db');
//     $this->db->join('signup', 'signup.id = doc_db.user_id');
//     $this->db->join('doctor', 'doctor.id = doc_db.doctor');
//     $query = $this->db->get();
//     return $query->result_array();
// }
 public function get_all_signups() {
        return $this->db->get('signup')->result(); // Fetch all rows from signup table
    }
    public function getAllDoctors($order_by = 'id', $direction = 'ASC') {
    $this->db->order_by($order_by, $direction);
    return $this->db->get('doctor')->result_array();
}
public function doc_db() {
        return $this->db->get('doc_db')->result(); // Fetch all rows from signup table
    }
}








?>