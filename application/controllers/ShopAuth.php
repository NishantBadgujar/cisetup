<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShopAuth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Shop_model');
    }

    public function login() {
        $this->load->view('shop/login');
    }

    public function authenticate() {
        $shop_code = $this->input->post('shop_code', TRUE); // XSS filtering
        $password = $this->input->post('password', TRUE);

        // Fetch shop details from database
        $shop = $this->Shop_model->get_shop_by_code($shop_code);

        if ($shop && ($password == $shop->password)) {
            // Set session data
            $session_data = [
                'shop_code' => $shop->shop_code,
                'shop_name' => $shop->shop_name,
                'logged_in' => TRUE
            ];
            $this->session->set_userdata($session_data);

            // Redirect to shop dashboard
            redirect('shopdashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid Shop Code or Password');
            redirect('shop/login');
        }
    }
    
    public function logout()
{
    $this->session->unset_userdata('user_id');
    $this->session->unset_userdata('shop_code');
    $this->session->sess_destroy();
    
    redirect('shop/login'); // Ensure full-page redirect to login
}

}
