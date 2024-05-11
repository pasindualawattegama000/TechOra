<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuestionDetails extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('QuestionModel');
        $this->load->model('AnswerModel');
        $this->load->helper(array('form', 'url'));
    }



    public function loadQuestionDetails($question_id) {
        $this->QuestionModel->increment_views($question_id);
        
        // Fetch question details using the QuestionModel
        $data['question'] = $this->QuestionModel->get_question_by_id($question_id);
        
        // Fetch answers using the AnswerModel
        $data['answers'] = $this->AnswerModel->get_answers_by_question_id($question_id);
        
        // Load the question details view
        $this->load->view('templates/header');
        $this->load->view('questionDetails', $data); 
        $this->load->view('templates/footer');
    }

}