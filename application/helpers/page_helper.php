<?php

    function header_view() {
        echo '
            <div id="header"> <!-- start #header -->
        

            </div> <!-- end #header -->
        ';
    }
    
    function menu_view() {
        echo '
            <ul class="menulist">
                <li class="menu_item"><a href="#">home</a></li>
                <li class="menu_item"><a href="#">new post</a></li>
                <li class="menu_item"><a href="#">gallery</a></li>
                <li class="menu_item"><a href="#">archive</a></li>
                <li class="menu_item"><a href="#">settings</a></li>
                <li class="menu_item"><a href="#">logout</a></li>
            </ul>
        ';
    }
    
   
?>
