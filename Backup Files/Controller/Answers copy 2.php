<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Answers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('AnswerModel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session'); // Ensure session library is loaded
    }



    public function post_answer() {
        $this->output->set_content_type('application/json');

        $userId = $this->session->userdata('userId');
        if (!$userId) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(array('status' => 'error', 'message' => 'User not logged in'));
                return;
            } else {
                redirect('login'); // if the user is not logged in
            }
        }
        $answer_data = array(
            'body' => $this->input->post('body', TRUE),
            'question_id' => $this->input->post('question_id', TRUE),
            'user_id' => $userId,
            'answered_dt' => date('Y-m-d H:i:s')
        );

        $this->AnswerModel->insert_answer($answer_data);

        try {
            // Your logic here
            $response = ['status' => 'success', 'message' => "Successfully Posted"];
            echo json_encode($response);
        } catch (Exception $e) {
            // Log error and create a JSON response for errors
            log_message('error', $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Server error']);
        }
        return;
    }


    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //VOTING
    //REFINED VOTING

    public function voteOnAnswer($answer_id, $type) {
        $user_id = $this->session->userdata('userId');
        if (!$user_id) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }
    
        $currentVote = $this->AnswerModel->checkUserVote($user_id, $answer_id);
    
        if ($currentVote) {
            if ($currentVote === $type) {
                echo json_encode(['status' => 'error', 'message' => 'You have already voted this way']);
            } else {
                $this->AnswerModel->updateUserVote($user_id, $answer_id, $type);
                echo json_encode(['status' => 'success', 'message' => 'Vote changed successfully']);
            }
        } else {
            $this->AnswerModel->recordUserVoteOnAnswer($user_id, $answer_id, $type);
            echo json_encode(['status' => 'success', 'message' => 'Vote recorded successfully']);
        }
    }
    

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //Answer Accpetance

    public function accept_answer($answer_id, $question_id) {
     
        try {
            $this->AnswerModel->accept_answer($answer_id,$question_id);
            echo json_encode(['status' => 'success', 'message' => 'Answer accepted successfully']);
      } catch (Exception $e) {
            log_message('error', 'Exception occurred: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Internal server error']);
            }

    }
    

    public function reject_answer($answer_id, $question_id) {

        try {
            $this->AnswerModel->reject_answer($answer_id,$question_id);
            echo json_encode(['status' => 'success', 'message' => 'Answer Rejected successfully']);
        } catch (Exception $e) {
            log_message('error', 'Exception occurred: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Internal server error']);
        }

    }

}
