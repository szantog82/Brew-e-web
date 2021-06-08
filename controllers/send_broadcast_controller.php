<?php
class Send_broadcast_controller
{

    public function main()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION["access_id"] == 2)
        {
            include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/send_message_model.php');
            $data = array(
                "toAll" => 1,
                "auth" => ""
                );
            $model = new Send_message_model;
            $model->main($data);
        }
    }
}

?>