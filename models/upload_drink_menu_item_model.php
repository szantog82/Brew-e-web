<?php
class Upload_drink_menu_item_model{

public function main(){
        if ($_SESSION["access_id"] == 2 && $_SERVER['REQUEST_METHOD'] === 'POST') {

            $shop_id = $_SESSION["id"];
            $item_group = $_POST["group"];
            $item_name = $_POST["name"];
            $item_price = $_POST["price"];
            if (isset($_FILES['image']) && $_FILES['image']['size'] < 200*1024){
                    $item_image = file_get_contents($_FILES['image']['tmp_name']);       
                } else {
                    $item_image = "";
                }

            $d = new Database;
            $conn = $d->get_connection();
            
            $data = [
                'shop_id' => $shop_id,
                'item_group' => $item_group,
                'item_name' => $item_name,
                'item_price' => $item_price,
                'item_image' => $item_image
                ];
                
            $sql = "insert into itallap (shop_id, item_group, item_name, item_price, item_image) values (:shop_id, :item_group, :item_name, :item_price, :item_image)";
            $conn->prepare($sql)->execute($data);
            $last_id = $conn->insert_id;
            return $last_id;
        }
}
}
?>