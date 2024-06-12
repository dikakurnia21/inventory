<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_items($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('items');
        return $query->result();
    }

    public function insert_item($data) {
        return $this->db->insert('items', $data);
    }

    public function get_item($id) {
        $query = $this->db->get_where('items', array('id' => $id));
        return $query->row();
    }

    public function update_item($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('items', $data);
    }

    public function delete_item($id) {
        $this->db->where('id', $id);
        return $this->db->delete('items');
    }

    public function empty_items($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->delete('items');
    }

}
?>
