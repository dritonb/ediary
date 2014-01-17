<?php

class home extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        if($this->session->userdata('loggedin') != TRUE) {
            redirect('login');
        }
        
        $this->load->library('form_validation');
        $this->load->helper('date');
        $this->load->model('home_model');
    }
    
    public function index() {
        $data['posts']= $this->getLastThreeEntries();
        $data['userdata'] = $this->session->all_userdata();
        
        $this->load->view('home_view', $data);
    }
    
    public function getLastThreeEntries() {
        $posts = $this->home_model->getLastThreeEntries();
        
        if(!$posts) {
            return array();
        } else {
            foreach($posts as $key => $post) {
                if(strlen($post['title']) > 50) {
                    $posts[$key]['title'] = substr($post['title'], 0, 50).'...';
                }
                
                $posts[$key]['title'] = '<a href="'.base_url().'index.php/single_post/postDetails/'.$post['id'].'" class="read_more">'.$posts[$key]['title'].'</a>';
                
                if(strlen($post['content']) > 220) {
                    $posts[$key]['content'] = 
                        substr($post['content'], 0, 220).'... <a href="'.base_url().'index.php/single_post/postDetails/'.$post['id'].'" class="read_more">read more</a>';
                }
                
                $tmp_date = explode(',', timespan($post['timestamp']));
                $posts[$key]['date_created'] = trim($tmp_date[0]) . ' ago';
            }
            
            return $posts;
        }
    }
    
    public function addQuickPost() {
        $this->form_validation->set_rules('post_title', 'Post title', 'required');
        $this->form_validation->set_rules('post_content', 'Post content', 'required');
        
        if(!$this->form_validation->run()) {
            echo -1;
            exit();
        }
        
        $data = array(
                    'id' => generateHash(),
                    'post_title' => $this->input->post('post_title'),
                    'post_content' => $this->input->post('post_content'),
                );
        
        $result = $this->home_model->addQuickPost($data);
        
        if($result) {
            echo json_encode($this->getLastThreeEntries());

            exit();
        } else {
            echo 0;
            exit();
        }
    }
}

?>
