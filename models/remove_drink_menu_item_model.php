<?php
class Remove_drink_menu_item_model{

public function main(){
        if ($_SESSION["access_id"] == 2 && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST["id"];
            $d = new Database;
            $conn = $d->get_connection();

            $sql = "delete from itallap where id = ". $id;
            $conn->prepare($sql)->execute();
        }
}
}
?>