<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminController extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->model('Admin_model');
    }

    public function index()
    {
        $data['admins'] = $this->Admin_model->get_admins();
        $this->load->view('admins', $data);
    }

    public function insert()
    {
        $this->form_validation->set_rules('name', 'Admin Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[admins.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admins');
        } else {
            if ($_FILES['image']['name']) {
                $config['upload_path'] = './uploads/admins/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('image')) {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('admins');
                } else {
                    $image_data = $this->upload->data();
                    $image_path = 'uploads/admins/' . $image_data['file_name'];
                }
            } else {
                $image_path = '';
            }

            $admin_data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role' => $this->input->post('role') == 'admin' ? 1 : 0,
                'status' => $this->input->post('status'),
                'image' => $image_path,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->Admin_model->insert_admin($admin_data);

            if ($result) {
                $this->session->set_flashdata('success', 'Data Added uccessfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to add admin.');
            }

            redirect('admins');
        }
    }

    public function delete($id)
    {
        $this->Admin_model->delete_admin($id);
        $this->session->set_flashdata('success', 'Data Deleted Successfully');

        redirect('admins');
    }

    public function update()
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/edit');
        } else {
            $admin_id = $this->input->post('id');
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $role = $this->input->post('role') == 'admin' ? 1 : 0;
            $status = $this->input->post('status');
            $password = $this->input->post('password');
            $old_image = $this->input->post('old_image');
            $new_image = $old_image;

            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './uploads/admins/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 2048;
                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    $file_data = $this->upload->data();
                    $new_image = 'uploads/admins/' . $file_data['file_name'];
                    if ($old_image && file_exists($old_image)) {
                        unlink($old_image);
                    }
                } else {
                    $error = $this->upload->display_errors();
                    log_message('error', 'Image upload failed: ' . $error);
                }
            }
            $admin_data = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => $role,
                'status' => $status,
                'image' => $new_image
            ];
            $this->db->where('id', $admin_id);
            $this->db->update('admins', $admin_data);
            $this->session->set_flashdata('success', 'Data Updated Successfully');
            redirect('admins');
        }
    }
    public function edit($id)
    {
        $admin = $this->Admin_model->get_admin_by_id($id);
        $data['admin'] = $admin;
        $this->load->view('admin/edit', $data);
    }

    public function changeStatus($id)
    {
        $admin = $this->Admin_model->get_admin_by_id($id); 
        if ($admin) {
            $new_status = ($admin->status == 1) ? 0 : 1;
            $data = ['status' => $new_status];
            if ($this->Admin_model->updateAdminStatus($id, $data)) {
                redirect('admins');
            } else {
                redirect('admins');
            }
        } else {
            show_404(); 
        }
    }
    
    
}
