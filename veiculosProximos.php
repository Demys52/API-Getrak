<?php
if(isset($_REQUEST["cliente"]) && !empty($_REQUEST["cliente"]))
{
  // pega veiculos da getrak
  require_once("apiGetrak/getLocalizacoes.php");
  $objVeiculos = getVeiculos();
  // lembrar de enviar o token pela função
  if(isset($objVeiculos->error))
  {exit('{"status":"null", "menssage":"Necessário relizar o login"}');}
  else
  {
    foreach($objVeiculos->veiculos as $veiculo)
      $arrayVeiculos[] = array("placa" => $veiculo->placa,
                               "label" => "V",
                               "localizacao" => array("lat" => $veiculo->lat,
                               "lng" => $veiculo->lon));
  }
// recebe endereço do cliente para convercao
  $endereco = $_REQUEST["cliente"];
  require_once("wsAPI/geocode.php");
  require_once("wsAPI/API_KEY.php");
  //comando abaixo obrigatório por algum motivo
  $endereco   = str_replace(" ", "+", $endereco);
  $cordenadas = convertlatlong($endereco, $key);
  // adiciona clientes nas coordenadas para os marcadores
  $arrayVeiculos[] = array("placa" => "Cliente",
                               "label" => "C",
                               "localizacao" => array("lat" => $cordenadas["coordenadas"]["latitude"],
                               "lng" => $cordenadas["coordenadas"]["longitude"]));
  $veiculos["veiculos"] = $arrayVeiculos;
  
require_once("funcoes/distancia.php");
for($x=0; $x < count($arrayVeiculos); $x++)
{
  if(!empty($arrayVeiculos[$x]['localizacao']['lat']) || !empty($arrayVeiculos[$x]['localizacao']['lng']))
  {
    if($arrayVeiculos[$x]["placa"] !== "Cliente")
    {
      $distancia[$x]["distancia"] = Distance($cordenadas["coordenadas"]["latitude"], $cordenadas["coordenadas"]["longitude"], $arrayVeiculos[$x]["localizacao"]["lat"], $arrayVeiculos[$x]["localizacao"]["lng"], "K");
      $distancia[$x]["veiculo"] = $arrayVeiculos[$x]["placa"];
    }
  }
}
sort($distancia);
echo json_encode($distancia, JSON_UNESCAPED_UNICODE);
}
else
{
  exit('{"status":"null"}');
}
