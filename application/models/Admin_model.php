<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    // Fetching all required fields from the admins table
    public function get_admins()
    {
        // Select the necessary fields from the 'admins' table
        $this->db->select('id, name, email, image, role, status, created_at');
        $query = $this->db->get('admins');  // Get data from 'admins' table
        return $query->result();  // Return the result as an array of objects
    }
 
   
    // Method to insert admin data
    public function insert_admin($admin_data) {
        return $this->db->insert('admins', $admin_data);
    }


// Update admin by id


// Delete admin by id
public function delete_admin($id) {
    $this->db->where('id', $id);
    return $this->db->delete('admins');
}

// Fetch admins with the latest one first (ordering by id desc)
public function get_all_admins() {
    $this->db->order_by('id', 'DESC'); // Order by id (latest first)
    return $this->db->get('admins')->result();
}



public function get_admin_by_id($id) {
    $this->db->where('id', $id);
    $query = $this->db->get('admins');
    return $query->row();  // Returns a single row based on ID
}

// Update admin data
public function update_admin($id, $admin_data) {
    $this->db->where('id', $id);
    return $this->db->update('admins', $admin_data);
}

// Get all admins


}