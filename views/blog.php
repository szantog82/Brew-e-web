<?php
class Blog
{

    public function main($data)
    {
        session_start();
        $menu = new Menu("Fooldal");
        $menu->main();
?>
        <style>
         img {
        max-width: 300px;
        max-height: 300px;
    }
    </style>
<div class='container'>
  <div class='col-sm-10 col-sm-offset-1'>

    <div style='margin-bottom: 70px;'>
      <h1 style="text-align: center; margin-bottom: 60px;"><?=$data["title"];?></h1>
      <h5 class='text-left' style='color: DarkRed; font-style: italic;'><?=$data["shop_name"];?> - <?=date("Y-m-d\ H:i", $data["upload_date"]);?></h5>
      <?=$data["text"];?>
    </div>
      <!-- AddToAny BEGIN -->
<div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="http://www.szantog82.nhely.hu" data-a2a-title="Kávéházak">
<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
<a class="a2a_button_facebook"></a>
<a class="a2a_button_twitter"></a>
<a class="a2a_button_whatsapp"></a>
</div>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->
  </div>
</div>

<?php
require('footer.php');
    }
}

?>