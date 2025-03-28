<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ordersModel extends CI_Model{


    function getOrders(){
        return $this->db->get('orders')->result_array();
    }

    function getDeletedProducts(){
        return $this->db->get('deleted_products')->result_array();
    }


    public function get_all_orders() {
        $query = $this->db->get('orders');
        return $query->result_array();
    }

    // Update an order by its id
    public function update_order($order_id, $data) {
        $this->db->where('id', $order_id);
        return $this->db->update('orders', $data);
    }
}