<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load the Admin model
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->model('Admin_model');
        
            // Check if the user is logged in and if the user is an admin
          //  if (!$this->session->userdata('user_id') || $this->session->userdata('role') != 'admin') {
             //   redirect(base_url('login'));
    }
    
    // Fetch and display all admins
    public function index()
    {
        $data['admins'] = $this->Admin_model->get_admins();
        $this->load->view('admins', $data);
        
    }

    // Edit admin method (Example)
        
    
        // Admin adds a new admin
       // Add a new admin
    public function insert() {
        // Set validation rules for the form
        $this->form_validation->set_rules('name', 'Admin Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[admins.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, redirect back to the form with errors
            $this->session->set_flashdata('error', validation_errors());
            redirect('AdminController');
        } else {
            // Handle image upload
            if ($_FILES['image']['name']) {
                $config['upload_path'] = './uploads/admins/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 2048;  // Max file size 2MB
                $config['encrypt_name'] = TRUE;  // To encrypt the name

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('image')) {
                    // Image upload failed
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('AdminController');
                } else {
                    $image_data = $this->upload->data();
                    $image_path = 'uploads/admins/' . $image_data['file_name'];
                }
            } else {
                $image_path = ''; // No image uploaded
            }

            // Prepare admin data for insertion
            $admin_data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role' => $this->input->post('role') == 'admin' ? 1 : 0,  // 1 for admin, 0 for moderator
                'status' => $this->input->post('status'),
                'image' => $image_path,
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Insert the admin into the database
            $result = $this->Admin_model->insert_admin($admin_data);

            if ($result) {
                // Redirect to admin list page with success message
                $this->session->set_flashdata('success', 'Data Added uccessfully!');
            } else {
                // Failure message
                $this->session->set_flashdata('error', 'Failed to add admin.');
            }

            redirect('AdminController');
        }
    }

// Delete admin method
public function delete($id) {
    // Delete admin from the database
    $this->Admin_model->delete_admin($id);
    $this->session->set_flashdata('success', 'Data Deleted Successfully');

    redirect('AdminController');
}
 
public function update() {
    // Load necessary libraries
    $this->load->library('form_validation');
    $this->load->helper('url');
    $this->load->library('upload');  // Loading the upload library

    // Set form validation rules
    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() === FALSE) {
        // If validation fails, reload the form with errors
        $this->load->view('admin/edit');
    } else {
        // Get form data
        $admin_id = $this->input->post('id');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $role = $this->input->post('role') == 'admin' ? 1 : 0;
        $status = $this->input->post('status');
        $password = $this->input->post('password');  // Hash password if necessary

        // Handle image upload
        $old_image = $this->input->post('old_image');
        $new_image = $old_image;  // Default to the old image if no new one is uploaded

        if (!empty($_FILES['image']['name'])) {
            // Configure upload settings
            $config['upload_path'] = './uploads/admins/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2MB max size
            $this->upload->initialize($config);  // Initialize upload with config

            // Attempt to upload the new image
            if ($this->upload->do_upload('image')) {
                $file_data = $this->upload->data();
                $new_image = 'uploads/admins/' . $file_data['file_name'];  // Get the new image path

                // Optionally, delete the old image if it exists
                if ($old_image && file_exists($old_image)) {
                    unlink($old_image);
                }
            } else {
                // Upload failed, handle the error
                $error = $this->upload->display_errors();  // Get upload error message
                // You can display the error to the user here if needed, for now, we just log it
                log_message('error', 'Image upload failed: ' . $error);
            }
        }

        // Prepare data to update
        $admin_data = [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),  // Hash password
            'role' => $role,
            'status' => $status,
            'image' => $new_image  // Use the new image if uploaded, otherwise keep the old one
        ];

        // Update the admin in the database
        $this->db->where('id', $admin_id);
        $this->db->update('admins', $admin_data);
        $this->session->set_flashdata('success', 'Data Updated Successfully');

        // Redirect after success
        redirect('AdminController');   


         // Adjust to the correct redirection path
    }
}
public function edit($id) {
    $admin = $this->Admin_model->get_admin_by_id($id);
    $data['admin'] = $admin;
    // Assuming you are using this view for editing the admin
    $this->load->view('admin/edit', $data);
}



}
    ?>
    