<?php

class login extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('login_model');
    }
    
    public function index() {
        if($this->session->userdata('loggedin') == TRUE) {
            redirect('home');
        } else {
            $this->load->view('login_view');
        }
    }
    
    public function verifyUser() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if(!$this->form_validation->run()) {
            $errors = validation_errors();
            echo json_encode($errors);

            exit();
        }
        
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $hashed_password = hash('sha1', $password);
        
        $verifyData = $this->login_model->verifyUser($username, $hashed_password);
        
        if(!$verifyData) {
            $error_msg = "Wrong username or password.";
            echo json_encode($error_msg);
            exit();
        }
        else {
            $session_data = array(
                'id' => $verifyData['id'],
                'username' => $verifyData['username'],
                'email' => $verifyData['email'],
                'avatar' => $verifyData['avatar'],
                'firstname' => $verifyData['firstname'],
                'lastname' => $verifyData['lastname'],
                'loggedin' => TRUE
                );
            $this->session->set_userdata($session_data);
            echo 1;
            exit();
        }
    }
}

?>
