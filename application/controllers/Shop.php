<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {

    

    public function index() {
        $data['shops'] = $this->Shop_model->get_all_shops();
        $this->load->view('shop/index', $data);
    }

    

    

    public function edit($id) {
        $data['shop'] = $this->Shop_model->get_shop_by_id($id);
        $this->load->view('shop/edit', $data);
    }

    public function update($id) {
        $data = array(
            'shop_code' => $this->input->post('shop_code'),
            'name' => $this->input->post('name'),
            'location' => $this->input->post('location'),
            'password' => $this->input->post('password')

        );
        $this->Shop_model->update_shop($id, $data);
        redirect('shop');
    }

    public function delete($id) {
        $this->Shop_model->delete_shop($id);
        redirect('shop');
    }
    

    public function __construct() {
        parent::__construct();
        $this->load->model('Shop_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function insert() {
        $shop_code = $this->input->post('shop_code');
        $name = $this->input->post('name');
        $location = $this->input->post('location');
        $password = $this->input->post('password');

        // Check if shop code already exists
        if ($this->Shop_model->shop_code_exists($shop_code)) {
            $this->session->set_flashdata('error', 'Shop code already exists. Please use a different shop code.');
            redirect('shop/add');
        } else {
            // Hash the password before storing it
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new shop data into the database
            $data = array(
                'shop_code' => $shop_code,
                'name' => $name,
                'location' => $location,
                'password' => $hashed_password
            );
            $this->Shop_model->insert_shop($data);
            redirect('shop/index'); // Redirect to a success page or dashboard
        }
    }

    public function add() {
        $this->load->view('shop/add');
    }

    public function success() {
        $this->load->view('shop/index');
    }
}


