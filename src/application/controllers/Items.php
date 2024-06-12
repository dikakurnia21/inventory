<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Item_model');
        $this->load->library('session');
        $this->load->helper(array('url'));

        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            redirect('login'); // Redirect to login page if not logged in
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['items'] = $this->Item_model->get_items($user_id); // Fetch items based on user_id
        $data['username'] = $this->session->userdata('username'); // Assuming you store username in session
        $this->load->view('items/index', $data);
    }

    // Method lainnya tetap sama


    public function create() {
        $this->load->view('items/create');
    }

    public function store() {
        $data = array(
            'user_id' => $this->session->userdata('user_id'), // Store user ID from session
            'name' => $this->input->post('name'),
            'quantity' => $this->input->post('quantity'),
            'description' => $this->input->post('description')
        );
        $this->Item_model->insert_item($data);
        redirect('items');
    }

    public function edit($id) {
        $data['item'] = $this->Item_model->get_item($id);
        $this->load->view('items/edit', $data);
    }

    public function update($id) {
        $data = array(
            'name' => $this->input->post('name'),
            'quantity' => $this->input->post('quantity'),
            'description' => $this->input->post('description')
        );
        $this->Item_model->update_item($id, $data);
        redirect('items');
    }

    public function delete($id) {
        $this->Item_model->delete_item($id);
        redirect('items');
    }

    // Display current user's inventory
    public function my_inventory() {
        $user_id = $this->session->userdata('user_id');
        $data['items'] = $this->Item_model->get_items($user_id); // Fetch items based on user_id
        $this->load->view('my_inventory_view', $data);
    }
}
?>
