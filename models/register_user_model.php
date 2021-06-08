<?php

class Register_user_model
{

    public function feedback()
    {
        $data = json_decode($_POST["user"], true);
        
        $login = $data["login"];
        $email = $data["email"];
        $password = $data["password"];
        $family_name = $data["family_name"];
        $first_name = $data["first_name"];
        $postalcode = $data["postal_code"];
        $city = $data["city"];
        $street = $data["street"];
        $country = $data["country"];
        $d = new Database;
        $conn = $d->get_connection();

        $query = "select count(*) from felhasznalo where login = '" . $login . "'";

        if ($conn->query($query)->fetchColumn() == 1)
        {
            return 0;
        }
        else if (strlen($login) < 3 || strlen($email) < 3 || strlen($password) < 3 || strlen($family_name) < 1 || strlen($first_name) < 3)
        {
            return -1;
        }
        else
        {
            $data = ['login' => $login,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT), 
                    'family_name' => $family_name,
                    'first_name' => $first_name,
                    'postalcode' => $postalcode,
                    'city' => $city,
                    'street' => $street,
                    'country' => $country,
                    'registration_date' => time(),
                    'is_active' => 1
                    ];
            try
            {
                $sql = "insert into felhasznalo (login, email, password, family_name, first_name, postalcode, city, street, country, registration_date, is_active) values
                (:login, :email, :password, :family_name, :first_name, :postalcode, :city, :street, :country, :registration_date, :is_active)";
                $conn->prepare($sql)->execute($data);
                $new_id = $conn->lastInsertId();
                session_start();
                $_SESSION["login"] = $login;
                $_SESSION["id"] = $new_id;
                $_SESSION["email"] = $email;
                $_SESSION["family_name"] = $family_name;
                $_SESSION["first_name"] = $first_name;
                $_SESSION["postalcode"] = $postalcode;
                $_SESSION["country"] = $country;
                $_SESSION["city"] = $city;
                $_SESSION["street"] = $street;
                $query3 = "update felhasznalo set sessid_short = '" . substr(session_id(), 0, 7) . "'" . " where login = '" . $login . "'";
                $conn->prepare($query3)->execute();
                return 1;
            }
            catch(Exception $e)
            {
                print_r($e);
                return -2;
            }
        }
    }

}

?>