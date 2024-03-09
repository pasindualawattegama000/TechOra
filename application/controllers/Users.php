<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function profile()
    {
        $this->load->view('templates/header');
        $this->load->view('profilePage');
        $this->load->view('templates/footer');
    }
    
}