<?php
class Drink_menu_edit
{
    private $items;
    private $groups;

    public function main($items, $groups)
    {
        $menu = new Menu("Itallap");
        $menu->main();

        $this->items = $items;
        $this->group = $groups;
?>


<style>
    .group_div {
        text-align: center;
}

    .group {
        color: red;
        font-weight: bold;
    }

</style>

<script>
var actualImage = null;

$(document).ready(function () {
  $("#new_group_input").keypress(function (event) {
    var txt = $(this).val();
    var keyCode = event.keyCode ? event.keyCode : event.which;
    if (keyCode == 13 && txt.length > 1) {
      $("#groups").append("<p class='group'>" + txt + "</p>");
      $(this).val("");
    }
  });

  $("#new_item_open_modal_button").click(function () {
    $("#group_selector").empty();
    $(".group").each(function () {
      $("#group_selector").append(
        "<option value='" + $(this).html() + "'>" + $(this).html() + "</option>"
      );
    });
  });

  $("body").on("click", "a.dropdown-group-item", function () {
    event.stopPropagation();
    event.stopImmediatePropagation();
    $("#new_item_dropdown_button").html($(this).html());
  });

  $(".remove-item").click(function () {
    var id = $(this).parent().siblings("td:first").html();
    if (confirm("Biztos, hogy töröljük?")) {
      $.ajax({
        url: "/remove_drink_menu_item",
        type: "POST",
        data: { id: id }
      });
      $(this).parent().parent().remove();
    }
  });

  $("#new_item_form").submit(function (e) {
    e.preventDefault();

    if (
      $("#new_item_name").val().length < 3 ||
      $("#new_item_price").val().length < 3
    ) {
      alert("Nincs minden adat kitoltve!");
    } else {
      var formData = new FormData(this);
      var newId = 0;

      $.ajax({
        url: "/upload_drink_menu_item",
        type: "POST",
        data: formData,
        success: function (data) {
          newId = data["last_id"];
        },
        cache: false,
        contentType: false,
        processData: false
      });

      $("#item_table_body").append(
        "<tr><td><img src='" +
          actualImage +
          "' style='width: 30px; height: 30px'/></td><td>" +
          $("#group_selector").val() +
          "</td><td>" +
          $("#new_item_name").val() +
          "</td><td>" +
          $("#new_item_price").val() +
          "Ft</td><td><span class='glyphicon glyphicon-remove remove-item'></span></td></tr>"
      );

      $("#new_item_name").val("");
      $("#new_item_price").val("");
    }
  });

  $("#new_item_image").change(function () {
    if (this.files && this.files[0]) {
      if (this.files[0].size > 200 * 1024) {
        alert("Túl nagy fájlméret!");
        $("#new_item_image").replaceWith(
          $("#new_item_image").val("").clone(true)
        );
      } else {
        var reader = new FileReader();

        reader.onload = function (e) {
          actualImage = e.target.result;
          $("#upload_preview").attr("src", actualImage);
          $("#upload_preview").css("display", "block");
        };

        reader.readAsDataURL(this.files[0]);
      }
    }
  });
});
</script>
<style>
    .remove-item {
        color: red;
    }

    .remove-item:hover {
        background-color: yellow;
    }
    
</style>

<body>
  <div class="container">
      <h1 style="text-align:center; margin-bottom: 100px;">Itallap szerkesztese</h1>
    <div class="row">
      <div class="col-sm-4 group_div" style="border-style: double;">
          <h4>Kategoriak</h4>
          <div id="groups">
               <?php
        foreach ($groups as $g)
        {
            echo "<p class='group'>" . $g["item_group"] . "</p>\n";
        }
?>
          </div>
          <input type="text" id="new_group_input" placeholder="Uj kategoria"/>
      </div>
      <div class="col-sm-8" id="items_container" style="border-style: double;">
        <table class="table">
          <thead>
            <tr>
              <th style="display: none;">id</th>
              <th>Kép</th>
              <th>Csoport</th>
              <th>Megnevezés</th>
              <th>Ár</th>
              <th>Törlés</th>
            </tr>
          </thead>
          <tbody id="item_table_body">
              <?php
        foreach ($items as $i)
        {
            echo "<tr>\n";
            echo "<td style='display: none'>" . $i['id'] . "</td>\n";
            echo "<td>" . '<img' . " style='width: 30px; height: 30px' " . 'src="data:image/jpg;base64,' . base64_encode($i['item_image']) . '">' . "</td>";
            echo "<td>" . $i["item_group"] . "</td>\n";
            echo "<td>" . $i["item_name"] . "</td>\n";
            echo "<td>" . $i["item_price"] . "Ft</td>\n";
            echo "<td><span class='glyphicon glyphicon-remove remove-item' title='Törlés'></span></td>\n";
            echo "</tr>\n";
        }
?>
          </tbody>
        </table>

        <button class="btn btn-info btn-lg" data-toggle="modal" data-target="#item_modal" id="new_item_open_modal_button">Új tétel hozzáadása</button>
        <div class="modal fade" id="item_modal" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">

                <h4 class="modal-title">Új tétel hozzáadása</h4>
              </div>
              <form id="new_item_form" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <p>Tétel adatai</p>
                   <label style="width: 100px; text-align: right;">Kávézó</label><label style="text-align: center; margin-left: 30px;"><?php echo $_SESSION["name"]; ?></label> <br>
                        <label for="group" style="width: 100px; text-align: right;">Csoport</label>
                        <select id="group_selector" name="group" style="width: 140px; margin-left: 30px;">
                        </select>
                        <br>
                        <label for="name" style="width: 100px; text-align: right;">Megnevezés</label><input type="text" name="name" id="new_item_name" style="width: 140px; margin-left: 30px;" /><br>
                        <label for="price" style="width: 100px; text-align: right;">Ár</label><input type="number" name="price" id="new_item_price" min="1" max="10000" style="width: 140px; margin-left: 30px;"/><br>
                        <label for="image" style="width: 100px; text-align: right;">Kép (max. 200KB):</label><br><input type="file" name="image" id="new_item_image" style="margin-left: 30px;"/><br>
                        <img id="upload_preview" style="width: 140px; height: 140px; display:none;"/>
                        </div>
                    <div class="modal-footer">
                        <button>Submit</button>
                 </form>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</body>






<?php
require('footer.php');
    }
}
?>
