<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>resources/css/style.css" />
        <script src="<?php echo base_url();?>resources/js/libs/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url();?>resources/js/navigation-script.js"></script>
        <script src="<?php echo base_url();?>resources/js/settings-script.js"></script>
        <title>eDiary</title>
    </head>
    <script type="text/javascript">
$(document).ready(function(){

    $('.avatar_select').click(function(e) {  
         $('#avatar').click();
    });
});
                </script>

    <body>
    <?php //echo "<pre>"; print_r($userdata); echo "<pre>"; ?>    
        <div id="container"> <!-- start #container -->
        
            <?php header_view(); ?>    
            
            <div id="menu_wrapper"> <!-- start #menu_wrapper -->
           


                <div id="menu"> <!-- start #menu -->
                    <div id="username_avatar"> <!-- start #username_avatar -->
                    <?php echo '<img class="menu_avatar" src="../' . $userdata['avatar'] . '"/><br />';
                      echo '<p>' . $userdata['firstname'] . ' ' . $userdata['lastname']  . '</p>';?>
                    </div>     <!-- end #username_avatar -->             
                
                <?php menu_view(); ?>
                  
                </div> <!-- end #menu -->
                       
                <div id="settings_content"> <!-- start #settings_content -->
     
                    <div class="settings_element">
                        <h3>Upload an avatar</h3> 
                    <form id="avatarForm"  enctype="multipart/form-data"> 
                       
                        <div class="avatar_select">  
                        <input type="button" value="Browse files"/></div> 
                        <input type="file" id="avatar" name="avatar" />
                        <br />
                          <input type="button" id="submit_avatar" value="Submit">
                          <p id="change_avatar_msg" class="error_msgs hidden"></p>
                       </form> 

                    </div>
             
                    <div class="settings_element">
                        <h3>Change your password</h3>   
                        <form id="changePasswordForm" name="changePasswordForm"> 
                         
                            <input type="password" id="current_password" name="current_password" placeholder="Your current password" /> <br />
                            <input type="password" id="new_password" name="new_password" placeholder="Your new password" /><br />
                            <input type="password" id="new_password_repeat" name="new_password_repeat" placeholder="Confirm your password" />
                            <br />
                          <input type="button" id="submit_password" value="Submit">
                            <p id="validation_password_error" class="error_msgs hidden">All fields are required.</p>
                            <p id="change_password_msg" class="error_msgs hidden"></p>
                        </form>
                        
                        
                    </div>
                    <br />
                    <div class="settings_element">
                        <h3>Change your name</h3>
                        <form id="changeNameForm" name="changeNameForm"> 
                            <input type="text" id="firstname" name="firstname" placeholder="First Name" /> <br />
                            <input type="text" id="lastname" name="lastname" placeholder="Last Name" /> <br />
                            <input type="button" id="submit_name" value="Submit">
                            <p id="validation_name_error" class="error_msgs hidden">All fields are required.</p>
                            <p id="change_name_msg" class="error_msgs hidden"></p>
                        </form>
                        
                    </div>
                    
                </div> <!-- end #settings_content -->
                
            </div> <!-- end #menu_wrapper -->
                
                
                             
            <div class="clear"></div>            
             
             
       
                
        </div> <!-- end #container -->
        
    </body>
</html>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
