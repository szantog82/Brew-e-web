<?php
class Modify_blog_model {

public function modify(){
    $blog_id = $_POST["id"];
    $title = $_POST["title"];
    $text = $_POST["text"];
    $shop_id = $_SESSION["id"];

    $d = new Database;
    $conn = $d->get_connection();

    $query = "select count(*) as c from blog where shop_id=" . $shop_id . " and id=" . $blog_id;
    $count = $conn->query($query)->fetchColumn();
    if ($count == 0){
        return "Hiba a modositas soran";
    }

        $data = array(
            "id" => $blog_id,
            "title" => $title,
            "text" => $text
            );
        
        $d = new Database;
        $conn = $d->get_connection();
        $query = "update blog set title=:title, text=:text where id=:id";
        try{
        $conn->prepare($query)->execute($data);
        return "Sikeres modositas";
        } catch (Exception $e){
            return "Sikertelen modositas; adatbazis hiba";
        }
}
   
}

?>