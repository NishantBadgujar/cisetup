<?php
class Sales_model extends CI_Model {

    public function get_all_sales() {
        // Example: Fetch sales data for all shops
        return $this->db->get('sales')->result();
    }
}
