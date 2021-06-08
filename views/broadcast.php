<?php
$menu = new Menu("Koruzenet");
$menu->main($blogszam);
?>

<script>
function escapeHtml(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };
  
  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

    $( document ).ready(function() {
        $("#title").on("input", function() {
      $("#mobile-view-header").html(escapeHtml('<?=$_SESSION["name"] . " - ";?>' + $("#title").val()));
    });
    $("#text").on("input", function() {
      $("#mobile-view-text").html(escapeHtml($("#text").val()));
      if ($("#text").val().length == 0){
          $("#mobile-view-text").html("[Ide jön az üzenet]");
      }
    });
        $("#submit").click(function(){
            if ($("#title").val().length < 3 ||  $("#text").val().length < 3){
                alert("Túl rövid a cím vagy szöveg!");
            } else {
           $.ajax({
            type: "POST",
            url: "/send_broadcast",
            data: {"message_title" : $("#title").val(), "message_text" : $("#text").val()},
        });
           alert("Uzenet elkuldve");
           $("#title").val("");
           $("#text").val("");
            $("#mobile-view-header").html('<?=$_SESSION["name"] . " - ";?>');
           $("#mobile-view-text").html("");
            }
        });
    });
</script>

<style>
    .mobile-view {
        position: absolute;
    }
</style>

<body>
  <div class="container">
    <h1 style="text-align:center; margin-bottom: 100px;">Koruzenet kuldese</h1>
    <div class="row">
      <h3><i>Figyelem! Az alabbi uzenetet minden regisztralt felhasznalo megkapja!</h3>
      <div class="container col-lg-6">
        <form method="POST" action="/send_broadcast" class="form-group">
          <label for="title">Cim:</label>
          <input type="text" id="title" name="message_title" class="form-control" maxlength="30"><br>
          <label for="text">Uzenet:</label>
          <textarea class="form-control" id="text" name="message_text" rows="3"></textarea>
        </form>
        <button id="submit">Kuldes</button>
      </div>
      <div class="container col-lg-6">
        <div style="width: 450px; height: 100px; background-color: white; margin: 20px; position: relative; border: 2px darkgreen solid;">
          <img class="mobile-view" src="https://www.iconexperience.com/_img/v_collection_png/256x256/shadow/coffee_beans.png" style="left: 5px; top; 20px; width: 30px; height: 30px;"/>
          <p class="mobile-view" id="mobile-view-header" style="left: 40px; top: 10px; right: 55px; font-style: normal; font-weight: bold; font-size: 1.2em;"><?=$_SESSION["name"] . " - ";?></p>
          <p class="mobile-view" id="mobile-view-text" style="left: 40px;top: 40px; font-style: normal;">[Ide jön az üzenet]</p>
          <p class="mobile-view" style="right: 10px;top: 10px;"> 18:32</p>
        </div>
      </div>
    </div>
  </div>
</body>

<?php
require('footer.php');
?>