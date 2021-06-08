<?php
class Modify_user_params_controller
{

    public function main()
    { 
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION["login"] != "")
        {
            include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/modify_user_params_model.php');
            $model = new Modify_user_params_model;
            $model->main();
        }
    }
}

?>