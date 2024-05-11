<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;

class Answers extends RestController {

    public function __construct() {
        parent::__construct();
        $this->load->model('AnswerModel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session'); 
    }

    public function postAnswer_post() { 
        if (!$this->session->userdata('userId')) {
            $this->response([
                'status' => FALSE,
                'message' => 'User not logged in'
            ], RestController::HTTP_UNAUTHORIZED); 
            return;
        }

        $answer_data = array(
            'body' => $this->post('body'),
            'question_id' => $this->post('question_id'),
            'user_id' => $this->session->userdata('userId'),
            'answered_dt' => date('Y-m-d H:i:s')
        );

        if ($this->AnswerModel->insert_answer($answer_data)) {
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

    public function voteOnAnswer_post($answer_id, $type) {
        $user_id = $this->session->userdata('userId');
        if (!$user_id) {
            $this->response(['status' => FALSE, 'message' => 'User not logged in'], RestController::HTTP_UNAUTHORIZED);
            return;
        }

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

    public function acceptAnswer_post($answer_id, $question_id) {
        try {
            $this->AnswerModel->accept_answer($answer_id, $question_id);
            $this->response(['status' => TRUE, 'message' => 'Answer accepted successfully'], RestController::HTTP_OK);
        } catch (Exception $e) {
            log_message('error', 'Exception occurred: ' . $e->getMessage());
            $this->response(['status' => FALSE, 'message' => 'Internal server error'], RestController::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function rejectAnswer_post($answer_id, $question_id) {
        try {
            $this->AnswerModel->reject_answer($answer_id, $question_id);
            $this->response(['status' => TRUE, 'message' => 'Answer rejected successfully'], RestController::HTTP_OK);
        } catch (Exception $e) {
            log_message('error', 'Exception occurred: ' . $e->getMessage());
            $this->response(['status' => FALSE, 'message' => 'Internal server error'], RestController::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
