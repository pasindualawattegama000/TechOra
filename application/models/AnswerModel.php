<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AnswerModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Fetch all answers for a specific question with user details
    // public function get_answers_by_question_id($question_id) {
    //     $this->db->select('answers.*, users.first_name, users.last_name');
    //     $this->db->from('answers');
    //     $this->db->join('users', 'users.id = answers.user_id', 'left');
    //     $this->db->where('answers.question_id', $question_id);
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }


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
    

    // Insert a new answer into the database
    public function insert_answer($data) {
        return $this->db->insert('answers', $data);
    }


    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //VOTING
    
    //INITITAL VOTING

    // public function recordUserVoteOnAnswer($user_id, $answer_id, $direction) {
    //     $data = [
    //         'user_id' => $user_id,
    //         'component_id' => $answer_id,
    //         'component_type' => 'answer',
    //         'vote_direction' => $direction
    //     ];
    //     $this->db->insert('user_votes', $data);
    // }

    // public function icriAnsVotes($answer_id) {
    //     $this->db->set('votes', 'votes + 1', FALSE);
    //     $this->db->where('answer_id', $answer_id);
    //     $this->db->update('answers');
    // }

    // public function decAnsVotes($answer_id) {
    //     $this->db->set('votes', 'votes - 1', FALSE);
    //     $this->db->where('answer_id', $answer_id);
    //     $this->db->update('answers');
    // }

    
    //+++++++++++++
    //REFINED VOTING
    
    public function checkUserVote($user_id, $answer_id) {
        $this->db->select('vote_direction');
        $this->db->from('user_votes');
        $this->db->where('user_id', $user_id);
        $this->db->where('component_id', $answer_id);
        $this->db->where('component_type', 'answer');
        $result = $this->db->get()->row();
        return $result ? $result->vote_direction : null;
    }
    
    public function updateUserVote($user_id, $answer_id, $vote_direction) {
        $data = ['vote_direction' => $vote_direction];
        $this->db->where('user_id', $user_id);
        $this->db->where('component_id', $answer_id);
        $this->db->where('component_type', 'answer');
        $this->db->update('user_votes', $data);
    }
    
    public function recordUserVoteOnAnswer($user_id, $answer_id, $direction) {
        $data = [
            'user_id' => $user_id,
            'component_id' => $answer_id,
            'component_type' => 'answer',
            'vote_direction' => $direction
        ];
        $this->db->insert('user_votes', $data);
    }




    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
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

    // public function get_question_id_by_answer($answer_id) {
    //     $this->db->select('question_id');
    //     $this->db->from('answers');
    //     $this->db->where('answer_id', $answer_id);
    //     $query = $this->db->get();
    //     if ($query->num_rows() > 0) {
    //         return $query->row()->question_id;
    //     }
    //     return NULL;
    // }

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //Profile Page

    public function get_answers_by_user($user_id) {
        $this->db->select('*');
        $this->db->from('answers');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_answer($answer_id) {
        $this->db->where('answer_id', $answer_id);
        $this->db->delete('answers');
    }


}
