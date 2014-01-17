<?php

class resetpass_model extends CI_Model {
    
    public function checkUser($username, $email) {
        $sql = "SELECT COUNT(*) AS cnt FROM users WHERE username = '{$username}' AND email = '{$email}'";
        $q = $this->db->query($sql);
        $result = $q->row()->cnt;
        
        if($result > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    
    public function generateToken($email) {
        $id = generateHash();
        $token = generateHash();
        
        $sql = "INSERT INTO resetpass_pending
                (
                    id,
                    email,
                    secret_token,
                    date_created,
                    visited
                )
                VALUES
                (
                    '{$id}',
                    '{$email}',
                    '{$token}',
                    NOW(),
                    0
                )";
        
        $q = $this->db->query($sql);
        if(!$q) {
            return false;
        }
        else {
            return $token;
        }
    }
    
    public function findUserByToken($token) {
        $sql = "SELECT * 
                FROM resetpass_pending
                WHERE secret_token = '{$token}' AND 
                        visited = 0 AND 
                        TIME_TO_SEC(TIMEDIFF(NOW(), date_created)) < 3600";
        
        $q = $this->db->query($sql);
        return $q->row_array();
    }
    
    public function chahgeUserPassword($email, $password) {
        $sql = "UPDATE users 
                SET password = '{$password}'
                WHERE email = '{$email}'";
                
        $q = $this->db->query($sql);
        
        return $q;
    }
    
    public function changeVisitedStatus($token) {
        $sql = "DELETE FROM resetpass_pending WHERE secret_token = '{$token}'";
        $q = $this->db->query($sql);
        
        return $q;
    }
}

?>
