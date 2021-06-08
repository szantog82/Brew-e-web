<?php
class Kileptet_model{

public function main(){
        session_start();
         $_SESSION["login"] = "";
         $_SESSION["id"] = "";
         $_SESSION["access_id"] = "";
         $_SESSION["email"] = "";
         $_SESSION["name"] = "";
        session_destroy();
        }
}

?>