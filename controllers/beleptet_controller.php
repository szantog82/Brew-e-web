<?php
class Beleptet_controller
{

    private $success;

    public function main()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/beleptet_model.php');
            $model = new Beleptet_model;
            $success = $model->getValidation();
            switch ($success)
            {
                case 0:
                    include_once($_SERVER['DOCUMENT_ROOT'].'models/view_model_message.php');
                    $message = "<h2 style='color: red;'>Sikertelen bejelentkezes!</h2>";
                    $view_message = new View_model_message($message);
                break;
                case 1:
                    header('Location: /');
                break;
            }
        } else{
            include_once($_SERVER['DOCUMENT_ROOT'].'models/view_model_message.php');
            $message = "<h2>Hiba tortent!</h2>";
            $view_message = new View_model_message($message);
        }
    }

}

?>
