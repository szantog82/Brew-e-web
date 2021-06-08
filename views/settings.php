<?php
class Settings
{

    public function main($data)
    {
        session_start();
        $menu = new Menu("Beallitasok");
        $menu->main();
?>

<div class='container'>
  <h1>Adatok szerkesztese</h1>
  <div class="row">
    <div class='col-lg-4'>
      <h4>Cím a térképen</h4>
      <div id="demoMap" style="width: 300px; height: 300px;"></div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/openlayers/2.13.1/OpenLayers.js"></script>
<script>
var shop_lat = <?=$data["lat_coord"];?>;
var shop_lon = <?=$data["lon_coord"];?>;
map = new OpenLayers.Map("demoMap");
map.addLayer(new OpenLayers.Layer.OSM());
map.zoomToMaxExtent();
var zoom = 15;
map.setCenter(
  new OpenLayers.LonLat(shop_lon, shop_lat).transform("EPSG:4326", "EPSG:3857"),
  zoom
);
var wgs84 = new OpenLayers.Projection("EPSG:4326");
var merc = new OpenLayers.Projection("EPSG:3857");

var markers = new OpenLayers.Layer.Markers("pontok");
map.addLayer(markers);
var lonLat = new OpenLayers.LonLat(shop_lon, shop_lat).transform(
          "EPSG:4326",
          "EPSG:3857"
        );
var m = new OpenLayers.Marker(lonLat);
markers.addMarker(m);

$(document).ready(function () {
  map.events.register("click", map, function (e) {
    markers.destroy();
    markers = new OpenLayers.Layer.Markers("pontok");
    map.addLayer(markers);
    // a kattintás helye a térképet tartalmazó div-ben
    var pxPos = map.events.getMousePosition(e);
    // átszámítva az aktuális vetületi rendszerbe
    var projPos = map.getLonLatFromPixel(pxPos);
    // új marker
    var m = new OpenLayers.Marker(projPos);
    markers.addMarker(m);
    var geoPos = projPos.clone().transform(merc, wgs84);
    var markerLon = geoPos.lon;
    var markerLat = geoPos.lat;
    shop_lat = markerLat;
    shop_lon = markerLon;

    $.post(
      "/get_location_data",
      { lon: markerLon, lat: markerLat },
      function (result) {
        var data = JSON.parse(result);
        if (data["city"].length > 1) {
          $("#city").val(data.city);
        } else {
          $("#city").val(data.town);
        }
        $("#postal_code").val(data.postcode);
        $("#street").val(data.road);
        $("#lon").val(markerLon);
        $("#lat").val(markerLat);
      }
    );
  });

  $("#street").focusout(function () {
    var cityName = $("#city").val();
    var postalcode = $("#postal_code").val();
    var streetName = $("#street").val();
    $.ajax({
      url: "/get_location_data",
      method: "POST",
      data: {
        type: "normal",
        location: cityName + " " + streetName
      },
      success: function (result) {
        var data = JSON.parse(result);
        shop_lat = data.lat;
        shop_lon = data.lon;
        markers.destroy();
        markers = new OpenLayers.Layer.Markers("pontok");
        map.addLayer(markers);
        var lonLat = new OpenLayers.LonLat(data.lon, data.lat).transform(
          "EPSG:4326",
          "EPSG:3857"
        );
        var m = new OpenLayers.Marker(lonLat);
        markers.addMarker(m);
      }
    });
  });
  
  $("#submit").click(function(event){
      event.preventDefault();
      var data = {
        lon_coord:   shop_lon,
        lat_coord: shop_lat,
        name: $("#shop_name").val(),
        description: $("#shop_descr").val(),
         city: $("#city").val(),
     postalcode: $("#postal_code").val(),
     street: $("#street").val(),
     tax_num: $("#tax_num").val()
      };
      $.ajax({
      url: "/modify_shop_params",
      method: "POST",
      data: data,
      success: function(result){
          var res = JSON.parse(result);
          if (res.response == 1){
              alert("Módosítás sikeres");
          } else {
              alert("Hiba történt, a módosítás sikertelen!");
          }
      }
      });
  });
});

</script>
    </div>

    <div class='col-lg-8'>
      <div class="container col-sm-6">
        <form method="POST" class="form-group">
          <label>Kavehaz neve:</label>
          <input type="text" name="shop_name" id="shop_name" class="form-control" value="<?=$data["name"];?>"><br>
          <label>Rovid leiras:</label>
          <input type="text" name="shop_descr" id="shop_descr" class="form-control" value="<?=$data["description"];?>"><br>
          <hr>
          <label>Felhasznalo nev:</label>
          <input type="text" name="login" class="form-control" disabled value="<?=$data["login"];?>"><br>
          <label>Email cim:</label>
          <input type="email" name="email" class="form-control" disabled value="<?=$data["email"];?>"><br>
          <hr>
          <label>Iranyitoszam:</label>
          <input id="postal_code" type="postal_code" name="postal_code" class="form-control" value="<?=$data["postalcode"];?>"><br>
          <label>Varos:</label>
          <input id="city" type="city" name="city" class="form-control" value="<?=$data["city"];?>"><br>
          <label>Utca és házszám:</label>
          <input id="street" type="street" name="street" class="form-control" value="<?=$data["street"];?>"><br>
          <label>Adoszam:</label>
          <input id="tax_num" type="tax_num" name="tax_num" class="form-control" value="<?=$data["tax_num"];?>"><br>
          <input type="hidden" id="lat" name="lat">
          <input type="hidden" id="lon" name="lon">
          <input id="submit" type="submit" value="Modositom">
        </form>
      </div>
    </div>
  </div>
</div>
    
    
        
        <?php
        require('footer.php');
    }
}

?>