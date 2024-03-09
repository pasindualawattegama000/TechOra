<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questions extends CI_Controller {

    public function create()
    {
        $this->load->view('templates/header');
        $this->load->view('askQuestionPage');
        $this->load->view('templates/footer');
    }

    public function searchQuestions()
    {
        
        $data['searchedFor'] = $this->input->get('search',TRUE);
        // // Get the search term from the GET request
        // $search_term = $this->input->get('search', TRUE);

        // // Load the model and perform the search
        // $this->load->model('Question_model');
        // $data['results'] = $this->Question_model->search_questions($search_term);

        // Load the view and pass in the search results
        // $this->load->view('search_results', $data);
        $this->load->view('templates/header');
        $this->load->view('searchResultPage',$data);
        $this->load->view('templates/footer');
    }
    
}