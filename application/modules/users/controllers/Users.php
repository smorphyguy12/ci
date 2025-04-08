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

    public function manageUsers()
    {
        $data['row'] = $this->model->getUsers();

        $this->load->view('manage-users', $data);
    }

    public function fetchUser()
    {
        $id = $this->input->post('id');

        $data = $this->model->fetchUser($id);

        echo json_encode(["status" => 1, "data" => $data]);
    }

    public function editUsers()
    {
        $id = $this->input->post('id');
        $fullname = $this->input->post('fullname');
        $email = $this->input->post('email');
        $gender = $this->input->post('gender');

        if (!$id || !$fullname || !$email || !$gender) {
            echo json_encode(['status' => 0, 'message' => 'Missing required fields.']);
            return;
        }

        $data = [
            'fullname' => $fullname,
            'email' => $email,
            'gender' => $gender
        ];

        $stmt = $this->model->updateData('register', $data, ['id' => $id]);

        if ($stmt) {
            echo json_encode(['status' => 1, 'message' => 'Edit Successfully!']);
        } else {
            echo json_encode([
                'status' => 0,
                'message' => 'Failed to update user. Error: ' . $this->db->_error_message()
            ]);
        }
    }

    public function deleteUsers()
    {
        $id = $this->input->post('id');

        if (!$id) {
            echo json_encode([
                'status' => 0,
                'message' => 'User ID is required.'
            ]);
            return;
        }

        $this->db->where('id', $id); 
        $stmt = $this->db->delete('register'); 

        if ($stmt) {
            echo json_encode([
                'status' => 1,
                'message' => 'User deleted successfully.'
            ]);
        } else {
            $error = $this->db->error(); 
            echo json_encode([
                'status' => 0,
                'message' => 'Failed to delete user. Error Code: ' . $error['code'] . ' - ' . $error['message']
            ]);
        }
    }

    public function addUser()
    {
        $fullname = $this->input->post('fullname');
        $email = $this->input->post('email');
        $gender = $this->input->post('gender');
        $password = $this->input->post('password');

        $data = [
            'fullname' => $fullname,
            'email' => $email,
            'gender' => $gender,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'date_created' => date('Y-m-d H:i:s')
        ];

        $stmt = $this->model->insertData('register', $data);

        if ($stmt) {
            echo json_encode(['status' => 1, 'message' => 'User added successfully!']);
        } else {
            echo json_encode(['status' => 0, 'message' => 'Failed to add user.']);
        }
    }


    public function login()
    {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));

        $data = [
            'email' => $email,
            'password' => $password
        ];

        $stmt = $this->model->getRow('register', "", $data);
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
