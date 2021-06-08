<?php
class Logout_user_model
{

    public function main()
    {
        session_start();
         $d = new Database;
         $conn = $d->get_connection();
         $query = "update felhasznalo set sessid_short = '' where login = '" . $_SESSION["login"] . "'";
         $conn->prepare($query)->execute();
        
        $_SESSION["login"] = "";
        $_SESSION["id"] = "";
        $_SESSION["email"] = "";
        $_SESSION["family_name"] = "";
        $_SESSION["first_name"] = "";
        $_SESSION["postalcode"] = "";
        $_SESSION["country"] = "";
        $_SESSION["city"] = "";
        $_SESSION["street"] = "";
        session_destroy();
    }
}

?>
