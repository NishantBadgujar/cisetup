<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller{

    function index (){
        $this->load->view('User');
    }

    public function dashboard() {
        $this->load->view('Product');
    }
}