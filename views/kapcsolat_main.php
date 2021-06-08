<?php

class Kapcsolat_main{
    
    public function main(){
     $menu = new Menu("Kapcsolat");
     $menu->main();
    ?>   
    
<div class="container">
<h2>Elerhetosegunk</h2>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6299.641250230859!2d19.708735237539337!3d46.89711523768303!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4743da3916718a1f%3A0x55bf8ab7b0c75909!2sKecskem%C3%A9ti%20Vadaspark!5e0!3m2!1shu!2shu!4v1601980335687!5m2!1shu!2shu" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
<h4>Kavehazak - Brew-e app</h4>
<h4>Kecskemet, Noveny u. 3</h4>
<h4>Tel.: 06-20-678-3456</h4>
<h4>E-mail: <a href="mailto:novenytermesztok@novenytermesztes.hu">brewe@brewe.hu</a></h4>
</div>    
    
<?php
require('footer.php');    
        
    }
}
?>