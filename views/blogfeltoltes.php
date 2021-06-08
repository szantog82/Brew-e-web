<?php
$menu = new Menu("Blogfeltoltes");
$menu->main($blogszam);
?>
<script src="https://cdn.ckeditor.com/4.11.4/standard-all/ckeditor.js"></script>
<script>
$( document ).ready(function() {
    $("#form").submit(function(event) {
      var valid = true;
      var title = $("#blog_title").val();
      var text = CKEDITOR.instances["blog_text"].getData();
      if (title.length < 2) {
        alert("Hianyzik a cim!");
        valid = false;
      }
      if (text.length < 2) {
        alert("Hianyzik a szoveg!");
        valid = false;
      }
      if (!valid) {
       event.preventDefault();   
      }
});
});
</script>
<body>
<div class="container">      
<h3>Blogbejegyzes feltoltese</h3>
<h5>Szerző: <i><b><?php echo $_SESSION["name"];?></i></b></h5><br>
<form action="/blog_upload" method="POST" id="form">
        <label for="blog_title">Bejegyzes cime:</label> <input type="text" class="form-control" name="blog_title" id="blog_title">
        <label for="blog_text">Szoveg:</label>
        <textarea class="form-control" rows="10" id="blog_text" name="blog_text"></textarea><br>
        <input type="submit" class="btn btn-success" />
      </form>
</div>


<script>
         CKEDITOR.replace('blog_text');
         CKEDITOR.config.entities_latin = false;
                </script>

</body>

<?php
require('footer.php');
?>