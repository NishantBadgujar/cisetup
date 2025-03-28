<?php
class BillingModel extends CI_Model {
    
    public function get_items() {
        return $this->db->get('items')->result_array();
    }
    

    public function add_item($data) {
        return $this->db->insert('items', $data);
    }

    public function delete_item($id) {
        return $this->db->delete('items', array('id' => $id));
    }

      
    public function generate_bill($selected_items) {
        if (empty($selected_items)) {
            return false;
        }
    
        $this->db->where_in('id', $selected_items);
        $query = $this->db->get('items');
        $bill_items = $query->result_array();
    
        $total_amount = 0;
        $total_quantity = 0;
    
        foreach ($bill_items as $item) {
            $product_name = $item['name'];
            $quantity_needed = $item['quantity'];
    
            $this->db->where('item_name', $product_name);
            $product = $this->db->get('shop_inventory')->row_array();
    
            if (!$product) {
                return false;
            }
    
            $available_stock = $product['quantity'];
    
            if ($available_stock < $quantity_needed) {
                $this->session->set_flashdata('error', "Not enough stock for: $product_name. Available: $available_stock, Needed: $quantity_needed");
                redirect('Billing');
                return false;
            }
        }
    
        foreach ($bill_items as $item) {
            $product_name = $item['name'];
            $quantity_needed = $item['quantity'];
    
            $this->db->where('item_name', $product_name);
            $product = $this->db->get('shop_inventory')->row_array();
            
            $new_stock = $product['quantity'] - $quantity_needed;
    
            $this->db->where('item_name', $product_name);
            $this->db->update('shop_inventory', ['quantity' => $new_stock]);
    
            $price = $item['price'];
            $gst_rate = $item['gst'];
            $gst_amount = ($price * $gst_rate) / 100;
            $total_item_price = ($price + $gst_amount) * $quantity_needed;
            $total_amount += $total_item_price;
            $total_quantity += $quantity_needed;
        }
    
        $shop_code = $this->session->userdata('shop_code');

        $billData = [
            'shop_code' => $shop_code,
            'items'        => json_encode($bill_items),
            'total_amount' => $total_amount,
            'quantity'     => $total_quantity,
            'created_at'   => date('Y-m-d H:i:s')
        ];
    
        $this->db->insert('generated_bills', $billData);
        
        // Delete the billed items from the menu (items table)
        $this->db->where_in('id', $selected_items);
        $this->db->delete('items');
    
        return $billData;
    } 
}
?>
