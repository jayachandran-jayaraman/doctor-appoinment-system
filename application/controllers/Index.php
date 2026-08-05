<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library(['form_validation', 'session', 'email']);
    $this->load->model(['user_model', 'patient_model']);
  }

  public function heropage() {
    $this->load->view('template/headerhome');
    $this->load->view('heropage');
    $this->load->view('template/footerhome');
  }

  public function signup() {
    $this->load->view('user/signup_view');
  }

  public function submit_signup() {
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[signup.email]', [
      'is_unique' => 'Email already exists!'
    ]);
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

    if ($this->form_validation->run() === TRUE) {
      $data = [
        'firstname' => $this->input->post('name'),
        'email'     => $this->input->post('email'),
        'phone'     => $this->input->post('phone'),
        'password'  => $this->input->post('password'),
        'role'      => 3,
        'created_at'=> date('Y-m-d H:i:s')
      ];

      if ($this->user_model->store($data)) {
        $this->session->set_flashdata('success', 'Registration successful! Please login.');
        redirect('index/login');
      } else {
        $data['error'] = 'Failed to register.';
        $this->load->view('user/signup_view', $data);
      }
    } else {
      $this->load->view('user/signup_view');
    }
  }

  public function login() {
    if ($this->session->has_userdata('id')) {
      redirect('index/dashboard');
    }
    $this->load->view('login_view');
  }

  public function do_login() {
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() === FALSE) {
      $this->load->view('login_view');
      return;
    }

    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $user = $this->user_model->getUser($email);

    if ($user && $password === $user->password) {
      $this->session->set_userdata([
        'id'        => $user->id,
        'role'      => $user->role,
        'email'     => $user->email,
        'firstname' => $user->firstname,
        'logged_in' => true
      ]);

      redirect('index/dashboard');
    } else {
      $data['error'] = 'Invalid email or password!';
      $this->load->view('login_view', $data);
    }
  }

  public function dashboard() {
    $this->require_patient_login();
    $data = $this->get_user_data();
    $data['doctors'] = $this->patient_model->get_all_doctors();
    $this->load->view('template/header', $data);
    $this->load->view('user/dashbord', $data);
    $this->load->view('template/footer');
  }

  public function logout() {
    $this->session->sess_destroy();
    redirect('index/login');
  }

  public function forgot_password() {
    $this->load->view('user/forgot_password');
  }

  public function send_password() {
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

    if ($this->form_validation->run() === FALSE) {
      $this->load->view('user/forgot_password');
      return;
    }

    $email = $this->input->post('email');
    $user = $this->user_model->getUser($email);

    if ($user) {
      $config = [
        'protocol'     => 'smtp',
        'smtp_host'    => 'smtp.gmail.com',
        'smtp_port'    => 587,
        'smtp_user'    => 'jayachandranjaya82@gmail.com',
        'smtp_pass'    => 'jlwglhhcxuacrygb',
        'smtp_crypto'  => 'tls',
        'mailtype'     => 'html',
        'charset'      => 'utf-8',
        'newline'      => "\r\n",
        'wordwrap'     => TRUE
      ];

      $this->email->initialize($config);
      $this->email->from('jayachandranjaya82@gmail.com', 'MedCare');
      $this->email->to($email);
      $this->email->subject('Your Password');
      $this->email->message('<p>Your password is: <strong>' . htmlspecialchars($user->password) . '</strong></p>');

      if ($this->email->send()) {
        $this->session->set_flashdata('success', 'Password sent to your email.');
        redirect('index/login');
      } else {
        $data['error'] = 'Failed to send email. Please try again later.';
        $this->load->view('user/forgot_password', $data);
      }
    } else {
      $data['error'] = 'No user with this email exists.';
      $this->load->view('user/forgot_password', $data);
    }
  }

  public function appointment_form() {
    redirect('index/dashboard');
  }

  public function datashow_appoitment() {
    $this->require_patient_login();
    $data = $this->get_user_data();
    $user_id = $this->session->userdata('id');
    $data['records'] = $this->patient_model->get_appointments_by_user_id($user_id);
    $this->load->view('template/header', $data);
    $this->load->view('user/appoinment', $data);
    $this->load->view('template/footer');
  }

  public function appointments_by_id($doctor_id) {
    $this->require_patient_login();
    $data = $this->get_user_data();
    $user_id = $this->session->userdata('id');
    $data['records'] = $this->patient_model->get_appointments_by_user_id($user_id);
    $this->load->view('template/header', $data);
    $this->load->view('user/appoinment', $data);
    $this->load->view('template/footer');
  }

  private function require_patient_login() {
    if (!$this->session->has_userdata('id')) {
      redirect('index/login');
    }
  }

  private function get_user_data() {
    return [
      'id'        => $this->session->userdata('id'),
      'firstname' => $this->session->userdata('firstname'),
      'email'     => $this->session->userdata('email')
    ];
  }
}
