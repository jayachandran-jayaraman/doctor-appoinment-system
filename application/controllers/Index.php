<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Index extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('form_validation');
    $this->load->model('user_model');
    $this->load->model('patient_model');
  }

  public function heropage()
  {
    $this->load->view('template/headerhome');
    $this->load->view('heropage');
    $this->load->view('template/footerhome');
  }

  //New registration page for all Users 
  public function signup()
  {
    $this->load->view('user/signup_view');
  }

  public function submit_signup()
  {
    $this->form_validation->set_rules('email', 'email', 'required|is_unique[signup.email]', array('is_unique' => 'Email already exists!'));

    if ($this->form_validation->run() == true) {
      $data['firstname'] = $this->input->post('name');
      $data['email'] = $this->input->post('email');
      $data['phone'] = $this->input->post('phone');
      $data['password'] = $this->input->post('password');

      $response = $this->user_model->store($data);
      if ($response == true) {
        echo 'Successfully registered';
        redirect('index/login');
      } else {
        echo 'Failed to register';
      }
    } else {
      $this->load->view('user/signup_view');
    }
  }

  //login verification page 
  public function login()
  {
    // if ($this->session->has_userdata('id')) {
    //   redirect('index/heropage');
    // }
    $this->load->view('login_view');
  }

  public function do_login()
  {
    // Validate form inputs
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('login_view');
    } else {
      $email = $this->input->post('email');
      $password = $this->input->post('password');

      $user = $this->user_model->getUser($email);

      if ($user) {
        if ($password == $user->password) {
          $this->session->set_userdata([
            'id' => $user->id,
            'role' => $user->role,
            'email' => $user->email
          ]);

          // Redirect based on role
          if ($user->role == 1) {
            redirect('data');
          } else {
            redirect('index/dashboard');
          }
        } else {
          $data['error'] = 'Invalid password!';
          $this->load->view('login_view', $data);
        }
      } else {
        $data['error'] = 'No account exists with this email!';
        $this->load->view('login_view', $data);
      }
    }
  }

  public function dashboard()
  {
    // Get user ID from session
    $user_id = $this->session->userdata('id');
    $user_data = $this->user_model->getUser_by_id($user_id);

    // Prepare data for view - extract individual variables for header.php
    $data = array();
    if ($user_data) {
      $data['firstname'] = $user_data->firstname; // Make sure this matches your database column
      $data['id'] = $user_data->id;
      $data['user'] = $user_data; // Keep the full user object as well
    } else {
      // Set default values if user not found
      $data['firstname'] = 'User';
      $data['id'] = 'Unknown';
      $data['user'] = null;
    }

    $this->load->view('template/header', $data);
    $this->load->view('user/dashbord', $data);
    $this->load->view('template/footer');
  }

  public function logout()
  {
    $this->session->unset_userdata('id');
    $this->session->unset_userdata('role');
    $this->session->unset_userdata('email');
    redirect('index/login');
  }

  public function forgot_password()
  {
    $this->load->view('forgot_password');
  }

  public function send_password()
  {
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('forgot_password');
    } else {
      $email = $this->input->post('email');
      $user = $this->user_model->getUserByEmail($email);

      if ($user) {
        // Load Email Library
        $this->load->library('email');

        // SMTP Configuration
        $config = array(
          'protocol' => 'smtp',
          'smtp_host' => 'smtp.gmail.com',
          'smtp_port' => 587,
          'smtp_user' => 'jayachandranjaya82@gmail.com',
          'smtp_pass' => 'jlwglhhcxuacrygb',
          'smtp_crypto' => 'tls',
          'mailtype' => 'html',
          'charset' => 'utf-8',
          'newline' => "\r\n",
          'wordwrap' => TRUE
        );

        $this->email->initialize($config);

        // Compose Email
        $this->email->from('jayachandranjaya82@gmail.com', 'Jayachandran');
        $this->email->to($email);
        $this->email->subject('Your Password');
        $this->email->message('<p>Your password is: <strong>' . $user->password . '</strong></p>');

        // Send Email
        if ($this->email->send()) {
          echo "Email has been sent! Please check your inbox.";
        } else {
          show_error($this->email->print_debugger());
        }
      } else {
        echo "No user with this email exists!";
      }
    }
  }

  // 🔍 Return all doctor details (name + specialist)
  public function doctor_details()
  {
    $this->db->select('id, firstname, specialist');
    $this->db->from('doctor');
    $query = $this->db->get();

    return ($query->num_rows() > 0) ? $query->result() : [];
  }

  // 🔎 Return JSON for a specific doctor by ID
  public function get_doctor_details()
  {
    header('Content-Type: application/json');
    $id = $this->input->post('id', TRUE);

    if (!empty($id) && is_numeric($id)) {
      $this->db->select('id, firstname, specialist');
      $this->db->from('doctor');
      $this->db->where('id', $id);
      $query = $this->db->get();

      if ($query->num_rows() > 0) {
        $datadoctor = $query->row();
        echo json_encode([
          'success' => true,
          'id' => $datadoctor->id,
          'firstname' => $datadoctor->firstname,
          'specialist' => $datadoctor->specialist
        ]);
      } else {
        echo json_encode(['success' => false, 'error' => 'Record not found']);
      }
    } else {
      echo json_encode(['success' => false, 'error' => 'Invalid ID']);
    }
  }

  // 🔍 Autocomplete doctor search by cause (specialist or name)
  public function doctor_search()
  {
    if ($this->input->get('action') === 'search_doctor') {
      $term = trim($this->input->get('term', TRUE));
      $datadoctors = [];

      if ($term !== '') {
        $sql = "SELECT id, firstname, specialist 
                      FROM doctor 
                      WHERE firstname LIKE ? OR specialist LIKE ? 
                      LIMIT 10";
        $search_param = "%{$term}%";
        $query = $this->db->query($sql, [$search_param, $search_param]);

        foreach ($query->result_array() as $row) {
          $display_text = $row['firstname'];
          if (!empty($row['specialist'])) {
            $display_text .= " ({$row['specialist']})";
          }
          $datadoctors[] = [
            'id' => $row['id'],
            'text' => $display_text,
            'name' => $row['firstname'],
            'specialist' => $row['specialist']
          ];
        }
      }

      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(['results' => $datadoctors]));
    }
  }

  public function appointment_form()
  {
    $user_id = $this->session->userdata('id');
    $user_data = $this->user_model->getUser_by_id($user_id);

    $data = array();
    if ($user_data) {
      $data['firstname'] = $user_data->firstname;
      $data['id'] = $user_data->id;
      $data['user'] = $user_data;
    } else {
      $data['firstname'] = 'User';
      $data['id'] = 'Unknown';
      $data['user'] = null;
    }

    // Get all doctors for dropdown
    $data['doctors'] = $this->db->get('doctor')->result();

    $this->load->view('template/header', $data);
    $this->load->view('user/dashbord', $data);
    $this->load->view('template/footer', $data);
  }
  
 public function submit_details_patient()
{
    // Ensure form is submitted via POST
    if ($this->input->post('submit') !== 'true') {
        show_error('Invalid request method', 400);
        return;
    }

    // Check user session
    $user_id = $this->session->userdata('id');
    if (!$user_id) {
        $this->session->set_flashdata('error', 'Session expired. Please login again.');
        redirect('auth/login');
        return;
    }

    // Validation rules
    $this->form_validation->set_rules('reason', 'Reason', 'required|trim|min_length[5]|max_length[500]');
    $this->form_validation->set_rules('doctor', 'Doctor', 'required|trim|numeric');
    $this->form_validation->set_rules('date', 'Date', 'required|trim|callback_validate_date');
    $this->form_validation->set_rules('time', 'Time', 'required|trim');

    if ($this->form_validation->run() === FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect('index/appointment_form');
        return;
    }

    // Prepare sanitized data
    $data = array(
        'reason'     => $this->input->post('reason', TRUE),
        'doctor'     => $this->input->post('doctor', TRUE),
        'date'       => $this->input->post('date', TRUE),
        'time'       => $this->input->post('time', TRUE),
        'user_id'    => $user_id,
        'created_at' => date('Y-m-d H:i:s')
    );

    // 🔍 Debug: Print received data
    echo "<pre>Received Appointment Data:\n";
    print_r($data);
    echo "</pre>";
    exit; // Remove or comment this after confirming data flow

    // Insert into DB
    if ($this->patient_model->store_doctor($data)) {
        $this->session->set_flashdata('success', 'Appointment booked successfully!');
        redirect('user/appointments');
    } else {
        $this->session->set_flashdata('error', 'Failed to book appointment. Please try again.');
        redirect('index/appointment_form');
    }
}

// ✅ Custom date validation
public function validate_date($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    if ($d && $d->format('Y-m-d') === $date) {
        if ($d >= new DateTime('today')) {
            return TRUE;
        }
        $this->form_validation->set_message('validate_date', 'The {field} cannot be in the past.');
    } else {
        $this->form_validation->set_message('validate_date', 'The {field} must be a valid date in YYYY-MM-DD format.');
    }
    return FALSE;
}}