<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('QuestionModel');
        $this->load->model('AnswerModel');
        $this->load->model('UserModel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
    }



    public function delete_question($question_id) {
        $this->QuestionModel->delete_question($question_id);
        echo json_encode(['status' => 'success']);
    }

    public function delete_answer($answer_id) {
        $this->AnswerModel->delete_answer($answer_id);
        echo json_encode(['status' => 'success']);
    }
}
?>
