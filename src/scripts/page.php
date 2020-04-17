<?php
    class Page{


        /* title of a page */
        private $title = "SocialNetwork";


        /* will display html header */
        public function displayHead($titleA, $styles = null){
            $this->displayDeclaration();
            $this->displayHeadTitle($titleA);
            $this->displayMeta();
            $this->displayStyles($styles);
        }


        /* will display declaration of a html file */
        private function displayDeclaration(){
            echo "<!DOCTYPE html>" .
            "<html lang='sk'>" .
            "<head>";
        }


        /* will display title of a page */
        private function displayHeadTitle($titleA){
            echo
                "<title>" . $titleA . " - " . $this->title . "</title>";
        }


        /* will display meta information of a page */
        private function displayMeta(){
            ?>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <?php
        }


        /* will display default and additional styles */
        private function displayStyles($styles){

            if ( !( isset($_SESSION['color_mode']) ) ){
                $_SESSION['color_mode'] = "dark";
            }

            /* default styles */
            $def_styles = array(
                "styles/reset",
                "styles/style",
                "styles/menu"
            );

            $def_style = @reset($def_styles);

            while ($def_style){
                echo "<link rel='stylesheet' href='" . $def_style . ".css'>";

                if ($_SESSION['color_mode'] == "dark" && $def_style != "styles/reset"){
                    echo "<link rel='stylesheet' href='" . $def_style . "-dark.css'>";
                }

                $def_style = next($def_styles);
            }


            /* extra styles */
            $style = @reset($styles);

            while ($style){
                echo "<link rel='stylesheet' href='" . $style . ".css'>";

                if ($_SESSION['color_mode'] == "dark"){
                    echo "<link rel='stylesheet' href='" . $style . "-dark.css'>";
                }

                $style = next($styles);
            }

            echo "</head>";
        }


        /* will display start of a body and menu */
        public function displayBodyStart(){
            echo "<body>";
            echo "<div id='page'>";
            $this->displayHeader();
            echo "<div class='main_content'>";
        }


        /* will display header of a webpage, logo, menu, etc. */
        public function displayHeader(){

            $message = "
                <div class='pageHeader'>
                    <div class='header_content'>
                        <div class='left'>";

            if (isset($_SESSION['id_user'])) $message .= "<a href='home.php' class='home_link'>";

            $message .= "<img class='pageLogo' src='srcPictures/defaultpicture.png' alt='Page logo'>";

            if (isset($_SESSION['id_user'])) $message .= "</a></div>";
            else $message .= "</div>";


            if(isset($_SESSION['id_user']))
                $message .= "
                    <div class='right'>
                        <div class='header_menu_div'>
                            <ul class='menu_ul'>
                                
                                <li class='header_menu_li drop_btn' id='header_menu_drop_btn'>
                                    <p class='header_menu_a'><i class='arrow down_arrow' id='arrow_btn_menu'></i></p>
                                </li>
                                
                                <ul id='header_drop_content' class='header_menu_drop_hide'>
                                
                                    <a href='friends.php?user=me' class='header_menu_drop_a'>
                                        <li class='header_drop_item header_drop_item_border'>
                                            <img class='header_menu_img_drop' src='srcPictures/icons8-user-account-100.png' alt='Friends icon'>
                                            <p class='header_drop_p'>Friends</p>
                                        </li>
                                    </a>
                                    
                                    <a href='user_settings.php' class='header_menu_drop_a'>
                                        <li class='header_drop_item header_drop_item_border'>
                                            <img class='header_menu_img_drop' src='srcPictures/icons8-settings-100.png' alt='Settings icon'>
                                            <p class='header_drop_p'>Settings</p>
                                        </li>
                                    </a>
                                    
                                    <a href='scripts/logout.php' class='header_menu_drop_a'>
                                        <li class='header_drop_item header_drop_item_border_last'> 
                                            <img class='header_menu_img_drop' src='srcPictures/icons8-exit-100.png' alt='Logout icon'>
                                            <p class='header_drop_p'>Logout</p>
                                        </li>
                                    </a>
                                    
                                </ul>
                                
                                <li class='header_menu_li border_left'>
                                    <a class='header_menu_a' href='profile.php?user=me'>" .
                                        $_SESSION['name'] . " " . $_SESSION['surname'] .
                                    "</a>
                                </li>
                                
                                <li class='header_menu_li border_left'>
                                    <a class='header_menu_a header_menu_a_img' href='messages.php'>
                                        <img class='header_menu_img' src='srcPictures/icons8-group-message-100.png' alt='Messages icon'>
                                    </a>
                                </li>
                                
                                <li class='header_menu_li'>
                                    <a class='header_menu_a header_menu_a_img' href='messages.php'>
                                        <img class='header_menu_img' src='srcPictures/icons8-notification-100.png' alt='Notification icon'>
                                    </a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>";

            $message .= "</div></div>";

            echo $message;
        }


        /* will display title / heading of a webpage */
        public function displayTitle($title){
            echo "<h1 class='pageTitle'>" . $title . "</h1>";
        }


        /* will display end of a body and will attach default and additional javascript sctipts */
        public function displayBodyEnd($scripts){
            echo "<script src='js/jquery-3.4.1.min.js'></script>";
            echo "<script src='js/menu.js'></script>";
            echo "<script src='js/js.js'></script>";

            $script = @reset($scripts);

            while ($script){
                echo "<script src='" . $script . "'></script>";
                $script = next($scripts);
            }

            echo "</div></div></body></html>";
        }
    }
?>