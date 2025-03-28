<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends CI_Controller{

    function index(){
        
            $this->load->model('ProductModel');
            $data['users'] = $this->ProductModel->get();
    
            $this->load->view('ProductView', $data);
        
    }


    public function delete($id) {
        $this->load->model('ProductModel');
        $reason = $this->input->get('reason'); // Get the reason from the query parameter
    
        if (!empty($id) && !empty($reason)) {
            // Fetch the product details before deleting (optional, for logging purposes)
            $product = $this->ProductModel->getProductById($id);
            
            if ($product) {
             $shop_code = $this->session->userdata('shop_code');
                // Store the reason in a log table (optional)
                $data = array(
                    'shop_code' => $shop_code,
                    'product_name' => $product['item_name'],
                    'quantity' => $product['quantity'],
                    'reason' => $reason,
                    'deleted_at' => date('Y-m-d H:i:s')
                );
                $this->db->insert('deleted_products', $data); // Insert into a new log table
    
                // Now delete the product from the main products table
                $this->ProductModel->deleteProduct($id);
    
                $this->session->set_flashdata('success', 'Product deleted successfully.');
            } else {
                $this->session->set_flashdata('failure', 'Product not found.');
            }
        } else {
            $this->session->set_flashdata('failure', 'Invalid request.');
        }
    
        redirect(base_url('ProductController')); // Redirect back to the products page
    }


    public function viewOrders(){
        $this->load->model('ProductModel');
            $data['orders'] = $this->ProductModel->getOrders();
    
            $this->load->view('order_products', $data);
        
    }

    public function orderProduct()
    {
        $this->load->model('ProductModel');
        $this->form_validation->set_rules('name', 'Product name' ,'trim|required');
        $this->form_validation->set_rules('quantity', 'Product quantity' ,'trim|required');

        if($this->form_validation->run()==false)
        {
            $data_error=[
                'error'=>validation_errors()
            ];
            $this->session->set_flashdata($data_error);
        }
        else
        {
             $shop_code = $this->session->userdata('shop_code');
            $data= array(
                'name' => $this->input->post('name'),
                'quantity'=>$this->input->post('quantity'),
                'shop_code' => $shop_code
            );
            // $result=$this->ProductModel->orderProduct([
            //     'name'=>$this->input->post('name'),
            //     'quantity'=>$this->input->post('quantity')
            // ]); 

            $result = $this->ProductModel->orderProduct($data);

            if($result)
            {
                $this->session->set_flashdata('inserted','Your order has been successfully done !');
            }

        }
        redirect('ProductController/viewOrders');
        
    }
}