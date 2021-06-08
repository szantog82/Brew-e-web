<?php

session_start();
$menu = new Menu("Regisztracio");
$menu->main();
?>


<div class="container">
<h1>Regisztracio</h1>



<div id="demoMap" style="width: 400px; height: 600px;"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/openlayers/2.13.1/OpenLayers.js"></script>
<script>
    
     map = new OpenLayers.Map("demoMap");
  map.addLayer(new OpenLayers.Layer.OSM());
  map.zoomToMaxExtent();
  var zoom = 8;
  var lon = 19.046550007;
  var lat = 47.49449609;
  map.setCenter(new OpenLayers.LonLat(lon, lat).transform('EPSG:4326', 'EPSG:3857'), zoom);
  var wgs84 = new OpenLayers.Projection('EPSG:4326');
  var merc = new OpenLayers.Projection('EPSG:3857');

  var markers = new OpenLayers.Layer.Markers("pontok");
  map.addLayer(markers);
  
  map.events.register("click", map, function(e) {
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

    $.post("/get_location_data", {lon: markerLon, lat: markerLat}, function(result){
       var data = JSON.parse(result);
       if (data["city"].length > 1){
            $("#city").val(data.city);
       } else {
            $("#city").val(data.town);
       }
       $("#postal_code").val(data.postcode);
       $("#street").val(data.road);
       $("#lon").val(markerLon);
       $("#lat").val(markerLat);
    });
    
  });

</script>

<div class="container col-sm-6">
  <form method="POST" action="/register" class="form-group">
     <label>Kavehaz neve:</label>
    <input type="text" name="shop_name" class="form-control"><br>
     <label>Rovid leiras:</label>
    <input type="text" name="shop_descr" class="form-control"><br>
    <hr>
    <label>Felhasznalo nev:</label>
    <input type="text" name="login" class="form-control"><br>
    <label>Email cim:</label>
    <input type="email" name="email" class="form-control"><br>
    <label>Jelszo:</label>
    <input type="password" name="password" class="form-control"><br>
    <hr>
    <label>Iranyitoszam:</label>
    <input id="postal_code" type="postal_code" name="postal_code" class="form-control"><br>
    <label>Varos:</label>
    <input id="city" type="city" name="city" class="form-control"><br>
    <label>Utca és házszám:</label>
    <input id="street" type="street" name="street" class="form-control"><br>
    <label>Adoszam:</label>
    <input id="tax_num" type="tax_num" name="tax_num" class="form-control"><br>
    <input type="hidden" id="lat" name="lat">
    <input type="hidden" id="lon" name="lon">
    <input type="submit">
  </form>
</div>
</div>
</body>

<?php
require('footer.php');
?>
