<?php


class login_model extends CI_Model {
    
    public function verifyUser($username, $hashed_password) {
        $sql = "SELECT id, username, email, avatar, firstname, lastname
                FROM users
                WHERE username = '{$username}' AND password = '{$hashed_password}'";
        
        $q = $this->db->query($sql);
        
        if(!$q) {
            return false;
        }
        else {
            return $q->row_array();
        }
        
    }
}

?>
