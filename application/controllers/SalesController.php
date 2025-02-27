<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SalesController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('SalesModel');
    }

    // Load Sales Page
    public function index()
    {
        $data['sales'] = $this->SalesModel->getAllSales();
        $this->load->view('sales', $data);
    }

    public function changeStatus($id, $status)
    {
        $data = ['status' => $status];
        $this->SalesModel->updateSaleStatus($id, $data);
        redirect('sales');
    }

    public function delete($id)
    {
        $this->SalesModel->deleteSale($id);
        $this->session->set_flashdata('success', 'Sale record deleted successfully!');
        redirect('sales');
    }

    public function insert()
    {
        $data = [
            'invoice_no' => $this->input->post('invoice_no'),
            'total_amount' => (float) $this->input->post('total_amount'),
            'discount' => (float) $this->input->post('discount'),
            'tax' => (float) $this->input->post('tax'),
            'final_amount' => ((float) $this->input->post('total_amount')) - ((float) $this->input->post('discount')) + ((float) $this->input->post('tax')),
            'payment_method' => $this->input->post('payment_method')
        ];        

        $this->SalesModel->insertSale($data);
        redirect('sales');
    }

    public function update()
    {
        $this->form_validation->set_rules('payment_method', 'Payment Method', 'required');
        $this->form_validation->set_rules('discount', 'Discount', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('sales');
        }

        $id = $this->input->post('id');
        $data = [
            'discount' => $this->input->post('discount'),
            'payment_method' => $this->input->post('payment_method'),
            'tax' => $this->input->post('tax'),
            'final_amount' => $this->input->post('total_amount') - $this->input->post('discount') + $this->input->post('tax')
        ];

        $this->SalesModel->updateSale($id, $data);
        redirect('sales');
    }

    // View Sales Items for a specific Sale
    public function viewSalesItems($sale_id)
    {
        $data['products'] = $this->SalesModel->getActiveProducts();
        $data['sale'] = $this->SalesModel->getSaleById($sale_id);
        $data['sales_items'] = $this->SalesModel->getSaleItems($sale_id);
        $this->load->view('sales_items', $data);
    }


    // Start Sales Items

    public function deleteItem($id)
    {
        // Fetch sale_id before deletion
        $sale = $this->SalesModel->getSaleItemById($id);
        if (!$sale) {
            $this->session->set_flashdata('error', 'Sale item not found!');
            redirect('sales');
        }

        $this->SalesModel->deleteItem($id);
        $this->session->set_flashdata('success', 'Sale record deleted successfully!');

        redirect('sales/items/' . $sale->sale_id);
    }

    public function insertItem() {
        $this->form_validation->set_rules('product_id', 'Product', 'required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
    
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('sales/items/' . $this->input->post('sale_id'));
        }
    
        $sale_id = $this->input->post('sale_id');
        $data = [
            'sale_id' => $sale_id,
            'product_id' => $this->input->post('product_id'),
            'quantity' => $this->input->post('quantity'),
            'price' => $this->input->post('price'),
            'total' => $this->input->post('quantity') * $this->input->post('price')
        ];
    
        $this->SalesModel->insertItem($data);
        $this->SalesModel->updateSaleTotal($sale_id);
    
        redirect('sales/items/' . $sale_id);
    }
    

    public function updateItem()
    {
        $this->form_validation->set_rules('product_id', 'Product', 'required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('sales/items/' . $this->input->post('sale_id'));
        }

        $id = $this->input->post('id');
        $data = [
            'product_id' => $this->input->post('product_id'),
            'quantity' => $this->input->post('quantity'),
            'price' => $this->input->post('price'),
            'total' => $this->input->post('quantity') * $this->input->post('price')
        ];

        $this->SalesModel->update_sale($id, $data);
        redirect('sales/items/' . $this->input->post('sale_id'));
    }

    // End Sales Items
}
