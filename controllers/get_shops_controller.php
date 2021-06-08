<?php
class Get_shops_controller
{

    public function main()
    {
        include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/get_shops_model.php');
        $model = new Get_shops_model;
        $data = $model->main();
        header('Content-Type: text/html; charset=utf-8');
        print_r(json_encode($data, JSON_UNESCAPED_UNICODE));
    }
}

?>