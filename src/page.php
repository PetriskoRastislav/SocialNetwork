<?php
    class Page{
        public $title = "SocialNetwork";

        public function displayHead($titleA, $styles = null){
            $this->displayDeclaration();
            $this->displayHeadTitle($titleA);
            $this->displayMeta();
            $this->displayStyles($styles);
        }

        public function displayTitle($title){
            echo "<h1 class='pageTitle'>" . $title . "</h1>";
        }

        private function displayDeclaration(){
            ?>
            <!DOCTYPE html>
            <html lang="sk">
            <head>
            <?php
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
            //echo "<link rel='stylesheet' href='styles/reset.css'>";
            //echo "<link rel='stylesheet' href='styles/style.css'>";

            $style = @reset($styles);
            while ($style){
                echo "<link rel='stylesheet' href='" . $style . "'>";
                $style = next($styles);
            }

            echo "</head>";
        }

    }
?>