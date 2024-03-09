<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function login()
    {
        // Load the login view
        $this->load->view('templates/header');
        $this->load->view('auth/loginPage');
        $this->load->view('templates/footer');
    }

    public function register()
    {
        // Load the registration view
        $this->load->view('templates/header');
        $this->load->view('auth/signupPage');
        $this->load->view('templates/footer');
    }

    public function do_login()
    {
        // Process the login form submission
        // Validate credentials
        // Set session data for logged in user
        // Redirect to the profile page or back to the login form with errors
    }

    public function do_register()
    {
        // Process the registration form submission
        // Validate form data
        // Save the new user to the database
        // Maybe auto-login the user
        // Redirect to the profile page or back to the register form with errors
    }

    public function logout()
    {
        // Clear user session data
        // Redirect to the homepage or login page
    }
}
