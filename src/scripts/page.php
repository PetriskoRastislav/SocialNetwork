<?php
    class Page{

        private $title = "SocialNetwork (tmp)";

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
                        <div class='left'>
                    
                            <img class='pageLogo' src='srcPictures/defaultpicture.png' alt='logo'>
                            <p class='pageName'>" . $this->title . "</p>
                        </div>
                        
                        ";




            if(isset($_SESSION['id_user']))
                $message .= "
                    <div class='right'>
                        <div class='header_menu_item header_drop_btn'>
                            <a href=''>" . $_SESSION['name'] . " " . $_SESSION['surname'] . "</a>
                        </div>
                        <div class='header_drop_content'>
                            <div class='header_menu_item'>
                                <a href=''>Friends</a>
                            </div>
                            <div class='header_menu_item'>
                                <a href=''>Settings</a>
                            </div>
                            <div class='header_menu_item'>
                                <a href='scripts/logout.php'>Logout</a>
                            </div>
                        </div>
                        <div class='header_menu_item'>
                            <a href=''>Messages</a>
                        </div>
                        <div class='header_menu_item'>
                            <a href=''>Notifications</a>
                        </div>
                    </div>";

            $message .= "</div></div>";

            echo $message;
        }

        public function displayTitle($title){
            echo "<h1 class='pageTitle'>" . $title . "</h1>";
        }

        public function displayBodyEnd(){
            echo "</div></body></html>";
        }
    }
?>