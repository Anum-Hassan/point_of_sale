<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends MY_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->helper('url'); 
    }

    public function index() 
    {
        $this->load->view('dashboard');
    }
}
