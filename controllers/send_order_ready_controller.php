<?php
class Send_order_ready_controller
{

    public function main()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION["access_id"] == 2)
        {
            session_start();
            include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/send_message_model.php');
            $data = array(
                "toAll" => 0
                );
            $model = new Send_message_model;
            $model->main($data);
        }
    }
}

?>