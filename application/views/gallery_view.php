<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>resources/css/style.css" />
        <script src="<?php echo base_url();?>resources/js/libs/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url();?>resources/js/libs/handlebars.js"></script>
        <script src="<?php echo base_url();?>resources/js/libs/galleria-1.2.9.js"></script>
        <script src="<?php echo base_url();?>resources/js/navigation-script.js"></script>
        <script src="<?php echo base_url();?>resources/js/gallery-script.js"></script>
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
                
                <div class="gallery_menu">
                    <span id="create_new_album"><a href="#">+ Create a new album</a></span>
                    <span id="back_to_albums" class="hidden"><a href="#">Back to album list</a></span>
                    <span id="add_images" class="hidden"><a href="#">+ Add images</a></span>
                </div>

                <div id="gallery_albums">  

                    <br />

                    <div id="albums_list">
                        <!-- album list -->
                    </div>

                    <div class="clear"></div>

                    <div id="paging">
                       <span class="pagination">
                            <span id="from"></span>
                            <span>-</span>
                            <span id="to"></span>
                            <span>of</span>
                            <span id="all"></span>
                            <a id="prev" href="#">&lt;</a>
                            <a id="next" href="#">&gt;</a>
                        </span>
                    </div>


                    <div class="clear"></div>

                </div>

                
                <div id="gallery" class="hidden"></div>
                
            </div> <!-- end #menu_wrapper -->
                             
            <div class="clear"></div>            
             
             
           
        </div> <!-- end #container -->
    

        <!-- create album modal box -->
        <div id="block_page_albums" class="block_page">
            <div id="modal_box_albums" class="modal_box">
                <a href="#" id="modal_close_albums" class="modal_close"></a>
                <div class="inner_modal_box">
                    <h2>Create a new album</h2>
                    <span id="create_album_modal" class="">
                        <input type="text"  id="album_name" class="" placeholder="album name"/>
                        <input type="button" id="submit_album_name" class="" value="create album" />
                    </span>
                </div>

            </div>
        </div>

        <!-- add images modal box -->
        <div id="block_page_images" class="block_page">
            <div id="modal_box_images" class="modal_box">
                <a href="#" id="modal_close_images" class="modal_close"></a>
                <div class="inner_modal_box">
                    <h2>Upload your images</h2>
                    <span id="add_images_modal" class="">
                        <form id="upload_images"enctype="multipart/form-data">
                            <input type="file" name="images[]" id="images" multiple />
                            <input type="button" id="submit_images_btn" class="hidden" value="Upload Files" />
                        </form>
                    </span>
                </div>
            </div>
        </div>

        <div id="errors">
            <p id="validation_error" class="error_msgs hidden"></p>
            <p id="ajax_fail" class="error_msgs hidden">An error occurred. Please try again.</p>
        </div>


    </body>

    <script id="albumsListTemplate" type="text/x-handlebars-template">
        {{#each this}}
            <div class="album_wrap" data-id="{{id}}">
                <span class="album"></span>
                <p class="delete_button"></p>
                <p class="album_title">{{title}}</p>
                <p class="album_date">added: {{date_created}}</p> 
            </div>
        {{/each}}
    </script>

    <script id="imageListTemplate" type="text/x-handlebars-template">
        {{#each this}}
            <img src="<?php echo base_url()?>{{path}}">
        {{/each}}
    </script>
</html>
