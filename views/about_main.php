<?php

class About_main{
    
    public function main(){
        $menu = new Menu("About");
        $menu->main();
        ?>        
     <div class="container">
        <h1>Rolunk</h1>
        <h2>Hamarosan...</h2>
    </div>   

<?php
require('footer.php');
    }
}
?>