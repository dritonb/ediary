<?php

class new_post_model extends CI_Model {
    
    public function addPost($data) {
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

}

?>
