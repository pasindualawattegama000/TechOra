<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Navigation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ProfileModel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
    }


    public function loadProfile() {
        // Fetch the current logged-in user
        $user_id = $this->session->userdata('userId');

        // If the user is not logged in, redirect to login page
        if (!$user_id) {
            redirect('users/loadLogin');
            return;
        }

        // Fetch the user's data
        $data['user'] = $this->ProfileModel->getUserFromId($user_id);

        // Fetch the user's questions and answers
        $data['questions'] = $this->ProfileModel->getQuestionFromUserId($user_id);
        $data['answers'] = $this->ProfileModel->getAnswerFromUserId($user_id);

        // Load the profile view
        $this->load->view('templates/header');
        $this->load->view('profile_page', $data);
        $this->load->view('templates/footer');
    }


    public function loadPostQuestions()
    {
        $this->load->view('templates/header');
        $this->load->view('post_question');
        $this->load->view('templates/footer');
    }


    public function loadLogin()
    {
        // Load the login view
        $this->load->view('templates/header');
        $this->load->view('auth/loginPage');
        $this->load->view('templates/footer');
    }

    public function loadRegister()
    {
        // Load the registration view
        $this->load->view('templates/header');
        $this->load->view('auth/signupPage');
        $this->load->view('templates/footer');
    }


    public function logout(){ 

        $this->session->unset_userdata('isUserLoggedIn'); 
        $this->session->unset_userdata('userId'); 
        $this->session->unset_userdata('userName'); 
        $this->session->sess_destroy(); 

        $this->load->view('templates/header');
        $this->load->view('auth/loginPage');
        $this->load->view('templates/footer');
    } 

    
}