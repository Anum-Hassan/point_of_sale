<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SalesItemsController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('SaleModel');
        $this->load->model('ProductModel');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['sales_items'] = $this->SaleModel->get_all_sales();
        $data['products'] = $this->ProductModel->getAllProducts();
        $this->load->view('sales_items', $data);
    }
    

    public function add() {
        $data['products'] = $this->ProductModel->getAllProducts();
        $this->load->view('sales', $data);
    }

    public function insert() {
        $this->form_validation->set_rules('product_id', 'Product', 'required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('sales');
        }

        $data = [
            'product_id' => $this->input->post('product_id'),
            'quantity' => $this->input->post('quantity'),
            'price' => $this->input->post('price'),
            'total' => $this->input->post('quantity') * $this->input->post('price')
        ];
        $this->SaleModel->insert_sale($data);
        redirect('sales');
    }

    public function update() {
        $this->form_validation->set_rules('id', 'Sale ID', 'required');
        $this->form_validation->set_rules('product_id', 'Product', 'required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('sales');
        }

        $id = $this->input->post('id');
        $data = [
            'product_id' => $this->input->post('product_id'),
            'quantity' => $this->input->post('quantity'),
            'price' => $this->input->post('price'),
            'total' => $this->input->post('quantity') * $this->input->post('price')
        ];

        $this->SaleModel->update_sale($id, $data);
        redirect('sales');
    }
}


