<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>resources/css/style.css" />
        <script src="<?php echo base_url();?>resources/js/libs/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url();?>resources/js/libs/handlebars.js"></script>
        <script src="<?php echo base_url();?>resources/js/navigation-script.js"></script>
        <script src="<?php echo base_url();?>resources/js/archive-script.js"></script>
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

                <div class="archive_menu">
                    <span id="back_to_years" class="hidden"><a href="#">Back to years list</a></span>
                    <span id="back_to_months" class="hidden"><a href="#">Back to months list</a></span>
                </div>
            
                <div id="archive_content_wrap">
                
                    <div id="year_wrap"> <!-- start #year_wrap -->              
                
                    </div> <!-- end #year_wrap -->       
                        
                        
                    <div style="clear:both;"></div>
            
                    <div id="month_wrap" class="hidden">    <!-- start #month_wrap -->
                        
                    </div> <!-- end #month_wrap -->
                    
                    <div id="posts_wrap" class="hidden">

                        <div id="archive_post_wrap"  > <!-- end #month_wrap -->
                 
                        </div> <!-- end #archive_post_wrap -->
                        <div style="clear:both;"></div>
                        <div id="paging" class="hidden">
                            <span class="pagination">
                                <span id="from"></span>
                                <span>-</span>
                                <span id="to"></span>
                                <span>of</span>
                                <span id="all"></span>
                                <a  id="prev" href="#">&lt;</a>
                                <a id="next" href="#">&gt;</a>
                                
                            </span>
                        </div>
                        
                    </div>
                    
                    
                </div> <!-- end #archive_content_wrapper -->
                
                
                
                
            </div> <!-- end #menu_wrapper -->
                
                
                             
            <div class="clear"></div>            
             
             
                
        </div> <!-- end #container -->
        
    </body>

    <!-- Years template -->
    <script id="yearsListTemplate" type="text/x-handlebars-template">
        {{#each this}}
            <div class="year"> 
                <p class="archive_title">{{year}}</p>
            </div>
        {{/each}}
    </script>

    <!-- Months template -->
    <script id="monthsListTemplate" type="text/x-handlebars-template">
        {{#each this}}
            <div class="month"> 
                <p class="archive_title">{{month}}</p>
            </div>
        {{/each}}
    </script>

    <!-- Posts template -->
    <script id="postListTemplate" type="text/x-handlebars-template">
        {{#each this}}
            <a href="<?php echo base_url(); ?>index.php/single_post/postDetails/{{id}}">
                <div class="archive_post" data-id="{{id}}">
                    <p class="archive_title_post">{{title}}</p>
                    <p class="posted_on">Posted:</p>
                    <p class="archive_date">{{date}}</p>
                </div>
            </a>
          {{/each}}
    </script>

</html>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
