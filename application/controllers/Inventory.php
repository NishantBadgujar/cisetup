<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Inventory_model');
        $this->load->library('form_validation');
    }

    // View all items
    public function index() {
        $data['items'] = $this->Inventory_model->get_items();
        $data['shops'] = $this->Inventory_model->get_shops();
        $this->load->view('inventory_view', $data);
    }

    // Add item
    public function add_item() {
        $this->form_validation->set_rules('item_name', 'Item Name', 'required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'item_name' => $this->input->post('item_name'),
                'quantity' => $this->input->post('quantity'),
                'price' => $this->input->post('price')
            );
            $this->Inventory_model->add_item($data);
            redirect('inventory');
        } else {
            $this->index();
        }
    }

    // Update item
    public function update_item($id) {
        $this->form_validation->set_rules('item_name', 'Item Name', 'required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
        $this->form_validation->set_rules('price', 'Shop', 'required|numeric');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'item_name' => $this->input->post('item_name'),
                'quantity' => $this->input->post('quantity'),
                'price' => $this->input->post('price')
            );
            $this->Inventory_model->update_item($id, $data);
            redirect('inventory');
        } else {
            $this->index();
        }
    }

    // Delete item
    public function delete_item($id) {
        $this->Inventory_model->delete_item($id);
        redirect('Inventory/index');
    }
    
}
?>