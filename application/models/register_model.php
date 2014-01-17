<?php

class register_model extends CI_Model {
    
    public function insertNewUser($data) {
        $id = generateHash();
        
        $newuser = "INSERT INTO users
                    (
                        id,
                        firstname, 
                        lastname, 
                        username, 
                        email,
                        avatar,
                        password
                    ) 
                    VALUES 
                    (
                        '{$id}',
                        '{$data['firstname']}',     
                        '{$data['lastname']}', 
                        '{$data['username']}', 
                        '{$data['email']}',
                        '{$data['avatar']}',    
                        '{$data['password']}'
                    )";
                  
        
        $q = $this->db->query($newuser);
        
        if(!$q) {
            return false;
        }
        else {
            return true;
        }
    }
    
    
    public function checkUsername($username) {
        $checkUsername = "SELECT COUNT(*) AS cnt FROM users WHERE username = '{$username}'";
        
        $q = $this->db->query($checkUsername);
        
        if(!$q) {
            return false;  
        }
        else {
            return $q->row()->cnt;
        }    
    }
    
    
    public function checkEmail($email) {
        $checkEmail = "SELECT COUNT(*) AS cnt FROM users WHERE email = '{$email}'";
        
        $q = $this->db->query($checkEmail);
        
        if(!$q) {
            return false;  
        }
        else {
             return $q->row()->cnt;
        }     
    }
}

?>
