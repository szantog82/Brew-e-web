<?php
class Modify_user_params_model {

public function main(){
       $input = json_decode($_POST["user"], true);
       
       $data = array(
           "street" => $input["street"],
           "family_name" => $input["family_name"],
           "first_name" => $input["first_name"],
           "city" => $input["city"],
           "postalcode" => $input["postalcode"],
           "login" => $_SESSION["login"]
           );
           
       $_SESSION["family_name"] = $input["family_name"];
       $_SESSION["first_name"] = $input["first_name"];
       $_SESSION["postalcode"] = $input["postalcode"];
       $_SESSION["country"] = $input["country"];
       $_SESSION["city"] = $input["city"];
       $_SESSION["street"] = $input["street"];

       $d = new Database;
       $conn = $d->get_connection();
       $query = "update felhasznalo set family_name=:family_name, first_name=:first_name, postalcode=:postalcode, city=:city, street=:street where login=:login";
       $conn->prepare($query)->execute($data);
}
   
}

?>