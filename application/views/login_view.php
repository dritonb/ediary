<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>resources/css/style.css" />
        <script src="<?php echo base_url();?>resources/js/libs/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url();?>resources/js/login-script.js"></script>
        
        <title>eDiary</title>
        
    </head>
    <body>

        <div id="container"> <!-- start #container -->
        
            <div id="header"> <!-- start #header -->
              
            </div> <!-- end #header -->
            
                   

                <div id="loginformwrap" class="buttons visible">       
                    <p class="logintext">Please log in. If you don't have an account, click <a href="#" class="registerlink">here</a> to create one. </p>
                    <form id="loginForm" name="login">
                        <input type="text" id="username" name="username" placeholder="username" /><br/>
                        <input type="password" id="password" name="password" placeholder="password" /><br />
                        <input class="buttons" type="button" name="submit" id="submit" value="log in" />
                    </form>
                    <p class="logintext">Can't remember your password? Click <a href="#" class="resetlink">here</a> to reset it.</p>
                </div>
             
            
                       

                <div id="registerformwrap" class="buttons">       
                    <form id="registerForm" name="register">
                        <input type="text" id="firstname" name="firstname" placeholder="first name" /><br/>
                        <input type="text" id="lastname" name="lastname" placeholder="last name" /><br/>
                        <input type="text" id="username_reg" name="username" placeholder="username" /><br/>
                        <input type="text" id="email_reg" name="email" placeholder="e-mail" /><br/>
                        <input type="password" id="password_reg" name="password" placeholder="password" /><br />
                        <input type="password" id="conf_password_reg" name="conf_password" placeholder="confirm password" /><br />
                        <input class="buttons" type="button" name="submitregistration" id="submitregistration" value="register" />
                    </form>     
                    <p class="logintext">Click <a href="#" class="backtologin">here</a> to go back.</p>
                </div>
             
                
            
            
                <div id="resetformwrap" class="buttons">       
                    <form id="resetForm" name="reset">
                        <input type="text" id="username_res" name="username" placeholder="username" /><br/>
                        <input type="text" id="email_res" name="email_res" placeholder="e-mail" /><br/>
                        <input class="buttons" type="button" name="submitreset" id="submitreset" value="reset password" />
                    </form>
                    <p class="logintext">Click <a href="#" class="backtologin">here</a> to go back.</p>
                </div>

                

                
                <div id="errors">
                    <p id="empty_fields" class="error_msgs hidden">All fields are required.</p>
                    <p id="validation_error" class="error_msgs hidden"></p>
                    <p id="ajax_fail" class="error_msgs hidden">Problem occurred. Please try again.</p>
                </div>
                               
      

                
        </div> <!-- end #container -->
        
    </body>
</html>
