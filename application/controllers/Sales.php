<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Sales_model');
    }

    public function index() {
        $data['sales'] = $this->Sales_model->get_all_sales();
        $this->load->view('admin/sales_analysis', $data);
    }
}
