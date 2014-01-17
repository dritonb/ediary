<?php

class gallery extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        if($this->session->userdata('loggedin') != TRUE) {
            redirect('login');
        }
        
        $this->load->library('form_validation');
        $this->load->helper('date');
        $this->load->model('gallery_model');
    }
    
    public function index() {
        $data['userdata'] = $this->session->all_userdata();
        $this->load->view('gallery_view', $data);
    }
    
    public function getAlbumList() {
        $this->form_validation->set_rules('from', 'From parameter', 'required');
        $this->form_validation->set_rules('to', 'To parameter', 'required');
        
        if(!$this->form_validation->run()) {
            echo 0;
            exit();
        }
        
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        
        $results = $this->gallery_model->getAlbumList($from, $to);
        
        if(is_array($results) && !empty($results)) {
            
            foreach($results['albums'] as $key => $album) {
                $tmp_date = explode(',', timespan($album['timestamp']));
                $results['albums'][$key]['date_created'] = trim($tmp_date[0]) . ' ago';
            }
            
            echo json_encode($results);
            exit();
        } else {
            echo json_encode(array());
            exit();
        }
    }
    
    public function getAlbumsCount() {
        $count = $this->gallery_model->countAlbums();
        
        if(!$count) {
            echo 0;
            exit();
        } else {
            echo json_encode($count);
            exit();
        }
    }
    
    public function addNewAlbum() {
        $this->form_validation->set_rules('album_name', 'Album name', 'required');
        
        if(!$this->form_validation->run()) {
            $errors = validation_errors();
            echo json_encode($errors);

            exit();
        }
        
        $album_name = $this->input->post('album_name');
        
        $result = $this->gallery_model->addNewAlbum($album_name);
        
        if($result) {
            echo 1;
            exit();
        } else {
            $errors = 'Problem occurred. Please try again.';
            echo json_encode($errors);

            exit();
        }
    }
    
    public function addImages() {
        $this->form_validation->set_rules('album_id', 'Album id', 'required');
        
        if(!$this->form_validation->run()) {
            echo 0;
            exit();
        }
        
        $album_id = $this->input->post('album_id');
        
        if(isset($_FILES['images']) && !empty($_FILES['images'])) {
            foreach($_FILES['images']['name'] as $key => $value) {
                $tmp = explode('.', $_FILES['images']['name'][$key]);
                $extension = $tmp[1];
                $hashedName = generateHash() . '.' . $extension;
                $imgs_path[$key] = 'resources/uploads/album_images/' . basename($hashedName);
                move_uploaded_file($_FILES['images']['tmp_name'][$key], $imgs_path[$key]);
            }
        }
        
        $data = array(
            'album_id' => $album_id,
            'imgs' => $imgs_path
        );
        
        $result = $this->gallery_model->addImages($data);
        
        if($result) {
            echo json_encode($this->getAlbumImages($data['album_id']));

            exit();
        } else {
            echo 0;
            exit();
        }
    }
    
    public function getAlbumImages($album_id = '') {
        $this->form_validation->set_rules('album_id', 'Album id', 'required');
        
        if(!$this->form_validation->run()) {
            echo 0;
            exit();
        }
        
        $album_id = $this->input->post('album_id');
        $result = $this->gallery_model->getAlbumImages($album_id);
        
        if($result) {
            echo json_encode($result);
            exit();
        } else {
            echo 0;
            exit();
        }
    }
    
    public function deleteAlbum() {
        $this->form_validation->set_rules('album_id', 'Album id', 'required');
        
        if(!$this->form_validation->run()) {
            echo 0;
            exit();
        }
        
        $album_id = $this->input->post('album_id');
        $result = $this->gallery_model->deleteAlbum($album_id);
        
        if(!$result) {
            echo 0;
            exit();
        } else {
            echo 1;
            exit();
        }
    }
}

?>
