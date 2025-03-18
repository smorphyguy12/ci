<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model'));
    }

    public function index()
    {
        $this->load->view('login');
    }

    public function registration()
    {
        $this->load->view('register');
    }

    public function dashboard()
    {
        $this->load->view('index');
    }

    public function login()
    {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));

        $data = [
            'email' => $email,
            'password' => $password
        ];

        $stmt = $this->model->getRow('register', "",$data);
        if ($stmt) {
            $this->session->set_flashdata('id', $stmt->id);
            $this->session->set_flashdata('fullname', $stmt->fullname);

            echo json_encode(['status' => 1, 'message' => 'Login Successfully!']);
        } else {
            echo json_encode(['status' => 2, 'message' => 'Invalid Credentials.']);
        }
    }

    public function register()
    {
        $fullname = $this->input->post('fullname');
        $email = $this->input->post('email');
        $gender = $this->input->post('gender');
        $password = md5($this->input->post('password'));
        $retype_password = md5($this->input->post('retype_password'));

        $data = [
            'fullname' => $fullname,
            'email' => $email,
            'gender' => $gender,
            'password' => $password
        ];

        if ($password !== $retype_password) {
            echo json_encode(['status' => 2, 'message' => 'Password not match']);
        } else {
            $getRow = $this->model->getRow('register', 'email', ['email' => $email]);

            if ($getRow) {
                echo json_encode(['status' => 2, 'message' => 'The email has been registered.']);
            } else {
                $stmt = $this->model->insertData('register', $data);

                if (!$stmt) {
                    echo json_encode(['status' => 0, 'message' => 'Registration Failed']);
                } else {
                    echo json_encode(['status' => 1, 'message' => 'Registration Success']);
                }
            }
        }
    }

    public function logout() {
        $this->session->set_flashdata('id', '');
        $this->session->set_flashdata('fullname', '');

        redirect(base_url());
        exit;
    }
}
