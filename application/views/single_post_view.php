<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>resources/css/style.css" />
        <script src="<?php echo base_url();?>resources/js/libs/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url();?>resources/js/navigation-script.js"></script>
        <script src="<?php echo base_url();?>resources/js/tinymce/tinymce.min.js"></script>


<script>
    function test(){
    alert($('#tinyeditor').val());
    }
       tinymce.init({selector:'textarea'});

</script>
    <title>eDiary</title>
    </head>
    <body>

        <div id="container"> <!-- start #container -->
        
            <?php header_view(); ?>    
            
            <div id="menu_wrapper_single"> <!-- start #menu_wrapper -->
           

                <div id="menu"> <!-- start #menu -->
                    <div id="username_avatar"> <!-- start #username_avatar -->
                    <?php echo '<img class="menu_avatar" src="../../../' . $userdata['avatar'] . '"/><br />';
                      echo '<p>' . $userdata['firstname'] . ' ' . $userdata['lastname']  . '</p>';?>
                    </div>     <!-- end #username_avatar -->             
                
                <?php menu_view(); ?>
                  
                </div> <!-- end #menu -->
            
                <div id="single_post_wrapper"><!-- start #single_post_wrapper -->
               
                    
                    <div id="single_post_content">  <!-- start #new_post -->
                       <p class="post_date"><b>posted:</b> <?php echo $post_details['date'] ?></p>
                  
                       <p class="post_title"><?php echo $post_details['title'] ?></p> 

                       <p class="post_content"><?php echo $post_details['content'] ?></p>                                                
                        
                
                    </div> <!-- end #single_post_wrapper -->
                    
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
