<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'models/view_model.php');
include_once($_SERVER['DOCUMENT_ROOT'].'includes/database.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'includes/normalize.php');
include_once($_SERVER['DOCUMENT_ROOT'].'views/menu.php');

if($_SERVER["PATH_INFO"] == ""){
    include_once($_SERVER['DOCUMENT_ROOT'].'controllers/main_page_controller.php');
     $controller = new Main_page_controller;
     $controller->main();
} 
else{
    $url = explode('/', ltrim($_SERVER['PATH_INFO'],'/'));
    $controller = strtolower($url[0]);
    if (file_exists($_SERVER['DOCUMENT_ROOT'].'controllers/'.$controller.'_controller.php')){
            include_once($_SERVER['DOCUMENT_ROOT'].'controllers/'.$controller.'_controller.php');
            $class = ucfirst($controller).'_controller';
            $controller = new $class;
            if (count($url) > 1){
                $controller->main($url);
            } else{
             $controller->main();   
            }
    } else{
        echo "404 - a kert oldal nem talalhato<br>";
        $previous = "javascript:history.go(-1)";
        echo "<a href='" . $previous . "'>Vissza az elozo oldalra</a>";
        die();
    }
}

exit();

?>		