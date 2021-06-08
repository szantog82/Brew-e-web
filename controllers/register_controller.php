<?php
class Register_controller
{

    private $success;

    public function main()
    {
        include_once($_SERVER['DOCUMENT_ROOT'].'models/view_model_message.php');
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/register_model.php');

            $model = new Register_model;
            $success = $model->feedback();
            switch ($success)
            {
                case -1:
                    $message =  "<h3 style='color: red;'>Sikertelen regisztracio! Hiányzó adatok vagy tul rovid nev, jelszo!</h3>";
                break;
                case 0:
                    $message = "<h3 style='color: red;'>Sikertelen regisztracio! Ez a login nev mar foglalt!</h3>";
                break;
                case 1:
                    $message =  "<h3 style='color: green;'>Sikeres regisztracio! Az admin megerositese utan be is jelentkezhet!</h3>";
                break;
            }
        } else{
            $message = "<h2>Hiba tortent!</h2>";
        }
        $view_message = new View_model_message($message);
    }

}

?>
