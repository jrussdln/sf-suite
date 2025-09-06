<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Auth_model');
    }

    public function index()
    {
        $this->load->view('auth/login');
    }
    public function load_fpass()
    {
        $this->load->view('auth/fpass');
    }
    //login process
    public function login_process()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Limit configuration
        $max_attempts = 4;
        $lockout_time = 60; // seconds (1 minute 30 seconds)

        $attempts = $this->session->userdata('login_attempts') ?? 0;
        $last_attempt_time = $this->session->userdata('last_attempt_time') ?? 0;

        $current_time = time();

        // Check if user is temporarily locked out
        if ($attempts >= $max_attempts && ($current_time - $last_attempt_time) < $lockout_time) {
            $remaining = $lockout_time - ($current_time - $last_attempt_time);
            $this->session->set_flashdata('login_error', "Too many login attempts. Try again in {$remaining} seconds.");
            redirect('auth');
            return;
        }

        $user = $this->Auth_model->get_user_by_username($username);

        if ($user && password_verify($password, $user->password)) {

            // Check if user account is blocked
            if ($user->user_account_access == 1) {
                $this->session->set_flashdata('login_error', 'Your account has been blocked.');
                redirect('auth');
                return;
            }

            // Reset login attempts on successful login
            $this->session->unset_userdata('login_attempts');
            $this->session->unset_userdata('last_attempt_time');

            // Update status
            $this->Auth_model->update_user_status($user->UserId, 'Active');

            // Set session data
            $this->session->set_userdata([
                'user_id' => $user->UserId,
                'username' => $user->username,
                'access_level' => $user->access_level,
                'Identifier' => $user->Identifier,
                'password' => $user->password,
                'logged_in' => true
            ]);

            if ($user->access_level === 'SIC') {
                $this->session->set_flashdata('redirect_to', site_url('main'));
            } elseif ($user->access_level === 'STUDENT') {
                $this->session->set_flashdata('redirect_to', site_url('main'));
            } else {
                $this->session->set_flashdata('login_error', 'Unauthorized access level.');
                redirect('auth');
                return;
            }

            $this->session->set_flashdata('redirecting', 'Redirecting... Please wait.');
            redirect('auth');
        } else {
            // Increment failed attempts
            $attempts++;
            $this->session->set_userdata('login_attempts', $attempts);
            $this->session->set_userdata('last_attempt_time', $current_time);

            $this->session->set_flashdata('login_error', 'Invalid username or password.');
            $this->session->set_flashdata('old_username', $username);
            redirect('auth');
        }
    }
    //reset password in login view
    public function fpass_process()
    {
        $username = $this->input->post('fp_username');
        $user = $this->Auth_model->get_user_by_username($username);

        if (!$user) {
            $this->session->set_flashdata('recover_error', 'Username not found.');
            redirect('auth/load_fpass');
        }

        if (empty($user->email)) {
            $this->session->set_flashdata('recover_error', 'This user has no registered email address.');
            redirect('auth/load_fpass');
        }

        $existing_reset = $this->Auth_model->has_requested_reset_today($user->UserId);

        if ($existing_reset) {
            $this->session->set_flashdata('recover_error', 'You can only reset your password once per day.');
            redirect('auth/load_fpass');
        }

        // Generate and hash new password
        $new_password = strval(rand(10000000, 99999999));
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Save new hashed password
        $this->Auth_model->update_user_password($user->UserId, $hashed_password);

        // Log the reset
        $this->db->insert('pass_reset_log_tbl', [
            'UserId'   => $user->UserId,
            'email'    => $user->email,
            'password' => $new_password, // optional: can hash this too
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Email config
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'pvpmnhs1998@gmail.com',
            'smtp_pass' => 'eonhzamfjxjehpem',
            'mailtype'  => 'text',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('pvpmnhs1998@gmail.com', 'Pedro V. Panaligan Memorial NHS');
        $this->email->to($user->email);
        $this->email->subject('Password Reset');
        $this->email->message("Hi {$user->username},\n\nYour new password is: {$new_password}\n\nPlease log in and change it immediately.");

        if ($this->email->send()) {
            $this->session->set_flashdata('recover_success', 'A new password was sent to your email.');
        } else {
            $this->session->set_flashdata('recover_error', 'Failed to send email. Please contact support.');
        }

        redirect('auth/load_fpass');
    }
    //logout
    public function logout()
    {
        $userId = $this->session->userdata('user_id');
        $this->Auth_model->update_user_status($userId, 'Inactive');

        $this->session->sess_destroy();
        redirect('auth');
    }

    public function verify_password_confirmation()
    {
        // Get input password from POST
        $input_password = $this->input->post('password');

        // Get stored password from session
        $stored_password = $this->session->userdata('password');

        if (password_verify($input_password, $stored_password)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
