<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>resources/css/style.css" />
        <script src="<?php echo base_url();?>resources/js/libs/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url();?>resources/js/libs/handlebars.js"></script>
        <script src="<?php echo base_url();?>resources/js/navigation-script.js"></script>
        <script src="<?php echo base_url();?>resources/js/home-script.js"></script>
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
              
            
             
                <div id="newpost"> <!-- start #newpost -->
                    <div id="title_wrapper"> <!-- start #title_wrapper -->
                    
                    <input type="text" name="post_title" id="post_title" maxlength="30" placeholder="Title..." />
                    </div> <!-- end #title_wrapper -->
                  
                    
                    
                    <div id="textarea">  <!-- start #textarea -->
                        <textarea id="post_content" placeholder="Type here..."></textarea>
                    </div> <!-- end #textarea -->
                  
                    <div class="clear"></div>
                    
                    <div class="buttons" id="buttons"> <!-- start #buttons -->
                  
                    <input id="reset_button" class="buttons" type="button" value="reset"></input>
                 
                    <input id="submit_button" class="buttons" type="button" value="submit"></input>
                    
                    </div> <!-- end #buttons -->

                    <div id="errors">
                        <p id="empty_fields" class="error_msgs hidden">All fields are required.</p>
                        <p id="validation_error" class="error_msgs hidden"></p>
                        <p id="ajax_fail" class="error_msgs hidden">Problem occurred. Please try again.</p>
                    </div>

                </div> <!-- end #newpost -->
            
                
                </div> <!-- end #menu_wrapper -->
                
                
                             
                <div class="clear"></div>            
             
                <div id="latestpostsheader"> <!-- start #latestpostsheader -->
                        
                </div> <!-- end #latestpostsheader -->
                
             
                <div id="latestposts"> <!-- start #latestposts -->

                    <?php 
                        foreach($posts as $post) {
                    ?>

                    <div class="post" data-id="<?php echo $post['id'] ?>">
                        <h3><?php echo $post['title']; ?></h3>   
                        <p>
                             <?php echo $post['content']; ?>
                        </p>
                        <p>
                             posted: <?php echo $post['date_created']; ?>
                        </p>
                    </div>

                    <?php
                        }
                    ?>
                      
                </div> <!-- end #latestposts -->
             
               
                
        </div> <!-- end #container -->
        
    </body>

    <script id="latestPostsTemplate" type="text/x-handlebars-template">
        {{#each this}}
            <div class="post" data-id="{{id}}">
                <h3>{{{title}}}</h3>
                <p>{{{content}}}</p>
                <p>posted: {{date_created}}</p>
            </div>
        {{/each}}
    </script>
</html>
