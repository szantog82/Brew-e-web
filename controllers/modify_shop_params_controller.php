<?php
class Modify_shop_params_controller
{

    public function main()
    { 
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION["access_id"] == 2)
        {
            include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/modify_shop_params_model.php');
            $model = new Modify_shop_params_model;
            $success = $model->main();

            $data = array(
                "response" => $success
                );
            echo json_encode($data);
        }
    }
}

?>