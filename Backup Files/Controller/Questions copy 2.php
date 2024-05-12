<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questions extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('QuestionModel');
        $this->load->helper(array('form', 'url'));
    }


    
    public function postQuestion(){

        $userId = $this->session->userdata('userId');
        if (!$userId) {
            $responseData = array(
                'success' => true,
                'condition' => 'D', // User not logged in so cant post a question
                'message' => 'Error'
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($responseData));
            return; // Stop execution and return error

        }

        // Get form data
        $title = $this->input->post('title');
        $body = $this->input->post('body');
        $tags = $this->input->post('tags');

        // Check if an image was uploaded
        $imagePath = '';
        if (!empty($_FILES['image']['name'])) {
            // Configure image upload settings
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2MB max size

            // Load the upload library
            $this->load->library('upload', $config);

            // Perform the upload
            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $imagePath = 'uploads/' . $uploadData['file_name'];
            } 
            else {
                // Handle upload failure
                // Upload failed 
                $responseData = array(
                    'success' => true,
                    'condition' => 'C', // Image file type is not valid
                    'message' => 'Error',
                    'error' => $this->upload->display_errors()
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($responseData));
                return; // Stop execution and return error
            }
        }

            // Insert question details into the database
            $questionData = array(
                'title' => $title,
                'body' => $body,
                'tags' => $tags,
                'views' => 0,  
                'is_answered' => FALSE, 
                'asked_dt' => date('Y-m-d H:i:s'),
                'image_path' => $imagePath,
                'user_id' => $userId
                
            );

                // Save to database
            if ($this->QuestionModel->insert_question($questionData)) {
                // If data is successfully saved, send a success response
                $responseData = array(
                    'success' => true,
                    'condition' => 'A', // Data is successfully saved
                    'message' => 'Error'
                );
                
            } else {
                // If data saving fails, send a failure response
                $responseData = array(
                    'success' => false,
                    'condition' => 'B', // Failed to save question
                    'message' => 'Error'
                );
            }

            $this->output->set_content_type('application/json')->set_output(json_encode($responseData));

           
        }

      
    public function fetch_filtered_questions() {
            // Check for user input
            $filter = $this->input->get('filter', TRUE);
        
            // Ensure the model is loaded
            $this->load->model('QuestionModel');
        
            // Fetch questions based on the filter
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
        
            // Send the questions as JSON
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($questions));
    }
        

    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //VOTING

    public function voteOnQuestion($question_id, $type) {
        $user_id = $this->session->userdata('userId');
        if (!$user_id) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }
    
        $currentVote = $this->QuestionModel->checkUserVote($user_id, $question_id);
    
        if ($currentVote) {
            if ($currentVote === $type) {
                echo json_encode(['status' => 'error', 'message' => 'You have already voted this way']);
            } else {
                $this->QuestionModel->updateUserVote($user_id, $question_id, $type);
                echo json_encode(['status' => 'success', 'message' => 'Vote changed successfully']);
            }
        } else {
            $this->QuestionModel->recordUserVoteOnQuestion($user_id, $question_id, $type);
            echo json_encode(['status' => 'success', 'message' => 'Vote recorded successfully']);
        }
    }
    

}
    
