<?php

class single_post extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        if($this->session->userdata('loggedin') != TRUE) {
            redirect('login');
        }
        
        $this->load->model('single_post_model');
    }


    public function postDetails($id = '') {
        
        if(isset($id) && !empty($id)) {
            $post = $this->single_post_model->getPostDetails($id);
            
            if(!$post) {
                $error = 'Problem occurred. Sorry for the inconvenience. <br/><br/><a href="'.base_url().'" class="read_more">return to home page</a>';
                show_error($error);
                exit();
            }
            
            $data['post_details'] = $post;
            $data['userdata'] = $this->session->all_userdata();
            $this->load->view('single_post_view', $data);
        } else {
            show_404();
        }
        
    }

}

?>
