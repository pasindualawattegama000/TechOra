<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AnswerModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    
    // Insert a new answer into the database
    public function insert_answer($data) {
        return $this->db->insert('answers', $data);
    }

    // Fetching Answers
    public function get_answers_by_question_id($question_id) {
        $this->db->select('
            answers.*, 
            users.first_name, 
            users.last_name, 
            COALESCE(SUM(CASE WHEN user_votes.vote_direction = \'up\' THEN 1 WHEN user_votes.vote_direction = \'down\' THEN -1 ELSE 0 END), 0) AS votes
        ');
        $this->db->from('answers');
        $this->db->join('users', 'users.id = answers.user_id', 'left');
        $this->db->join('user_votes', 'user_votes.component_id = answers.answer_id AND user_votes.component_type = \'answer\'', 'left');
        $this->db->where('answers.question_id', $question_id);
        $this->db->group_by('answers.answer_id');
        $query = $this->db->get();
        return $query->result_array();
    }
    

    //Answer accpetance

    public function accept_answer($answer_id, $question_id) {
        $this->db->set('is_accepted', '1');
        $this->db->where('answer_id', $answer_id);
        $this->db->update('answers');

        $this->db->set('is_answered', '1');
        $this->db->where('question_id', $question_id);
        $this->db->update('questions');
    }

    public function reject_answer($answer_id, $question_id) {
        $this->db->set('is_accepted', '0');
        $this->db->where('answer_id', $answer_id);
        $this->db->update('answers');

        $this->db->set('is_answered', '0');
        $this->db->where('question_id', $question_id);
        $this->db->update('questions');
    }


}
