<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends CI_Controller{


    public function __construct() {
        parent::__construct();
        $this->load->model('BillingModel');
        $this->load->helper('url');
        $this->load->library('session');
    }

    function index(){
        $data['items'] = $this->BillingModel->get_items();
        $this->load->view('BillGenerate', $data);
    }


    // public function add_item() {
    //     $this->load->helper('form');
    //     $this->load->library('form_validation');
        
    //     $this->form_validation->set_rules('name', 'Name', 'required');
    //     $this->form_validation->set_rules('price', 'Price', 'required|numeric');
    //     $this->form_validation->set_rules('gst', 'GST', 'required|numeric');
    //     $this->form_validation->set_rules('quantity', 'Quantity', 'required');
        
    //     if ($this->form_validation->run() === FALSE) {
    //         $this->session->set_flashdata('error', 'All fields are required and must be valid.');
    //         redirect('Billing');
    //     } else {
    //         $data = array(
    //             'name' => $this->input->post('name'),
    //             'price' => $this->input->post('price'),
    //             'gst' => $this->input->post('gst'),
    //             'quantity' => $this->input->post('quantity')
    //         );
    //         $this->BillingModel->add_item($data);
    //         $this->session->set_flashdata('success', 'Item added successfully.');
    //         redirect('Billing');
    //     }
    // }

    public function delete_item($id) {
        if ($this->BillingModel->delete_item($id)) {
            $this->session->set_flashdata('success', 'Item deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete item.');
        }
        redirect('Billing');
    }


    public function generate_bill() {
        // Get selected item IDs from the form
        $selected_items = $this->input->post('items');
        
        // Check if any items are selected
        if (empty($selected_items)) {
            $this->session->set_flashdata('error', 'No items selected!');
            redirect('Billing'); // or load a view with an error message
        }
        
        // Generate bill data and store it in the generated_bills table
        $bill = $this->BillingModel->generate_bill($selected_items);
        
        // Optionally, pass the bill data to your view
        $data['bill'] = $bill;
        $this->load->view('bill_view', $data);
    }
    

    public function add_item() {
        // Retrieve POST data
        $item_name = $this->input->post('name');
        $price        = $this->input->post('price');
        $gst          = $this->input->post('gst');
        $quantity     = $this->input->post('quantity');
    
        // Fetch the product details from the products table
        $this->db->where('item_name', $item_name);
        $product = $this->db->get('shop_inventory')->row_array();
    
        if (!$product) {
            $this->session->set_flashdata('error', 'Product not found!');
            redirect('Billing');
            return;
        }
    
        // Check if the requested quantity is available
        $available_stock = $product['quantity'];
        if ($quantity > $available_stock) {
            $this->session->set_flashdata('error', "Not enough stock for {$item_name}. Available: {$available_stock}, Requested: {$quantity}.");
            redirect('Billing');
            return;
        }
    
        // If enough stock is available, add the item to the items table
        $itemData = [
            'name'     => $item_name,
            'price'    => $price,
            'gst'      => $gst,
            'quantity' => $quantity
        ];
        $this->db->insert('items', $itemData);
        $this->session->set_flashdata('success', 'Item added successfully.');
        redirect('Billing');
    }
    
    
    public function get_product_price() {
        $item_name = $this->input->post('product_name');
        $shop_code = $this->session->userdata('shop_code'); // Get the logged-in shop's code
    
        // Fetch product details based on item name and shop code
        $this->db->where('item_name', $item_name);
        $this->db->where('shop_code', $shop_code);
        $product = $this->db->get('shop_inventory')->row_array();
    
        if ($product) {
            echo json_encode(['status' => true, 'price' => $product['price']]);
        } else {
            echo json_encode(['status' => false]);
        }
    }
    
    
    

    
}