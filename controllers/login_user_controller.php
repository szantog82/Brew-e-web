<?php
class Login_user_controller
{

    private $success;

    public function main()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/login_user_model.php');
            $model = new Login_user_model;
            $success = $model->getValidation();
            $output = array(
                        'success'=> $success,
                        'session_id' => session_id()
                        );
            echo json_encode($output);
        }
    }

}

?>