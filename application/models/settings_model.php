<?php

class settings_model extends CI_Model {
    
    public function changeName($data){

        $sql = "UPDATE users SET  
                    firstname =  '{$data['firstname']}',
                    lastname =  '{$data['lastname']}'
                WHERE id = '{$this->session->userdata('id')}'";
                
        $q = $this->db->query($sql);

        if($q) {
            return true;
        } else {
            return false;
        }
    }
      
    public function changePassword($password){
     
        $updatepassword = "UPDATE users 
                            SET  
                            password =  '{$password}'                
                            WHERE 
                            id = '{$this->session->userdata('id')}'";

        $q = $this->db->query($updatepassword);

        if($q) {
            return true;
        } else {
            return false;
        }    
    }
  
  
    public function addAvatar($data){
       
        $data['imgpath'] = str_replace('\\', '/', $data['imgpath']);
        
        $sql = sprintf("UPDATE users 
                        SET avatar = '{$data['imgpath']}' 
                        WHERE id='{$data['userid']}'");         

        $q = $this->db->query($sql);

        if(!$q) {
            return false;
        } else {
            return true;
        } 
    }
    
    public function checkPassword($password) {
        $sql = "SELECT COUNT(*) as cnt
                FROM users 
                WHERE password = '{$password}'AND 
                        id = '{$this->session->userdata('id')}'";
                        
       $res = $this->db->query($sql);                  
                             
       if (!$res) {
           return false;
       } else {
           return $res->row()->cnt;
       }
    }
}

?>
