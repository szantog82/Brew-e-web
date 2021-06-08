<?php
class Modify_blog_controller
{

    public function main()
    { 
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION["access_id"] == 2)
        {
            include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/modify_blog_model.php');
            $model = new Modify_blog_model;
            echo $model->modify();
        }
    }
}

?>