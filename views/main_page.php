<?php
class Main_page
{

    public function main($data)
    {
        session_start();
        $menu = new Menu("Fooldal");
        $menu->main();

        $date = array_column($data, 'upload_date');

        array_multisort($date, SORT_DESC, $data);
?>
        <style>
         img {
        max-width: 300px;
        max-height: 300px;
    }
    </style>
<div class='container'>
<div class='col-sm-10 col-sm-offset-1'>
        
        <?php
        foreach ($data as $d)
        {
            echo "<div style='margin-bottom: 70px; padding: 10px; background-color: WhiteSmoke;'>";
            echo "<h1 style='text-align: center;'><a href='/blog/" . $d["id"] . "'>" . $d["title"] . "</a></h1>";
            echo "<h5 class='text-left' style='color: DarkRed; font-style: italic;'>" . $d["shop_name"] . " - " . date("Y-m-d\ H:i", $d["upload_date"]) . "</h5>";
            echo substr($d["text"], 0, 600) . "...";
            echo "<h4 style='font-style: italic;'><a href='/blog/" . $d["id"] . "'>Olvass tovabb...</a></h4>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
require('footer.php');
    }
}

?>
