<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Shop_model');
        $this->load->model('Sales_model');
       
    }

    // Admin Dashboard
    public function index() {
        $data['shops'] = $this->Shop_model->get_all_shops();
        $data['sales'] = $this->Sales_model->get_all_sales();
        
        $this->load->view('admin/admin_panel', $data);
    }

    public function superadmin (){
        $this->load->view('superadmin');
    }
   
    
    // public function dashboard() {
    //     $this->load->model('Shop_inventory_model');  // Load model
    //     $data['inventory'] = $this->Shop_inventory_model->get_all_inventory(); // Fetch inventory data
    //     $this->load->view('dashboard', $data);  // Pass data to view
    //}
    public function dashboard() {
        $data['shops'] = $this->Shop_model->get_shop_inventory();
        $this->load->view('dashboard', $data);
    }
    
}
