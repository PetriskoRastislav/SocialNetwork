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
            if(isset($_SESSION['id_user'])) echo "<a href='scripts/logout.php'>Logout</a>";
        }

        public function displayHeader(){
            echo "<div class='pageHeader'>" .
                "<img class='pageLogo' src='srcPictures/defaultpicture.png' alt='logo'>" .
                "<p class='pageName'>" . $this->title . "</p>" .
                "</div>";
        }

        public function displayTitle($title){
            echo "<h1 class='pageTitle'>" . $title . "</h1>";
        }

        public function displayBodyEnd(){
            echo "</div>" . "</body>" . "</html>";
        }
    }
?>