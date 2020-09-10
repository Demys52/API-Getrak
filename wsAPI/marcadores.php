<?php
require_once("API_KEY.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Marker Animations With setTimeout()</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
      #floating-panel {
        margin-left: -52px;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>

      // If you're adding a number of markers, you may want to drop them on the map
      // consecutively rather than all at once. This example shows how to use
      // window.setTimeout() to space your markers' animation.
/*
      var neighborhoods = [
        {lat: 52.511, lng: 13.447},
        {lat: 52.549, lng: 13.422},
        {lat: 52.497, lng: 13.396},
        {lat: 52.517, lng: 13.394}
      ];
*/
<?php
if(isset($_POST['lat']) && isset($_POST['lng']))
{
  $lat = $_POST['lat'];
  $lng = $_POST['lng'];
  
  
  if(count($_POST['lat']) == count($_POST['lng']))
  {
    for ($x=0; $x < count($_POST['lat']); $x++)
    {
      if($lat[$x] !== "" || $lat[$x] != null || $lng[$x] !== "" || $lng[$x] != null)
      {
        if (floatval($lat[$x]) && floatval($lng[$x]))
        $latlong[] = ["lat" => floatval($lat[$x]), "lng" => floatval($lng[$x])];
        else
        $erro[] = ["lat" => $lat[$x], "lng" => $lng[$x]];
      }
      else
      {
        $erro[] = ["mensagem" => "Latitude ou Longitude inválida"];
        // CRIAR UM COMFIRM PARA SABER SE CONTINUA OU ENCERRA A CHAMADA
      }
    }
    if(isset($latlong))
    echo "var neighborhoods = ". json_encode($latlong).";";
  }
  else
  {
    $erro[] = ["mensagem2" => "Quantidade de latitude diferente de longitude!"];
    // CRIAR UM COMFIRM PARA SABER SE CONTINUA OU ENCERRA A CHAMADA
  }
}


/*
$latlong[] = ["lat" => 52.511, "lng" => 13.447];
$latlong[] = ["lat" => 52.549, "lng" => 13.422];
$latlong[] = ["lat" => 52.497, "lng" => 13.396];
$latlong[] = ["lat" => 52.517, "lng" => 13.394];
*/
//print_r($latlong);
//echo "var neighborhoods = ". json_encode($latlong);

//echo json_encode($latlong);
?>
      var markers = [];
      var map;

      function initMap() {
      var latlngbounds = new google.maps.LatLngBounds();
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: {"lat": -3.7089581, "lng": -38.5572186}
        });
        
        function drop() {
        if (typeof neighborhoods == "undefined")
        {return;}
        clearMarkers();
        for (var i = 0; i < neighborhoods.length; i++) {
          
          var marker = new google.maps.Marker({
                map: map,
                position: neighborhoods[i]
              });
              //pega marcador por marcador e ajusta no map
            latlngbounds.extend(marker.position);
            map.fitBounds(latlngbounds);
          
        }
      }
      
      function clearMarkers() {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(null);
        }
        markers = [];
      }
      drop();
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo$key;?>&callback=initMap">
    </script>
    
    <script>
    <?php
    //  ERROS
      if(isset($erro))
      {
        echo json_encode($erro, JSON_UNESCAPED_UNICODE);
      }
    ?>
    </script>
  </body>
</html>