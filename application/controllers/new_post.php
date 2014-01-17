<?php

class new_post extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        if($this->session->userdata('loggedin') != TRUE) {
            redirect('login');
        }
        
        $this->load->library('form_validation');
        $this->load->model('new_post_model');
    }
    
    public function index() {
        $data['userdata'] = $this->session->all_userdata();
        $this->load->view('new_post_view', $data);
    }

    
    public function addPost() {
        $this->form_validation->set_rules('posttitle', 'Post title', 'required');
        $this->form_validation->set_rules('tinyeditor', 'Post content', 'required');
        
        if(!$this->form_validation->run()) {
            $errors = validation_errors();
            echo json_encode($errors);
//            echo 0;
            exit();
        }
        
        $data = array(
            'id' => generateHash(),
            'post_title' => $this->input->post('posttitle'),
            'post_content' => $this->input->post('tinyeditor'),
        );
        
        $result = $this->new_post_model->addPost($data);
        
        if(!$result) {
            $error_msg = "A problem occurred. Please try again.";
            echo json_encode($error_msg);

            exit();
        } else {
            echo 1;
            exit();
        }
    }
}

?>
