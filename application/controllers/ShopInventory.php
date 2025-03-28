<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShopInventory extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('shop_inventory_model');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    // Display form to assign items to a shop
    public function assign_items() {
        $data['shops'] = $this->shop_inventory_model->get_shops();
        $data['items'] = $this->shop_inventory_model->get_items();
        $this->load->view('assign_items_form', $data);
    }

    // Save assigned items to the database
   

    // View items assigned to a shop
    public function view_shop_items($shop_code = NULL) {
        if ($shop_code) {
            // Fetch items for a specific shop
            $data['shop_items'] = $this->shop_inventory_model->get_shop_items($shop_code);
        } else {
            // Fetch all shop items
            $data['shop_items'] = $this->shop_inventory_model->get_all_shop_items();
        }

        $this->load->view('view_shop_items', $data);
    }

    public function get_total_assigned_quantity() {
        $item_name = $this->input->post('item_name');
        $total_assigned_quantity = $this->shop_inventory_model->get_total_assigned_quantity($item_name);
        echo json_encode(['total_assigned_quantity' => $total_assigned_quantity]);
    }
    // public function save_assigned_items() {
    //     $this->form_validation->set_rules('shop_code', 'Shop Code', 'required');
    //     $this->form_validation->set_rules('item_name', 'Item Name', 'required');
    //     $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
    
    //     if ($this->form_validation->run() === FALSE) {
    //         $this->assign_items();
    //     } else {
    //         $shop_code = $this->input->post('shop_code');
    //         $item_name = $this->input->post('item_name');
    //         $quantity = (int) $this->input->post('quantity');
    
    //         $this->db->trans_start(); // Start transaction
    
    //         // Get available quantity in inventory
    //         $available_quantity = (int) $this->shop_inventory_model->get_available_quantity($item_name);
    
    //         // Get current shop quantity (if assigned previously)
    //         $current_quantity_in_shop = (int) $this->shop_inventory_model->get_item_quantity($shop_code, $item_name);
    
    //         // Ensure we are not exceeding available stock
    //         if ($quantity > $available_quantity) {
    //             $this->session->set_flashdata('error', 'Quantity exceeds available stock.');
    //         } else {
    //             if ($current_quantity_in_shop > 0) {
    //                 // Update existing shop stock quantity
    //                 $new_quantity = $current_quantity_in_shop + $quantity;
    //                 $this->shop_inventory_model->update_item_quantity($shop_code, $item_name, $new_quantity);
    //             } else {
    //                 // Insert new record if the item is not assigned before
    //                 $data = [
    //                     'shop_code' => $shop_code,
    //                     'item_name' => $item_name,
    //                     'quantity' => $quantity
    //                 ];
    //                 $this->shop_inventory_model->assign_item_to_shop($data);
    //             }
    
    //             // Reduce available stock in inventory
    //             $new_available_quantity = $available_quantity - $quantity;
    //             $this->shop_inventory_model->update_available_quantity($item_name, $new_available_quantity);
    
    //             $this->session->set_flashdata('success', 'Item assigned successfully!');
    //         }
    
    //         $this->db->trans_complete(); // Complete transaction
    
    //         if ($this->db->trans_status() === FALSE) {
    //             $this->session->set_flashdata('error', 'Transaction failed. Please try again.');
    //         }
    
    //         redirect('shopinventory/assign_items');
    //     }
    // }
    
    
    public function save_assigned_items() {
        // Add validation for price along with other fields
        $this->form_validation->set_rules('shop_code', 'Shop Code', 'required');
        $this->form_validation->set_rules('item_name', 'Item Name', 'required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
    
        if ($this->form_validation->run() === FALSE) {
            $this->assign_items();
        } else {
            $shop_code = $this->input->post('shop_code');
            $item_name = $this->input->post('item_name');
            $quantity = (int) $this->input->post('quantity');
            $price = (float) $this->input->post('price');  // Retrieve the price
    
            $this->db->trans_start(); // Start transaction
    
            // Get available quantity in inventory
            $available_quantity = (int) $this->shop_inventory_model->get_available_quantity($item_name);
    
            // Get current shop quantity (if assigned previously)
            $current_quantity_in_shop = (int) $this->shop_inventory_model->get_item_quantity($shop_code, $item_name);
    
            // Ensure we are not exceeding available stock
            if ($quantity > $available_quantity) {
                $this->session->set_flashdata('error', 'Quantity exceeds available stock.');
            } else {
                if ($current_quantity_in_shop > 0) {
                    // Update existing shop stock quantity.
                    // Note: Adjust logic here if you want to update the price as well.
                    $new_quantity = $current_quantity_in_shop + $quantity;
                    $this->shop_inventory_model->update_item_quantity($shop_code, $item_name, $new_quantity);
                } else {
                    // Insert new record if the item is not assigned before
                    $data = [
                        'shop_code' => $shop_code,
                        'item_name' => $item_name,
                        'quantity'  => $quantity,
                        'price'     => $price  // Save the price with the record
                    ];
                    $this->shop_inventory_model->assign_item_to_shop($data);
                }
    
                // Reduce available stock in inventory
                $new_available_quantity = $available_quantity - $quantity;
                $this->shop_inventory_model->update_available_quantity($item_name, $new_available_quantity);
    
                $this->session->set_flashdata('success', 'Item assigned successfully!');
            }
    
            $this->db->trans_complete(); // Complete transaction
    
            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Transaction failed. Please try again.');
            }
    
            redirect('shopinventory/assign_items');
        }
    }
    
    
    public function delete($id, $shop_code = NULL) {
        $this->db->trans_start(); // Start transaction
    
        $item_data = $this->shop_inventory_model->get_item($id);
        if ($item_data) {
            $item_name = $item_data->item_name;
            $deleted_quantity = $item_data->quantity;
    
            // Remove from shop inventory
            $this->shop_inventory_model->delete($id);
    
            // Increase available inventory back
            $available_quantity = (int) $this->shop_inventory_model->get_available_quantity($item_name);
            $new_available_quantity = $available_quantity + $deleted_quantity;
            $this->shop_inventory_model->update_available_quantity($item_name, $new_available_quantity);
        }
    
        $this->db->trans_complete(); // Complete transaction
    
        if ($shop_code) {
            redirect('shopinventory/view_shop_items/' . $shop_code);
        } else {
            redirect('shopinventory/view_shop_items');
        }
    }
    
    public function update($id)
    {
        // Load the model
        $this->load->model('shop_inventory_model');
    
        // Check if the form is submitted
        if ($this->input->post()) {
            // Get the updated data from the form
            $data = array(
                'item_name' => $this->input->post('item_name'),
                'quantity' => $this->input->post('quantity'),
                
                // Add other fields as necessary
            );
    
            // Update the item in the database
            $this->shop_inventory_model->update($id, $data);
    
            // Redirect to the view shop items page
            redirect('ShopInventory/view_shop_items');
        } else {
            // Fetch the current item data for editing
            $data['item'] = $this->shop_inventory_model->get_item($id);
    
            // Load the update view
            $this->load->view('update_item', $data);
        }
    }  
    
    
}
?>
