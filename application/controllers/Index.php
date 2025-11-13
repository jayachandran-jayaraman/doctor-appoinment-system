<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library(['form_validation', 'session', 'email']);
    $this->load->model(['user_model', 'patient_model']);
  }

  // 🏠 Public landing page
  public function heropage() {
    $this->load->view('template/headerhome');
    $this->load->view('heropage');
    $this->load->view('template/footerhome');
  }

  // 📝 Signup form
  public function signup() {
    $this->load->view('user/signup_view');
  }

  // 📝 Signup submission
  public function submit_signup() {
    $this->form_validation->set_rules('email', 'Email', 'required|is_unique[signup.email]', [
      'is_unique' => 'Email already exists!'
    ]);

    if ($this->form_validation->run() === TRUE) {
      $data = [
        'firstname' => $this->input->post('name'),
        'email'     => $this->input->post('email'),
        'phone'     => $this->input->post('phone'),
        'password'  => $this->input->post('password') // 🔒 Consider hashing in production
      ];

      if ($this->user_model->store($data)) {
        redirect('index/login');
      } else {
        $data['error'] = 'Failed to register.';
        $this->load->view('user/signup_view', $data);
      }
    } else {
      $this->load->view('user/signup_view');
    }
  }

  // 🔐 Login form
  public function login() {
    if ($this->session->has_userdata('id')) {
      redirect('index/dashboard');
    }
    $this->load->view('login_view');
  }

  // 🔐 Login handler
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
        'firstname' => $user->firstname
      ]);

      redirect($user->role == 1 ? 'data' : 'index/dashboard');
    } else {
      $data['error'] = 'Invalid email or password!';
      $this->load->view('login_view', $data);
    }
  }

  // 🏠 Dashboard
  public function dashboard() {
    $data = $this->get_user_data();
    $this->load->view('template/header', $data);
    $this->load->view('user/dashbord', $data);
    $this->load->view('template/footer');
  }

  // 🚪 Logout
  public function logout() {
    $this->session->sess_destroy();
    redirect('index/login');
  }

  // 🔑 Forgot password form
  public function forgot_password() {
    $this->load->view('forgot_password');
  }

  // 📧 Send password via email
  public function send_password() {
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

    if ($this->form_validation->run() === FALSE) {
      $this->load->view('forgot_password');
      return;
    }

    $email = $this->input->post('email');
    $user = $this->user_model->getUserByEmail($email);

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
      $this->email->from('jayachandranjaya82@gmail.com', 'Jayachandran');
      $this->email->to($email);
      $this->email->subject('Your Password');
      $this->email->message('<p>Your password is: <strong>' . $user->password . '</strong></p>');

      if ($this->email->send()) {
        echo "Email has been sent! Please check your inbox.";
      } else {
        show_error($this->email->print_debugger());
      }
    } else {
      echo "No user with this email exists!";
    }
  }

  // 📅 Appointment form
  public function appointment_form() {
    $data = $this->get_user_data();
    $datadoctor['doctors'] = $this->patient_model->get_all_doctors();
    $this->load->view('template/header', $data);
    $this->load->view('user/appointment_form', $datadoctor);
    $this->load->view('template/footer');
  }
public function datashow_appoitment() {
   $data = $this->get_user_data();
       $this->load->model('doctor_model'); 
        $dataofrecord['records'] = $this->doctor_model->getAllRecords();
        $this->load->view('template/header', $data);
        $this->load->view('user/appoinment', $dataofrecord);
        $this->load->view('template/footer');
    }
  // 📋 Appointments by doctor
  // public function appointments_by_id($doctor_id) {
  //   $data = $this->get_user_data();
  //   $datadoctor['appointments'] = $this->patient_model->get_appointments_by_doctor_id($doctor_id);
  //   $this->load->view('template/header', $data);
  //   $this->load->view('user/appoinment', $datadoctor);
  //   $this->load->view('template/footer');
  // }

  // 📋 Appointments by logged-in user
// public function appoinments() {
//   if (!$this->session->has_userdata('id')) {
//     redirect('index/login'); // or show a message
//     return;
//   }

//   $user_id = $this->session->userdata('id');
//   $data = $this->get_user_data();
//   $data['appointments'] = $this->patient_model->get_appointments_by_user_id_data($user_id);
//   $this->load->view('template/header', $data);
//   $this->load->view('user/appoinment', $data);
//   $this->load->view('template/footer');
// }

  // 🔧 Helper: get user data from session
  private function get_user_data() {
    return [
      'id'        => $this->session->userdata('id'),
      'firstname' => $this->session->userdata('firstname'),
      'email'     => $this->session->userdata('email')
    ];
  }
}
?>