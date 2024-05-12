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
        $this->QuestionModel->incrementViews($question_id);
        
        // Fetch question details using the QuestionModel
        $data['question'] = $this->QuestionModel->getQuestionFromId($question_id);
        
        // Fetch answers using the AnswerModel
        $data['answers'] = $this->AnswerModel->getAnswerFromQuestionId($question_id);
        
        // Load the question details view
        $this->load->view('templates/header');
        $this->load->view('detailed_question_page', $data); 
        $this->load->view('templates/footer');
    }

}