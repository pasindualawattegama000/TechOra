<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('QuestionModel');
        $this->load->helper(array('form', 'url'));
    }


    // SEARCH QUESTIONS
    public function Questions() {
        // Get the search term from the GET request
        $search_term = $this->input->get('search', TRUE);
        $data['searchedFor'] = $search_term;

        // Perform the search
        $data['results'] = $this->QuestionModel->search_questions($search_term);

        // Load the search results view
        $this->load->view('templates/header');
        $this->load->view('search_results', $data);
        $this->load->view('templates/footer');
    }

}