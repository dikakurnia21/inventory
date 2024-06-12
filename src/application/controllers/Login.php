<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        // Load the login form view
        $this->load->view('login_form');
    }

    public function authenticate() {
        // Load form validation library
        $this->load->library('form_validation');
        // Set validation rules for username and password
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        // Run form validation
        if ($this->form_validation->run() == FALSE) {
            // Validation failed, load the login form view again
            $this->load->view('login_form');
        } else {
            // Validation passed, get username and password from POST data
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            // Check if the user exists in the database
            $user = $this->User_model->get_user($username, $password);

            if ($user) {
                // User exists, set session data
                $this->session->set_userdata('user_id', $user->id);
                $this->session->set_userdata('username', $user->username);
                // Redirect to the items page
                redirect('items');
            } else {
                // User does not exist, set flash data for error message
                $this->session->set_flashdata('error', 'Invalid Username or Password');
                // Redirect to the login page
                redirect('login');
            }
        }
    }

    public function logout() {
        // Unset user session data
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        // Destroy the entire session
        $this->session->sess_destroy();
        // Redirect to the login page
        redirect('login');
    }
}
?>
