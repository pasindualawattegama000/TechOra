<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Users extends RestController {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('UserModel');
        $this->load->helper('url');
    }

    public function login_post() {
        // Unset session data
        if ($this->session->userdata('success_msg')) {
            $this->session->unset_userdata('success_msg');
        }
        if ($this->session->userdata('error_msg')) {
            $this->session->unset_userdata('error_msg');
        }
    
        // Set validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
    
        if ($this->form_validation->run() === TRUE) {

            $userData = array( 
                'email' => strip_tags($this->input->post('email')), 
                'password' => md5($this->input->post('password')) 
            ); 

            $con = array( 
                'returnType' => 'single', 
                'conditions' => array( 
                    'email'=> $userData['email'], 
                    'password' => ($userData['password']), 
                    'status' => 1 
                ) 
            ); 
    
            // Use UserModel to check user credentials
            $user = $this->UserModel->getRows($con); 
    
            if ($user) {
                // Set session data
                $this->session->set_userdata('isUserLoggedIn', TRUE);
                $this->session->set_userdata('userId', $user['id']);
                $this->session->set_userdata('userName', $user['first_name']);
    
                // Prepare response data
                $responseData = array(
                    'status' => TRUE,
                    'message' => 'Login successful'
                   
                );
                $this->response($responseData, RestController::HTTP_OK); // Send success response
            } else {
                $responseData = array(
                    'status' => FALSE,
                    'message' => 'Login failed. Invalid email or password.'
                );
                $this->response($responseData, RestController::HTTP_UNAUTHORIZED); // Send error response
            }
        } else {
            $responseData = array(
                'status' => FALSE,
                'message' => validation_errors()
            );
            $this->response($responseData, RestController::HTTP_BAD_REQUEST); // Send validation error response
        }
    }
    



    public function registration_post() {
        $this->form_validation->set_rules('firstname', 'First Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => FALSE,
                'message' => validation_errors()
            ], 400); // Bad Request
        } else {
            $userData = array( 
                'first_name' => strip_tags($this->input->post('firstname')), 
                'last_name' => strip_tags($this->input->post('lastname')), 
                'email' => strip_tags($this->input->post('email')), 
                'password' => md5($this->input->post('password')) 
            ); 

            if ($this->UserModel->insert($userData)) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'User registered successfully.'
                ], 200); // OK
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Failed to register user.'
                ], 500); // Internal Server Error
            }
        }
    }


}
