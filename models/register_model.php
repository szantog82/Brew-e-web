<?php

class Register_model
{

    public function feedback()
    {
        $login = mysqli_real_escape_string($_POST["login"]);
        $email = mysqli_real_escape_string($_POST["email"]);
        $password = mysqli_real_escape_string($_POST["password"]);
        $name = mysqli_real_escape_string($_POST["shop_name"]);
        $description = mysqli_real_escape_string($_POST["shop_descr"]);
        $postalcode = mysqli_real_escape_string($_POST["postal_code"]);
        $city = mysqli_real_escape_string($_POST["city"]);
        $street = mysqli_real_escape_string($_POST["street"]);
        $tax_num = mysqli_real_escape_string($_POST["tax_num"]);
        $lat_coord = mysqli_real_escape_string($_POST["lat"]);
        $lon_coord = mysqli_real_escape_string($_POST["lon"]);
        $d = new Database;
        $conn = $d->get_connection();

        $query = "select count(*) from kavehaz where login = '" . $login . "'";

        if ($conn->query($query)->fetchColumn() == 1)
        {
            return 0;
        }
        else if (strlen($login) < 3 || strlen($email) < 3 || strlen($password) < 3 || strlen($name) < 1 || strlen($postalcode) < 3 || strlen($city) < 1 || strlen($tax_num) < 8 || strlen($lat_coord) < 8)
        {
            return -1;
        }
        else
        {
            $data = ['login' => $login,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT), 
                    'name' => $name,
                    'description' => $description,
                    'postalcode' => $postalcode,
                    'city' => $city,
                    'street' => $street,
                    'tax_num' => $tax_num,
                    'lat_coord' => $lat_coord,
                    'lon_coord' => $lon_coord,
                    'registration_date' => time(),
                    'access_id' => 2,
                    'is_active' => 0
                    ];
            try
            {
                $sql = "insert into kavehaz (login, email, password, name, description, postalcode, city, street, tax_num, lat_coord, lon_coord, registration_date, access_id, is_active) values
                (:login, :email, :password, :name, :description, :postalcode, :city, :street, :tax_num, :lat_coord, :lon_coord, :registration_date, :access_id, :is_active)";
                $conn->prepare($sql)->execute($data);

            }
            catch(Exception $e)
            {
                print_r($e);
            }
            return 1;
        }
    }

}

?>
