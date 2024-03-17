<?php
class Home extends CI_Controller{

    public function index(){
        $data['hello'] =$this->session->userdata('test');
        $this->load->view('templates/header');
        $this->load->view('homePage',$data);
        $this->load->view('templates/footer');
    }
}