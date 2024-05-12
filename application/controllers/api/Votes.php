<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;

class Votes extends RestController {

    public function __construct() {
        parent::__construct();
        $this->load->model('QuestionModel');
        $this->load->model('AnswerModel'); 
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
    }

   
    // VOTING ON A QUESTION FUNCTIONALITY
    public function voteOnQuestion_post($question_id, $type) {
        $user_id = $this->session->userdata('userId');
        if (!$user_id) {
            $this->response([
                'status' => FALSE,
                'message' => 'User not logged in'
            ], RestController::HTTP_UNAUTHORIZED);
            return;
        }
    
        $currentVote = $this->QuestionModel->checkUserVote($user_id, $question_id);
        if ($currentVote) {
            if ($currentVote === $type) {
                $this->response([
                    'status' => FALSE,
                    'message' => 'You have already voted this way'
                ], RestController::HTTP_CONFLICT);
            } else {
                $this->QuestionModel->updateUserVote($user_id, $question_id, $type);
                $this->response([
                    'status' => TRUE,
                    'message' => 'Vote changed successfully'
                ], RestController::HTTP_OK);
            }
        } else {
            $this->QuestionModel->recordUserVoteOnQuestion($user_id, $question_id, $type);
            $this->response([
                'status' => TRUE,
                'message' => 'Vote recorded successfully'
            ], RestController::HTTP_OK);
        }
    }




        // VOTING ON A ANSWER FUNCTIONALITY
        public function voteOnAnswer_post($answer_id, $type) {
            $user_id = $this->session->userdata('userId');
            // Ensure user is logged in before proceeding
            if (!$user_id) {
                $this->response(['status' => FALSE, 'message' => 'User not logged in'], RestController::HTTP_UNAUTHORIZED);
                return;
            }
    
            // Checking existing votes prevent duplicate voting
            $currentVote = $this->AnswerModel->checkUserVote($user_id, $answer_id);
            if ($currentVote) {
              
                if ($currentVote === $type) {
                    $this->response(['status' => FALSE, 'message' => 'You have already voted'], RestController::HTTP_BAD_REQUEST);
                } else {
                    $this->AnswerModel->updateUserVote($user_id, $answer_id, $type);
                    $this->response(['status' => TRUE, 'message' => 'Vote changed successfully'], RestController::HTTP_OK);
                }
            } else {
        
                $this->AnswerModel->recordUserVoteOnAnswer($user_id, $answer_id, $type);
                $this->response(['status' => TRUE, 'message' => 'Vote recorded successfully'], RestController::HTTP_OK);
            }
        }
    
}
