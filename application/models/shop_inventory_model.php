<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_inventory_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Get all shops
    public function get_shops(): mixed {
        return $this->db->get('shops')->result();
    }

    // Get all items from the inventory table
    public function get_items() {
        return $this->db->get('inventory')->result();
    }
     
    // Check if an item is already assigned to a shop
    public function is_item_assigned($shop_code, $item_name) {
        $this->db->where('shop_code', $shop_code);
        $this->db->where('item_name', $item_name);
        $query = $this->db->get('shop_inventory');
        return $query->num_rows() > 0;
    }

    // Get the current quantity of an item in a shop
    public function get_item_quantity($shop_code, $item_name) {
        $this->db->select('quantity');
        $this->db->where('shop_code', $shop_code);
        $this->db->where('item_name', $item_name);
        $query = $this->db->get('shop_inventory');
        return $query->row()->quantity;
    }

    // Update the quantity of an item in a shop
    public function update_item_quantity($shop_code, $item_name, $quantity) {
        $data = array(
            'quantity' => $quantity
        );
        $this->db->where('shop_code', $shop_code);
        $this->db->where('item_name', $item_name);
        return $this->db->update('shop_inventory', $data);
    }

    // Assign an item to a shop
    public function assign_item_to_shop($data) {
        return $this->db->insert('shop_inventory', $data);
    }

    // Get the total assigned quantity of an item across all shops
    
    public function get_total_assigned_quantity($item_name) {
        $this->db->select_sum('quantity');
        $this->db->where('item_name', $item_name);
        $query = $this->db->get('shop_inventory');
        return $query->row()->quantity ? (int)$query->row()->quantity : 0;
    }
    
    // Get the available quantity of an item from the inventory table
    
    public function get_available_quantity($item_name) {
        $this->db->select('quantity');
        $this->db->where('item_name', $item_name);
        $query = $this->db->get('inventory');
        return $query->row() ? (int)$query->row()->quantity : 0;
    }
    
    // Update the available quantity of an item in the inventory table
   
    public function update_available_quantity($item_name, $quantity) {
        $this->db->where('item_name', $item_name);
        return $this->db->update('inventory', ['quantity' => $quantity]);
    }
    

    // Get items assigned to a specific shop
    public function get_shop_items($shop_code) {
        $this->db->where('shop_code', $shop_code);
        return $this->db->get('shop_inventory')->result();
    }

    // Get all items assigned to shops
    public function get_all_shop_items() {
        return $this->db->get('shop_inventory')->result();
    }

    // Delete an item from a shop
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('shop_inventory');
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('shop_inventory', $data);
    }

    public function get_item($id) {
        $this->db->where('id', $id);
        return $this->db->get('shop_inventory')->row();
    }

    public function get_all_inventory() {
        $query = $this->db->get('shop_inventory'); // Ensure 'shop_inventory' is the correct table name
        return $query->result_array(); // Return data as an array
    }
}
?>
