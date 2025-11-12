<?php
class Admin extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('form_validation');
    $this->load->library('email');
    $this->load->model('user_model');
    $this->load->database();
    $this->load->library('session');
  }

  public function heropage()
  {
    $this->load->view('admin/pages/template/headerhome');
    $this->load->view('admin/pages/heropage');
    $this->load->view('admin/pages/template/footerhome');
  }

  // Doctor Registration
  public function doctor_signup()
  {
    $this->load->view('admin/pages/doctor_signup_view');
  }

  public function do_doctor_signup()
  {
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[signup.email]', 
      array('is_unique' => 'Email already exists!')
    );
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
    $this->form_validation->set_rules('phone', 'Phone', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('admin/pages/doctor_signup_view');
    } else {
      $data = [
        'firstname' => $this->input->post('name'),
        'email' => $this->input->post('email'),
        'phone' => $this->input->post('phone'),
        'role' => 2, // Doctor role
        'password' => $this->input->post('password'),
        'created_at' => date('Y-m-d H:i:s')
      ];

      $response = $this->user_model->store_doctor($data);
      if ($response) {
        $this->session->set_flashdata('success', 'Doctor registered successfully!');
        redirect('admin/doctor_login');
      } else {
        $this->session->set_flashdata('error', 'Failed to register doctor');
        $this->load->view('admin/pages/doctor_signup_view');
      }
    }
  }

  // Admin Registration (Only for super admin)
  public function admin_signup()
  {
    // Check if user is super admin before allowing admin registration
    if (!$this->session->userdata('role') == 1) {
      redirect('admin/login');
    }
    
    $this->load->view('admin/pages/admin_signup_view');
  }

  public function do_admin_signup()
  {
    // Verify super admin privileges
    if (!$this->session->userdata('role') == 1) {
      redirect('admin/login');
    }

    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[signup.email]');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('admin/pages/admin_signup_view');
    } else {
      $data = [
        'firstname' => $this->input->post('name'),
        'email' => $this->input->post('email'),
        'phone' => $this->input->post('phone'),
        'role' => 1, // Admin role
        'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT), // Hash password for admin
        'created_at' => date('Y-m-d H:i:s')
      ];

      $response = $this->user_model->store_admin($data);
      if ($response) {
        $this->session->set_flashdata('success', 'Admin registered successfully!');
        redirect('admin/dashbord_admin');
      } else {
        $this->session->set_flashdata('error', 'Failed to register admin');
        $this->load->view('admin/pages/admin_signup_view');
      }
    }
  }

  // Unified Login (for both admin and doctor)
  public function login()
  {
    if ($this->session->has_userdata('id')) {
      $role = $this->session->userdata('role');
      if ($role == 1) {
        redirect('admin/dashbord_admin');
      } else {
        redirect('admin/dashbord_doctor');
      }
    }
    $this->load->view('admin/pages/login_view');
  }

  public function do_login()
  {
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() == FALSE) {
      $data['error'] = 'Form validation failed!';
      $this->load->view('admin/pages/login_view', $data);
    } else {
      $email = $this->input->post('email');
      $password = $this->input->post('password');

      $user = $this->user_model->getUser_admin($email);
      
      if ($user) {
        // For doctors: plain text comparison (consider hashing)
        // For admins: use password_verify() if you hash admin passwords
        if ($user->role == 1) {
          // Admin login - use password_verify if hashed
          if (password_verify($password, $user->password)) {
            $this->set_user_session($user);
            redirect('admin/dashbord_admin');
          } else {
            $data['error'] = 'Invalid password!';
            $this->load->view('admin/pages/login_view', $data);
          }
        } else {
          // Doctor login - plain text (consider changing to hashing)
          if ($password == $user->password) {
            $this->set_user_session($user);
            redirect('admin/dashbord_doctor');
          } else {
            $data['error'] = 'Invalid password!';
            $this->load->view('admin/pages/login_view', $data);
          }
        }
      } else {
        $data['error'] = 'No account exists with this email!';
        $this->load->view('admin/pages/login_view', $data);
      }
    }
  }

  private function set_user_session($user)
  {
    $this->session->set_userdata([
      'id' => $user->id,
      'role' => $user->role,
      'email' => $user->email,
      'firstname' => $user->firstname,
      'logged_in' => true
    ]);
  }

  public function dashbord_doctor()
  {
    $this->check_doctor_access();
    
    $user_id = $this->session->userdata('id');
    $data = $this->user_model->getUser_by_id_admin($user_id);

    $this->load->view('admin/pages/template/header', $data);
    $this->load->view('admin/pages/doctor_dashbord');
    $this->load->view('admin/pages/template/footer');
  }

  public function dashbord_admin()
  {
    $this->check_admin_access();
    
    $user_id = $this->session->userdata('id');
    $data = $this->user_model->getUser_by_id_admin($user_id);

    $this->load->view('admin/pages/template/header', $data);
    $this->load->view('admin/pages/dashbord');
    $this->load->view('admin/pages/template/footer');
  }

  private function check_doctor_access()
  {
    if (!$this->session->userdata('logged_in') || $this->session->userdata('role') < 2) {
      redirect('admin/login');
    }
  }

  private function check_admin_access()
  {
    if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 1) {
      redirect('admin/login');
    }
  }

  public function logout()
  {
    $this->session->sess_destroy();
    $this->session->set_flashdata('success', 'You have been logged out successfully');
    redirect('admin/login');
  }
}
?>