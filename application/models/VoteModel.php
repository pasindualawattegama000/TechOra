<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VoteModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }



  //VOTING QUESTIONS

    public function checkUserQuestionVote($user_id, $question_id) {
        $this->db->select('vote_direction');
        $this->db->from('user_votes');
        $this->db->where('user_id', $user_id);
        $this->db->where('component_id', $question_id);
        $this->db->where('component_type', 'question');
        $result = $this->db->get()->row();
        return $result ? $result->vote_direction : null;
    }
    
    public function updateUserQuestionVote($user_id, $question_id, $vote_direction) {
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




    //VOTING ANSWERS
    
    public function checkUserAnswerVote($user_id, $answer_id) {
        $this->db->select('vote_direction');
        $this->db->from('user_votes');
        $this->db->where('user_id', $user_id);
        $this->db->where('component_id', $answer_id);
        $this->db->where('component_type', 'answer');
        $result = $this->db->get()->row();
        return $result ? $result->vote_direction : null;
    }
    
    public function updateUserAnswerVote($user_id, $answer_id, $vote_direction) {
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


    


}


