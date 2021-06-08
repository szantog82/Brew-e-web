<?php
class Test_user_connection_controller
{

    public function main()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $data = array(
                'login' => $_SESSION["login"],
                'id' => $_SESSION["id"],
                'email' => $_SESSION["email"],
                'family_name' => $_SESSION["family_name"],
                'first_name' => $_SESSION["first_name"],
                'postalcode' => $_SESSION["postalcode"],
                'country' => $_SESSION["country"],
                'city' => $_SESSION["city"],
                'street' => $_SESSION["street"]
            );
            header('Content-Type: text/html; charset=utf-8');
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
}

?>
