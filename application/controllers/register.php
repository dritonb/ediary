<?php

class register extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('register_model');
    }
    
    public function newaccount() {
        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email_address', 'E-mail', 'required|valid_email|callback_email_check');
        $this->form_validation->set_rules('username', 'Username', 'required|callback_username_check');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('conf_password', 'Confirm password', 'required|matches[password]');
        
        if(!$this->form_validation->run()) {
            $errors = validation_errors();
            echo json_encode($errors);

            exit();
        }
        
        $password = $this->input->post('password');
        $hashed_password = hash('sha1', $password);
        
        $data = array (
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email_address'),
                    'avatar' => 'resources/uploads/useravatars/default_avatar.png',
                    'password' => $hashed_password
                );
        
        $verifyData = $this->register_model->insertNewUser($data);
        
        if(!$verifyData) {
            $error_msg = "A problem occurred. Please try again.";
            echo json_encode($error_msg);

            exit();
        } 
        else {
            echo 1;
            exit();
        }
    }
    
    public function username_check($username) {
        $verifyUsername = $this->register_model->checkUsername($username);
        
        if($verifyUsername > 0) {
            $this->form_validation->set_message('username_check', 'That username already exist.');
            return false;
        }
        else {
            return true;
        }  
    }
    
    public function email_check($email) {
        $verifyEmail = $this->register_model->checkEmail($email);
        
        if($verifyEmail > 0) {
            $this->form_validation->set_message('email_check', 'The email address already exists.');
            return false;
        }
        else {
            return true;
        }
    }

}

?>


