<?php
class Get_drink_menu_model{

public function main($shop_id){
        $d = new Database;
        $conn = $d->get_connection();
            try
            {
                $query = "select i.id, i.item_group, i.item_name, i.item_price, i.item_image, i.shop_id, k.name as shop_name from itallap as i inner join kavehaz as k on i.shop_id = k.id where i.shop_id = " . $shop_id;
                $items = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(Exception $e)
            {
                print_r($e);
            }
        return $items;
}
}
?>