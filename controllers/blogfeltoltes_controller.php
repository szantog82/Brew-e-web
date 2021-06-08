<?php

class Blogfeltoltes_controller{

public function main(){
    if ($_SESSION["access_id"] == 2) {
        $view = new View_model("blogfeltoltes");   
    } else{
        include_once($_SERVER['DOCUMENT_ROOT'].'models/view_model_message.php');
        $message = "<h2>Hiba tortent!</h2>";
        $view_message = new View_model_message($message);
    }
}

}

?>	