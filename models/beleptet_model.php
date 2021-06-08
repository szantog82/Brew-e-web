<?php
class Beleptet_model{

public function getValidation(){
        session_start();
        $d = new Database;
        $conn = $d->get_connection();
        $login = $_POST["login"];
        $password = $_POST["password"];
        if ($login == 'admin' || password_verify($password,'$2y$10$xu2jILgbnGSdpI1B4oXt5./cnDKJ5l.1Vpq3ucGXhuWXGg9wpd0Ie')) {
            $_SESSION["login"] = $login;
            $_SESSION["id"] = 1;
            $_SESSION["access_id"] = 1;
            return 1;
        }
        
        $query = "select count(*) from kavehaz where is_active = 1 AND login = '" . $login . "'";
        if ($conn->query($query)->fetchColumn() == 0)
        {
            return 0;  
    
        } else{
            $query2 = "select id, login, password, name, email, access_id from kavehaz where login = '" . $login . "'";
            $user_row = $conn->query($query2)->fetch();
            
            if (password_verify($password, $user_row["password"])) {
                $_SESSION["login"] = $login;
                $_SESSION["id"] = $user_row["id"];
                $_SESSION["access_id"] = $user_row["access_id"];
                $_SESSION["email"] = $user_row["email"];
                $_SESSION["name"] = $user_row["name"];
                return 1;
            } else {
                return 0;
            }
        }
}
   
}

?>