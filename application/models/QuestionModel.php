<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuestionModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Posting questions    
    public function postQuestion($data) {
        return $this->db->insert('questions', $data);
    }

    // Search for questions based on the term in title or body
    public function search_questions($search_term) {
        $this->db->like('title', $search_term);
        $this->db->or_like('body', $search_term);
        $query = $this->db->get('questions');
        return $query->result_array();
    }


    // Fetch all the questions without filters
    public function getAllQuestions() {
        $this->db->select('
            questions.*,
            COUNT(answers.answer_id) as answer_count,
            users.first_name, 
            users.last_name,
            COALESCE(SUM(CASE WHEN user_votes.vote_direction = \'up\' THEN 1 WHEN user_votes.vote_direction = \'down\' THEN -1 ELSE 0 END), 0) AS votes
        ');
        $this->db->from('questions');
        $this->db->join('users', 'questions.user_id = users.id');
        $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
        $this->db->join('user_votes', 'user_votes.component_id = questions.question_id AND user_votes.component_type = \'question\'', 'left');
        $this->db->group_by('questions.question_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Filtering the questions 
    public function FilterLatestQuestions() {
        $this->db->select('
            questions.*, 
            COUNT(answers.answer_id) as answer_count, 
            users.first_name, 
            users.last_name, 
            COALESCE(SUM(CASE WHEN user_votes.vote_direction = \'up\' THEN 1 WHEN user_votes.vote_direction = \'down\' THEN -1 ELSE 0 END), 0) AS votes
        ');
        $this->db->from('questions');
        $this->db->join('users', 'questions.user_id = users.id');
        $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
        $this->db->join('user_votes', 'user_votes.component_id = questions.question_id AND user_votes.component_type = \'question\'', 'left');
        $this->db->group_by('questions.question_id');
        $this->db->order_by('asked_dt', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function FilterTopQuestions() {
        $this->db->select('questions.*, COUNT(answers.answer_id) as answer_count, users.first_name, users.last_name, COALESCE(SUM(CASE WHEN user_votes.vote_direction = \'up\' THEN 1 WHEN user_votes.vote_direction = \'down\' THEN -1 ELSE 0 END), 0) AS votes');
        $this->db->from('questions');
        $this->db->join('users', 'questions.user_id = users.id');
        $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
        $this->db->join('user_votes', 'user_votes.component_id = questions.question_id AND user_votes.component_type = \'question\'', 'left');
        $this->db->group_by('questions.question_id');
        $this->db->order_by('votes', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    

    public function FilterUnansweredQuestions() {
        $this->db->select('
            questions.*, 
            COUNT(answers.answer_id) as answer_count, 
            users.first_name, 
            users.last_name, 
            COALESCE(SUM(CASE WHEN user_votes.vote_direction = \'up\' THEN 1 WHEN user_votes.vote_direction = \'down\' THEN -1 ELSE 0 END), 0) AS votes
        ');
        $this->db->from('questions');
        $this->db->join('users', 'questions.user_id = users.id');
        $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
        $this->db->join('user_votes', 'user_votes.component_id = questions.question_id AND user_votes.component_type = \'question\'', 'left');
        $this->db->group_by('questions.question_id');
        $this->db->where('is_answered', FALSE);  
        $this->db->order_by('questions.asked_dt', 'DESC');  
        $query = $this->db->get();
        return $query->result_array();
    }
    


    //Get question details based on the Id
    public function getQuestionFromId($question_id) {
        $this->db->select('
            questions.*, 
            COUNT(answers.answer_id) as answer_count, 
            users.first_name, 
            users.last_name, 
            COALESCE(SUM(CASE WHEN user_votes.vote_direction = \'up\' THEN 1 WHEN user_votes.vote_direction = \'down\' THEN -1 ELSE 0 END), 0) AS votes
        ');
        $this->db->from('questions');
        $this->db->join('users', 'questions.user_id = users.id');
        $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
        $this->db->join('user_votes', 'user_votes.component_id = questions.question_id AND user_votes.component_type = \'question\'', 'left');
        $this->db->where('questions.question_id', $question_id);
        $this->db->group_by('questions.question_id');
        $query = $this->db->get();
        return $query->row_array();
    }
    

    // When a question is viewed, incrimenting the views
    public function incrementViews($question_id) {
        $this->db->set('views', 'views + 1', FALSE);
        $this->db->where('question_id', $question_id);
        $this->db->update('questions');
    }
    



}
