<?php

class Show_own_blogs_controller{

public function main($url = [-1, -1]){
    if ($_SESSION["access_id"] == 2) {
        $view = new View_model("show_own_blogs", $url);   
    } else{
        include_once($_SERVER['DOCUMENT_ROOT'].'models/view_model_message.php');
        $message = "<h2>Hiba tortent!</h2>";
        $view_message = new View_model_message($message);
    }
}

}

?>