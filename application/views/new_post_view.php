<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>resources/css/style.css" />
        <script src="<?php echo base_url();?>resources/js/libs/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url();?>resources/js/tinymce/tinymce.min.js"></script>
        <script src="<?php echo base_url();?>resources/js/navigation-script.js"></script>
        <script src="<?php echo base_url();?>resources/js/new_post-script.js"></script>
        



    <title>eDiary</title>
    </head>
    <body>

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
            
                <div id="newpost_wrapper"><!-- start #newpost_wrapper -->
               
                    
                    <div id="new_post">  <!-- start #new_post -->
                        
                        <form id="newpost_form">
                        
                        <input type="text" name="posttitle" id="posttitle" placeholder="Title..."/>
                        <br /><br />
                        <textarea id="tinyeditor" name="tinyeditor">
                        </textarea>
                         
                        <input id="submit_post" type="button" value="Submit new post" />
                        <p id="validation_error" class="error_msgs hidden">All fields are required.</p>
                        <p id="new_post_msg" class="error_msgs hidden"></p>
                        </form>
                        
                    </div> <!-- end #new_post -->
                    
                </div>
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
