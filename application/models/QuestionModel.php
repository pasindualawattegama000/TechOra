<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_model extends CI_Model {

    // ... other methods ...

    public function search_questions($search_term)
    {
        // Use CodeIgniter's Active Record database methods to perform the search
        $this->db->like('title', $search_term);
        $this->db->or_like('body', $search_term);
        $query = $this->db->get('questions');

        return $query->result();
    }
}
