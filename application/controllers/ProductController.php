<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProductController extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ProductModel');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['sub_categories'] = $this->ProductModel->getActiveSubCategories();
        $data['categories'] = $this->ProductModel->getActiveCategories();
        $data['products'] = $this->ProductModel->getAllProducts();
        $this->load->view('products', $data);
    }

    public function changeStatus($id, $status)
    {
        $data = ['status' => $status];
        $this->ProductModel->updateProductStatus($id, $data);
        redirect('products');
    }

    public function delete($id)
    {
        $this->ProductModel->deleteProduct($id);
        $this->session->set_flashdata('success', 'Product deleted successfully!');
        redirect('products');
    }

    public function getSubCategories()
    {
        $category_id = $this->input->post('category_id');

        $this->db->where('category_id', $category_id);
        $query = $this->db->get('sub_categories'); 

        echo json_encode($query->result_array());
    }


    public function insert()
    {
        $this->form_validation->set_rules('name', 'Product Name', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('sub_category_id', 'SubCategory', 'required');
        $this->form_validation->set_rules('qty', 'Quantity', 'required');
        $this->form_validation->set_rules('mrp', 'MRP', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('shortDesc', 'Short Description', 'required');
        $this->form_validation->set_rules('longDesc', 'Long Description', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Please fill all required fields.');
            redirect('products');
        }

        $data = [
            'category_id' => $this->input->post('category_id'),
            'sub_category_id' => $this->input->post('sub_category_id'),
            'name' => $this->input->post('name'),
            'qty' => $this->input->post('qty'),
            'mrp' => $this->input->post('mrp'),
            'price' => $this->input->post('price'),
            'short_description' => $this->input->post('shortDesc'),
            'long_description' => $this->input->post('longDesc'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/products/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048;
            $config['file_name'] = time() . $_FILES['image']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $data['image'] = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('products');
            }
        }

        $inserted = $this->ProductModel->insertProduct($data);

        if ($inserted) {
            $this->session->set_flashdata('success', 'Product added successfully!');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong while adding the Product.');
        }

        redirect('products');
    }

    public function update()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $qty = $this->input->post('qty');
        $mrp = $this->input->post('mrp');
        $price = $this->input->post('price');
        $category_id = $this->input->post('category_id');
        $sub_category_id = $this->input->post('sub_category_id');
        $short_description = $this->input->post('shortDesc');
        $long_description = $this->input->post('longDesc');
        $old_image = $this->input->post('old_image');
        $image = $_FILES['image']['name'];

        // Image upload handling
        if (!empty($image)) {
            $config['upload_path'] = './uploads/products/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['file_name'] = time() . '_' . $_FILES['image']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $uploaded_image = $this->upload->data('file_name');

                // Delete old image if exists
                if (!empty($old_image) && file_exists('./uploads/products/' . $old_image)) {
                    unlink('./uploads/products/' . $old_image);
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('products');
                return;
            }
        } else {
            $uploaded_image = $old_image;
        }

        // Prepare update data
        $data = [
            'category_id' => $category_id,
            'sub_category_id' => $sub_category_id,
            'name' => $name,
            'qty' => $qty,
            'mrp' => $mrp,
            'price' => $price,
            'short_description' => $short_description,
            'long_description' => $long_description,
            'image' => $uploaded_image
        ];

        $this->db->where('id', $id);
        if ($this->db->update('products', $data)) {
            $this->session->set_flashdata('success', 'Product updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update product.');
        }

        redirect('products');
    }
}
