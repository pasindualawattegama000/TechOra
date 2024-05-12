<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProfileModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    //FETCH USER INFROMATION
    public function getUserFromId($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row_array();
    }

    //FETCH QUESTIONS
    public function getQuestionFromUserId($user_id) {
        $this->db->select('questions.*, COUNT(answers.answer_id) as answer_count');
        $this->db->from('questions');
        $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
        $this->db->where('questions.user_id', $user_id);
        $this->db->group_by('questions.question_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    //FETCH ANSWERS
    public function getAnswerFromUserId($user_id) {
        $this->db->select('*');
        $this->db->from('answers');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    //DELETE QUESTIONS
    public function delete_question($question_id) {
        $this->db->where('question_id', $question_id);
        $result = $this->db->delete('questions');
        return $result; 
    }
    

    //DELETE ANSWERS
    public function delete_answer($answer_id) {
        $this->db->where('answer_id', $answer_id);
        $result = $this->db->delete('answers');
        return $result; 
    }

    //DELETE USER

    public function deleteUser($userId) {
        $this->db->trans_start();
        $this->db->delete('answers', ['user_id' => $userId]);
        $this->db->delete('questions', ['user_id' => $userId]);
        $this->db->delete('user_votes', ['user_id' => $userId]);
        $this->db->delete('users', ['id' => $userId]);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    

}
