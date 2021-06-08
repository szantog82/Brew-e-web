<?php
class Get_blog_controller
{

    public function main($url)
    {
        $shop_id = $url[1]; 
        include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/get_blog_model.php');
        $model = new Get_blog_model;
        $data = $model->main($shop_id);
        header('Content-Type: text/html; charset=utf-8');
        print_r(json_encode($data, JSON_UNESCAPED_UNICODE));
    }
}

?>