<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        // Load the database library
        $this->load->database();
    }

    // Fetch all categories
    public function getAllCategories()
    {
        $query = $this->db->get('categories');  // 'categories' is your table name
        return $query->result_array();
    }

    // Insert new category
    public function insertCategory($data)
    {
        return $this->db->insert('categories', $data);
    }

    // Update category status (published/unpublished)
    public function updateCategoryStatus($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }

    // Delete category by ID
    public function deleteCategory($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('categories');
    }

    // Fetch category by ID (optional for editing)
    public function getCategoryById($id)
    {
        $query = $this->db->get_where('categories', ['id' => $id]);
        return $query->row_array();
    }
}
