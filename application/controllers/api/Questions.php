<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;

class Questions extends RestController {

    public function __construct() {
        parent::__construct();
        $this->load->model('QuestionModel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
    }

    public function postQuestion_post() {
        $userId = $this->session->userdata('userId');
        if (!$userId) {
            $this->response([
                'status' => FALSE,
                'message' => 'User not logged in'
            ], RestController::HTTP_UNAUTHORIZED);
            return;
        }

        $title = $this->input->post('title');
        $body = $this->input->post('body');
        $tags = $this->input->post('tags');
        $imagePath = $this->handleImageUpload();

        if ($imagePath === FALSE) {
            return; // Image upload failed
        }

        $questionData = [
            'title' => $title,
            'body' => $body,
            'tags' => $tags,
            'views' => 0,
            'is_answered' => FALSE,
            'asked_dt' => date('Y-m-d H:i:s'),
            'image_path' => $imagePath,
            'user_id' => $userId
        ];

        if ($this->QuestionModel->postQuestion($questionData)) {
            $this->response([
                'status' => TRUE,
                'message' => 'Question posted successfully'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Failed to post question'
            ], RestController::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //function to handel the images 
    private function handleImageUpload() {
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2MB

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image')) {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Image upload failed',
                    'error' => $this->upload->display_errors()
                ], RestController::HTTP_BAD_REQUEST);
                return FALSE;
            } else {
                $uploadData = $this->upload->data();
                return 'uploads/' . $uploadData['file_name'];
            }
        }
        return ''; // No image uploaded
    }



    // FILTRING QUESTIONS
    public function filterQuestions_get() {
        $filter = $this->input->get('filter', TRUE);
        $questions = [];
    
        switch ($filter) {
            case 'top':
                $questions = $this->QuestionModel->FilterTopQuestions();
                break;
            case 'latest':
                $questions = $this->QuestionModel->FilterLatestQuestions();
                break;
            case 'unanswered':
                $questions = $this->QuestionModel->FilterUnansweredQuestions();
                break;
            default:
                $questions = $this->QuestionModel->getQuestions(); // Fetch all questions by default
                break;
        }
    
        if (empty($questions)) {
            $this->response([
                'status' => FALSE,
                'message' => 'No questions found'
            ], RestController::HTTP_NOT_FOUND);
        } else {
            // $this->response([
            //     'status' => TRUE,
            //     'data' => $questions
            // ], RestController::HTTP_OK);

            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($questions));
        }
    }
    

    
}
