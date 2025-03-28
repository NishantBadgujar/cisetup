<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class ProductModel extends CI_Model{


    function get(){
       // return $this->db->get('shop_inventory')->result_array();
       $shop_code = $this->session->userdata('shop_code'); // Get the logged-in shop ID
       $this->db->where('shop_code', $shop_code); // Filter by shop ID
       $query = $this->db->get('shop_inventory'); // Assuming 'products' is your table
       return $query->result_array();
    }

    function getProduct($productId){
        $this->db->where('id', $productId);
        return $user = $this->db->get('shop_inventory')->row_array();
    }


        public function deleteProduct($id) {
            $this->db->where('id', $id);
            return $this->db->delete('shop_inventory');
        }
    
        public function getProductById($id) {
            return $this->db->where('id', $id)->get('shop_inventory')->row_array();
        }



        function getOrders(){
            // return $this->db->get('shop_inventory')->result_array();
            $shop_code = $this->session->userdata('shop_code'); // Get the logged-in shop ID
            $this->db->where('shop_code', $shop_code); // Filter by shop ID
            $query = $this->db->get('orders'); // Assuming 'products' is your table
            return $query->result_array();
         }
        public function orderProduct($data){
        
        $query=$this->db->insert('orders' ,$data);  
        if($query)
        {
            return true;
        }   
        else
        {
            return false;
        }
    }
    
    

}