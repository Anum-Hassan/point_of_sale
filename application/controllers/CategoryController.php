<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryController extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load the CategoryModel to interact with the database
        $this->load->model('CategoryModel');
        // Load the form and validation helpers for form handling
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    // Display Categories Page
    public function index()
    {
        // Get all categories from the model
        $data['categories'] = $this->CategoryModel->getAllCategories();

        // Load the view and pass the categories data to it
        $this->load->view('categories', $data);
        
    }

    // Insert new category
    public function insert()
    {
        // Set validation rules for the form inputs
        $this->form_validation->set_rules('name', 'Category Name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        // If the form validation fails, reload the view with errors
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Please fill all required fields.');
            redirect('CategoryController');
        }

        // Prepare data to be inserted into the database
        $data = [
            'name' => $this->input->post('name'),
            'status' => $this->input->post('status'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/categories/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = time() . $_FILES['image']['name'];
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $data['image'] = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', 'Image upload failed.');
                redirect('categories');
            }
        }

        // Insert category into the database using the model
        $inserted = $this->CategoryModel->insertCategory($data);

        if ($inserted) {
            $this->session->set_flashdata('success', 'Category added successfully!');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong.');
        }

        redirect('categories');

        
    }

    // Change status (Published/Unpublished)
    public function changeStatus($id, $status)
    {
        $data = ['status' => $status];
        $this->CategoryModel->updateCategoryStatus($id, $data);
        redirect('CategoryController');
    }

    // Delete category
    public function delete($id)
    {
        $this->CategoryModel->deleteCategory($id);
        $this->session->set_flashdata('success', 'Category deleted successfully!');
        redirect('CategoryController');
    }

        // Other methods...
    
        // Update Category
        public function update() {
            // Get the ID and other details from POST data
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $status = $this->input->post('status');
            $old_image = $this->input->post('old_image');
            $image = $_FILES['image']['name'];
    
            // If a new image is uploaded, handle the image upload
            if (!empty($image)) {
                $config['upload_path'] = './uploads/categories/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048; // Maximum file size (2MB)
    
                $this->load->library('upload', $config);
    
                if ($this->upload->do_upload('image')) {
                    $uploaded_image = $this->upload->data('file_name');
                } else {
                    // Handle upload error (optional)
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('CategoryController');
                    return;
                }
    
                // Delete the old image if it exists
                if (file_exists('./uploads/categories/' . $old_image)) {
                    unlink('./uploads/categories/' . $old_image);
                }
            } else {
                // If no new image is uploaded, keep the old image
                $uploaded_image = $old_image;
            }
    
            // Prepare data for updating the category
            $data = [
                'name' => $name,
                'status' => $status,
                'image' => $uploaded_image
            ];
    
            // Update the category in the database
            $this->db->where('id', $id);
            if ($this->db->update('categories', $data)) {
                $this->session->set_flashdata('success', 'Category updated successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to update category.');
            }
    
            // Redirect to the category page
            redirect('CategoryController');
        }
    
        // Other methods...
    }
    
