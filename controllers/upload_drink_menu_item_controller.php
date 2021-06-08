<?php
class Upload_drink_menu_item_controller
{
    public function main()
    {
        if (
            strlen($_POST["group"]) < 1 ||
            strlen($_POST["name"]) < 3 ||
            strlen($_POST["price"]) < 3
        ) {
            //no upload
        } else {
            include_once $_SERVER['DOCUMENT_ROOT'] . 'models/upload_drink_menu_item_model.php';
            $model = new Upload_drink_menu_item_model();
            $last_id = $model->main();
            $output = [
                "last_id" => $last_id,
            ];
            echo json_encode($output);
        }
    }
}

?>
