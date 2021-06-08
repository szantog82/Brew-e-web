<?php

class Message_view {
    public function __construct($message){
        $menu = new Menu("About");
        $menu->main();
        echo $message;
        require('footer.php');
    }
    
    
}

?>
