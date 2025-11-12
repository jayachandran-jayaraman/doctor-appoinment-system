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
   
}








?>