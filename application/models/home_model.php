<?php


class home_model extends CI_Model {
    
    public function addQuickPost($data) {
        $sql = "INSERT INTO entries
                (
                    id,
                    title,
                    content,
                    date,
                    timestamp,
                    user_id
                )
                VALUES
                (
                    '{$data['id']}',
                    '{$data['post_title']}',
                    '{$data['post_content']}',
                    NOW(),
                    UNIX_TIMESTAMP(),
                    '{$this->session->userdata('id')}'
                )";
                    
        $q = $this->db->query($sql);
        
        if($q) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getLastThreeEntries() {
        $sql = "SELECT *
                FROM entries
                WHERE user_id = '{$this->session->userdata('id')}'
                ORDER BY date DESC
                LIMIT 0, 3";
                
        $q = $this->db->query($sql);
        
        if(!$q) {
            return false;
        } else {
            return $q->result_array();
        }
    }
}

?>
