<?php

class resetpass extends CI_Controller {
    
    private $token;
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->model('resetpass_model');
    }
    
    public function sendEmail() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email_address', 'Email', 'required|valid_email');
        
        if(!$this->form_validation->run()) {
            $errors = validation_errors();
            echo json_encode($errors);

            exit();
        }
        
        $username = trim($this->input->post('username'));
        $email = trim($this->input->post('email_address'));
        
        $user_check = $this->resetpass_model->checkUser($username, $email);
        
        if(!$user_check) {
            $error_msg = "Wrong username or email.";
            echo json_encode($error_msg);

            exit();
        }
        
        $token = $this->resetpass_model->generateToken($email);
        
        if(!$token) {
            $error_msg = "A problem occurred. Please try again.";
            echo json_encode($error_msg);

            exit();
        }
        
        $url = base_url().'index.php/resetpass/resetPassword/'.$token;
        
        $message = '
                <html>
                <head>
                </head>
                <body>
                <p>Please click this <a href="'.$url.'">link</a> to reset your password!!<p>
                </body>
                </html>
            ';
        
        $config['protocol']='smtp';  
        $config['smtp_host']='ssl://smtp.googlemail.com';  
        $config['smtp_port']='465';  
        $config['smtp_timeout']='30';  
        $config['smtp_user']='e-mail@gmail.com';  
        $config['smtp_pass']='%@ac';  
        $config['charset']='utf-8';
        $config['mailtype'] = 'html';
        $config['newline']="\r\n";
        
        $this->email->initialize($config);
        
        $this->email->from('axz@live.com', 'eDiary');
        $this->email->to($email);
        $this->email->subject('eDiary - Reset password');
        $this->email->message($message);
        
        if(!$this->email->send()) {
            $error_msg = "A problem occurred. Please try again.";
            echo json_encode($error_msg);

            exit();
        }
        else {
            echo 1;
            exit();
        }       
    }
    
    public function resetPassword($get_token=''){
        
        $post_token = $this->input->post('token');
        
        if(isset($get_token) && !empty($get_token)) {
            $this->token = $get_token;
        }
        else if(isset($post_token) && !empty($post_token)) {
            $this->token = $post_token;
        }
        else {
            $this->token = '';
        }
        
        if(isset($this->token) && !empty($this->token)) {
            $pending = $this->resetpass_model->findUserByToken($this->token);
            if(isset($pending) && !empty($pending)) {
                $email = $pending['email'];
                $this->form_validation->set_rules('new_password', 'Password', 'required');
                $this->form_validation->set_rules('confirm_password', 'Confirm password', 'required|matches[new_password]');
                
                if($this->form_validation->run()) {
                    $password = $this->input->post('new_password');                    
                    $hashedPassword = hash('sha1', $password);
                    $pass_changed = $this->resetpass_model->chahgeUserPassword($email, $hashedPassword);                    
                    if($pass_changed) {
                        $this->resetpass_model->changeVisitedStatus($this->token);
                        echo 1;
                        exit();
                    }
                    else {
                        //Password update failed
                        $error = 'A problem occurred. Please try again.';
                        echo json_encode($error);
//                        echo 0;
                        exit();
                    }
                }
                $this->load->view('reset_view');
            }
            else {
                //One hour has passed (time limit for activating the sent link) or specified token doesn't exists in database.
                //The procedure (password reset) must be repeated.
                
                $error = 'Time limit for password reset has passed.<br/>
                            Please click this <a href="'.base_url().'index.php/login">link</a> 
                                and repeat the operation.';
                show_error($error);
                exit();
            }
        }
        else {
            //The GET parameter (secret token) is not set. Show error 404.
            show_404();
        }
    }
}

?>
