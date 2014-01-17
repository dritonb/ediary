<?php

class archive extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        if($this->session->userdata('loggedin') != TRUE) {
            redirect('login');
        }
        
        $this->load->library('form_validation');
        $this->load->model('archive_model');
    }
    
    public function index() {
        $data['userdata'] = $this->session->all_userdata();
        $this->load->view('archive_view', $data);
    }
    
    public function getYears() {
        $result = $this->archive_model->getYears();
        if($result) {
            echo json_encode($result);
            exit();
        } else {
            echo 0;
            exit();
        }
    }
    
    public function getMonths() {
        $this->form_validation->set_rules('year', 'Year', 'required');
        
        if(!$this->form_validation->run()) {
            echo 0;
            exit();
        }
        
        $year = $this->input->post('year');
        $result = $this->archive_model->getMonths($year);
        
        if($result) {
            echo json_encode($result);
            exit();
        } else {
            echo 0;
            exit();
        }
    }
    
    public function getPosts() {
        $this->form_validation->set_rules('year', 'Year', 'required');
        $this->form_validation->set_rules('month', 'Month', 'required');
        $this->form_validation->set_rules('from', 'From', 'required');
        $this->form_validation->set_rules('to', 'To', 'required');
        
        if(!$this->form_validation->run()) {
            echo 0;
            exit();
        }
        
        $data = array(
            'year' => $this->input->post('year'),
            'month' => $this->input->post('month'),
            'from' => $this->input->post('from'),
            'to' => $this->input->post('to'),
        );
        

        $results = $this->archive_model->getPosts($data);
        
        if(is_array($results) && !empty($results)) {
            foreach($results['posts'] as $key => $post) {
                if(strlen($post['title']) > 40) {
                    $results['posts'][$key]['title'] = substr($post['title'], 0, 40) . '...';
                }
            }
            
            echo json_encode($results);
            exit();  
        } else {
            echo 0;
            exit();
        }
    }
    
    public function getPostsCount() {
        $this->form_validation->set_rules('year', 'Year', 'required');
        $this->form_validation->set_rules('month', 'Month', 'required');
        
        if(!$this->form_validation->run()) {
            echo 0;
            exit();
        }
        
        $data = array(
            'year' => $this->input->post('year'),
            'month' => $this->input->post('month')
        );
        
        $count = $this->archive_model->getPostsCount($data);
        
        if(!$count) {
            echo 0;
            exit();
        } else {
            echo json_encode($count);
            exit();
        }
    }
}

?>
