<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $allowed = ['login', 'register'];
        $current_method = $this->router->fetch_method();

        if (!in_array($current_method, $allowed) && !$this->session->userdata('admin_logged_in')) {
            $this->session->set_flashdata('error', 'Please login first.');
            redirect('login');
            exit;
        }
    }
}
