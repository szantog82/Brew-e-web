<?php
class Blog_edit_controller
{

    public function main()
    {
        include_once($_SERVER['DOCUMENT_ROOT'].'models/view_model_message.php');
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION["access_id"] == 2)
        {
            include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/blog_edit_model.php');
            $model = new Blog_edit_model;
            $result = $model->main();
            if ($result = 1)
            {
                $message = "<h3>Sikeres valtoztatas</h3>";
            } else{
                $message = "<h2>Hiba!</h2>";
            }
        }
        else {
            $message = "<h2>Hiba tortent!</h2>";
        }
        $view_message = new View_model_message($message);
    }
}

?>
