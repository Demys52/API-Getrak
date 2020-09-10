<!DOCTYPE html>
<html lang="pt-br">
   <head>
       <meta charset="utf-8"/>
       <title>Demys WS</title>
   </head>
   <body>
       <p>Index!</p>
       <h1>Converter em coordenadas</h1>
       
       <input type="text" id="endereco">
       <button onclick="GetEndereco();">Converter</button><br>
       
       <script>
         function GetEndereco ()
         {
            var endereco = document.getElementById("endereco").value;
            //alert(endereco);
            window.location = "?converte=true&endereco="+endereco;
         }
       </script>
         <?php
            
         function GetLatLong ($endereco)
         {
            //inicia
            $ws = curl_init();
            //configuração do acesso
            curl_setopt_array($ws, array(
               CURLOPT_RETURNTRANSFER => 1,
               CURLOPT_URL => "http://localhost/webservice/convertelatlong.php",
               CURLOPT_USERAGENT => 'Codular Sample cURL Request',
               CURLOPT_POSTFIELDS => $endereco
            ));
            $result = curl_exec($ws);
            //fecha
            curl_close($ws);
            $obj = json_decode($result);
            
            return $obj;
         }
            if (isset($_GET['converte']) && $_GET['converte'] == true)
            {
               //$latlng = GetLatLong ("endereco=Rua Nossa Senhora das Graças, 1014, Pirambu");
               $endereco = $_GET['endereco'];
               //echo $endereco;
               $latlng = GetLatLong ("endereco=".$endereco);
               
               echo $latlng->status;
               echo "<br>";
               echo $latlng->coordenadas->latitude;
               echo "<br>";
               echo $latlng->coordenadas->longitude;
               
            }
            else{echo "Get falhou!";}
            
         ?>
         <form action="wsAPI/marcadores.php" method="POST" name="eviarltln" " target="_blank">
            <h1>Adicionar marcadores</h1>
            Latitude:
            <input type="text" name="lat[]"><br>
            Longitude:
            <input type="text" name="lng[]"><br>
            Latitude:
            <input type="text" name="lat[]"><br>
            Longitude:
            <input type="text" name="lng[]"><br>
            Latitude:
            <input type="text" name="lat[]"><br>
            Longitude:
            <input type="text" name="lng[]"><br>
            Latitude:
            <input type="text" name="lat[]"><br>
            Longitude:
            <input type="text" name="lng[]"><br>
            <input type="submit" value="Enviar">
         </form>
   </body>
</html>