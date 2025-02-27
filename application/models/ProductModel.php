<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductModel extends CI_Model {

    // Get all products 
    public function getAllProducts()
    {
        $this->db->select('products.*, categories.name as category_name, sub_categories.name as sub_category_name');
        $this->db->from('products');
        $this->db->join('categories', 'products.category_id = categories.id');
        $this->db->join('sub_categories', 'products.sub_category_id = sub_categories.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getActiveCategories()
    {
        $query = $this->db->get_where('categories', ['status' => 1]); 
        return $query->result_array();
    }

    public function getActiveSubCategories()
    {
        $query = $this->db->get_where('sub_categories', ['status' => 1]); 
        return $query->result_array();
    }

    public function insertProduct($data)
    {
        return $this->db->insert('products', $data);
    }
    
    public function updateProductStatus($id, $data)
    {
        return $this->db->where('id', $id)->update('products', $data);
    }

    public function deleteProduct($id)
    {
        return $this->db->where('id', $id)->delete('products');
    }

    public function getProductById($id)
    {
        return $this->db->where('id', $id)->get('products')->row_array();
    }
    
    public function decreaseStock($product_id, $quantity_sold) {
        $this->db->set('qty', 'qty - ' . (int)$quantity_sold, FALSE);
        $this->db->where('id', $product_id);
        $this->db->update('products');
    }
    
}
