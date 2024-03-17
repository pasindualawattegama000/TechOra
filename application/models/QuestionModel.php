<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuestionModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function search_questions($search_term)
    {
        // Use CodeIgniter's Active Record database methods to perform the search
        $this->db->like('title', $search_term);
        $this->db->or_like('body', $search_term);
        $query = $this->db->get('questions');

        return $query->result();
    }


    public function insert_question($data) {

        return $this->db->insert('questions', $data);
    }

}
