<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AuthModel');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');

        $allowed = ['login', 'register'];
        if (!in_array($this->router->fetch_method(), $allowed)) {
            $this->is_logged_in();
        }

        $user_data = array(
            'username' => $this->session->userdata('username'),
            'image'    => $this->session->userdata('image')
        );

        $this->load->vars($user_data);
    }

    private function is_logged_in()
    {
        if (!$this->session->userdata('admin_logged_in')) {
            $this->session->set_flashdata('error', 'Please login first.');
            redirect('login');
            exit;
        }
    }
    
    // public function register()
    // {
    //     $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]|max_length[20]');
    //     $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[admins.email]');
    //     $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
    //     $this->form_validation->set_rules('role', 'Role', 'required');

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->load->view('auth/register');
    //     } else {
    //         $config['upload_path']   = './uploads/admins';
    //         $config['allowed_types'] = 'jpg|jpeg|png|gif';
    //         $config['max_size']      = 2048;
    //         $config['file_name']     = time() . '_' . $_FILES["image"]["name"];

    //         $this->load->library('upload', $config);

    //         if (!$this->upload->do_upload('image')) {
    //             $error = $this->upload->display_errors();
    //             $this->session->set_flashdata('error', $error);
    //             redirect('register');
    //         } else {
    //             $uploadData = $this->upload->data();
    //             $imagePath = 'uploads/admins/' . $uploadData['file_name'];

    //             $admin_data = array(
    //                 'name' => $this->input->post('name'),
    //                 'email'    => $this->input->post('email'),
    //                 'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
    //                 'role'     => $this->input->post('role'),
    //                 'image'    => $imagePath
    //             );

    //             $insert = $this->AuthModel->insert_admin($admin_data);

    //             if ($insert) {
    //                 $this->session->set_flashdata('success', 'Registered Successfully!');
    //                 redirect('login');
    //             } else {
    //                 $this->session->set_flashdata('error', 'Registration Failed!');
    //                 redirect('register');
    //             }
    //         }
    //     }
    // }

    public function login()
    {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/login');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $admin = $this->AuthModel->check_admin_login($email, $password);

            if ($admin) {
                $admin_data = [
                    'admin_id' => $admin->id,
                    'username' => $admin->username,
                    'email' => $admin->email,
                    'role' => $admin->role,
                    'image' => $admin->image,
                    'admin_logged_in' => TRUE
                ];
                $this->session->set_userdata($admin_data);

                $this->session->set_flashdata('success', 'Login successful! Welcome, ' . $admin->username);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid username or password.');
                redirect('login');
            }
        }
    }

    // Logout functionality
    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'You have been logged out.');
        redirect('login');
    }
}
