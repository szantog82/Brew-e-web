<?php

class Admin_main{
    
public function main($shops, $users){
        $menu = new Menu("Admin");
        $menu->main();
?>

<script>
    $(document).ready(function() {
        $('input').change(function(){
            if(this.classList[0] == "shop"){
                $.post("/alter_shop", {login: this.name, active_value: this.value}, function(result){
                });
            } else if (this.classList[0] == "user"){
                $.post("/alter_user", {login: this.name, active_value: this.value}, function(result){
                });
            }
            });
        $(".remove").click(function(){
            if (confirm("Biztos, hogy toroljuk?")) {
                var url = "";
                if ((this.classList[0] == "remove_shop")){
                    url = "alter_shop";
                } else {
                    url = "alter_user";
                }
                $.ajax({
                    type: "DELETE",
                    url:"/" + url,
                    data: {login: this.id}
                });
            $(this).parent().parent().fadeOut(300);
            }
        });
        });
    </script>


<div class="container">
<h3 style="text-align: center; margin-bottom: 100px;">Admin oldal</h3>
<div class="container-block bg-success">
    <h4 style="color: darkred;">Kavehazak kezelese</h4>
    <table class="table">
      <thead>
      <tr>
        <th>Nev</th>
        <th>Email</th>
        <th>Ceg</th>
        <th>Aktiv-e</th>
        <th>Torles</th>
      </tr>
    </thead>
    <tbody>
        
<?php
foreach ($shops as $d){
    echo "<tr>";
    echo "<td>" . $d["login"] . "</td>\n";
    echo "<td>" . $d["email"] . "</td>\n";
    echo "<td>" . $d["name"] . "</td>\n";
    echo "<td>";
    if ($d["is_active"] == 1){
        $aktiv_checked = "checked";
        $disabled_checked = "";
    } else {
        $aktiv_checked = "";
        $disabled_checked = "checked";
    }
    echo "<label class='radio-inline'><input type='radio' class='shop' name='" . $d["login"] . "' value='1' " . $aktiv_checked . ">Aktiv</label>\n";
    echo "<label class='radio-inline'><input type='radio' class='shop' name='" . $d["login"] . "' value='0' " . $disabled_checked . ">Letiltva</label>\n";
    echo "</td>"; 
    echo "<td><button class='remove_shop remove btn btn-danger' id='" . $d["login"] . "'>Torles</Button>\n";
    echo"</tr>";
}

?>
     </tbody>
    </table>
  </div>
  
  
  <div class="container-block bg-success">
    <h4 style="color: darkred;">Felhasznalok kezelese</h4>
    <table class="table">
      <thead>
      <tr>
        <th>Login</th>
        <th>Email</th>
        <th>Csaladi nev</th>
        <th>Utonev</th>
        <th>Aktiv-e</th>
        <th>Torles</th>
      </tr>
    </thead>
    <tbody>
        
<?php
foreach ($users as $d){
    echo "<tr>";
    echo "<td>" . $d["login"] . "</td>\n";
    echo "<td>" . $d["email"] . "</td>\n";
    echo "<td>" . $d["family_name"] . "</td>\n";
    echo "<td>" . $d["first_name"] . "</td>\n";
    echo "<td>";
    if ($d["is_active"] == 1){
        $aktiv_checked = "checked";
        $disabled_checked = "";
    } else {
        $aktiv_checked = "";
        $disabled_checked = "checked";
    }
    echo "<label class='radio-inline'><input type='radio' class='user' name='" . $d["login"] . "' value='1' " . $aktiv_checked . ">Aktiv</label>\n";
    echo "<label class='radio-inline'><input type='radio' class='user' name='" . $d["login"] . "' value='0' " . $disabled_checked . ">Letiltva</label>\n";
    echo "</td>"; 
    echo "<td><button class='remove_user remove btn btn-danger' id='" . $d["login"] . "'>Torles</Button>\n";
    echo"</tr>";
}

?>
     </tbody>
    </table>
  </div>
  
</div>

<?php
require('footer.php');
}
}
?>