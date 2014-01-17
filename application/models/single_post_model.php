<?php


class single_post_model extends CI_Model {
    
    public function getPostDetails($id) {
        $sql = "SELECT *
                FROM entries
                WHERE user_id = '{$this->session->userdata('id')}' AND id = '{$id}'";
                
        $q = $this->db->query($sql);
        
        if(!$q) {
            return false;
        } else {
            return $q->row_array();
        }
    }
}

?>
