<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class UserModel extends CI_Model{ 
    function __construct() { 
        // Defining the tabel name
        $this->table = 'users'; 
    } 
     
    function getRows($params = array()){ 
        $this->db->select('*'); 
        $this->db->from($this->table); 
         
        if(array_key_exists("conditions", $params)){ 
            foreach($params['conditions'] as $key => $val){ 
                $this->db->where($key, $val); 
            } 
        } 
         
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
            $result = $this->db->count_all_results(); 
        }else{ 
            if(array_key_exists("id", $params) || $params['returnType'] == 'single'){ 
                if(!empty($params['id'])){ 
                    $this->db->where('id', $params['id']); 
                } 
                $query = $this->db->get(); 
                $result = $query->row_array(); 
            }else{ 
                $this->db->order_by('id', 'desc'); 
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                    $this->db->limit($params['limit'],$params['start']); 
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                    $this->db->limit($params['limit']); 
                } 
                 
                $query = $this->db->get(); 
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
        
            } 
        } 
         
        // Return the user data
        return $result; 
    } 
     

    public function insert($data = array()) { 
        if(!empty($data)){ 
            // Insert user's data 
            $insert = $this->db->insert($this->table, $data); 
             
            // Return status 
            return $insert?$this->db->insert_id():false; 
        } 
        return false; 
    } 


}