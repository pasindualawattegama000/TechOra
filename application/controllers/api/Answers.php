<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Import necessary REST API libraries from CodeIgniter
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;


class Answers extends RestController {

    // loading necessary models, helpers, and libraries
    public function __construct() {
        parent::__construct();
        $this->load->model('AnswerModel'); // Load the model that handles answer data
        $this->load->helper(array('form', 'url')); 
        $this->load->library('session'); 
    }

    // endpoint to handle submission of an answer
    public function postAnswer_post() { 
        // Check if user is logged in, respond with unauthorized if not
        if (!$this->session->userdata('userId')) {
            $this->response([
                'status' => FALSE,
                'message' => 'User not logged in'
            ], RestController::HTTP_UNAUTHORIZED); 
            return;
        }

        // Collect answer data from POST data
        $answer_data = array(
            'body' => $this->post('body'), 
            'question_id' => $this->post('question_id'), 
            'user_id' => $this->session->userdata('userId'), 
            'answered_dt' => date('Y-m-d H:i:s') 
        );

        //inserting answer into database 
        if ($this->AnswerModel->postAnswer($answer_data)) {
            $this->response([
                'status' => TRUE,
                'message' => "Successfully Posted"
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Failed to post answer'
            ], RestController::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    // endpoint for accepting an answer
    public function acceptAnswer_post($answer_id, $question_id) {
        try {
            // accepting the answer 
            $this->AnswerModel->accept_answer($answer_id, $question_id);
            $this->response(['status' => TRUE, 'message' => 'Answer accepted successfully'], RestController::HTTP_OK);
        } catch (Exception $e) {
           
            log_message('error', 'Exception occurred: ' . $e->getMessage());
            $this->response(['status' => FALSE, 'message' => 'Internal server error'], RestController::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // endpoint for rejecting an answer
    public function rejectAnswer_post($answer_id, $question_id) {
        try {
            // rejecting the answer 
            $this->AnswerModel->reject_answer($answer_id, $question_id);
            $this->response(['status' => TRUE, 'message' => 'Answer rejected successfully'], RestController::HTTP_OK);
        } catch (Exception $e) {
     
            log_message('error', 'Exception occurred: ' . $e->getMessage());
            $this->response(['status' => FALSE, 'message' => 'Internal server error'], RestController::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
