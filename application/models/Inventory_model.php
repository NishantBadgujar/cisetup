<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Add item to inventory
    public function add_item($data) {
        return $this->db->insert('inventory', $data);
    }

    // Get all items from inventory
    public function get_items() {
        $this->db->select('inventory.*, price');
        $this->db->from('inventory');
      //  $this->db->join('shops', 'id = inventory.id', 'left');
        return $this->db->get()->result_array();
    }

    // Get item by ID
    public function get_item_by_id($id) {
        return $this->db->get_where('inventory', array('id' => $id))->row_array();
    }

    // Update item in inventory
    public function update_item($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('inventory', $data);
    }

    // Delete item from inventory
    public function delete_item($id) {
        return $this->db->delete('inventory', array('id' => $id));
    }

    // Get all shops
    public function get_shops() {
        return $this->db->get('shops')->result_array();
    }
    
}
?>