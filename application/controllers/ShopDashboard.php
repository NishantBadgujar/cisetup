<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShopDashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Shop_model');

        // Check if shop is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('shop/login');
        }
    }

    // public function index() {
    //     $shop_code = $this->session->userdata('shop_code');
    //     $shop = $this->Shop_model->get_shop_by_code($shop_code);

    //     $data['shop'] = $shop;
    //     $this->load->view('shop/shopdashboard', $data);
    // }

    public function index() {
        // Check if session data exists
        if (!$this->session->userdata('logged_in')) {
            redirect('shop/login');
        }

        $shop_code = $this->session->userdata('shop_code'); // Retrieve shop_code from session
        //echo "Shop Code: " . $shop_code; // Debugging purpose (Remove this in production)
        
        // Load your shop dashboard view and pass shop_code
        $this->load->view('shop/shopdashboard', ['shop_code' => $shop_code]);
    }

    public function logout() {
        $this->session->unset_userdata('shop_code');
        $this->session->sess_destroy();
        redirect('shop/login');
    }
}
