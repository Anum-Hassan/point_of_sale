<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubCategoryModel extends CI_Model {

    // Get all sub-categories with their category info
    public function getAllSubCategories()
    {
        $this->db->select('sub_categories.*, categories.name as category_name');
        $this->db->from('sub_categories');
        $this->db->join('categories', 'sub_categories.category_id = categories.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getActiveCategories()
    {
        $query = $this->db->get_where('categories', ['status' => 1]); 
        return $query->result_array();
    }
    // Insert a new sub-category
    public function insertSubCategory($data)
    {
        return $this->db->insert('sub_categories', $data);
    }
    

    // Update sub-category status
    public function updateSubCategoryStatus($id, $data)
    {
        return $this->db->where('id', $id)->update('sub_categories', $data);
    }

    // Delete sub-category
    public function deleteSubCategory($id)
    {
        return $this->db->where('id', $id)->delete('sub_categories');
    }

    // Get sub-category by ID
    public function getSubCategoryById($id)
    {
        return $this->db->where('id', $id)->get('sub_categories')->row_array();
    }
    
}
