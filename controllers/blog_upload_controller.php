<?php
class Blog_upload_controller
{

    public function main()
    {
        include_once($_SERVER['DOCUMENT_ROOT'].'models/view_model_message.php');
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION["access_id"] == 2)
        {
            include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/blog_upload_model.php');
            $model = new Blog_upload_model;
            $result = $model->main();
            if ($result = 1)
            {
                $message = "<h3>Sikeres feltoltes</h3>";
            } else{
                $message = "<h2>Hiba a feltoltes soran!</h2>";
            }
        }
        else {
            $message = "<h2>Hiba tortent!</h2>";
        }
        $view_message = new View_model_message($message);
    }
}

?>

