<?php


class archive_model extends CI_Model {
    
    public function getYears() {
        $sql = "SELECT DISTINCT YEAR(date) as year FROM entries WHERE user_id = '{$this->session->userdata('id')}'";
        $q = $this->db->query($sql);
        
        if(!$q) {
            return false;
        } else {
            return $q->result_array();
        }
    }
    
    public function getMonths($year) {
        $sql = "SELECT DISTINCT MONTHNAME(date) AS month 
                FROM entries 
                WHERE user_id = '{$this->session->userdata('id')}' AND YEAR(date) = '{$year}'
                ORDER BY month";
            
        $q = $this->db->query($sql);
        
        if(!$q) {
            return false;
        } else {
            return $q->result_array();
        }
    }
    
    public function getPosts($data) {
        $sql = "SELECT id, title, date
                FROM entries
                WHERE user_id = '{$this->session->userdata('id')}' AND 
                    YEAR(date) = '{$data['year']}' AND MONTHNAME(date) = '{$data['month']}'
                ORDER BY date DESC
                LIMIT {$data['from']}, {$data['to']}";
        
        $q = $this->db->query($sql);
        
        if(!$q) {
            return false;
        } else {
            return array('posts' => $q->result_array(), 'posts_num' => $q->num_rows());
        }   
    }
    
    public function getPostsCount($data) {
        $sql = "SELECT COUNT(*) as cnt
                FROM entries
                WHERE user_id = '{$this->session->userdata('id')}' AND 
                    YEAR(date) = '{$data['year']}' AND MONTHNAME(date) = '{$data['month']}'";
                    
        $q = $this->db->query($sql);
        
        if($q) {
            return $q->row()->cnt;
        } else {
            return false;
        }
    }
}

?>
