<?php

class gallery_model extends CI_Model {
    
    public function addNewAlbum($album_name) {
        $id = generateHash();
        
        $sql = "INSERT INTO albums
                (
                    id,
                    user_id,
                    title,
                    date,
                    timestamp
                )
                VALUES
                (
                    '{$id}',
                    '{$this->session->userdata('id')}',
                    '{$album_name}',
                    NOW(),
                    UNIX_TIMESTAMP()
                )";
            
        $q = $this->db->query($sql);
        
        if(!$q) {
            return false;
        } else {
            return true;
        }
    }
    
    public function getAlbumList($from, $to) {
        $sql = "SELECT * 
                FROM albums 
                WHERE user_id = '{$this->session->userdata('id')}'
                ORDER BY date DESC
                LIMIT {$from}, {$to}";
                
        $q = $this->db->query($sql);
        
        if(!$q) {
            return false;
        } else {
            return array('albums' => $q->result_array(), 'albums_num' => $q->num_rows());
        }
    }
    
    public function countAlbums() {
        $sql = "SELECT COUNT(*) AS cnt FROM albums WHERE user_id='{$this->session->userdata('id')}'";
        $q = $this->db->query($sql);
        if($q) {
            return $q->row()->cnt;
        } else {
            return false;
        }
    }
    
    public function addImages($data) {
        $count = count($data['imgs']);
        
        $sql = "INSERT INTO images
            (
                id,
                path,
                album_id
            )
            VALUES";
    
        foreach($data['imgs'] as $key => $img) {
            $img = str_replace('\\', '/', $img);
            $id = generateHash();
            $sql .= " ('{$id}', '".  $img ."', '{$data['album_id']}')";
            if(($key+1) < $count) {
                $sql .= ",";
            }
        }
        
        $q = $this->db->query($sql);
        
        if(!$q) {
            return false;
        } else {
            return true;
        }
    }
    
    public function getAlbumImages($album_id) {
        $sql = "SELECT * FROM images WHERE album_id = '{$album_id}'";
        $q = $this->db->query($sql);
        
        if(!$q) {
            return false;
        } else {
            return $q->result_array();
        }
    }
    
    public function deleteAlbum($album_id) {
        $sql = "DELETE FROM images WHERE album_id = '{$album_id}'";
        $q = $this->db->query($sql);
        
        if(!$sql) {
            return false;
        }
        
        $sql = "DELETE FROM albums WHERE user_id = '{$this->session->userdata('id')}' AND id = '{$album_id}'";
        $q = $this->db->query($sql);
        
        if(!$sql) {
            return false;
        } else {
            return true;
        }
    }
}

?>
