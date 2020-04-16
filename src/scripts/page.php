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
            echo "<link rel='stylesheet' href='styles/reset.css'>";
            echo "<link rel='stylesheet' href='styles/style.css'>";
            echo "<link rel='stylesheet' href='styles/style-dark.css'>";

            $style = @reset($styles);
            while ($style){
                echo "<link rel='stylesheet' href='" . $style . "'>";
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
            /*$message = "
                <div class='pageHeader'>
                    <div class='left pageHeader'>
                        <img class='pageLogo' src='srcPictures/defaultpicture.png' alt='logo'>
                        <p class='pageName'>" . $this->title . "</p>
                    </div>
                    <div class='right pageHeader'>";*/

            $message = "
                <div class='pageHeader'>
                    <div class='header_content'>
                        <div class='left'>";

            if (isset($_SESSION['id_user'])) $message .= "<a href='home.php' class='home_link'>";

            /*$message .= "
                            <img class='pageLogo' src='srcPictures/defaultpicture.png' alt='logo'>
                            <p class='pageName'>" . $this->title . "</p>
                            </a>
                        </div>";*/

            $message .= "<img class='pageLogo' src='srcPictures/defaultpicture.png' alt='logo'>";

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
                                
                                <div id='header_drop_content' class='header_menu_drop_hide'>
                                    <a class='header_menu_a' href='friends.php?user=me'>Friends</a>
                                    
                                    <a class='header_menu_a' href='user_settings.php'>Settings</a>

                                    <a class='header_menu_a' href='scripts/logout.php'>Logout</a>
                                </div>
                                
                                <li class='header_menu_li border_left'>
                                    <a class='header_menu_a' href='profile.php?user=me'>" . $_SESSION['name'] . " " . $_SESSION['surname'] . "</a>
                                </li>
                                
                                <li class='header_menu_li border_left'>
                                    <a class='header_menu_a header_menu_a_img' href='messages.php'><img class='header_menu_img' src='srcPictures/icons8-group-message-100.png' alt='message icon'></a>
                                </li>
                                
                                <li class='header_menu_li'>
                                    <p class='header_menu_a'>Notifications</p>
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