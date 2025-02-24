<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model {

    public function insert_admin($admin_data) {
        return $this->db->insert('admins', $admin_data);
    }
    public function check_admin_login($email, $password)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('admins');

        if ($query->num_rows() == 1) {
            $admin = $query->row();

            if (password_verify($password, $admin->password)) {
                return $admin;
            }
        }
        return false;
    }
    // Authenticate user credentials
    public function authenticate($email, $password) {
        // Query the database to find the user by email
        $this->db->where('email', $email);
        $query = $this->db->get('users');  // Assuming 'users' is your table name
        
        if ($query->num_rows() == 1) {
            $user = $query->row();
            // Check if the password matches
            if (password_verify($password, $user->password)) {
                return $user;  // Return the user data if password is correct
            }
        }

        return false;  // Return false if the credentials are incorrect
    }
}
