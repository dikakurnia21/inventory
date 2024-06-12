<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        $this->load->view('register_form');
    }

    public function create_user() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('register_form');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            if ($this->User_model->register_user($username, $password)) {
                $this->session->set_flashdata('success', 'Registration successful. You can now log in.');
                redirect('login');
            } else {
                $this->session->set_flashdata('error', 'An error occurred. Please try again.');
                redirect('register');
            }
        }
    }
}
?>
