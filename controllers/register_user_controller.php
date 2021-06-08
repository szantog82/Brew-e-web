<?php
class Register_user_controller
{

    private $success;

    public function main()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/register_user_model.php');
            $model = new Register_user_model;
            $success = $model->feedback();
            $output = array(
                'success'=> $success,
                'session_id'=> session_id()
                );
            echo json_encode($output);
        }
    }
}

?>