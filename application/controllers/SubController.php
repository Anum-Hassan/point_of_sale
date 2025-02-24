<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SubController extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('SubCategoryModel');
        $this->load->model('SubCategoryModel');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['sub_categories'] = $this->SubCategoryModel->getAllSubCategories();
        $data['categories'] = $this->SubCategoryModel->getAllCategories();
        $this->load->view('sub_categories', $data);
    }


    public function changeStatus($id, $status)
    {
        $data = ['status' => $status];
        $this->SubCategoryModel->updateSubCategoryStatus($id, $data);
        redirect('subCategories');
    }

    public function delete($id)
    {
        $this->SubCategoryModel->deleteSubCategory($id);
        $this->session->set_flashdata('success', 'Sub-Category deleted successfully!');
        redirect('subCategories');
    }

    public function insert()
    {
        $this->form_validation->set_rules('name', 'Sub-Category Name', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Please fill all required fields.');
            redirect('subCategories');
        }

        $data = [
            'category_id' => $this->input->post('category_id'),
            'name' => $this->input->post('name'),
            'status' => $this->input->post('status'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/sub-category/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048;
            $config['file_name'] = time() . $_FILES['image']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $data['image'] = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('subCategories');
            }
        }

        $inserted = $this->SubCategoryModel->insertSubCategory($data);

        if ($inserted) {
            $this->session->set_flashdata('success', 'Sub-Category added successfully!');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong while adding the sub-category.');
        }

        redirect('subCategories');
    }

    public function update()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $status = $this->input->post('status');
        $category_id = $this->input->post('category_id');
        $old_image = $this->input->post('old_image');
        $image = $_FILES['image']['name'];

        // Check if a new image is uploaded
        if (!empty($image)) {
            $config['upload_path'] = './uploads/sub-categories/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['file_name'] = time() . '_' . $_FILES['image']['name']; // Unique filename

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $uploaded_image = $this->upload->data('file_name');

                // Delete old image only if it exists
                if (!empty($old_image) && file_exists('./uploads/sub-categories/' . $old_image)) {
                    unlink('./uploads/sub-categories/' . $old_image);
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('subCategories');
                return;
            }
        } else {
            $uploaded_image = $old_image; // Keep the old image if no new image is uploaded
        }

        // Update data in the database
        $data = [
            'category_id' => $category_id,
            'name' => $name,
            'status' => $status,
            'image' => $uploaded_image
        ];

        $this->db->where('id', $id);
        if ($this->db->update('sub_categories', $data)) {
            $this->session->set_flashdata('success', 'Category updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update category.');
        }
        redirect('subCategories');
    }
}
