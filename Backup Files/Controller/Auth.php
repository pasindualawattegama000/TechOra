<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function profile()
    {
        $this->load->view('templates/header');
        $this->load->view('profilePage');
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
