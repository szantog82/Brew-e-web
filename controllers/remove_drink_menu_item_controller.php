<?php
class Remove_drink_menu_item_controller{

    public function main(){
        include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/remove_drink_menu_item_model.php');
        $model = new Remove_drink_menu_item_model;
        $model->main();
    }
}

?>