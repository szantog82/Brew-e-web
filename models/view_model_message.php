<?php

    class View_model_message {
    private $message;

    public function __construct($message){
        $this->message = $message;
        include_once($_SERVER['DOCUMENT_ROOT'].'views/message.php');
        $message_view = new Message_view($message);
    }

}

?>					