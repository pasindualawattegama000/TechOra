<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;

class Profile extends RestController {

    public function __construct() {
        parent::__construct();
        $this->load->model('QuestionModel');
        $this->load->model('AnswerModel');
        $this->load->model('UserModel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
    }


    public function deleteQuestion_delete($question_id) {
        if (!$this->session->userdata('userId')) {
            $this->response([
                'status' => FALSE,
                'message' => 'Not authorized'
            ], RestController::HTTP_UNAUTHORIZED);
            return;
        }
    
        $delete_success = $this->QuestionModel->delete_question($question_id);
        if ($delete_success) {
            $this->response([
                'status' => TRUE,
                'message' => 'Question successfully deleted'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Failed to delete question'
            ], RestController::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    public function deleteAnswer_delete($answer_id) {
        if (!$this->session->userdata('userId')) {
            $this->response([
                'status' => FALSE,
                'message' => 'Not authorized'
            ], RestController::HTTP_UNAUTHORIZED);
            return;
        }
    
        $delete_success = $this->AnswerModel->delete_answer($answer_id);
        if ($delete_success) {
            $this->response([
                'status' => TRUE,
                'message' => 'Answer successfully deleted'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Failed to delete answer'
            ], RestController::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
}
?>
