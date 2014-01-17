<?php


class settings extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('settings_model');
        if($this->session->userdata('loggedin') != TRUE) {
            redirect('login');
        }
    }
    
    public function index() {
        $data['userdata'] = $this->session->all_userdata();
        $this->load->view('settings_view', $data);
    }
 
    public function uploadAvatar(){
        
        if (isset($_FILES['avatar'])) {
                        
            $tmp = explode('.', $_FILES['avatar']['name']);
            $extension = $tmp[1];
            $validExtensions = array('jpg', 'jpeg', 'png');    
          
            if(in_array($extension, $validExtensions)) {      
                switch($_FILES['avatar']['type']) {
                    case 'image/jpeg':
                        $image = imagecreatefromjpeg($_FILES['avatar']['tmp_name']);
                        break;
                    case 'image/png':
                        $image = imagecreatefrompng($_FILES['avatar']['tmp_name']);
                        break;
                    case 'image/jpg':
                        $image = imagecreatefromjpeg($_FILES['avatar']['tmp_name']);
                        break;
                    default:
                        exit('Unsupported type: '.$_FILES['avatar']['type']);
                }
             
                $max_width      = 50;
		$max_height     = 50;
                $old_width      = imagesx($image);
		$old_height     = imagesy($image);
		$scale          = min($max_width/$old_width, $max_height/$old_height);
		$new_width      = ceil($scale*$old_width);
		$new_height     = ceil($scale*$old_height);

		$new = imagecreatetruecolor($new_width, $new_height);

		imagecopyresampled($new, $image, 
				0, 0, 0, 0, 
				$new_width, $new_height, $old_width, $old_height);
                                
                $hashedName = generateHash() . '.' . $extension;
                $img = 'resources\uploads\useravatars\\' .  basename($hashedName);
		imagejpeg($new, $img, 90);
		imagedestroy($image);
		imagedestroy($new);
                
                $data = array( 
                    'imgpath' => $img,
                    'userid' => $this->session->userdata('id')
                );
            
                $res = $this->settings_model->addAvatar($data);
                
                if(!$res){
                    $error_msg = "A problem occurred. Please try again. result";
                    echo json_encode($error_msg);
        //            echo 0;
                    exit();
                } else {
                    $temp_img =  str_replace('\\', '/', $img);
                    $userdata = $this->session->all_userdata();
                    $userdata['avatar'] = $temp_img; 
                    $this->session->set_userdata($userdata);
                    echo 1;
                    exit();
                }
            }              
        } else {
            $error_msg = "Please choose an image.";
            echo json_encode($error_msg);
//            echo 0;
            exit();
        }
    }
    
    public function changeName() {
        $this->form_validation->set_rules('firstname', 'First Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');
        
        if(!$this->form_validation->run()) {
            $errors = validation_errors();
            echo json_encode($errors);

            exit();
        }
           
        $data = array (
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname')                  
        );
             
        $res = $this->settings_model->changeName($data);
        
        if(!$res) {
            $error_msg = "Problem occurred. Please try again.";
            echo json_encode($error_msg);

            exit();
        } else {
            $userdata = $this->session->all_userdata();
            $userdata['firstname'] = $data['firstname'];
            $userdata['lastname'] = $data['lastname'];
            $this->session->set_userdata($userdata);
            echo 1;
            exit();
        }
    }
    
    public function changePassword() {
    
        $this->form_validation->set_rules('current_password', 'Current password', 'required|callback_password_check');
        $this->form_validation->set_rules('new_password', 'New password', 'required');
        $this->form_validation->set_rules('new_password_repeat', 'New password confirmation', 'required|matches[new_password]');
        
        if(!$this->form_validation->run()) {
            $errors = validation_errors();
            echo json_encode($errors);

            exit();
        }
        
        $new_password = $this->input->post('new_password');
        $hashed_password_new = hash('sha1', $new_password);
          
        $result = $this->settings_model->changePassword($hashed_password_new);
           
        if(!$result) {
            $error_msg = "Problem occurred. Please try again.";
            echo json_encode($error_msg);

            exit();
        } else {
            echo 1;
            exit();
        }
    }
    
    public function password_check($password) {
        $password = hash('sha1', $password);
        $password_check = $this->settings_model->checkPassword($password);
        
        if($password_check > 0) {
            return true;
        }
        else {
            $this->form_validation->set_message('password_check', 'The current password is incorrect.');
            return false;
        }
    }
}

?>
