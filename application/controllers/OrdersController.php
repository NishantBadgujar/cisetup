<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdersController extends CI_Controller{

    function getOrders(){
        $this->load->model('ordersModel');
        $data['orders'] = $this->ordersModel->getOrders();

        $this->load->view('ViewOrders',$data);
    }


    function deletedProducts(){

        $this->load->model('ordersModel');
        $data['products'] = $this->ordersModel->getDeletedProducts();
        $this->load->view('deletedProducts', $data);
    }



    public function accept_order($order_id) {
        $this->load->model('ordersModel');

        // Data to update: mark as accepted and update timestamp
        $data = [
            'status'     => 'accepted',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        if ($this->ordersModel->update_order($order_id, $data)) {
            $this->session->set_flashdata('success', 'Order accepted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to accept order.');
        }
        redirect('OrdersController/getOrders');
    }

    // Reject order endpoint
    public function reject_order($order_id) {
        $this->load->model('ordersModel');

        // Data to update: mark as rejected and update timestamp
        $data = [
            'status'     => 'rejected',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        if ($this->ordersModel->update_order($order_id, $data)) {
            $this->session->set_flashdata('success', 'Order rejected successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to reject order.');
        }
        redirect('OrdersController/getOrders');
    }
}