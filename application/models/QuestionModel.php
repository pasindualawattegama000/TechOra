<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuestionModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function search_questions($search_term) {
        // Search for questions based on the term in title or body
        $this->db->like('title', $search_term);
        $this->db->or_like('body', $search_term);
        $query = $this->db->get('questions');
        return $query->result_array();
    }



    // public function search_questions($search_term) {
    //     $this->db->select('questions.*, users.first_name, users.last_name, COALESCE(v.vote_sum, 0) as votes');
    //     $this->db->from('questions');
    //     $this->db->join('users', 'questions.user_id = users.id', 'left');
        
    //     // Adding a subquery for summing votes
    //     $this->db->join('(SELECT 
    //                         component_id, 
    //                         SUM(CASE WHEN vote_direction = \'up\' THEN 1 WHEN vote_direction = \'down\' THEN -1 ELSE 0 END) AS vote_sum 
    //                      FROM user_votes 
    //                      WHERE component_type = \'question\' 
    //                      GROUP BY component_id) AS v', 
    //                     'v.component_id = questions.question_id', 'left');
    
    //     // Apply search condition on title or body
    //     $this->db->group_start();  // Group the like conditions
    //     $this->db->like('title', $search_term);
    //     $this->db->or_like('body', $search_term);
    //     $this->db->group_end();  // Close grouping
    
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }
    



    public function insert_question($data) {
        return $this->db->insert('questions', $data);
    }
    // public function getAllQuestions() {
    //     $this->db->select('questions.*, COUNT(answers.answer_id) as answer_count, users.first_name, users.last_name');
    //     $this->db->from('questions');
    //     $this->db->join('users', 'questions.user_id = users.id');
    //     $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
    //     $this->db->group_by('questions.question_id');
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

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
    



    // public function get_latest_questions() {
    //     $this->db->select('questions.*, COUNT(answers.answer_id) as answer_count, users.first_name, users.last_name');
    //     $this->db->from('questions');
    //     $this->db->join('users', 'questions.user_id = users.id');
    //     $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
    //     $this->db->group_by('questions.question_id');
    //     $this->db->order_by('asked_dt', 'DESC');
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    public function get_latest_questions() {
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
    


    
        // public function get_top_questions() {
    //     $this->db->select('questions.*, COUNT(answers.answer_id) as answer_count, users.first_name, users.last_name');
    //     $this->db->from('questions');
    //     $this->db->join('users', 'questions.user_id = users.id');
    //     $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
    //     $this->db->group_by('questions.question_id');
    //     $this->db->order_by('votes', 'DESC');
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }


    public function get_top_questions() {
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
    



    // public function get_unanswered_questions() {
    //     $this->db->select('questions.*, COUNT(answers.answer_id) as answer_count, users.first_name, users.last_name');
    //     $this->db->from('questions');
    //     $this->db->join('users', 'questions.user_id = users.id');
    //     $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
    //     $this->db->group_by('questions.question_id');
    //     $this->db->where('is_answered', FALSE);
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    public function get_unanswered_questions() {
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
        $this->db->where('is_answered', FALSE);  // Ensure to include only unanswered questions
        $this->db->order_by('questions.asked_dt', 'DESC');  // Optional: order by date to show newest unanswered questions first
        $query = $this->db->get();
        return $query->result_array();
    }
    






    // public function get_question_by_id($question_id) {
    //     $this->db->select('questions.*, COUNT(answers.answer_id) as answer_count, users.first_name, users.last_name');
    //     $this->db->from('questions');
    //     $this->db->join('users', 'questions.user_id = users.id');
    //     $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
    //     $this->db->where('questions.question_id', $question_id);
    //     $this->db->group_by('questions.question_id');
    //     $query = $this->db->get();
    //     return $query->row_array();
    // }


    public function get_question_by_id($question_id) {
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
    

    public function increment_views($question_id) {
        $this->db->set('views', 'views + 1', FALSE);
        $this->db->where('question_id', $question_id);
        $this->db->update('questions');
    }
    

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //VOTING

    //INITIAL VOTING 

    // public function hasUserVotedOnQuestion($user_id, $question_id) {
    //     $this->db->where('user_id', $user_id);
    //     $this->db->where('component_id', $question_id);
    //     $this->db->where('component_type', 'question');
    //     $query = $this->db->get('user_votes');
    //     return $query->num_rows() > 0;
    // }

    // public function recordUserVoteOnQuestion($user_id, $question_id, $direction) {
    //     $data = [
    //         'user_id' => $user_id,
    //         'component_id' => $question_id,
    //         'component_type' => 'question',
    //         'vote_direction' => $direction
    //     ];
    //     $this->db->insert('user_votes', $data);
    // }

    // public function icriQuestVotes($question_id) {
    //     $this->db->set('votes', 'votes + 1', FALSE);
    //     $this->db->where('question_id', $question_id);
    //     $this->db->update('questions');
    // }

    // public function decQuestVotes($question_id) {
    //     $this->db->set('votes', 'votes - 1', FALSE);
    //     $this->db->where('question_id', $question_id);
    //     $this->db->update('questions');
    // }

        
    //+++++++++++++
    // REFINED VOTING

    public function checkUserVote($user_id, $question_id) {
        $this->db->select('vote_direction');
        $this->db->from('user_votes');
        $this->db->where('user_id', $user_id);
        $this->db->where('component_id', $question_id);
        $this->db->where('component_type', 'question');
        $result = $this->db->get()->row();
        return $result ? $result->vote_direction : null;
    }
    
    public function updateUserVote($user_id, $question_id, $vote_direction) {
        $data = ['vote_direction' => $vote_direction];
        $this->db->where('user_id', $user_id);
        $this->db->where('component_id', $question_id);
        $this->db->where('component_type', 'question');
        $this->db->update('user_votes', $data);
    }
    
    public function recordUserVoteOnQuestion($user_id, $question_id, $direction) {
        $data = [
            'user_id' => $user_id,
            'component_id' => $question_id,
            'component_type' => 'question',
            'vote_direction' => $direction
        ];
        $this->db->insert('user_votes', $data);
    }

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //Profile Page
    public function get_questions_by_user($user_id) {
        $this->db->select('questions.*, COUNT(answers.answer_id) as answer_count');
        $this->db->from('questions');
        $this->db->join('answers', 'answers.question_id = questions.question_id', 'left');
        $this->db->where('questions.user_id', $user_id);
        $this->db->group_by('questions.question_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_question($question_id) {
        $this->db->where('question_id', $question_id);
        $this->db->delete('questions');
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //
}
