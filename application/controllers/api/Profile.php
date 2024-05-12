<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;

class Profile extends RestController {

    public function __construct() {
        parent::__construct();
        $this->load->model('ProfileModel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
    }


    public function deleteQuestion_delete($question_id) {
        // Checking if the user is logged in.
        if (!$this->session->userdata('userId')) {
            $this->response([
                'status' => FALSE,
                'message' => 'Not authorized'
            ], RestController::HTTP_UNAUTHORIZED);
            return;
        }
    
        //deleting the question form the DB
        $delete_success = $this->ProfileModel->delete_question($question_id);
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
        // Checking if the user is logged in.
        if (!$this->session->userdata('userId')) {
            $this->response([
                'status' => FALSE,
                'message' => 'Not authorized'
            ], RestController::HTTP_UNAUTHORIZED);
            return;
        }
    
        //Deleting the answer linked with the user 
        $delete_success = $this->ProfileModel->delete_answer($answer_id);
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


    //DELETE PROFILE
    public function deleteProfile_delete() {
        $userId = $this->session->userdata('userId');
        if ($this->ProfileModel->deleteUser($userId)) {
            $this->session->sess_destroy();  // Destroy session after deletion
            $this->response([
                'status' => TRUE,
                'message' => 'Profile deleted successfully'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Failed to delete profile'
            ], RestController::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    
}
?>
