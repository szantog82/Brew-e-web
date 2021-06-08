<?php
class Send_message_model {

public function main($data){
        session_start();
        $message = array();
        $message["toAll"] = $data["toAll"];

        if ($data["toAll"] == 0){
            $user_id = $_POST["user_id"];
            $d = new Database;
            $conn = $d->get_connection();
            $query = "select login, email from felhasznalo where id = " . $user_id;
            $result = $conn->query($query)->fetch();
            $message["message"] = $_SESSION["name"] . " - rendeles elkeszult" . "&&" . $_POST["message"];
            
            //lehetne akar login es email alapjan is hitelesiteni...
            $message["auth"] = $result["email"];
            
            //tovabbi adatbaztis muveletek kellenek, pl. jelolni hogy a rendeles teljesult
            
        } else {
            $message["message"] = $_SESSION["name"] . " - " . $_POST["message_title"] . "&&" . $_POST["message_text"];
            $message["auth"] = "";
        }
        
        $payload = json_encode($message);

        $url = "https://brewe-websocket.herokuapp.com/send_message";
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        curl_close($ch);
        print_r ($result);
    }
}