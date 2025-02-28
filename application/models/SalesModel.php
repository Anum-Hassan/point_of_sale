<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SalesModel extends CI_Model {

    // Fetch all sales records
    public function getAllSales() {
        return $this->db->get('sales')->result_array();
    }

    public function deleteSale($id)
    {
        return $this->db->where('id', $id)->delete('sales');
    }

    public function insertSale($data) {
        return $this->db->insert('sales', $data);
    }

    public function insertSaleItem($data) {
        return $this->db->insert('sales_items', $data);
    }

    public function updateSaleStatus($id, $data)
    {
        return $this->db->where('id', $id)->update('sales', $data);
    }

    public function updateSale($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('sales', $data);
    }
    public function updateSaleItem($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('sales_items', $data);
    }

    // Get a specific sale by ID
    public function getSaleById($sale_id) {
        return $this->db->get_where('sales', ['id' => $sale_id])->row_array();
    }
    public function getASaleById($sale_id) {
        return $this->db->get_where('sales', ['id' => $sale_id])->row();
    }

    // Fetch sale items for a specific sale
    public function getSaleItems($sale_id) {
        $this->db->select('sales_items.*, products.name as product_name');
        $this->db->from('sales_items');
        $this->db->join('products', 'sales_items.product_id = products.id', 'left');
        $this->db->where('sales_items.sale_id', $sale_id);
        return $this->db->get()->result_array();
    }

    public function getActiveProducts()
    {
        $query = $this->db->get_where('products', ['status' => 1]); 
        return $query->result_array();
    }

    public function insertItem($data) {
        $this->db->insert('sales_items', $data);
        $this->db->set('qty', 'qty - ' . (int)$data['quantity'], FALSE)
            ->where('id', $data['product_id'])
            ->update('products');
    }
    public function getSaleItemById($id) {
        return $this->db->get_where('sales_items', ['id' => $id])->row();
    }

    public function deleteItem($id)
    {
        return $this->db->where('id', $id)->delete('sales_items');
    }
    
    public function updateSaleTotal($sale_id) {
        $this->db->select('SUM(total) as total_amount');
        $this->db->where('sale_id', $sale_id);
        $query = $this->db->get('sales_items')->row();
    
        $total_amount = $query->total_amount ?? 0;
    
        $this->db->where('id', $sale_id);
        $sale = $this->db->get('sales')->row();
    
        $discount = $sale->discount ?? 0;
        $tax = $sale->tax ?? 0;
    
        $final_amount = $total_amount - $discount + $tax;
    
        $this->db->where('id', $sale_id);
        $this->db->update('sales', [
            'total_amount' => $total_amount,
            'final_amount' => $final_amount
        ]);
    }
    
}
