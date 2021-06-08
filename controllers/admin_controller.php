<?php
class Admin_controller{

    public function main(){
        if ($_SESSION["access_id"] == 1){
            $view = new View_model("admin_main");
        } else {
            include_once($_SERVER['DOCUMENT_ROOT'].'models/view_model_message.php');
            $message = "<h2>Hiba tortent!</h2>";
            $view_message = new View_model_message($message);
        }
    }
}

?>