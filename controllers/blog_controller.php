<?php

class Blog_controller{

public function main($url){
    $view = new View_model("blog", $url);
}

}

?>