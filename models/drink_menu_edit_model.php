<?php
class Drink_menu_edit_model{

public function getDrinkMenu(){
        $id = $_SESSION["id"];
        $d = new Database;
        $conn = $d->get_connection();
        $query = "select count(*) from kavehaz where is_active = 1 AND login = '" . $login . "'";

}
   
}

?>