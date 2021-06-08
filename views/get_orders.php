<?php
class Get_Orders
{
    private $orders;

    public function main($orders)
    {
        $menu = new Menu("Beerkezett rendelesek");
        $menu->main();

        $this->orders = $orders;
?>

<style>
    textarea {
        resize: none;
    }
</style>

<script>
$(document).ready(function () {
    
    var actualCheckbox = null;
    var data = [];
    
    var order_id;
    var user_id;
    var item_id;
    var item_name;
    var item_count;
    
  $(".checkbox").change(function () {
    actualCheckbox = $(this);
     order_id = actualCheckbox.parent().parent().children(":eq(0)").html();
     user_id = actualCheckbox.parent().parent().children(":eq(4)").html();
     item_id = actualCheckbox.parent().parent().children(":eq(5)").html();
     item_name = actualCheckbox.parent().parent().children(":eq(6)").html();
     item_count = actualCheckbox.parent().parent().children(":eq(7)").html();
    if (actualCheckbox.is(":checked")) {
      $("#modal").modal("show");
      $("#textarea").html("A(z) " + item_count + "db " + item_name + " elkeszult, johetsz erte!");
    }
  });
  
    $("#modal_dismiss_btn").click(function () {
      actualCheckbox.prop("checked", false);
    });
  
  
   $("#modal_send_btn").on('click', function () {
      actualCheckbox.prop("checked", true);
      actualCheckbox.prop("disabled", true);
      sendMessage(order_id, user_id, item_id, item_count);
    });
  
  var sendMessage = function(order_id, user_id, item_id, item_count){
      var message = $("#textarea").html();
      $.ajax({
        type: "POST",
        url: "/send_order_ready",
        data: {"order_id": order_id, "user_id" : user_id, "item_id": item_id, "item_count": item_count, "message": message},
        success: function(response){
           $("#mess").html(response);
        }
      });
      //alert("Uzenet sikeresen elkuldve!");
  }
});
</script>

<body>
   <div class="container">
      <h1 style="text-align:center; margin-bottom: 100px;">Beerkezett rendelesek</h1>
       <table class="table" id="table">
          <thead>
            <tr>
              <th>Rendeles id</th>
              <th>Datum</th>
              <th>Megrendelo neve</th>
              <th>Megrendelo email</th>
              <th style="display:none;">Megrendelo id</th>
              <th style="display:none;">Tetel id</th>
              <th>Tetel</th>
              <th>Darab</th>
              <th>Teljesitve</th>
            </tr>
          </thead>
          <tbody>
                  <?php
                  $prev_id = -1;
                  $count = -1;
                  $color = "#FFFFCC";
          foreach ($orders as $o) {
              if ($o["order_id"] != $prev_id) {
                  if ($count %2 == 0) {
                      $color = "#FFFFEE";
                  } else {
                      $color = "#FFEEFF";
                  }
                  $count++;
                  $prev_id = $o["order_id"];
              }
              ?>
              <tr style="background-color: <?=$color?>">
                  <td><?=$o["order_id"];?></td>
                  <td><?=date('m/d/Y H:i:s', $o["order_date"]);?></td>
                  <td><?=$o["family_name"]. " " . $o["first_name"] . " (" . $o["login"] . ")";?></td>
                  <td><?=$o["email"];?></td>
                  <td style="display:none;"><?=$o["user_id"];?></td>
                  <td style="display:none;"><?=$o["item_id"];?></td>
                  <td><?=$o["item_name"] . " (" . $o["item_price"] . "Ft)";?></td>
                  <td><?=$o["item_count"];?></td>
                  <td><input class="form-check-input checkbox" type="checkbox" value="" <?= ($o["is_complete"] == 1) ? "checked disabled" : "unchecked";?>></td>
              </tr>
              
              
              <?php
          }
          
          ?>
          </tbody>
          </table>
  </div>
  
   <div class="modal fade" id="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Rendeles elkeszult - visszaigazolas</h3>
      </div>
      <div class="modal-body">
        <div class="form-group">
  <label for="textarea">Visszajelzes kuldese:</label>
  <textarea class="form-control" id="textarea" rows="7"></textarea>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" id="modal_dismiss_btn" class="btn btn-secondary" data-dismiss="modal">Megse</button>
        <button type="button" id="modal_send_btn" class="btn btn-primary" data-dismiss="modal">Kuldes</button>
      </div>
    </div>
  </div>
</div>

  <p id="mess"></p>
</body>

<?php
require('footer.php');
    }
}
?>