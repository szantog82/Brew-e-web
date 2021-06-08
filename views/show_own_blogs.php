<?php
class Show_own_blogs
{

    public function main($blogs, $url)
    {
        $menu = new Menu("Sajat blogok");
        $menu->main();
?>



<style>

    .item-row:hover {
        background-color: yellow;
        cursor: pointer;
    }
    
    img {
        max-width: 100px;
        max-height: 100px;
    }
    
    #tooltip {
        background-color: black;
        display: none;
    }
</style>
  <?php
if ($url >= 0){
?>
<script src="https://cdn.ckeditor.com/4.11.4/standard-all/ckeditor.js"></script>
<?php }
?>

<script>
var id = -1;
$( document ).ready(function() {
<?php
    if ($url >= 0){
?>
    CKEDITOR.replace('blog_text');
    CKEDITOR.config.entities_latin = false;
    $('html, body').animate({
     scrollTop: $("#form-edit").offset().top
    }, 500);
    
    $("#submit_btn").click(function(e){
        $.ajax({
            method: "POST",
            url: "/modify_blog",
            data: { id: $("#blog_id").val(), title: $("#blog_title").val(), text: CKEDITOR.instances["blog_text"].getData()},
            success: function(result){
                alert(result);
            }
        })
       e.preventDefault();
    });
<?php }
?>
    
    $(".item-row").on('click', function(){
        $('#tooltip').css({'display': 'block'});
        id =$(this).find(">:first-child").html();
        positionTooltip(event); 
    });

function positionTooltip(event){
    var tPosX = event.pageX;
    var tPosY = event.pageY;
    $('#tooltip').css({'position': 'absolute', 'top': tPosY, 'left': tPosX});
};

$("#editbtn").click(function(){
    window.location.replace("http://www.szantog82.nhely.hu/show_own_blogs/" + id);
});

$("#deletebtn").click(function(){
    if (confirm("Biztos, hogy toroljuk?")){
        alert(id);
    }
});

});


    
</script>

<body>
  <div class="container">
      <h1 style="text-align:center; margin-bottom: 100px;">Sajat blogok</h1>
       <table class="table" id="table">
          <thead>
            <tr>
              <th style="display: none;">id</th>
              <th style="width: 25%;">Cim</th>
              <th style="width: 75%;">Szoveg</th>
            </tr>
          </thead>
          <tbody>
                  <?php
          foreach ($blogs as $b) {
              echo "<tr class='item-row'>\n";
              echo "<td style='display: none;'>" . $b["id"] . "</td>\n";
              echo "<td><b>" . $b["title"] . "</b></td>\n";
              echo "<td>" . substr($b["text"], 0, 500) . "..." . "</td>\n";
              echo "</tr>\n";
          }
          
          ?>
          </tbody>
          </table>
<?php
if ($url >= 0){
 $blog_index = array_search($url, array_column($blogs, 'id'));   

?>
          <form id="form-edit">
              <input type="hidden" id="blog_id" name="blog_id" value="<?=$blogs[$blog_index]["id"];?>">
              <label for="blog_title">Bejegyzes cime:</label> <input type="text" class="form-control" name="blog_title" id="blog_title" value="<?=$blogs[$blog_index]["title"] ?>">
              <label for="blog_text">Szoveg:</label>
              <textarea class="form-control" rows="10" id="blog_text" name="blog_text"><?= $blogs[$blog_index]["text"] ?></textarea><br>
              <input id="submit_btn" type="submit">
          </form>
<?php
}
?>

  </div>
  
  <div id="tooltip">
      <button id="editbtn" class="btn btn-primary" style="margin: auto;">Szerkesztés</button>
      <button id="deletebtn" class="btn btn-danger">Törlés</button>
  </div>
</body>

<?php
require('footer.php');
    }
}
?>