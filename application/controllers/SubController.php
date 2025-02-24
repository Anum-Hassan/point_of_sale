<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubController extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load the model for sub-categories
        $this->load->model('SubCategoryModel');
        $this->load->model('CategoryModel');  // If you need category data for dropdown
        $this->load->library('form_validation');
    }

 
    // Display Sub-Categories
    public function index()
    {
        
        $data['sub_categories'] = $this->SubCategoryModel->getAllSubCategories();
        $data['categories'] = $this->CategoryModel->getAllCategories();
        $this->load->view('sub_categories', $data);
    }

    // Insert new sub-category

    // Change status (Published/Unpublished)
    public function changeStatus($id, $status)
    {
        $data = ['status' => $status];
        $this->SubCategoryModel->updateSubCategoryStatus($id, $data);
        redirect('SubController');
    }

    // Delete sub-category
    public function delete($id)
    {
        $this->SubCategoryModel->deleteSubCategory($id);
        $this->session->set_flashdata('success', 'Sub-Category deleted successfully!');
        redirect('SubController');
    }

    public function insert()
    {
        // Set form validation rules
        $this->form_validation->set_rules('name', 'Sub-Category Name', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
    
        // Run validation checks
        if ($this->form_validation->run() == FALSE) {
            // If validation fails, redirect back to the form with an error message
            $this->session->set_flashdata('error', 'Please fill all required fields.');
            redirect('SubController');
        }
    
        // Prepare data for insertion
        $data = [
            'category_id' => $this->input->post('category_id'),
            'name' => $this->input->post('name'),
            'status' => $this->input->post('status'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
    
        // Handle image upload if an image was selected
        if (!empty($_FILES['image']['name'])) {
            // Image upload configuration
            $config['upload_path'] = './uploads/sub-category/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048;  // 2MB max size
            $config['file_name'] = time() . $_FILES['image']['name'];  // Unique file name
    
            $this->load->library('upload', $config);
    
            // Attempt to upload the image
            if ($this->upload->do_upload('image')) {
                // If upload is successful, get the image file name and add to the data array
                $data['image'] = $this->upload->data('file_name');
            } else {
                // If upload fails, set an error and redirect
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('SubController');
            }
        }
    
        // Insert sub-category into the database
        $inserted = $this->SubCategoryModel->insertSubCategory($data);
    
        // Check if insertion was successful
        if ($inserted) {
            $this->session->set_flashdata('success', 'Sub-Category added successfully!');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong while adding the sub-category.');
        }
    
        // Redirect back to the sub-category page
        redirect('SubController');
    }
    

}
