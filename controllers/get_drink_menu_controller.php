<?php
class Get_drink_menu_controller
{

    public function main($url)
    {
        $shop_id = $url[1]; 
        include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/get_drink_menu_model.php');
        $model = new Get_drink_menu_model;
        $data = $model->main($shop_id);
        $output = array();
        $i = 0;
        foreach ($data as $d) {
            $insert = array(
              'id' => $d["id"], 
              'item_group' => $d["item_group"], 
              'item_name' => $d["item_name"], 
              'item_price' => $d["item_price"],
              'item_image' => base64_encode($d["item_image"]),
              'shop_id' => $d["shop_id"],
              'shop_name' => $d["shop_name"]
            );
            $output[$i] = $insert;
            $i++;
        }
        header('Content-Type: text/html; charset=utf-8');
        print_r(json_encode($output, JSON_UNESCAPED_UNICODE));
    }
}

?>