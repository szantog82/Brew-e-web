<?php
class Login_user_model
{

    public function getValidation()
    {
        session_start();
        $login = $_POST["login"];
        $password = $_POST["password"];
        $d = new Database;
        $conn = $d->get_connection();
        $query = "select count(*) from felhasznalo where is_active = 1 AND login = '" . $login . "'";
        if ($conn->query($query)->fetchColumn() == 0)
        {
            return 0;

        }
        else
        {
            $query2 = "select * from felhasznalo where login = '" . $login . "'";
            $user_row = $conn->query($query2)->fetch();
            if (password_verify($password, $user_row["password"])){
                $_SESSION["login"] = $login;
                $_SESSION["id"] = $user_row["id"];
                $_SESSION["email"] = $user_row["email"];
                $_SESSION["family_name"] = $user_row["family_name"];
                $_SESSION["first_name"] = $user_row["first_name"];
                $_SESSION["postalcode"] = $user_row["postalcode"];
                $_SESSION["country"] = $user_row["country"];
                $_SESSION["city"] = $user_row["city"];
                $_SESSION["street"] = $user_row["street"];
                $query3 = "update felhasznalo set sessid_short = '" . substr(session_id(), 0, 7) . "'" . " where login = '" . $login . "'";
                $conn->prepare($query3)->execute();
                return 1;
            }
            else
            {
                return 0;
            }
        }
    }

}

?>
