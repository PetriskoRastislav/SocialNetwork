<?php
    class Page{

        private $title = "SocialNetwork";

        public function displayHead($titleA, $styles = null){
            $this->displayDeclaration();
            $this->displayHeadTitle($titleA);
            $this->displayMeta();
            $this->displayStyles($styles);
        }

        private function displayDeclaration(){
            echo "<!DOCTYPE html>" .
            "<html lang='sk'>" .
            "<head>";
        }

        private function displayHeadTitle($titleA){
            echo
                "<title>" . $this->title . " - " . $titleA . "</title>";
        }

        private function displayMeta(){
            ?>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <?php
        }

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

        public function displayBodyStart(){
            echo "<body>";
            echo "<div id='page'>";
            $this->displayHeader();
            echo "<div class='main_content'>";
        }

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
                                
                                <li class='header_menu_li' id='header_menu_drop_btn'>
                                    <p class='header_menu_a'><i class='arrow up_arrow'></i></p>
                                </li>
                                
                                <div id='header_drop_content'>
                                    <a class='header_menu_a' href=''>Friends</a>
                                    
                                    <a class='header_menu_a' href='user_settings.php'>Settings</a>

                                    <a class='header_menu_a' href='scripts/logout.php'>Logout</a>
                                </div>
                                
                                <li class='header_menu_li border_left'>
                                    <a class='header_menu_a' href='profile.php'>" . $_SESSION['name'] . " " . $_SESSION['surname'] . "</a>
                                </li>
                                
                                <li class='header_menu_li border_left'>
                                    <a class='header_menu_a header_menu_a_img' href='messages.php'><img class='header_menu_img' src='srcPictures/icons8-message-100.png' alt='message icon'></a>
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

        public function displayTitle($title){
            echo "<h1 class='pageTitle'>" . $title . "</h1>";
        }

            public function displayBodyEnd(){
            $script = "<script src='js/jquery-3.4.1.min.js'></script>";

            $script .= "<script src='js/menu.js'></script>";

            echo $script . "</div></div></body></html>";
        }
    }
?>