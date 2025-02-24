<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CategoryController extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('CategoryModel');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['categories'] = $this->CategoryModel->getAllCategories();
        $this->load->view('categories', $data);
    }

    public function insert()
    {
        $this->form_validation->set_rules('name', 'Category Name', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Please fill all required fields.');
            redirect('categories');
        }

        $data = [
            'name' => $this->input->post('name'),
            'status' => $this->input->post('status'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

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

        $inserted = $this->CategoryModel->insertCategory($data);

        if ($inserted) {
            $this->session->set_flashdata('success', 'Category added successfully!');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong.');
        }
        redirect('categories');
    }

    public function changeStatus($id, $status)
    {
        $data = ['status' => $status];
        $this->CategoryModel->updateCategoryStatus($id, $data);
        redirect('categories');
    }

    // Delete category
    public function delete($id)
    {
        $this->CategoryModel->deleteCategory($id);
        $this->session->set_flashdata('success', 'Category deleted successfully!');
        redirect('categories');
    }

    public function update()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $status = $this->input->post('status');
        $old_image = $this->input->post('old_image');
        $image = $_FILES['image']['name'];

        if (!empty($image)) {
            $config['upload_path'] = './uploads/categories/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $uploaded_image = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('categories');
                return;
            }

            if (file_exists('./uploads/categories/' . $old_image)) {
                unlink('./uploads/categories/' . $old_image);
            }
        } else {
            $uploaded_image = $old_image;
        }

        $data = [
            'name' => $name,
            'status' => $status,
            'image' => $uploaded_image
        ];

        $this->db->where('id', $id);
        if ($this->db->update('categories', $data)) {
            $this->session->set_flashdata('success', 'Category updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update category.');
        }
        redirect('categories');
    }
}
