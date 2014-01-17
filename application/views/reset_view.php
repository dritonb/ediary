<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>resources/css/style.css" />
        <script src="<?php echo base_url();?>resources/js/libs/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url();?>resources/js/resetpass-script.js"></script>
        
        <title>eDiary</title>
        
    </head>
    <body>

        <div id="container"> <!-- start #container -->
        
            <div id="header"> <!-- start #header -->
              
            </div> <!-- end #header -->
            
                   

                 
            
                <div id="resetpassform" class="buttons">       
                    <form id="resetForm" name="reset">
                        <input type="password" id="password_res" name="password_res" placeholder="new password" /><br/>
                        <input type="password" id="password_res_conf" name="password_res_conf" placeholder="confirm your password" /><br/>
                        <input class="buttons" type="button" name="submitreset" id="submitreset" value="reset password" />
                    </form>

                    <div id="errors">
                        <p id="empty_fields" class="error_msgs hidden">All fields are required.</p>
                        <p id="fields_mismatch" class="error_msgs hidden">The Confirm password field does not match the New password field.</p>
                        <p id="validation_error" class="error_msgs hidden"></p>
                        <p id="ajax_fail" class="error_msgs hidden">Problem occurred. Please try again.</p>
                    </div>
                    
                 </div>
             
                
                
                
      

                
        </div> <!-- end #container -->
        
    </body>
</html>
